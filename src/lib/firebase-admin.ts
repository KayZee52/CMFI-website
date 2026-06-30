
import { initializeApp, getApps, getApp, App } from 'firebase-admin/app';

// This file initializes the Firebase Admin SDK.
// It is designed to be a singleton, so the app is only initialized once.

let app: App;

if (!getApps().length) {
  // When deployed to Firebase App Hosting, the SDK is automatically
  // initialized with the correct project credentials.
  // For local development, you would need to set up a service account JSON file.
  // See: https://firebase.google.com/docs/admin/setup
  app = initializeApp();
} else {
  app = getApp();
}

export function getFirebaseAdminApp() {
  return app;
}
