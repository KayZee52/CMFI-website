
import { google } from 'googleapis';
import { cache } from 'react';
import dotenv from 'dotenv';

dotenv.config();

export type DriveMedia = {
  id: string;
  name: string;
  thumbnailLink: string;
  mimeType: string;
  webViewLink: string; // Add webViewLink to the type
};

// Helper function to extract folder ID from a URL
const getFolderIdFromUrl = (input: string): string => {
  try {
    // Check if the input is a valid URL
    if (input.includes('drive.google.com')) {
      const url = new URL(input);
      const pathParts = url.pathname.split('/');
      // The ID is usually the last part of the path for /folders/
      const folderIdIndex = pathParts.indexOf('folders');
      if (folderIdIndex !== -1 && folderIdIndex < pathParts.length - 1) {
        return pathParts[folderIdIndex + 1];
      }
    }
  } catch (e) {
    // If it's not a valid URL, assume it's an ID
    return input;
  }
  // Return the input if it's not a URL or if parsing fails (treating it as an ID)
  return input;
};


// This function is cached to prevent hitting the API on every request.
// The `cache` function from React ensures that if this function is called
// multiple times in a single render pass, it only executes once.
export const getGalleryImages = cache(async (): Promise<DriveMedia[]> => {
  const {
    GOOGLE_CLIENT_EMAIL,
    GOOGLE_PRIVATE_KEY,
    GOOGLE_DRIVE_GALLERY_FOLDER_ID,
  } = process.env;

  if (!GOOGLE_CLIENT_EMAIL || !GOOGLE_PRIVATE_KEY || !GOOGLE_DRIVE_GALLERY_FOLDER_ID) {
    console.error('One or more Google Drive environment variables are not set.');
    console.error('Please check your .env file and ensure GOOGLE_CLIENT_EMAIL, GOOGLE_PRIVATE_KEY, and GOOGLE_DRIVE_GALLERY_FOLDER_ID are all present.');
    return [];
  }

  const folderId = getFolderIdFromUrl(GOOGLE_DRIVE_GALLERY_FOLDER_ID);

  try {
    const auth = new google.auth.GoogleAuth({
      credentials: {
        client_email: GOOGLE_CLIENT_EMAIL,
        private_key: GOOGLE_PRIVATE_KEY.replace(/\\n/g, '\n'), // Handle newline characters
      },
      // Scope needs to be changed to allow file permission modifications
      scopes: ['https://www.googleapis.com/auth/drive'],
    });

    const drive = google.drive({ version: 'v3', auth });

    const response = await drive.files.list({
      q: `'${folderId}' in parents and (mimeType contains 'image/' or mimeType contains 'video/')`,
      // Add webViewLink to the fields
      fields: 'files(id, name, thumbnailLink, mimeType, webViewLink)',
      orderBy: 'createdTime desc',
      pageSize: 50,
    });

    const files = response.data.files;
    
    if (!files || files.length === 0) {
        console.log('No files found in the specified Google Drive folder.');
        return [];
    }

    // Ensure all files are publicly accessible
    for (const file of files) {
      if (file.id) {
        await drive.permissions.create({
          fileId: file.id,
          requestBody: {
            role: 'reader',
            type: 'anyone',
          },
        });
      }
    }

    // We are sure `thumbnailLink` and `webViewLink` exist because we requested them in `fields`.
    return files.filter(file => file.id && file.name && file.thumbnailLink && file.mimeType && file.webViewLink) as DriveMedia[];

  } catch (error: any) {
    console.error('Failed to fetch images from Google Drive. Full error:');
    console.error(error);
    
    if (error.response?.data?.error) {
       console.error('Google API Error Details:', error.response.data.error);
    }
    
    return [];
  }
});
