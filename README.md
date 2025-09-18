# CMFI Bilingual High School Website

This is the official website for the CMFI (Christian Missionary Fellowship International) Bilingual High School, located in Paynesville, Liberia. This project was built using Next.js and Tailwind CSS within Firebase Studio.

## Features

- **Fully Responsive Design**: A modern and accessible design that works on all devices.
- **Dynamic Pages**: Separate, detailed sections for key aspects of the school:
  - About Us
  - Admissions (with an in-person process flow)
  - Academics (detailing curriculum and faculty)
  - Student Life (sports, events, and alumni)
  - Parents' Portal (resources and involvement)
- **Markdown-Based Blog**: A simple and fast blog that can be updated by adding `.md` files to the `src/posts` directory.
- **Google Drive Integrated Gallery**: The photo and video gallery is powered by a connection to a Google Drive folder, making it easy for staff to update.
- **Contact Form**: A functional contact form that submits inquiries directly to a Google Form for easy management.
- **Built with Modern Tools**: Leverages server components, image optimization, and other modern Next.js features.

## Tech Stack

- **Framework**: [Next.js](https://nextjs.org/) (App Router)
- **Language**: [TypeScript](https://www.typescriptlang.org/)
- **Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **UI Components**: [Shadcn/UI](https://ui.shadcn.com/)
- **Icons**: [Lucide React](https://lucide.dev/)
- **Markdown Parsing**: `gray-matter` and `remark`
- **Deployment**: Intended for [Firebase App Hosting](https://firebase.google.com/docs/app-hosting)

## Getting Started

To run this project locally, follow these steps:

### 1. Prerequisites

Make sure you have Node.js (version 18 or higher) and npm installed on your machine.

### 2. Installation

Clone the repository and install the dependencies:

```bash
git clone <your-repository-url>
cd <project-directory>
npm install
```

### 3. Environment Variables

Create a `.env` file in the root of your project and add the necessary environment variables. These are required for the contact form and gallery to function correctly.

See the `.env.example` file for a template of the required variables:
- `GOOGLE_FORM_URL`: The submission URL for your contact form's Google Form.
- `GOOGLE_FORM_ENTRY_NAME`: The entry ID for the "name" field.
- `GOOGLE_FORM_ENTRY_EMAIL`: The entry ID for the "email" field.
- `GOOGLE_FORM_ENTRY_SUBJECT`: The entry ID for the "subject" field.
- `GOOGLE_FORM_ENTRY_MESSAGE`: The entry ID for the "message" field.
- `GOOGLE_CLIENT_EMAIL`: The client email from your Google Cloud service account.
- `GOOGLE_PRIVATE_KEY`: The private key from your service account JSON file.
- `GOOGLE_DRIVE_GALLERY_FOLDER_ID`: The ID of the Google Drive folder for the gallery.

### 4. Running the Development Server

Start the development server:

```bash
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) (or the port specified in `package.json`) in your browser to see the result.

## Updating the Blog

To add a new blog post, simply create a new `.md` file in the `src/posts` directory. The file name will be used as the URL slug. Make sure to include the required front matter at the top of the file:

```md
---
title: "Your Post Title"
date: "YYYY-MM-DD"
author: "Author Name"
excerpt: "A short summary of the post."
---

Your content here...
```

## "Powered by Soumed"

This project was developed by Soumed. The logo and credit in the footer can be found in `src/components/footer.tsx`.
