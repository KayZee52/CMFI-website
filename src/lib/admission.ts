
'use server';

import { PDFDocument, rgb, StandardFonts } from 'pdf-lib';
import { z } from 'zod';
import { getFirebaseAdminApp } from './firebase-admin';
import { getStorage } from 'firebase-admin/storage';
import nodemailer from 'nodemailer';

// Define the schema for form values, including files
const fileSchema = z.instanceof(File).optional();
const admissionFormSchema = z.object({
  academyYear: z.string().optional(),
  studentFullName: z.string().optional(),
  gender: z.string().optional(),
  dobMonth: z.string().optional(),
  dobDate: z.string().optional(),
  dobYear: z.string().optional(),
  religion: z.string().optional(),
  studentContact: z.string().optional(),
  studentAddress: z.string().optional(),
  guardianFullName: z.string().optional(),
  guardianRelationship: z.string().optional(),
  motherFullName: z.string().optional(),
  motherOccupation: z.string().optional(),
  motherAlive: z.string().optional(),
  motherMobile: z.string().optional(),
  motherAddress: z.string().optional(),
  fatherFullName: z.string().optional(),
  fatherOccupation: z.string().optional(),
  fatherAlive: z.string().optional(),
  fatherMobile: z.string().optional(),
  fatherAddress: z.string().optional(),
  prevSchoolName: z.string().optional(),
  prevSchoolLocation: z.string().optional(),
  documentsBrought: z
    .string()
    .transform((str) => JSON.parse(str))
    .optional(),
  gradeLevel: z.string().optional(),
  principalName: z.string().optional(),
  prevSchoolContact: z.string().optional(),
  birthCertificateFile: fileSchema,
  reportCardFile: fileSchema,
  transcriptFile: fileSchema,
  recommendationFile: fileSchema,
});

type AdmissionFormState = {
  message: string;
  downloadUrl?: string;
  errors?: Record<string, string[] | undefined>;
};

// Helper function to draw text on the PDF page
const drawText = (
  page: any,
  text: string,
  x: number,
  y: number,
  font: any,
  size: number
) => {
  if (text) {
    page.drawText(text, { x, y, font, size, color: rgb(0, 0, 0) });
  }
};

// Helper function to embed an image
const embedImage = async (
  doc: PDFDocument,
  page: any,
  file: File | undefined,
  x: number,
  y: number,
  maxWidth: number,
  maxHeight: number
) => {
  if (!file) return y;

  const fileBuffer = await file.arrayBuffer();
  let embeddedImage;
  if (file.type === 'image/png') {
    embeddedImage = await doc.embedPng(fileBuffer);
  } else if (file.type === 'image/jpeg') {
    embeddedImage = await doc.embedJpg(fileBuffer);
  } else {
    // For PDFs or other types, just note it. Could also try to embed PDF pages.
    drawText(page, `File uploaded: ${file.name}`, x, y, await doc.embedFont(StandardFonts.Helvetica), 8);
    return y - 15;
  }

  const dims = embeddedImage.scaleToFit(maxWidth, maxHeight);
  page.drawImage(embeddedImage, {
    x: x,
    y: y - dims.height,
    width: dims.width,
    height: dims.height,
  });
  return y - dims.height - 10;
};

async function sendAdmissionEmail(applicantName: string, pdfBuffer: Buffer, pdfFileName: string) {
    const { EMAIL_HOST, EMAIL_PORT, EMAIL_USER, EMAIL_PASS, ADMIN_EMAIL } = process.env;

    if (!EMAIL_HOST || !EMAIL_PORT || !EMAIL_USER || !EMAIL_PASS || !ADMIN_EMAIL) {
        console.warn("Email environment variables are not fully configured. Skipping email notification.");
        return;
    }

    const transporter = nodemailer.createTransport({
        host: EMAIL_HOST,
        port: Number(EMAIL_PORT),
        secure: Number(EMAIL_PORT) === 465, // true for 465, false for other ports
        auth: {
            user: EMAIL_USER,
            pass: EMAIL_PASS,
        },
    });

    try {
        await transporter.sendMail({
            from: `"CMFI Admissions" <${EMAIL_USER}>`,
            to: ADMIN_EMAIL,
            subject: `New Admission Application: ${applicantName}`,
            text: `A new admission application has been submitted for ${applicantName}. The completed form is attached to this email.`,
            html: `<p>A new admission application has been submitted for <strong>${applicantName}</strong>.</p><p>The completed form is attached.</p>`,
            attachments: [
                {
                    filename: pdfFileName,
                    content: pdfBuffer,
                    contentType: 'application/pdf',
                },
            ],
        });
        console.log("Admission notification email sent successfully.");
    } catch (error) {
        console.error("Error sending admission email:", error);
        // We don't want to fail the whole process if email fails, so we just log the error.
    }
}


