'use server';

import { z } from 'zod';
import dotenv from 'dotenv';

dotenv.config();

const contactFormSchema = z.object({
  name: z.string().min(2, { message: 'Name must be at least 2 characters.' }),
  email: z.string().email({ message: 'Please enter a valid email.' }),
  subject: z.string().min(5, { message: 'Subject must be at least 5 characters.' }),
  message: z.string().min(10, { message: 'Message must be at least 10 characters.' }),
});

export type ContactFormState = {
  message: string;
  errors?: {
    name?: string[];
    email?: string[];
    subject?: string[];
    message?: string[];
  };
};

export async function submitContactForm(prevState: ContactFormState | undefined, formData: FormData): Promise<ContactFormState> {
  const validatedFields = contactFormSchema.safeParse({
    name: formData.get('name'),
    email: formData.get('email'),
    subject: formData.get('subject'),
    message: formData.get('message'),
  });

  if (!validatedFields.success) {
    return {
      message: 'Failed to send message. Please check your input.',
      errors: validatedFields.error.flatten().fieldErrors,
    };
  }

  const { name, email, subject, message } = validatedFields.data;
  const googleFormUrl = process.env.GOOGLE_FORM_URL;
  const nameEntry = process.env.GOOGLE_FORM_ENTRY_NAME;
  const emailEntry = process.env.GOOGLE_FORM_ENTRY_EMAIL;
  const subjectEntry = process.env.GOOGLE_FORM_ENTRY_SUBJECT;
  const messageEntry = process.env.GOOGLE_FORM_ENTRY_MESSAGE;

  if (!googleFormUrl || !nameEntry || !emailEntry || !subjectEntry || !messageEntry) {
    console.error('Google Form environment variables are not set.');
    return { message: 'Server configuration error. Could not send message.' };
  }

  const googleFormData = new FormData();
  googleFormData.append(nameEntry, name);
  googleFormData.append(emailEntry, email);
  googleFormData.append(subjectEntry, subject);
  googleFormData.append(messageEntry, message);

  try {
    const response = await fetch(googleFormUrl, {
      method: 'POST',
      body: googleFormData,
      mode: 'no-cors',
    });

    // no-cors mode means we can't check the response status,
    // but we can assume it was successful if no error was thrown.
    return { message: 'success' };
  } catch (error) {
    console.error('Error submitting to Google Form:', error);
    return { message: 'An error occurred while sending your message. Please try again.' };
  }
}
