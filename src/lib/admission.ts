
'use server';

import { PDFDocument, rgb, StandardFonts } from 'pdf-lib';
import { z } from 'zod';
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
  // downloadUrl is removed as we are not uploading to storage anymore
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

  try {
    const fileBuffer = await file.arrayBuffer();
    let embeddedImage;
    if (file.type === 'image/png') {
      embeddedImage = await doc.embedPng(fileBuffer);
    } else if (file.type === 'image/jpeg') {
      embeddedImage = await doc.embedJpg(fileBuffer);
    } else {
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
  } catch (e) {
      console.error(`Could not embed image ${file.name}:`, e);
      drawText(page, `Could not embed image: ${file.name}`, x, y, await doc.embedFont(StandardFonts.Helvetica), 8);
      return y - 15;
  }
};

async function sendAdmissionEmail(applicantName: string, pdfBuffer: Buffer, pdfFileName: string) {
    const { EMAIL_HOST, EMAIL_PORT, EMAIL_USER, EMAIL_PASS, ADMIN_EMAIL } = process.env;

    if (!EMAIL_HOST || !EMAIL_PORT || !EMAIL_USER || !EMAIL_PASS || !ADMIN_EMAIL) {
        console.warn("Email environment variables are not fully configured. Skipping email notification.");
        throw new Error("Email service is not configured on the server.");
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
}


export async function submitAdmissionForm(
  prevState: AdmissionFormState | undefined,
  formData: FormData
): Promise<AdmissionFormState> {
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
    if (y < 300) { // Check if we need a new page
        page = pdfDoc.addPage();
        y = height - margin;
    }
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
    // Create a new page for attached documents to ensure there's enough space
    let attachmentsPage = pdfDoc.addPage();
    let yAttachments = height - margin;
    drawText(attachmentsPage, 'Uploaded Documents', margin, yAttachments, boldFont, 14);
    yAttachments -= 30;

    const embedAndSwitchPageIfNeeded = async (doc: PDFDocument, currentPage: any, yPos: number, file: File | undefined, label: string) => {
        let newY = yPos;
        let newPage = currentPage;
        if (file) {
            if (newY < 250) { // Check if there's enough space
                newPage = doc.addPage();
                newY = height - margin;
            }
            drawText(newPage, label, margin, newY, boldFont, 12);
            newY -= 15;
            newY = await embedImage(doc, newPage, file, margin, newY, 500, 350);
            newY -= 20; // Add spacing after image
        }
        return { newPage, newY };
    }
    
    let temp;
    temp = await embedAndSwitchPageIfNeeded(pdfDoc, attachmentsPage, yAttachments, data.birthCertificateFile, "Birth Certificate");
    attachmentsPage = temp.newPage;
    yAttachments = temp.newY;
    
    temp = await embedAndSwitchPageIfNeeded(pdfDoc, attachmentsPage, yAttachments, data.reportCardFile, "Most Recent Report Card");
    attachmentsPage = temp.newPage;
    yAttachments = temp.newY;

    temp = await embedAndSwitchPageIfNeeded(pdfDoc, attachmentsPage, yAttachments, data.transcriptFile, "Transcript");
    attachmentsPage = temp.newPage;
    yAttachments = temp.newY;

    temp = await embedAndSwitchPageIfNeeded(pdfDoc, attachmentsPage, yAttachments, data.recommendationFile, "Recommendation Letter");
    attachmentsPage = temp.newPage;
    yAttachments = temp.newY;

    const pdfBytes = await pdfDoc.save();
    const pdfBuffer = Buffer.from(pdfBytes);
    const pdfFileName = `admission_${applicantName.replace(/\s/g, '_')}_${Date.now()}.pdf`;

    // Send email notification with the PDF
    await sendAdmissionEmail(applicantName, pdfBuffer, pdfFileName);

    return {
      message: 'success',
    };

  } catch (error: any) {
    console.error('Error processing admission form:', error);
    return {
      message: `An error occurred: ${error.message}`,
    };
  }
}
