# Teacher Recruitment System Blueprint

## Context

CMFI already has a public-facing teacher application flow in the website codebase, but the current flow is email-driven. Applications and files are submitted, then forwarded by email, which means there is no reliable internal tracking, scoring, stage management, or reporting layer.

This blueprint defines a proper teacher recruitment and reapplication management system for the 2026/2027 academic year and beyond.

Proposed stack:

- Laravel
- Blade
- Vite
- MySQL

Confirmed product decisions:

- deploy as a separate Laravel application
- current teachers reapply through a public link, not login-first
- applicant status remains internal only in version one
- hiring workflow includes demo lessons and classroom observation forms
- version one should support email plus WhatsApp/SMS notifications

## Current Gap

Current public flow in this repo:

- `src/app/careers/apply/page.tsx`
- `src/lib/actions.ts`

Observed limitations:

- No database record for applicants
- No stage pipeline
- No interview notes workspace
- No structured scorecards
- No document checklist tracking beyond email attachments
- No reapplication history for current teachers
- No analytics dashboard for hiring progress
- No reviewer permissions or audit trail

## Product Goal

Build a recruitment system that can:

- collect teacher applications
- distinguish new applicants from current-teacher reapplications
- track required document completeness
- manage screening, interview, and decision stages
- capture interview notes and rating scorecards
- flag missing items and follow-ups
- generate reports and hiring analytics
- preserve a history of past applications and outcomes

## Recommended Product Scope

### 1. Public Application Portal

Purpose:

- allow new teachers and current teachers to apply online

Key features:

- multi-step application form
- save draft support
- file uploads for required documents
- conditional fields for current teachers vs new applicants
- confirmation page and acknowledgement email
- application reference number
- reapplication option through the same public entry path

Recommendation:

- keep this separate from the internal HR/staff dashboard
- allow the public form to write directly into MySQL instead of sending only email
- because this is a separate Laravel app, plan for light integration points later rather than coupling version one to an existing school SIS

### 2. Internal Recruitment Dashboard

Purpose:

- give school leadership and HR a single place to review and manage all applications

Key features:

- applicant list with filters
- stage tracking
- document completeness status
- shortlist / reject / hold actions
- reviewer assignment
- interview scheduling
- interview notes
- scoring and recommendation capture
- final decision logging

### 3. Reapplication Management

Purpose:

- treat current teachers as a separate workflow, not just another applicant type

Key features:

- link reapplication to existing staff profile
- compare current-year reapplication against prior-year service data
- capture achievements, challenges, and continuation rationale
- supervisor comments
- retention recommendation

Implementation note:

- current teachers should use a public reapplication link with extra identifying fields so HR can match them to existing staff records during review

## Recommended Roles

### `super_admin`

- full system access
- system settings
- user and role management
- final reporting access

### `hr_admin`

- manage vacancies
- review applicants
- move candidates across pipeline stages
- request missing documents
- schedule interviews

### `principal`

- review shortlisted applicants
- add final comments
- approve or decline final recommendation

### `department_head`

- review subject-fit
- score interview and demo lesson
- add academic comments

### `interviewer`

- access assigned candidates only
- complete interview notes and scorecards

### `staff_reviewer`

- read-only or limited-comment access where needed

## Recommended Recruitment Pipeline

Use a fixed pipeline first. Make it configurable later.

### New Applicant Pipeline

1. Application Received
2. Under Review
3. Documents Incomplete
4. Shortlisted
5. Interview Scheduled
6. Interview Completed
7. Demo Lesson Scheduled
8. Demo Lesson Completed
9. Classroom Observation Review
10. Reference Check
11. Final Review
12. Offer Approved
13. Hired
14. Rejected
15. Withdrawn

### Current Teacher Reapplication Pipeline

1. Reapplication Submitted
2. Department Review
3. Performance Review
4. Interview or Renewal Meeting
5. Final Decision
6. Renewed
7. Not Renewed

## Core Modules

### 1. Vacancy and Position Management

- academic year setup
- job opening creation
- department
- position type
- subject specialization
- grade bands
- number of openings
- hiring status

### 2. Applicant Profile

Each applicant should have one master profile with:

- bio data
- contact details
- emergency contact
- applicant type
- preferred grades
- teachable subjects
- education history
- experience history
- references
- availability
- personal statement

### 3. Document Management

Required documents should be tracked individually, not just as a file bundle.

Recommended document types:

- CV/Resume
- Academic Certificate
- Transcript
- Professional Certificate
- National ID or Passport
- Passport Photo
- Police Clearance
- Recommendation Letter

