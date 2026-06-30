'use server';

import { z } from 'zod';
import dotenv from 'dotenv';
import nodemailer from 'nodemailer';

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

// Validation Schema for Teacher Application
const teacherApplicationSchema = z.object({
  fullName: z.string().min(2, { message: 'Full name must be at least 2 characters.' }),
  email: z.string().email({ message: 'Please enter a valid email address.' }),
  mobileNumber: z.string().min(5, { message: 'Please enter a valid mobile number.' }),
  whatsAppNumber: z.string().optional(),
  applicantType: z.string().min(1, { message: 'Applicant type is required.' }),
  positionApplyingFor: z.string().min(1, { message: 'Position applying for is required.' }),
  highestQualification: z.string().min(1, { message: 'Highest qualification is required.' }),
  personalStatement: z.string().optional(),
});

export type TeacherApplicationState = {
  message: string;
  errors?: { [key: string]: string[] };
};

export async function submitTeacherApplication(
  prevState: TeacherApplicationState | undefined,
  formData: FormData
): Promise<TeacherApplicationState> {
  // Validate text fields
  const validatedFields = teacherApplicationSchema.safeParse({
    fullName: formData.get('fullName'),
    email: formData.get('email'),
    mobileNumber: formData.get('mobileNumber'),
    whatsAppNumber: formData.get('whatsAppNumber'),
    applicantType: formData.get('applicantType'),
    positionApplyingFor: formData.get('positionApplyingFor'),
    highestQualification: formData.get('highestQualification'),
    personalStatement: formData.get('personalStatement'),
  });

  if (!validatedFields.success) {
    return {
      message: 'Validation failed. Please check the fields.',
      errors: validatedFields.error.flatten().fieldErrors,
    };
  }

  const { fullName, email } = validatedFields.data;

  // Retrieve SMTP config
  const smtpHost = process.env.SMTP_HOST;
  const smtpPort = parseInt(process.env.SMTP_PORT || '587');
  const smtpSecure = process.env.SMTP_SECURE === 'true';
  const smtpUser = process.env.SMTP_USER;
  const smtpPass = process.env.SMTP_PASSWORD;
  const adminEmail = process.env.ADMIN_EMAIL || 'info@cmfischool.online';

  if (!smtpHost || !smtpUser || !smtpPass) {
    console.error('SMTP environment variables are not fully configured.');
    return {
      message: 'Server configuration error. SMTP credentials are not configured.',
    };
  }

  // Parse files from FormData into Node buffers for attachment
  const getAttachment = async (name: string, label: string) => {
    const file = formData.get(name) as File | null;
    if (file && file.size > 0) {
      const buffer = Buffer.from(await file.arrayBuffer());
      return {
        filename: file.name || `${label}.pdf`,
        content: buffer,
      };
    }
    return null;
  };

  const attachmentConfigs = [
    { name: 'cv', label: 'CV_Resume' },
    { name: 'academicCertificate', label: 'Academic_Certificate' },
    { name: 'transcript', label: 'Transcript' },
    { name: 'professionalCertificate', label: 'Professional_Certificate' },
    { name: 'idCard', label: 'ID_Card' },
    { name: 'photo', label: 'Passport_Photo' },
    { name: 'policeClearance', label: 'Police_Clearance' },
    { name: 'recommendationLetter', label: 'Recommendation_Letter' },
  ];

  const attachments = [];
  try {
    for (const config of attachmentConfigs) {
      const attachment = await getAttachment(config.name, config.label);
      if (attachment) {
        attachments.push(attachment);
      }
    }
  } catch (fileError) {
    console.error('Error processing attachments:', fileError);
    return {
      message: 'An error occurred while processing your uploaded documents. Please make sure files are not corrupt.',
    };
  }

  // Construct Email content for Admin
  const formatField = (key: string) => formData.get(key) || 'Not Provided';
  
  const adminHtml = `
    <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
      <h2 style="color: #2962FF; border-bottom: 2px solid #2962FF; padding-bottom: 8px;">CMFI Bilingual High School - Teacher Application</h2>
      <p><strong>Academic Year:</strong> 2026/2027</p>
      <p><strong>Submitted On:</strong> ${new Date().toLocaleString()}</p>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px;">Section 1: Personal Information</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Full Name:</td><td style="border-bottom: 1px solid #eee;">${formatField('fullName')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Gender:</td><td style="border-bottom: 1px solid #eee;">${formatField('gender')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Date of Birth:</td><td style="border-bottom: 1px solid #eee;">${formatField('dob')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Nationality:</td><td style="border-bottom: 1px solid #eee;">${formatField('nationality')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">City/County of Residence:</td><td style="border-bottom: 1px solid #eee;">${formatField('cityOfResidence')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Mobile Number:</td><td style="border-bottom: 1px solid #eee;">${formatField('mobileNumber')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">WhatsApp Number:</td><td style="border-bottom: 1px solid #eee;">${formatField('whatsAppNumber')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Email Address:</td><td style="border-bottom: 1px solid #eee;">${formatField('email')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Home Address:</td><td style="border-bottom: 1px solid #eee;">${formatField('homeAddress')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Emergency Contact Name:</td><td style="border-bottom: 1px solid #eee;">${formatField('emergencyName')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Emergency Contact Number:</td><td style="border-bottom: 1px solid #eee;">${formatField('emergencyNumber')}</td></tr>
      </table>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 2: Position Information</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Applicant Type:</td><td style="border-bottom: 1px solid #eee;">${formatField('applicantType')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Position Applying For:</td><td style="border-bottom: 1px solid #eee;">${formatField('positionApplyingFor')} ${formatField('otherPosition') !== 'Not Provided' ? `(${formatField('otherPosition')})` : ''}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Subjects Can Teach:</td><td style="border-bottom: 1px solid #eee;">${formatField('subjectsCanTeach')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Grade Levels Preferred:</td><td style="border-bottom: 1px solid #eee;">${formatField('gradesPreferred')}</td></tr>
      </table>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 3: Educational Background</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Highest Qualification:</td><td style="border-bottom: 1px solid #eee;">${formatField('highestQualification')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Institution Attended:</td><td style="border-bottom: 1px solid #eee;">${formatField('institution')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Graduation Year:</td><td style="border-bottom: 1px solid #eee;">${formatField('graduationYear')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Major/Area of Study:</td><td style="border-bottom: 1px solid #eee;">${formatField('major')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Professional Certifications:</td><td style="border-bottom: 1px solid #eee;">${formatField('certifications')}</td></tr>
      </table>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 4: Teaching Experience</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Total Experience:</td><td style="border-bottom: 1px solid #eee;">${formatField('yearsExperience')} Years</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Last Current/Previous School:</td><td style="border-bottom: 1px solid #eee;">${formatField('previousSchool')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Position Held:</td><td style="border-bottom: 1px solid #eee;">${formatField('prevPosition')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Subjects Taught:</td><td style="border-bottom: 1px solid #eee;">${formatField('prevSubjects')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Employment Period:</td><td style="border-bottom: 1px solid #eee;">${formatField('prevPeriod')}</td></tr>
        ${formatField('applicantType') === 'New Applicant' ? `
          <tr><td style="font-weight: bold; border-bottom: 1px solid #eee; vertical-align: top;">Additional Prior Employers:</td><td style="border-bottom: 1px solid #eee;">
            <strong>Employer 1:</strong> ${formatField('newAppEmployer1')}<br/>
            <strong>Employer 2:</strong> ${formatField('newAppEmployer2')}
          </td></tr>
        ` : ''}
      </table>
      
      ${formatField('applicantType') === 'Current Teacher (Reapplying)' ? `
        <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 5: Current Teacher Reapplication</h3>
        <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
          <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Current Dept/Grade:</td><td style="border-bottom: 1px solid #eee;">${formatField('currentDept')}</td></tr>
          <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Years Served at CMFI:</td><td style="border-bottom: 1px solid #eee;">${formatField('yearsServed')} Years</td></tr>
          <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Achievements:</td><td style="border-bottom: 1px solid #eee;">${formatField('achievements')}</td></tr>
          <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Challenges Faced:</td><td style="border-bottom: 1px solid #eee;">${formatField('challenges')}</td></tr>
          <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Why Continue:</td><td style="border-bottom: 1px solid #eee;">${formatField('whyContinue')}</td></tr>
        </table>
      ` : ''}
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 6: Skills & Competencies</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 35%; font-weight: bold; border-bottom: 1px solid #eee;">Classroom Management:</td><td style="border-bottom: 1px solid #eee;">${formatField('classroomManagement')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Lesson Planning:</td><td style="border-bottom: 1px solid #eee;">${formatField('lessonPlanning')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Student Assessment:</td><td style="border-bottom: 1px solid #eee;">${formatField('studentAssessment')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Computer Skills:</td><td style="border-bottom: 1px solid #eee;">${formatField('computerSkills')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Microsoft Word:</td><td style="border-bottom: 1px solid #eee;">${formatField('msWord')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Microsoft Excel:</td><td style="border-bottom: 1px solid #eee;">${formatField('msExcel')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Google Workspace:</td><td style="border-bottom: 1px solid #eee;">${formatField('googleWorkspace')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Online Teaching Platforms:</td><td style="border-bottom: 1px solid #eee;">${formatField('onlinePlatforms')}</td></tr>
      </table>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 7: Conduct & Declaration</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 35%; font-weight: bold; border-bottom: 1px solid #eee;">Dismissed from previous job?</td><td style="border-bottom: 1px solid #eee;">${formatField('dismissed')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Criminal offense conviction?</td><td style="border-bottom: 1px solid #eee;">${formatField('convicted')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Will abide by school rules?</td><td style="border-bottom: 1px solid #eee;">${formatField('abidePolicies')}</td></tr>
      </table>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 8: Professional References</h3>
      <div style="margin-left: 10px; margin-bottom: 15px;">
        <p><strong>Reference 1:</strong><br/>
           Name: ${formatField('ref1Name')}<br/>
           Position: ${formatField('ref1Position')} at ${formatField('ref1Org')}<br/>
           Contact: Phone: ${formatField('ref1Phone')}, Email: ${formatField('ref1Email')}
        </p>
        <p><strong>Reference 2:</strong><br/>
           Name: ${formatField('ref2Name')}<br/>
           Position: ${formatField('ref2Position')} at ${formatField('ref2Org')}<br/>
           Contact: Phone: ${formatField('ref2Phone')}, Email: ${formatField('ref2Email')}
        </p>
      </div>
      
      <h3 style="color: #1a237e; background-color: #E6F0FF; padding: 6px 12px; border-radius: 4px; margin-top: 20px;">Section 9 & 10: Availability & Personal Statement</h3>
      <table border="0" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <tr><td style="width: 30%; font-weight: bold; border-bottom: 1px solid #eee;">Available Start Date:</td><td style="border-bottom: 1px solid #eee;">${formatField('startDate')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Full-Time / Part-Time:</td><td style="border-bottom: 1px solid #eee;">${formatField('commitmentType')}</td></tr>
        <tr><td style="font-weight: bold; border-bottom: 1px solid #eee;">Other Commitments:</td><td style="border-bottom: 1px solid #eee;">${formatField('otherCommitments')}</td></tr>
      </table>
      <div style="margin-top: 15px; padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; background-color: #fafafa;">
        <strong>Personal Statement:</strong><br/>
        <p style="white-space: pre-line;">${formatField('personalStatement')}</p>
      </div>
      
      <p style="margin-top: 25px; font-size: 11px; color: #666; font-style: italic;">
        Applicant certified the declaration at submission.
      </p>
    </div>
  `;

  // Construct Email content for Applicant (Auto-response)
  const applicantHtml = `
    <div style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 8px; color: #333;">
      <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #2962FF; margin-bottom: 5px;">CMFI Bilingual High School</h2>
        <span style="font-size: 12px; text-transform: uppercase; tracking: 0.1em; color: #666;">Knowledge - Character - Leadership</span>
      </div>
      <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;" />
      
      <p>Dear <strong>${fullName}</strong>,</p>
      <p>Thank you for submitting your application to join our teaching faculty for the upcoming <strong>2026/2027 Academic Year</strong>.</p>
      <p>We have successfully received your personal information, teaching credentials, and uploaded supporting files. Our hiring committee will review your application details shortly.</p>
      
      <div style="background-color: #E6F0FF; border-left: 4px solid #2962FF; padding: 18px; border-radius: 4px; margin: 25px 0;">
        <h4 style="margin: 0 0 10px 0; color: #1a237e; font-size: 16px;">Connect with Us Directly</h4>
        <p style="margin: 0 0 15px 0; font-size: 13px; color: #555;">To inquire immediately about your application status or ask any questions regarding recruitment, you can contact our admissions and staffing office directly on WhatsApp.</p>
        <a href="https://wa.me/YOUR_PLACEHOLDER_NUMBER" target="_blank" style="background-color: #25D366; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; font-size: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
          Chat with Recruitment on WhatsApp
        </a>
      </div>
      
      <p>Our team will contact you via email or phone call if your credentials align with our educational needs for the upcoming school year.</p>
      
      <p style="margin-top: 30px;">Warm regards,</p>
      <p style="margin-bottom: 0;"><strong>Administrator & Recruitment Board</strong></p>
      <p style="margin-top: 0; font-size: 13px; color: #666;">CMFI Bilingual High School, Paynesville, Liberia</p>
    </div>
  `;

  try {
    const transporter = nodemailer.createTransport({
      host: smtpHost,
      port: smtpPort,
      secure: smtpSecure,
      auth: {
        user: smtpUser,
        pass: smtpPass,
      },
    });

    // Send Admin Email with attachments
    await transporter.sendMail({
      from: `"CMFI Recruitment Portal" <${smtpUser}>`,
      to: adminEmail,
      subject: `[Teacher Application] 2026/2027 - ${fullName}`,
      html: adminHtml,
      attachments: attachments,
    });

    // Send Applicant Email
    await transporter.sendMail({
      from: `"CMFI Admissions & Staffing" <${smtpUser}>`,
      to: email,
      subject: `Application Received - CMFI Bilingual High School`,
      html: applicantHtml,
    });

    return { message: 'success' };
  } catch (emailError: any) {
    console.error('SMTP Email sending error:', emailError);
    return {
      message: `Failed to send email. Error: ${emailError?.message || 'Unknown SMTP error'}`,
    };
  }
}

