<x-mail::message>
# New Application Received

A new teacher application has been submitted through the career portal.

### Applicant Information:
- **Name:** {{ $application->applicant->full_name }}
- **Email:** {{ $application->applicant->email }}
- **Position Applied For:** {{ $application->position_applying_for }}
- **Reference Number:** #{{ $application->reference_number }}
- **Submitted At:** {{ $application->submitted_at->format('M d, Y H:i') }}

<x-mail::button :url="config('app.url') . '/admin/applicants/' . $application->applicant->id">
Review Application
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
