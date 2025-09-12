
'use server';

import { z } from 'zod';
import { summarizeMilestone } from '@/ai/flows/summarize-timeline-milestones';

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

export async function submitContactForm(prevState: ContactFormState, formData: FormData) {
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

  // Simulate sending an email
  console.log('New contact form submission:');
  console.log(validatedFields.data);

  // In a real application, you would integrate with an email service here.
  // For example: await sendEmail(validatedFields.data);

  return { message: 'success' };
}


export async function generateSummary(milestoneText: string) {
  try {
    const result = await summarizeMilestone({ milestoneText });
    return { summary: result.summary, error: null };
  } catch (error) {
    console.error('AI summary failed:', error);
    return { summary: null, error: 'Failed to generate summary. Please try again later.' };
  }
}
