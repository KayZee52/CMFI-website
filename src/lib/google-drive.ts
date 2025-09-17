
import { google } from 'googleapis';
import { cache } from 'react';
import dotenv from 'dotenv';

dotenv.config();

export type DriveImage = {
  id: string;
  name: string;
  thumbnailLink: string;
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
export const getGalleryImages = cache(async (): Promise<DriveImage[]> => {
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
      scopes: ['https://www.googleapis.com/auth/drive.readonly'],
    });

    const drive = google.drive({ version: 'v3', auth });

    const response = await drive.files.list({
      // The `q` parameter is a query to search for files.
      // We are searching for image files inside the specified folder.
      q: `'${folderId}' in parents and (mimeType='image/jpeg' or mimeType='image/png')`,
      // The fields we want the API to return for each file.
      fields: 'files(id, name, thumbnailLink)',
      // Order by the date the file was created.
      orderBy: 'createdTime desc',
      pageSize: 50, // Limit to 50 images
    });

    const files = response.data.files;
    
    if (!files || files.length === 0) {
        console.log('No files found in the specified Google Drive folder.');
        return [];
    }

    // We are sure `thumbnailLink` exists because we requested it in `fields`.
    return files.filter(file => file.id && file.name && file.thumbnailLink) as DriveImage[];

  } catch (error: any) {
    console.error('Failed to fetch images from Google Drive. Full error:');
    // Log the full error object to get more details
    console.error(error);
    
    // Check if the error object has more specific details from the Google API
    if (error.response?.data?.error) {
       console.error('Google API Error Details:', error.response.data.error);
    }
    
    return [];
  }
});