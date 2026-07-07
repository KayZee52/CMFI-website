<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Application | CMFI Bilingual High School</title>

    <!-- Local Styles & Fonts -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    
    <!-- Local Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="min-h-screen bg-[#fafafa] font-body text-slate-800 antialiased">

    <!-- Session Message -->
    @if(session('success'))
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-[100] p-6 animate-fadeIn">
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

                <!-- WhatsApp Group Invite -->
                <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 space-y-4">
                    <div class="flex items-center justify-center gap-3 text-emerald-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .018 5.394 0 12.03a11.854 11.854 0 001.54 5.851L0 24l6.232-1.635a11.79 11.79 0 005.815 1.53h.005c6.637 0 12.032-5.395 12.035-12.032a11.762 11.762 0 00-3.479-8.502"/>
                        </svg>
                        <span class="font-bold text-lg">Join Applicants Group</span>
                    </div>
                    <p class="text-sm text-emerald-600 font-medium">
                        To stay updated on the recruitment process, please join our official WhatsApp group for 2026/2027 applicants.
                    </p>
                    <a href="https://chat.whatsapp.com/JtG7tq9iJS63npg9EX0J6w?mode=gi_t" target="_blank"
                       class="flex items-center justify-center gap-2 w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg shadow-emerald-200">
                        Join Group Now
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <a href="{{ route('apply') }}" class="btn-primary w-full py-5 text-xl">Continue</a>
            </div>
        </div>
    @endif

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

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-8 py-6 rounded-[2rem] shadow-sm animate-fadeIn">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg">Please check the following:</span>
                        </div>
                        <ul class="list-disc list-inside text-base space-y-2 ml-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                                    <input type="text" name="full_name" class="input-class" value="{{ old('full_name') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Gender <span class="text-red-500">*</span></label>
                                    <select name="gender" class="input-class" required>
                                        <option value="Male" @selected(old('gender') == 'Male')>Male</option>
                                        <option value="Female" @selected(old('gender') == 'Female')>Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Date of Birth <span class="text-red-500">*</span></label>
                                    <input type="date" name="date_of_birth" class="input-class" value="{{ old('date_of_birth') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Nationality <span class="text-red-500">*</span></label>
                                    <input type="text" name="nationality" class="input-class" value="{{ old('nationality') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">City of Residence <span class="text-red-500">*</span></label>
                                    <input type="text" name="city_of_residence" class="input-class" value="{{ old('city_of_residence') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Mobile Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" class="input-class" value="{{ old('phone') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">WhatsApp Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="whatsapp_number" class="input-class" value="{{ old('whatsapp_number') }}" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="input-class" value="{{ old('email') }}" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Home Address <span class="text-red-500">*</span></label>
                                    <textarea name="home_address" class="input-class" rows="2" required>{{ old('home_address') }}</textarea>
                                </div>

                                <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Emergency
                                        Contact</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="form-label">Contact Name <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="emergency_name" class="input-class" value="{{ old('emergency_name') }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Contact Number <span
                                                    class="text-red-500">*</span></label>
                                            <input type="tel" name="emergency_number" class="input-class" value="{{ old('emergency_number') }}" required>
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
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <select name="position_applying_for" class="input-class" required x-model="selectedPosition">
                                            <option value="">Select Position...</option>
                                            @foreach ($openings as $opening)
                                                <option value="{{ $opening->position->title }}" @selected(old('position_applying_for') == $opening->position->title)>{{ $opening->position->title }}</option>
                                            @endforeach
                                            <option value="Nursery Teacher" @selected(old('position_applying_for') == 'Nursery Teacher')>Nursery Teacher</option>
                                            <option value="Elementary Teacher" @selected(old('position_applying_for') == 'Elementary Teacher')>Elementary Teacher</option>
                                            <option value="Junior High Teacher" @selected(old('position_applying_for') == 'Junior High Teacher')>Junior High Teacher</option>
                                            <option value="Senior High Teacher" @selected(old('position_applying_for') == 'Senior High Teacher')>Senior High Teacher</option>
                                            <option value="Subject Specialist" @selected(old('position_applying_for') == 'Subject Specialist')>Subject Specialist</option>
                                            <option value="Other" @selected(old('position_applying_for') == 'Other')>Other (Specify below)</option>
                                        </select>
                                        <input type="text" name="other_position" class="input-class" x-show="selectedPosition === 'Other' || selectedPosition === 'Subject Specialist'" 
                                            value="{{ old('other_position') }}" placeholder="Specify Subject or Role" :required="selectedPosition === 'Other' || selectedPosition === 'Subject Specialist'">
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Subjects You Can Teach <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="subjects_can_teach" class="input-class"
                                        value="{{ old('subjects_can_teach') }}" placeholder="e.g. Mathematics, Physics" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Grade Level(s) Preferred <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="grades_preferred" class="input-class"
                                        value="{{ old('grades_preferred') }}" placeholder="e.g. Grade 7, Grade 8" required>
                                </div>
                                <div>
                                    <label class="form-label">Employment Type <span class="text-red-500">*</span></label>
                                    <select name="commitment_type" class="input-class" required>
                                        <option value="Full-Time" @selected(old('commitment_type') == 'Full-Time')>Full-Time</option>
                                        <option value="Part-Time" @selected(old('commitment_type') == 'Part-Time')>Part-Time</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Available Start Date <span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="available_start_date" class="input-class" value="{{ old('available_start_date') }}" required>
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
                                        <option value="Bachelor's Degree" @selected(old('highest_qualification') == "Bachelor's Degree")>Bachelor's Degree</option>
                                        <option value="Master's Degree" @selected(old('highest_qualification') == "Master's Degree")>Master's Degree</option>
                                        <option value="Doctorate" @selected(old('highest_qualification') == "Doctorate")>Doctorate</option>
                                        <option value="Other" @selected(old('highest_qualification') == "Other")>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Institution <span class="text-red-500">*</span></label>
                                    <input type="text" name="institution" class="input-class" value="{{ old('institution') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Graduation Year <span class="text-red-500">*</span></label>
                                    <input type="number" name="graduation_year" class="input-class" value="{{ old('graduation_year') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Major / Area of Study</label>
                                    <input type="text" name="major" class="input-class" value="{{ old('major') }}">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Professional Certifications</label>
                                    <input type="text" name="certifications" class="input-class" value="{{ old('certifications') }}"
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
                                <p class="text-sm text-slate-500">Document your teaching journey over the last 5 years.</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Total Years of Teaching Experience <span class="text-red-500">*</span></label>
                                    <input type="number" name="years_experience" class="input-class w-32" value="{{ old('years_experience') }}" required>
                                </div>

                                <div class="space-y-8">
                                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Most Recent Institution</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div class="sm:col-span-2">
                                                <label class="form-label">Name of School/Institution <span class="text-red-500">*</span></label>
                                                <input type="text" name="previous_school" class="input-class" value="{{ old('previous_school') }}" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Position Held <span class="text-red-500">*</span></label>
                                                <input type="text" name="prev_position" class="input-class" value="{{ old('prev_position') }}" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Employment Period <span class="text-red-500">*</span></label>
                                                <input type="text" name="prev_period" class="input-class" value="{{ old('prev_period') }}" required placeholder="e.g. 2021 - 2024">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-6">
                                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Previous Institution (2)</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div class="sm:col-span-2">
                                                <label class="form-label">Name of School/Institution</label>
                                                <input type="text" name="prev_school_2" class="input-class" value="{{ old('prev_school_2') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">Position Held</label>
                                                <input type="text" name="prev_position_2" class="input-class" value="{{ old('prev_position_2') }}">
                                            </div>
                                            <div>
                                                <label class="form-label">Employment Period</label>
                                                <input type="text" name="prev_period_2" class="input-class" value="{{ old('prev_period_2') }}" placeholder="e.g. 2018 - 2020">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Secondary Employment History -->
                        <div x-show="currentStep === 5" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Secondary Employment History</h2>
                                <p class="text-sm text-slate-500">Provide details for non-teaching roles or other employment.</p>
                            </div>

                            <div class="space-y-8">
                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" name="secondary_employment[0][company]" class="input-class" value="{{ old('secondary_employment.0.company') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Position Held</label>
                                            <input type="text" name="secondary_employment[0][position]" class="input-class" value="{{ old('secondary_employment.0.position') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Dates of Employment</label>
                                            <input type="text" name="secondary_employment[0][dates]" class="input-class" value="{{ old('secondary_employment.0.dates') }}" placeholder="e.g. Jan 2015 - Dec 2017">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Nature of Work</label>
                                            <textarea name="secondary_employment[0][nature]" class="input-class" rows="2">{{ old('secondary_employment.0.nature') }}</textarea>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Reason for Leaving</label>
                                            <textarea name="secondary_employment[0][reason]" class="input-class" rows="2">{{ old('secondary_employment.0.reason') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: For Current Teachers -->
                        <div x-show="currentStep === 6" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Staff Reapplication</h2>
                                <p class="text-sm text-slate-500">For our valued returning faculty members.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Current Dept / Grade</label>
                                    <input type="text" name="current_dept" class="input-class" value="{{ old('current_dept') }}">
                                </div>
                                <div>
                                    <label class="form-label">Years Served at CMFI</label>
                                    <input type="number" name="years_served" class="input-class" value="{{ old('years_served') }}">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Major Achievements During Service</label>
                                    <textarea name="achievements" class="input-class" rows="3">{{ old('achievements') }}</textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Challenges Faced Last Year</label>
                                    <textarea name="challenges" class="input-class" rows="3">{{ old('challenges') }}</textarea>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Why would you like to continue?</label>
                                    <textarea name="why_continue" class="input-class" rows="3">{{ old('why_continue') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 7: Skills Proficiency -->
                        <div x-show="currentStep === 7" class="space-y-8 animate-fadeIn">
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
                                                    <input type="radio" :name="'skills_proficiency[' + skill.id + ']'" :value="n" 
                                                        :checked="({{ json_encode(old('skills_proficiency', (object)[])) }})[skill.id] == n"
                                                        class="hidden peer">
                                                    <div class="w-10 h-10 rounded-xl bg-white border-2 border-slate-100 flex items-center justify-center text-slate-400 font-bold peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all hover:border-slate-300" x-text="n"></div>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Step 8: Character & Conduct -->
                        <div x-show="currentStep === 8" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Character & Conduct</h2>
                                <p class="text-sm text-slate-500">Verification of standards and ethics.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Have you ever been dismissed from a previous job?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="dismissed" value="No" @checked(old('dismissed', 'No') == 'No') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="dismissed" value="Yes" @checked(old('dismissed') == 'Yes') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Have you ever been convicted of a criminal offense?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="convicted" value="No" @checked(old('convicted', 'No') == 'No') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="convicted" value="Yes" @checked(old('convicted') == 'Yes') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-white border border-slate-100 space-y-4">
                                    <p class="font-bold text-slate-900">Are you willing to abide by all school policies and regulations?</p>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="abide_policies" value="Yes" @checked(old('abide_policies', 'Yes') == 'Yes') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">Yes, I agree</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="abide_policies" value="No" @checked(old('abide_policies') == 'No') class="w-4 h-4 text-slate-900">
                                            <span class="text-slate-700">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 9: References -->
                        <div x-show="currentStep === 9" class="space-y-8 animate-fadeIn">
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
                                            <input type="text" name="references[0][name]" class="input-class" value="{{ old('references.0.name') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Position</label>
                                            <input type="text" name="references[0][position]" class="input-class" value="{{ old('references.0.position') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Organization</label>
                                            <input type="text" name="references[0][org]" class="input-class" value="{{ old('references.0.org') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="references[0][phone]" class="input-class" value="{{ old('references.0.phone') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="references[0][email]" class="input-class" value="{{ old('references.0.email') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-6">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Reference 2</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="sm:col-span-2">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="references[1][name]" class="input-class" value="{{ old('references.1.name') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Position</label>
                                            <input type="text" name="references[1][position]" class="input-class" value="{{ old('references.1.position') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Organization</label>
                                            <input type="text" name="references[1][org]" class="input-class" value="{{ old('references.1.org') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" name="references[1][phone]" class="input-class" value="{{ old('references.1.phone') }}">
                                        </div>
                                        <div>
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="references[1][email]" class="input-class" value="{{ old('references.1.email') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 10: Personal Statement & Declaration -->
                        <div x-show="currentStep === 10" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Final Submission</h2>
                                <p class="text-sm text-slate-500">Provide your statement and certify your application.</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Personal Statement <span class="text-red-500">*</span></label>
                                    <textarea name="personal_statement" class="input-class" rows="8" required
                                        placeholder="Why you want to teach here, the value you bring, and your philosophy...">{{ old('personal_statement') }}</textarea>
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label class="form-label">Other Commitments</label>
                                    <textarea name="other_commitments" class="input-class" rows="2" 
                                        placeholder="Any other jobs or studies that may affect your schedule?">{{ old('other_commitments') }}</textarea>
                                </div>

                                <div class="p-6 rounded-2xl bg-amber-50 border border-amber-100 space-y-6">
                                    <div class="flex gap-4">
                                        <input type="checkbox" name="declaration" id="declaration" required class="w-5 h-5 mt-1 text-slate-900 border-slate-300 rounded">
                                        <label for="declaration" class="text-sm text-amber-900 leading-relaxed">
                                            <strong>Declaration:</strong> I hereby certify that the information provided in this application is true and complete to the best of my knowledge. I understand that any false information may result in the rejection of my application or termination of employment.
                                        </label>
                                    </div>
                                    <div class="pt-4 border-t border-amber-200">
                                        <label class="form-label text-amber-900">Digital Signature (Full Name) <span class="text-red-500">*</span></label>
                                        <input type="text" name="digital_signature" class="input-class border-amber-200" value="{{ old('digital_signature') }}" required placeholder="Type your full name here">
                                        <p class="text-[10px] text-amber-700 mt-2 uppercase tracking-widest font-bold">I understand that typing my name above constitutes a legal signature.</p>
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
                            <button type="button" x-show="currentStep < 10" @click="handleNext()"
                                class="btn-primary w-full sm:w-auto order-1 sm:order-3">
                                Next Step
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <button type="submit" x-show="currentStep === 10" :disabled="isPending"
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
    </div>

    <script>
        function applicationForm() {
            return {
                currentStep: @if($errors->any())
                                @if($errors->hasAny(['full_name', 'gender', 'date_of_birth', 'nationality', 'city_of_residence', 'phone', 'whatsapp_number', 'email', 'home_address', 'emergency_name', 'emergency_number'])) 1
                                @elseif($errors->hasAny(['applicant_type', 'position_applying_for', 'other_position', 'subjects_can_teach', 'grades_preferred'])) 2
                                @elseif($errors->hasAny(['highest_qualification', 'institution', 'graduation_year', 'major', 'certifications'])) 3
                                @elseif($errors->hasAny(['years_experience', 'previous_school', 'prev_position', 'prev_period'])) 4
                                @elseif($errors->hasAny(['secondary_employment'])) 5
                                @elseif($errors->hasAny(['current_dept', 'years_served', 'achievements', 'challenges', 'why_continue'])) 6
                                @elseif($errors->hasAny(['skills_proficiency'])) 7
                                @elseif($errors->hasAny(['dismissed', 'convicted', 'abide_policies'])) 8
                                @elseif($errors->hasAny(['references'])) 9
                                @elseif($errors->hasAny(['cv', 'photo', 'transcripts', 'academic_certificates', 'professional_certificates', 'identification_card', 'police_clearance', 'recommendation_letters', 'personal_statement', 'digital_signature'])) 10
                                @else 10
                                @endif
                             @else 0 @endif,
                applicantType: '{{ old('applicant_type', '') }}',
                isPending: false,
                selectedPosition: '{{ old('position_applying_for', '') }}',
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
                    'Secondary Employment History',
                    'Staff Reapplication',
                    'Skills & Competencies',
                    'Character & Conduct',
                    'Professional References',
                    'Personal Statement & Declaration'
                ],

                totalActiveSteps() {
                    // For "new" applicants, we skip step 6 (Reapplication)
                    return this.applicantType === 'current_teacher' ? 11 : 10;
                },

                getActiveStepIndex() {
                    if (this.applicantType === 'new' && this.currentStep > 6) {
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

                    if (this.currentStep < 10) {
                        // If it's a new applicant, skip Step 6 (Staff Reapplication)
                        if (this.applicantType === 'new' && this.currentStep === 5) {
                            this.currentStep = 7;
                        } else {
                            this.currentStep++;
                        }
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                handleBack() {
                    if (this.currentStep > 0) {
                        // If it's a new applicant, skip back from 7 to 5
                        if (this.applicantType === 'new' && this.currentStep === 7) {
                            this.currentStep = 5;
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