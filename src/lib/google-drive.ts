
import { google } from 'googleapis';
import { cache } from 'react';
import dotenv from 'dotenv';
import { Readable } from 'stream';

dotenv.config();

export type DriveMedia = {
  id: string;
  name: string;
  thumbnailLink: string;
  mimeType: string;
};

// Helper function to extract folder ID from a URL
const getFolderIdFromUrl = (input: string): string => {
  if (!input) return '';
  // Regular expression to find the folder ID from various Google Drive URL formats
  const regex = /\/folders\/([a-zA-Z0-9_-]+)|id=([a-zA-Z0-9_-]+)/;
  const match = input.match(regex);
  // The ID could be in the first or second capturing group
  if (match) {
    return match[1] || match[2];
  }
  // If no match is found, assume the input string is the ID itself
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
  
  if (!folderId) {
    console.error('Could not extract a valid Google Drive folder ID from the environment variable.');
    return [];
  }

  try {
    const auth = new google.auth.GoogleAuth({
      credentials: {
        client_email: GOOGLE_CLIENT_EMAIL,
        private_key: GOOGLE_PRIVATE_KEY.replace(/\\n/g, '\n'), // Handle newline characters
      },
      scopes: ['https://www.googleapis.com/auth/drive'],
    });

    const drive = google.drive({ version: 'v3', auth });

    const response = await drive.files.list({
      q: `'${folderId}' in parents and (mimeType contains 'image/' or mimeType contains 'video/')`,
      fields: 'files(id, name, thumbnailLink, mimeType)',
      orderBy: 'createdTime desc',
      pageSize: 50,
    });

    const files = response.data.files;
    
    if (!files || files.length === 0) {
        console.log('No files found in the specified Google Drive folder.');
        return [];
    }

    // Ensure all files are publicly accessible
    await Promise.all(files.map(file => {
      if (file.id) {
        return drive.permissions.create({
          fileId: file.id,
          requestBody: {
            role: 'reader',
            type: 'anyone',
          }
        }).catch(err => {
            // Log permission errors but don't fail the whole process
            if (err.code !== 409) { // 409 is "duplicate permission", which is fine
                 console.error(`Failed to set permission for file ${file.id}:`, err.message);
            }
        });
      }
      return Promise.resolve();
    }));

    return files
      .filter((file): file is DriveMedia => 
        !!file.id && !!file.name && !!file.thumbnailLink && !!file.mimeType
      );

  } catch (error: any) {
    console.error('Failed to fetch images from Google Drive. Full error:');
    console.error(error);
    
    if (error.response?.data?.error) {
       console.error('Google API Error Details:', error.response.data.error);
    }
    
    return [];
  }
});


export const uploadFileToDrive = async (
  fileBuffer: Uint8Array,
  mimeType: string,
  fileName: string
): Promise<{ message: string; downloadUrl?: string }> => {
  const {
    GOOGLE_CLIENT_EMAIL,
    GOOGLE_PRIVATE_KEY,
    GOOGLE_DRIVE_ADMISSIONS_FOLDER_ID,
  } = process.env;
  
  if (!GOOGLE_CLIENT_EMAIL || !GOOGLE_PRIVATE_KEY || !GOOGLE_DRIVE_ADMISSIONS_FOLDER_ID) {
    return { message: 'Google Drive environment variables are not set for admissions.' };
  }

  const folderId = getFolderIdFromUrl(GOOGLE_DRIVE_ADMISSIONS_FOLDER_ID);
  if (!folderId) {
    return { message: 'Could not extract a valid admissions folder ID.' };
  }

  try {
    const auth = new google.auth.GoogleAuth({
      credentials: {
        client_email: GOOGLE_CLIENT_EMAIL,
        private_key: GOOGLE_PRIVATE_KEY.replace(/\\n/g, '\n'),
      },
      scopes: ['https://www.googleapis.com/auth/drive.file'],
    });

    const drive = google.drive({ version: 'v3', auth });
    
    const fileMetadata = {
      name: fileName,
      parents: [folderId],
    };

    const media = {
      mimeType: mimeType,
      body: Readable.from(Buffer.from(fileBuffer)),
    };

    const file = await drive.files.create({
        requestBody: fileMetadata,
        media: media,
        fields: 'id, webViewLink'
    });

    if (!file.data.id) {
        throw new Error('File upload succeeded but no file ID was returned.');
    }

    // Make the file publicly readable
    await drive.permissions.create({
        fileId: file.data.id,
        requestBody: {
            role: 'reader',
            type: 'anyone',
        },
    });

    // Create a downloadable link
    const downloadUrl = `https://drive.google.com/uc?export=download&id=${file.data.id}`;

    return { message: 'success', downloadUrl: downloadUrl };
  } catch (error: any) {
    console.error('Error uploading to Google Drive:', error);
    return { message: `Google Drive upload failed: ${error.message}` };
  }
};
