
import { google } from 'googleapis';
import { cache } from 'react';

export type DriveImage = {
  id: string;
  name: string;
  thumbnailLink: string;
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
      q: `'${GOOGLE_DRIVE_GALLERY_FOLDER_ID}' in parents and (mimeType='image/jpeg' or mimeType='image/png')`,
      // The fields we want the API to return for each file.
      fields: 'files(id, name, thumbnailLink)',
      // Order by the date the file was created.
      orderBy: 'createdTime desc',
      pageSize: 50, // Limit to 50 images
    });

    const files = response.data.files;
    
    if (!files) {
        console.log('No files found in the specified Google Drive folder.');
        return [];
    }

    // We are sure `thumbnailLink` exists because we requested it in `fields`.
    return files as DriveImage[];

  } catch (error: any) {
    console.error('Failed to fetch images from Google Drive. Full error:');
    // Log the full error object to get more details
    console.error(error);
    
    if (error.response?.data?.error) {
       console.error('Google API Error Details:', error.response.data.error);
    }
    
    return [];
  }
});