Per-document fields:

- uploaded
- verified
- rejected
- replacement requested
- verified by
- verified at
- note

### 4. Screening and Review

Internal reviewers should be able to record:

- meets minimum qualification
- subject fit
- years of experience fit
- salary expectation if later added
- shortlist recommendation
- red flags
- follow-up actions

### 5. Interview Management

Recommended interview types:

- phone screening
- panel interview
- subject interview
- demo lesson
- classroom observation
- renewal meeting for current teachers

For each interview:

- date
- time
- venue or online link
- assigned interviewers
- attendance status
- interview notes
- rating criteria
- final recommendation

Additional for demo lesson / classroom observation:

- class level observed
- subject observed
- lesson objective
- observer rubric
- learner engagement notes
- pedagogy notes
- classroom control notes
- post-observation recommendation

### 6. Notes and Checkmarks

This is one of the most important parts for your use case.

Support three note layers:

- private reviewer notes
- shared panel notes
- final decision notes

Support checklist blocks:

- documents checklist
- screening checklist
- interview checklist
- onboarding-ready checklist

### 7. Analytics and Reporting

Dashboard metrics should include:

- total applicants by academic year
- new applicants vs reapplicants
- applicants by position
- applicants by subject
- stage counts
- document completion rate
- shortlist rate
- interview-to-offer ratio
- offer acceptance rate
- average time in stage
- top rejection reasons
- hiring outcome by department

## Recommended Interview Scorecard

Use structured scoring instead of free-text only.

Score each item on a 1 to 5 scale:

- subject mastery
- communication
- classroom management presence
- lesson planning depth
- child engagement approach
- professionalism
- technology readiness
- values and culture fit

Additional for reapplying teachers:

- prior-year impact
- collaboration with staff
- consistency and reliability
- learner outcomes contribution

Derived outputs:

- average score
- interviewer recommendation
- final panel recommendation

Recommendation:

- do not auto-hire based on score alone
- use thresholds only for prioritization and reporting

## Recommended Data Model

### Main Tables

- `academic_years`
- `departments`
- `positions`
- `job_openings`
- `applicants`
- `applications`
- `application_subjects`
- `application_grade_preferences`
- `education_records`
- `employment_records`
- `references`
- `application_documents`
- `document_types`
- `application_stages`
- `application_stage_history`
- `application_reviews`
- `interviews`
- `interview_panelists`
- `interview_scorecards`
- `interview_score_items`
- `application_notes`
- `application_tasks`
- `staff_profiles`
- `reapplication_links`
- `users`
- `roles`
- `audit_logs`

### Design Intent

`applicants`:

- person-level identity
- can apply multiple times across years

`applications`:

- one submission for one academic year / opening
- carries status and outcome

`application_stage_history`:

- full audit of who moved the applicant and when

`application_documents`:

- stores each uploaded file and its verification state

`interview_scorecards`:

- one scorecard per interviewer per interview

`reapplication_links`:

- ties an application to an existing staff member record

## Suggested Applicant Status Logic

Use both:

- `current_stage`
- `decision_status`

Example:

- `current_stage = Interview Completed`
- `decision_status = Pending`

This avoids overloading one field for the whole lifecycle.

## Suggested UI Pages

### Public Side

- `Apply to Teach`
- `Application Success`
- `Resume Draft`
- `Track Application` later if needed

### Internal Side

- Dashboard
- Open Positions
- Applicants
- Applicant Detail
- Interview Calendar
- Reapplications
- Reports
- Settings
- Users and Permissions

### Applicant Detail Page Sections

- profile summary
- application form snapshot
- uploaded documents
- screening notes
- stage timeline
- interview records
- references
- decision summary
- activity log

## Recommended Automation

### Notifications

- application received
- missing document request
- interview invitation
- interview reminder
- status update
- offer notification
- rejection message
- WhatsApp/SMS reminders for interview and missing-document follow-up

### Internal Triggers

- notify HR when a new application is submitted
- notify assigned reviewer when an application is moved to review
- notify panelists when an interview is scheduled
- notify decision-makers when all scorecards are complete
- notify candidates by email and WhatsApp/SMS when interviews are scheduled or documents are missing

### Useful Background Jobs

- document virus-scan hook if introduced later
- reminder emails
- reminder SMS / WhatsApp dispatch
- stale application alerts
- nightly metrics summary

## Security and Data Handling Recommendations

