
import * as admin from 'firebase-admin';

// This file initializes the Firebase Admin SDK.
// It is designed to be a singleton, so the app is only initialized once.

let app: admin.app.App;

if (!admin.apps.length) {
  // When deployed to Firebase App Hosting, the SDK is automatically
  // initialized with the correct project credentials.
  // For local development, you would need to set up a service account JSON file.
  // See: https://firebase.google.com/docs/admin/setup
  app = admin.initializeApp();
} else {
  app = admin.app();
}

export function getFirebaseAdminApp() {
  return app;
}