export async function submitAdmissionForm(
  prevState: AdmissionFormState | undefined,
  formData: FormData
): Promise<AdmissionFormState> {
  // Convert FormData to an object
  const formObject = Object.fromEntries(formData.entries());

  const validatedFields = admissionFormSchema.safeParse(formObject);

  if (!validatedFields.success) {
    return {
      message: 'Validation failed. Check your inputs.',
      errors: validatedFields.error.flatten().fieldErrors,
    };
  }

  const data = validatedFields.data;
  const applicantName = data.studentFullName || 'Unknown Applicant';

  try {
    const pdfDoc = await PDFDocument.create();
    const page = pdfDoc.addPage();
    const { width, height } = page.getSize();
    const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
    const boldFont = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
    const margin = 50;
    let y = height - margin;

    // --- PDF Header ---
    drawText(page, 'CMFI Bilingual High School - Admission Form', margin, y, boldFont, 18);
    y -= 30;

    // --- Student Details ---
    drawText(page, 'Student Details', margin, y, boldFont, 14);
    y -= 20;
    drawText(page, `Academy Year: ${data.academyYear || ''}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Full Name: ${data.studentFullName || ''}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Gender: ${data.gender || ''}`, margin, y, font, 10);
    drawText(page, `Religion: ${data.religion || ''}`, margin + 200, y, font, 10);
    y -= 15;
    drawText(page, `Date of Birth: ${data.dobMonth || ''} ${data.dobDate || ''}, ${data.dobYear || ''}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Contact: ${data.studentContact || ''}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Address: ${data.studentAddress || ''}`, margin, y, font, 10);
    y -= 30;

    // --- Guardian Details ---
    drawText(page, 'Guardian Details', margin, y, boldFont, 14);
    y -= 20;
    drawText(page, `Guardian Name: ${data.guardianFullName || ''}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Relationship: ${data.guardianRelationship || ''}`, margin, y, font, 10);
    y -= 30;
    
    // --- Parents Details ---
    drawText(page, 'Parents Details', margin, y, boldFont, 14);
    y -= 20;
    drawText(page, "Mother's Info", margin, y, boldFont, 12);
    y -= 15;
    drawText(page, `Name: ${data.motherFullName || 'N/A'}`, margin, y, font, 10);
    drawText(page, `Occupation: ${data.motherOccupation || 'N/A'}`, margin + 250, y, font, 10);
    y -= 15;
    drawText(page, `Alive: ${data.motherAlive || 'N/A'}`, margin, y, font, 10);
    drawText(page, `Mobile: ${data.motherMobile || 'N/A'}`, margin + 100, y, font, 10);
    drawText(page, `Address: ${data.motherAddress || 'N/A'}`, margin + 250, y, font, 10);
    y -= 25;
    drawText(page, "Father's Info", margin, y, boldFont, 12);
    y -= 15;
    drawText(page, `Name: ${data.fatherFullName || 'N/A'}`, margin, y, font, 10);
    drawText(page, `Occupation: ${data.fatherOccupation || 'N/A'}`, margin + 250, y, font, 10);
    y -= 15;
    drawText(page, `Alive: ${data.fatherAlive || 'N/A'}`, margin, y, font, 10);
    drawText(page, `Mobile: ${data.fatherMobile || 'N/A'}`, margin + 100, y, font, 10);
    drawText(page, `Address: ${data.fatherAddress || 'N/A'}`, margin + 250, y, font, 10);
    y -= 30;

    // --- Previous School Details ---
    drawText(page, 'Previous School Details', margin, y, boldFont, 14);
    y -= 20;
    drawText(page, `School Name: ${data.prevSchoolName || 'N/A'}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Location: ${data.prevSchoolLocation || 'N/A'}`, margin, y, font, 10);
    y -= 15;
    const docs = data.documentsBrought as any;
    const docsBrought = `Transcript: ${docs?.transcript ? 'Yes' : 'No'}, Recommendation: ${docs?.recommendation ? 'Yes' : 'No'}, Report Card: ${docs?.reportCard ? 'Yes' : 'No'}`;
    drawText(page, `Documents Brought: ${docsBrought}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Grade Applied For: ${data.gradeLevel || 'N/A'}`, margin, y, font, 10);
    y -= 15;
    drawText(page, `Principal Name: ${data.principalName || 'N/A'}`, margin, y, font, 10);
    drawText(page, `Contact: ${data.prevSchoolContact || 'N/A'}`, margin + 250, y, font, 10);
    y -= 30;


    // --- Document Uploads ---
    drawText(page, 'Uploaded Documents', margin, y, boldFont, 14);
    y -= 20;

    const page2 = pdfDoc.addPage();
    let y2 = height - margin;

    y = await embedImage(pdfDoc, page, data.birthCertificateFile, margin, y, 250, 200);
    drawText(page, 'Birth Certificate', margin, y + 10, font, 8);
    
    y = await embedImage(pdfDoc, page, data.reportCardFile, margin + 300, height - margin - 350, 250, 200);
    drawText(page, 'Report Card', margin + 300, y + 10, font, 8);
    
    y2 = await embedImage(pdfDoc, page2, data.transcriptFile, margin, y2, 500, 350);
    drawText(page2, 'Transcript', margin, y2 + 10, font, 8);
    
    y2 = await embedImage(pdfDoc, page2, data.recommendationFile, margin, y2 - 20, 500, 350);
    drawText(page2, 'Recommendation Letter', margin, y2 - 10, font, 8);


    const pdfBytes = await pdfDoc.save();
    const pdfBuffer = Buffer.from(pdfBytes);

    // Upload to Firebase Storage
    const adminApp = getFirebaseAdminApp();
    const bucket = getStorage(adminApp).bucket();
    const fileName = `admissions/${applicantName.replace(/\s/g, '_')}_${Date.now()}.pdf`;
    const file = bucket.file(fileName);

    await file.save(pdfBuffer, {
        metadata: {
            contentType: 'application/pdf',
        },
    });

    // Make the file public and get the URL
    await file.makePublic();
    const downloadUrl = file.publicUrl();

    // Send email notification
    await sendAdmissionEmail(applicantName, pdfBuffer, fileName);

    return {
      message: 'success',
      downloadUrl: downloadUrl,
    };

  } catch (error: any) {
    console.error('Error processing admission form:', error);
    return {
      message: `An error occurred: ${error.message}`,
    };
  }
}
