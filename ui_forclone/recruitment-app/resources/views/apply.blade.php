<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Application | CMFI Bilingual High School</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
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
                <a href="/" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Back to Website
                </a>
            </div>
        </header>

        <!-- Main Container -->
        <main class="py-12 px-6">
            <div class="max-w-3xl mx-auto space-y-10">
                
                <!-- Title -->
                <div class="text-center space-y-3">
                    <h1 class="font-headline text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Teacher Application</h1>
                    <p class="text-sm sm:text-base text-slate-500 max-w-lg mx-auto leading-relaxed">Join our educational faculty for the 2026/2027 Academic Year. We are looking for passionate educators to join our mission.</p>
                </div>

                <!-- Progress Bar -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" x-text="'Step ' + getActiveStepIndex() + ' of ' + totalActiveSteps()"></p>
                            <h3 class="font-headline font-bold text-slate-900 text-lg" x-text="getCurrentStepName()"></h3>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-slate-900" x-text="Math.round(progressPercent()) + '%'"></span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200/50 h-2 rounded-full overflow-hidden">
                        <div class="bg-slate-900 h-full transition-all duration-500 ease-out" :style="'width: ' + progressPercent() + '%'"></div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_1px_3px_rgba(0,0,0,0.02),0_10px_20px_rgba(0,0,0,0.01)] p-8 sm:p-12 overflow-hidden relative">
                    <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data" @submit="isPending = true">
                        @csrf
                        
                        <!-- Step 1: Personal Info -->
                        <div x-show="currentStep === 1" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Personal Information</h2>
                                <p class="text-sm text-slate-500">Please provide your contact and identification details.</p>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2">
                                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="full_name" class="input-class" placeholder="First, Middle, Last Name" required>
                                </div>
                                
                                <div>
                                    <label class="form-label">Gender <span class="text-red-500">*</span></label>
                                    <select name="gender" class="input-class" required>
                                        <option value="">Select Gender</option>
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
                                    <input type="text" name="nationality" class="input-class" placeholder="Liberian" required>
                                </div>

                                <div>
                                    <label class="form-label">City of Residence <span class="text-red-500">*</span></label>
                                    <input type="text" name="city_of_residence" class="input-class" placeholder="Paynesville, Montserrado" required>
                                </div>

                                <div>
                                    <label class="form-label">Mobile Number <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" class="input-class" placeholder="+231..." required>
                                </div>

                                <div>
                                    <label class="form-label">WhatsApp Number</label>
                                    <input type="tel" name="whatsapp_number" class="input-class" placeholder="+231...">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="input-class" placeholder="name@example.com" required>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Home Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="home_address" class="input-class" placeholder="Community / Neighborhood Address" required>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Position Info -->
                        <div x-show="currentStep === 2" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Position & Preferences</h2>
                                <p class="text-sm text-slate-500">Tell us what role you are looking for.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Applicant Type <span class="text-red-500">*</span></label>
                                    <select name="applicant_type" x-model="applicantType" class="input-class" required>
                                        <option value="new">New Applicant</option>
                                        <option value="current_teacher">Current Teacher (Reapplying)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Position Applying For <span class="text-red-500">*</span></label>
                                    <select name="job_opening_id" class="input-class" required>
                                        <option value="">Select Position</option>
                                        @foreach($openings as $opening)
                                            <option value="{{ $opening->id }}">{{ $opening->position->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Subject(s) You Can Teach</label>
                                    <input type="text" name="subjects_can_teach" class="input-class" placeholder="E.g. Mathematics, French, Biology">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Grade Level(s) Preferred</label>
                                    <input type="text" name="grades_preferred" class="input-class" placeholder="E.g. Grades 7-9, Primary">
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Education -->
                        <div x-show="currentStep === 3" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Education & Credentials</h2>
                                <p class="text-sm text-slate-500">Your academic background and document uploads.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Highest Qualification <span class="text-red-500">*</span></label>
                                    <select name="highest_qualification" class="input-class" required>
                                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                                        <option value="Master's Degree">Master's Degree</option>
                                        <option value="Associate Degree">Associate Degree</option>
                                        <option value="High School Graduate">High School Graduate</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Institution Attended <span class="text-red-500">*</span></label>
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
                            </div>

                            <div class="pt-8 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">CV / Resume <span class="text-red-500">*</span></label>
                                    <input type="file" name="cv" class="input-class file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" required>
                                </div>
                                <div>
                                    <label class="form-label">Passport Photo</label>
                                    <input type="file" name="photo" class="input-class file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Experience -->
                        <div x-show="currentStep === 4" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Teaching Experience</h2>
                                <p class="text-sm text-slate-500">Provide a summary of your professional journey.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Total Years of Experience <span class="text-red-500">*</span></label>
                                    <input type="number" name="years_experience" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Previous School</label>
                                    <input type="text" name="previous_school" class="input-class">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Position Held & Main Responsibilities</label>
                                    <textarea name="prev_position" class="input-class" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Reapplication (Conditional) -->
                        <div x-show="currentStep === 5" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">CMFI Reapplication</h2>
                                <p class="text-sm text-slate-500">For returning staff members only.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Current Department <span class="text-red-500">*</span></label>
                                    <input type="text" name="current_dept" class="input-class" :required="applicantType === 'current_teacher'">
                                </div>
                                <div>
                                    <label class="form-label">Years Served at CMFI <span class="text-red-500">*</span></label>
                                    <input type="number" name="years_served" class="input-class" :required="applicantType === 'current_teacher'">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="form-label">Key Achievements at CMFI</label>
                                    <textarea name="achievements" class="input-class" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Skills & Conduct -->
                        <div x-show="currentStep === 6" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Skills & Conduct</h2>
                                <p class="text-sm text-slate-500">Verification of standards and ethics.</p>
                            </div>

                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="form-label">Ever Dismissed from a Job?</label>
                                        <select name="dismissed" class="input-class">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Criminal History?</label>
                                        <select name="convicted" class="input-class">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Willingness to Abide by School Policies?</label>
                                    <select name="abide_policies" class="input-class">
                                        <option value="Yes">Yes, I agree</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Step 7: References -->
                        <div x-show="currentStep === 7" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">References & Availability</h2>
                                <p class="text-sm text-slate-500">Who can vouch for your work?</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Available Start Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="available_start_date" class="input-class" required>
                                </div>
                                <div>
                                    <label class="form-label">Reference Information</label>
                                    <textarea name="reference_data" class="input-class" rows="4" placeholder="Name, Position, Contact Details..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Step 8: Review -->
                        <div x-show="currentStep === 8" class="space-y-8 animate-fadeIn">
                            <div class="space-y-2">
                                <h2 class="text-2xl font-bold text-slate-900 font-headline">Final Statement</h2>
                                <p class="text-sm text-slate-500">Your motivation to join us.</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Personal Statement / Teaching Philosophy</label>
                                    <textarea name="personal_statement" class="input-class" rows="6" placeholder="Why do you want to teach at CMFI Bilingual High School?"></textarea>
                                </div>

                                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex gap-4 items-start">
                                    <input type="checkbox" id="declaration" name="declaration" class="mt-1 h-5 w-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900" required>
                                    <label for="declaration" class="text-sm text-slate-600 leading-relaxed">
                                        I certify that all information provided is true and accurate to the best of my knowledge. I understand that any false statement is grounds for immediate disqualification or dismissal.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex items-center justify-between mt-12 pt-8 border-t border-slate-50 gap-4">
                            <button type="button" x-show="currentStep > 1" @click="handleBack()" class="btn-secondary min-w-[140px]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-2 inline"><path d="m15 18-6-6 6-6"/></svg>
                                Previous
                            </button>
                            <div x-show="currentStep === 1" class="flex-1"></div>
                            
                            <button type="button" x-show="currentStep < totalActiveSteps()" @click="handleNext()" class="btn-primary flex-1 max-w-[320px] text-lg py-5">
                                Next Step
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                            
                            <button type="submit" x-show="currentStep === totalActiveSteps()" class="btn-primary flex-1 max-w-[320px] text-lg py-5" :disabled="isPending">
                                <span x-show="!isPending">Submit Application</span>
                                <span x-show="isPending" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Processing...
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
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md flex items-center justify-center z-50 p-6 animate-fadeIn">
            <div class="bg-white rounded-[2rem] max-w-lg w-full p-10 text-center space-y-8 shadow-2xl">
                <div class="flex justify-center">
                    <div class="h-24 w-24 bg-emerald-50 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
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
                currentStep: 1,
                applicantType: 'new',
                isPending: false,
                steps: [
                    { id: 1, name: 'Personal Information' },
                    { id: 2, name: 'Position & Preferences' },
                    { id: 3, name: 'Education & Credentials' },
                    { id: 4, name: 'Teaching Experience' },
                    { id: 5, name: 'CMFI Reapplication', conditional: true },
                    { id: 6, name: 'Skills & Conduct' },
                    { id: 7, name: 'References & Availability' },
                    { id: 8, name: 'Final Statement' }
                ],
                
                activeSteps() {
                    return this.steps.filter(step => !step.conditional || this.applicantType === 'current_teacher');
                },
                
                totalActiveSteps() {
                    return this.activeSteps().length;
                },
                
                getActiveStepIndex() {
                    return this.activeSteps().findIndex(s => s.id === this.currentStep) + 1;
                },
                
                getCurrentStepName() {
                    const step = this.activeSteps().find(s => s.id === this.currentStep);
                    return step ? step.name : '';
                },
                
                progressPercent() {
                    return (this.getActiveStepIndex() / this.totalActiveSteps()) * 100;
                },
                
                handleNext() {
                    const active = this.activeSteps();
                    const currentIndex = active.findIndex(s => s.id === this.currentStep);
                    if (currentIndex < active.length - 1) {
                        this.currentStep = active[currentIndex + 1].id;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },
                
                handleBack() {
                    const active = this.activeSteps();
                    const currentIndex = active.findIndex(s => s.id === this.currentStep);
                    if (currentIndex > 0) {
                        this.currentStep = active[currentIndex - 1].id;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            }
        }
    </script>
</body>
</html>
