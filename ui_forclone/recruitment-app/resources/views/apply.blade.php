<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Application | CMFI Bilingual High School</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CDN (Ensures design works without local compilation) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        headline: ['Poppins', 'sans-serif'],
                        body: ['Roboto', 'sans-serif'],
                    },
                    colors: {
                        slate: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                            600: '#475569',
                            500: '#64748b',
                            400: '#94a3b8',
                            200: '#e2e8f0',
                            100: '#f1f5f9',
                            50: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer components {
            .input-class {
                @apply w-full rounded-lg border border-slate-200 bg-slate-50/30 px-4 py-3 text-base transition-all focus:bg-white focus:border-slate-800 focus:ring-0 focus:outline-none;
            }
            .btn-primary {
                @apply bg-slate-900 text-white font-semibold py-4 px-8 rounded-lg transition-all hover:bg-slate-800 flex items-center justify-center gap-2 disabled:opacity-50;
            }
            .btn-secondary {
                @apply bg-white text-slate-600 font-semibold py-4 px-8 rounded-lg border border-slate-200 transition-all hover:text-slate-900 hover:border-slate-300;
            }
            .form-label {
                @apply text-[13px] font-bold text-slate-600 uppercase tracking-wider block mb-2;
            }
        }

        [x-cloak] { display: none !important; }
        
        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen bg-[#fafafa] font-body text-slate-800 antialiased">

    <div x-data="applicationForm()" x-init="init()" x-cloak>
        <!-- Header -->
        <header class="w-full border-b border-slate-100 bg-white py-5 sticky top-0 z-40">
            <div class="max-w-3xl mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="CMFI Logo" class="h-8 w-auto">
                    <span class="font-headline text-lg font-bold tracking-tight text-slate-900">CMFI BHS</span>
                </div>
            </div>
        </header>

        <!-- Main Container -->
        <main class="py-12 px-6">
            <div class="max-w-3xl mx-auto space-y-10">

                <!-- Title -->
                <div class="text-center space-y-3">
                    <h1 class="font-headline text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Teacher
                        Application</h1>
                    <p class="text-sm sm:text-base text-slate-500 max-w-lg mx-auto leading-relaxed">Join our educational
                        faculty for the 2026/2027 Academic Year. We are looking for passionate educators to join our
                        mission.</p>
                </div>

                <!-- Progress Bar -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]"
                                x-text="'Step ' + getActiveStepIndex() + ' of ' + totalActiveSteps()"></p>
                            <h3 class="font-headline font-bold text-slate-900 text-lg" x-text="getCurrentStepName()">
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-900"
                                x-text="Math.round(progressPercent()) + '%'"></span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200/50 h-2 rounded-full overflow-hidden">
                        <div class="bg-slate-900 h-full transition-all duration-500 ease-out"
                            :style="'width: ' + progressPercent() + '%'"></div>
                    </div>
                </div>

                <!-- Form Card -->
                <div
                    class="bg-white rounded-3xl border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.02),0_10px_20px_rgba(0,0,0,0.01)] p-8 sm:p-12 overflow-hidden relative">
                    <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data"
                        @submit="isPending = true">
                        @csrf

                        <!-- Step 0: Selection -->
                        <div x-show="currentStep === 0" class="space-y-10 animate-fadeIn py-4">
                            <div class="text-center space-y-2">
                                <h2 class="text-3xl font-black text-slate-900 font-headline">Welcome</h2>
                                <p class="text-slate-500">Please select your application type to begin.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <button type="button" @click="applicantType = 'new'; handleNext()"
                                    class="group p-8 rounded-3xl border-2 transition-all duration-300 text-left hover:shadow-xl flex flex-col gap-4"
                                    :class="applicantType === 'new' ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-100 bg-slate-50 text-slate-600 hover:border-slate-200'">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                        :class="applicantType === 'new' ? 'bg-white/10' : 'bg-white'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-xl font-headline">New Applicant</h3>
                                        <p class="text-sm opacity-70">Applying to join our faculty for the first time.</p>
                                    </div>
                                </button>

                                <button type="button" @click="applicantType = 'current_teacher'; handleNext()"
                                    class="group p-8 rounded-3xl border-2 transition-all duration-300 text-left hover:shadow-xl flex flex-col gap-4"
                                    :class="applicantType === 'current_teacher' ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-100 bg-slate-50 text-slate-600 hover:border-slate-200'">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                        :class="applicantType === 'current_teacher' ? 'bg-white/10' : 'bg-white'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-xl font-headline">Current Staff</h3>
                                        <p class="text-sm opacity-70">Reapplying for the next academic year.</p>
                                    </div>
                                </button>
                            </div>
                            <input type="hidden" name="applicant_type" :value="applicantType">
                        </div>

                        <!-- Step 1: Personal Info -->
                        <div x-show="currentStep === 1" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Personal Information</h2>
                                <p class="text-sm text-slate-500">Contact and emergency details.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2">
                                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="full_name" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Gender <span class="text-red-500">*</span></label>
                                    <select name="gender" class="input-class" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Date of Birth <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_of_birth" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Nationality <span class="text-red-500">*</span></label>
                                    <input type="text" name="nationality" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">City of Residence <span class="text-red-500">*</span></label>
                                    <input type="text" name="city_of_residence" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Mobile Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">WhatsApp Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="whatsapp_number" class="input-class" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="input-class" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Home Address <span class="text-red-500">*</span></label>
                                    <textarea name="home_address" class="input-class" rows="2" required></textarea>
                                </div>

                                <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Emergency
                                        Contact</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="form-label">Contact Name <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="emergency_name" class="input-class" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Contact Number <span
                                                    class="text-red-500">*</span></label>
                                            <input type="tel" name="emergency_number" class="input-class" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Position Details -->
                        <div x-show="currentStep === 2" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Position Details</h2>
                                <p class="text-sm text-slate-500">Select the role you are applying for.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2">
                                    <label class="form-label">Position Applying For <span
                                            class="text-red-500">*</span></label>
                                    <select name="job_opening_id" class="input-class" required>
                                        @foreach ($openings as $opening)
                                            <option value="{{ $opening->id }}">{{ $opening->position->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Subjects You Can Teach <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="subjects_can_teach" class="input-class"
                                        placeholder="e.g. Mathematics, Physics" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Grade Level(s) Preferred <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="grades_preferred" class="input-class"
                                        placeholder="e.g. Grade 7, Grade 8" required>
                                </div>
                                <div>
                                    <label class="form-label">Employment Type <span class="text-red-500">*</span></label>
                                    <select name="commitment_type" class="input-class" required>
                                        <option value="Full-Time">Full-Time</option>
                                        <option value="Part-Time">Part-Time</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Available Start Date <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="available_start_date" class="input-class" required>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Education & Documents -->
                        <div x-show="currentStep === 3" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Education & Documents</h2>
                                <p class="text-sm text-slate-500">Provide your academic background and required proofs.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Highest Qualification <span
                                            class="text-red-500">*</span></label>
                                    <select name="highest_qualification" class="input-class" required>
                                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                                        <option value="Master's Degree">Master's Degree</option>
                                        <option value="Doctorate">Doctorate</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Institution <span class="text-red-500">*</span></label>
                                    <input type="text" name="institution" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Graduation Year <span class="text-red-500">*</span></label>
                                    <input type="number" name="graduation_year" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Major / Area of Study</label>
                                    <input type="text" name="major" class="input-class">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Professional Certifications</label>
                                    <input type="text" name="certifications" class="input-class"
                                        placeholder="List any certifications (comma separated)">
                                </div>

                                <div class="sm:col-span-2 pt-6 border-t border-slate-100">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6">Required
                                        Documents</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                        <div class="space-y-1">
                                            <label class="form-label">CV / Resume <span
                                                    class="text-red-500">*</span></label>
                                            <input type="file" name="cv" class="text-sm text-slate-500" required>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="form-label">Passport Photo <span
                                                    class="text-red-500">*</span></label>
                                            <input type="file" name="photo" class="text-sm text-slate-500" required>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="form-label">Academic Certificates</label>
                                            <input type="file" name="academic_certificates"
                                                class="text-sm text-slate-500">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="form-label">Transcripts</label>
                                            <input type="file" name="transcripts" class="text-sm text-slate-500">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="form-label">National ID / Passport</label>
                                            <input type="file" name="identification_card"
                                                class="text-sm text-slate-500">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="form-label">Police Clearance</label>
                                            <input type="file" name="police_clearance" class="text-sm text-slate-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Teaching Experience -->
                        <div x-show="currentStep === 4" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Teaching Experience</h2>
                                <p class="text-sm text-slate-500">Provide details of your professional journey.</p>
                            </div>

                            <div class="space-y-10">
                                <div>
                                    <label class="form-label">Total Years of Experience <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="years_experience" class="input-class w-32" required>
                                </div>

                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Most Recent
                                        Employer</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">School / Organization</label>
                                            <input type="text" name="previous_school" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Position Held</label>
                                            <input type="text" name="prev_position" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Employment Period</label>
                                            <input type="text" name="prev_period" class="input-class"
                                                placeholder="e.g. 2020 - 2023">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Secondary
                                        Employer</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">School / Organization</label>
                                            <input type="text" name="prev_school_2" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Position Held</label>
                                            <input type="text" name="prev_position_2" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Employment Period</label>
                                            <input type="text" name="prev_period_2" class="input-class"
                                                placeholder="e.g. 2018 - 2020">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: For Current Teachers -->
                        <div x-show="currentStep === 5" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Staff Reapplication</h2>
                                <p class="text-sm text-slate-500">For our valued returning faculty members.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Current Dept / Grade</label>
                                    <input type="text" name="current_dept" class="input-class">
                                </div>
                                <div>
                                    <label class="form-label">Years Served at CMFI</label>
                                    <input type="number" name="years_served" class="input-class">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Major Achievements During Service</label>
                                    <textarea name="achievements" class="input-class" rows="3"></textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Challenges Faced Last Year</label>
                                    <textarea name="challenges" class="input-class" rows="3"></textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Why would you like to continue?</label>
                                    <textarea name="why_continue" class="input-class" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Skills Proficiency -->
                        <div x-show="currentStep === 6" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Skills & Competencies</h2>
                                <p class="text-sm text-slate-500">Rate your proficiency (1 = Beginner, 5 = Expert).</p>
                            </div>

                            <div class="space-y-4">
                                <template x-for="skill in skills" :key="skill.id">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-colors gap-4">
                                        <span class="font-bold text-slate-900" x-text="skill.label"></span>
                                        <div class="flex gap-2">
                                            <template x-for="n in 5">
                                                <label class="cursor-pointer">
                                                    <input type="radio" :name="'skills_proficiency[' + skill.id + ']'" :value="n" class="hidden peer">
                                                    <div class="w-10 h-10 rounded-xl bg-white border-2 border-slate-100 flex items-center justify-center text-slate-400 font-bold peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all hover:border-slate-300" x-text="n"></div>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Step 7: Character & Conduct -->
                        <div x-show="currentStep === 7" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Character & Conduct</h2>
                                <p class="text-sm text-slate-500">Verification of standards and ethics.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Have you ever been dismissed from a previous job?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="dismissed" value="No" checked class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="dismissed" value="Yes" class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Have you ever been convicted of a criminal offense?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="convicted" value="No" checked class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="convicted" value="Yes" class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Are you willing to abide by all school policies and regulations?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="abide_policies" value="Yes" checked class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes, I agree</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="abide_policies" value="No" class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 8: References -->
                        <div x-show="currentStep === 8" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Professional References</h2>
                                <p class="text-sm text-slate-500">Provide details of two people who can vouch for you.</p>
                            </div>

                            <div class="space-y-10">
                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Reference 1</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="references[0][name]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Position</label>
                                            <input type="text" name="references[0][position]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Organization</label>
                                            <input type="text" name="references[0][org]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="references[0][phone]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="references[0][email]" class="input-class">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Reference 2</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="references[1][name]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Position</label>
                                            <input type="text" name="references[1][position]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Organization</label>
                                            <input type="text" name="references[1][org]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="references[1][phone]" class="input-class">
                                        </div>
                                        <div>
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="references[1][email]" class="input-class">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 9: Personal Statement & Final -->
                        <div x-show="currentStep === 9" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Personal Statement</h2>
                                <p class="text-sm text-slate-500">Tell us more about your teaching philosophy.</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Statement (200-500 words) <span class="text-red-500">*</span></label>
                                    <textarea name="personal_statement" class="input-class" rows="8" required
                                        placeholder="Why you want to teach here, the value you bring, and your philosophy..."></textarea>
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label class="form-label">Other Commitments</label>
                                    <textarea name="other_commitments" class="input-class" rows="2" 
                                        placeholder="Any other jobs or studies that may affect your schedule?"></textarea>
                                </div>

                                <div class="p-6 rounded-2xl bg-amber-50 border border-amber-100">
                                    <div class="flex gap-4">
                                        <input type="checkbox" name="declaration" id="declaration" required class="w-5 h-5 mt-1 text-slate-900 border-slate-300 rounded">
                                        <label for="declaration" class="text-sm text-amber-900 leading-relaxed">
                                            <strong>Declaration:</strong> I hereby certify that the information provided in this application is true and complete to the best of my knowledge. I understand that any false information may result in the rejection of my application or termination of employment.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="pt-10 mt-10 border-t border-slate-100 flex flex-col sm:flex-row gap-4">
                            <button type="button" x-show="currentStep > 0" @click="handleBack()"
                                class="btn-secondary w-full sm:w-auto order-2 sm:order-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </button>
                            <div class="flex-grow order-1 sm:order-2"></div>
                            <button type="button" x-show="currentStep < 9" @click="handleNext()"
                                class="btn-primary w-full sm:w-auto order-1 sm:order-3">
                                Next Step
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <button type="submit" x-show="currentStep === 9" :disabled="isPending"
                                class="btn-primary w-full sm:w-auto order-1 sm:order-3">
                                <span x-show="!isPending">Submit Application</span>
                                <span x-show="isPending" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-12 px-6">
            <div class="max-w-3xl mx-auto text-center border-t border-slate-100 pt-8">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em]">
                    &copy; 2026 CMFI BILINGUAL HIGH SCHOOL &bull; ALL RIGHTS RESERVED
                </p>
            </div>
        </footer>

        <!-- Session Message -->
        @if(session('success'))
            <div
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-md flex items-center justify-center z-50 p-6 animate-fadeIn">
                <div class="bg-white rounded-[2rem] max-w-lg w-full p-10 text-center space-y-8 shadow-2xl">
                    <div class="flex justify-center">
                        <div class="h-24 w-24 bg-emerald-50 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                                stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <h2 class="font-headline text-3xl font-extrabold text-slate-900">Submitted!</h2>
                        <p class="text-slate-500 leading-relaxed text-lg">{{ session('success') }}</p>
                    </div>
                    <a href="{{ route('apply') }}" class="btn-primary w-full py-5 text-xl">Continue</a>
                </div>
            </div>
        @endif
    </div>

    <script>
        function applicationForm() {
            return {
                currentStep: 0,
                applicantType: 'new',
                isPending: false,
                skills: [
                    { id: 'classroom_management', label: 'Classroom Management' },
                    { id: 'lesson_planning', label: 'Lesson Planning' },
                    { id: 'student_assessment', label: 'Student Assessment' },
                    { id: 'computer_skills', label: 'Computer Literacy' },
                    { id: 'ms_word', label: 'Microsoft Word' },
                    { id: 'ms_excel', label: 'Microsoft Excel' },
                    { id: 'google_workspace', label: 'Google Workspace' },
                    { id: 'online_teaching', label: 'Online Teaching Platforms' }
                ],
                
                stepNames: [
                    'Selection',
                    'Personal Information',
                    'Position Information',
                    'Educational Background',
                    'Teaching Experience',
                    'Staff Reapplication',
                    'Skills & Competencies',
                    'Character & Conduct',
                    'Professional References',
                    'Personal Statement'
                ],

                totalActiveSteps() {
                    // For "new" applicants, we skip step 5 (Reapplication)
                    return this.applicantType === 'current_teacher' ? 10 : 9;
                },

                getActiveStepIndex() {
                    if (this.applicantType === 'new' && this.currentStep > 5) {
                        return this.currentStep;
                    }
                    return this.currentStep + 1;
                },

                getCurrentStepName() {
                    return this.stepNames[this.currentStep];
                },

                progressPercent() {
                    const total = this.totalActiveSteps();
                    const current = this.getActiveStepIndex();
                    return (current / total) * 100;
                },

                handleNext() {
                    // Validation Check: Find all required fields in the current step
                    const currentStepEl = document.querySelector(`[x-show="currentStep === ${this.currentStep}"]`);
                    if (currentStepEl) {
                        const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
                        let isValid = true;
                        
                        // Check validity from last to first so the first invalid one gets the focus/bubble
                        for (let i = 0; i < inputs.length; i++) {
                            if (!inputs[i].checkValidity()) {
                                inputs[i].reportValidity();
                                isValid = false;
                                break; // Stop at the first error
                            }
                        }
                        
                        if (!isValid) return;
                    }

                    if (this.currentStep < 9) {
                        // If it's a new applicant, skip Step 5 (Staff Reapplication)
                        if (this.applicantType === 'new' && this.currentStep === 4) {
                            this.currentStep = 6;
                        } else {
                            this.currentStep++;
                        }
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                handleBack() {
                    if (this.currentStep > 0) {
                        // If it's a new applicant, skip back from 6 to 4
                        if (this.applicantType === 'new' && this.currentStep === 6) {
                            this.currentStep = 4;
                        } else {
                            this.currentStep--;
                        }
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            }
        }
    </script>
</body>

</html>