Because this system stores CVs, IDs, transcripts, and other sensitive records, security should be built in from day one.

Recommended controls:

- role-based access control
- per-role page and action authorization
- audit trail for stage changes and notes
- private file storage outside public web root
- randomized stored filenames
- file type allowlist
- file size limits
- MIME and extension validation
- malware scanning hook later
- encrypted backups
- retention and archive rules

Practical recommendation for Laravel:

- store files with Laravel `Storage` on a private disk
- serve documents through authorized controller responses
- never expose raw upload paths publicly

## Research-Based Design Recommendations

These recommendations are based on current ATS and security patterns and then adapted for a school teacher-hiring workflow.

### Recommendation 1: Keep a searchable candidate database

Rationale:

- past applicants become future talent pools
- reapplication becomes easier
- school leadership can review trends across academic years

### Recommendation 2: Use standardized interview scorecards

Rationale:

- reduces inconsistent panel decisions
- improves fairness
- makes reporting possible

### Recommendation 3: Separate applicant data, application records, and documents

Rationale:

- one person may apply more than once
- documents may be re-uploaded or re-verified
- a school needs long-term historical records

### Recommendation 4: Make document completeness visible at list level

Rationale:

- HR should see missing files without opening every record
- this is one of the fastest operational wins

### Recommendation 5: Add stage history from the start

Rationale:

- schools need accountability on who moved an applicant
- avoids confusion around silent changes

### Recommendation 6: Treat reapplying teachers as a dedicated workflow

Rationale:

- retention decisions depend on prior service, not just the new form
- current teachers need manager comments and renewal context

## Suggested Phase Plan

### Phase 1: Foundation

- academic years
- positions and openings
- public application form
- applicant and application tables
- document uploads
- admin login
- applicant listing

### Phase 2: Review Workflow

- stage pipeline
- stage history
- screening notes
- missing-document requests
- filters and search

### Phase 3: Interview Management

- interview scheduling
- panel assignment
- scorecards
- interview notes
- recommendations

### Phase 4: Analytics and Decisioning

- dashboards
- exportable reports
- rejection reasons
- shortlist and conversion metrics

### Phase 5: Reapplication and Staff Integration

- staff profile linkage
- prior-year history
- renewal workflow
- supervisor review

## Laravel Implementation Recommendation

For this stack, I recommend:

- Laravel 12 or current stable Laravel version at build time
- Blade for admin pages
- Vite for assets
- MySQL for persistence
- Laravel Fortify or Breeze as auth baseline
- Spatie Laravel Permission for roles and permissions
- Laravel Policies for record-level access
- Laravel Notifications for email and internal alerts
- Laravel Queues for reminders and async jobs
- provider integration layer for SMS / WhatsApp delivery

Optional later:

- FullCalendar for interview calendar UI
- Laravel Excel for exports
- media library package if file handling becomes complex

Notification provider note:

- for version one, keep messaging behind a small notification abstraction so email can ship first and WhatsApp/SMS providers can be swapped without rewriting workflow logic

## Risks to Avoid

- storing files publicly
- using only email as system of record
- mixing public applicants and internal staff data in one unstructured table
- making interview notes editable without audit history
- using only free-text review without structured scoring
- allowing all admins to see all sensitive documents by default

## Recommended MVP

If you want the smallest strong first version, build this first:

1. Public application form writing to database
2. Admin login
3. Applicant listing with filters
4. Applicant detail page
5. Document checklist with verification
6. Stage movement with history
7. Interview note entry
8. Demo lesson and classroom observation forms
9. Basic dashboard metrics
10. Email plus WhatsApp/SMS notification hooks

That MVP is enough to replace email chaos and create a real hiring workflow.

## Open Questions

These answers will change the final blueprint and schema:

1. Do you want department heads to score candidates separately from HR?
2. Should the system support offer letters and onboarding later, or stop at hiring decision?
3. Should only HR see sensitive documents like IDs and police clearances?
4. Which provider do you want for version-one messaging: SMS, WhatsApp, or both from the same provider?
5. For current teacher reapplication matching, what identifier should HR rely on first: staff ID, phone number, email, or employee code?

## Source Notes

Useful external references reviewed for this blueprint:

- OWASP guidance on unrestricted file upload risk and validation controls
- Workable ATS feature references for candidate database, standardized scorecards, interview coordination, permissions, analytics, audit trails, and compliance-oriented controls

This blueprint adapts those general hiring patterns to a school-specific teacher recruitment workflow rather than copying a generic corporate ATS.
