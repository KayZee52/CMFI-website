<x-mail::message>
# Application Received!

Dear {{ $application->applicant->full_name }},

Thank you for your interest in joining the educational faculty at **CMFI Bilingual High School**. We have successfully received your application for the position of **{{ $application->position_applying_for }}**.

### Your Application Details:
- **Reference Number:** #{{ $application->reference_number }}
- **Submitted On:** {{ $application->submitted_at->format('M d, Y') }}

---

### Stay Connected
To stay updated on the recruitment process, interview schedules, and other important announcements, please join our official WhatsApp group for 2026/2027 applicants.

<x-mail::button :url="'https://chat.whatsapp.com/JtG7tq9iJS63npg9EX0J6w?mode=gi_t'">
Join Applicants Group
</x-mail::button>

Our recruitment team will review your documents and contact you if you are shortlisted for the next phase.

Best regards,

**The Recruitment Team**  
CMFI Bilingual High School
</x-mail::message>
