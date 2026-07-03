<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply to Teach | CMFI School</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #2A85FF;
            --primary-dark: #1A73E8;
            --bg-main: #F4F7F6;
            --bg-white: #FFFFFF;
            --text-main: #1A1D1F;
            --text-muted: #6F767E;
            --border-color: #EFEFEF;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background: var(--bg-white);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
        }

        .form-header {
            padding: 32px;
            border-bottom: 1px solid var(--border-color);
            background: #fff;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            padding: 24px 32px;
            background: #FAFBFA;
            border-bottom: 1px solid var(--border-color);
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            background: #fff;
            border: 1.5px solid var(--border-color);
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 4px 10px rgba(42, 133, 255, 0.2);
        }

        .step-dot.completed {
            background: #E8F2FF;
            border-color: var(--primary);
            color: var(--primary);
        }

        .form-content {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--border-color);
            background: #FAFBFA;
            font-size: 15px;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(42, 133, 255, 0.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-next {
            background: var(--primary);
            color: #fff;
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-next:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-prev {
            background: #fff;
            color: var(--text-main);
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 700;
            border: 1.5px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-prev:hover {
            background: #FAFBFA;
        }

        .file-upload-area {
            border: 2px dashed var(--border-color);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #FAFBFA;
        }

        .file-upload-area:hover {
            border-color: var(--primary);
            background: #F0F7FF;
        }

        .hidden {
            display: none;
        }

        .success-message {
            text-align: center;
            padding: 60px 40px;
        }
    </style>
</head>
<body>

<div x-data="applicationForm()" class="form-container">
    <!-- Header -->
    <div class="form-header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h1 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0;">Teacher Application</h1>
                <p style="color: var(--text-muted); font-size: 14px; margin-top: 4px;">Join the academic excellence at CMFI School</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 50px;">
        </div>
    </div>

    <!-- Indicators -->
    <div class="step-indicator">
        <template x-for="i in 8" :key="i">
            <div class="step-dot" 
                 :class="{ 'active': step === i, 'completed': step > i }"
                 x-text="i"></div>
        </template>
    </div>

    <!-- Form Content -->
    <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-content">
            
            <!-- Step 1: Personal Information -->
            <div x-show="step === 1" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 1: Personal Information</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-input" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-input" placeholder="Enter last name" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" placeholder="+231..." required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-input">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Home Address</label>
                    <textarea name="home_address" class="form-input" rows="2" placeholder="Full residential address"></textarea>
                </div>
            </div>

            <!-- Step 2: Position & Preferences -->
            <div x-show="step === 2" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 2: Position & Preferences</h2>
                <div class="form-group">
                    <label class="form-label">Applicant Type</label>
                    <div class="form-grid">
                        <label class="file-upload-area" style="padding: 15px; border-style: solid; border-width: 1px;" :style="applicantType === 'new' ? 'border-color: var(--primary); background: #F0F7FF;' : ''">
                            <input type="radio" name="applicant_type" value="new" x-model="applicantType" class="hidden">
                            <div style="font-weight: 600; font-size: 14px;">New Applicant</div>
                        </label>
                        <label class="file-upload-area" style="padding: 15px; border-style: solid; border-width: 1px;" :style="applicantType === 'current_teacher' ? 'border-color: var(--primary); background: #F0F7FF;' : ''">
                            <input type="radio" name="applicant_type" value="current_teacher" x-model="applicantType" class="hidden">
                            <div style="font-weight: 600; font-size: 14px;">Current CMFI Teacher</div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Position Applying For</label>
                    <select name="job_opening_id" class="form-input" required>
                        @foreach($openings as $opening)
                            <option value="{{ $opening->id }}">{{ $opening->position->title }} ({{ $opening->position->department->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Subjects You Can Teach</label>
                    <input type="text" name="subjects_can_teach" class="form-input" placeholder="e.g. Mathematics, Physics, Chemistry">
                </div>
            </div>

            <!-- Step 3: Education & Credentials -->
            <div x-show="step === 3" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 3: Educational Background</h2>
                <div class="form-group">
                    <label class="form-label">Highest Qualification</label>
                    <input type="text" name="highest_qualification" class="form-input" placeholder="e.g. B.Sc. in Education">
                </div>
                <div class="form-group">
                    <label class="form-label">Institution Attended</label>
                    <input type="text" name="institution" class="form-input">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Graduation Year</label>
                        <input type="number" name="graduation_year" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Major/Area of Study</label>
                        <input type="text" name="major" class="form-input">
                    </div>
                </div>
            </div>

            <!-- Step 4: Teaching Experience -->
            <div x-show="step === 4" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 4: Work Experience</h2>
                <div class="form-group">
                    <label class="form-label">Total Years of Teaching Experience</label>
                    <input type="number" name="years_experience" class="form-input" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Last School Taught</label>
                    <input type="text" name="previous_school" class="form-input">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Previous Position</label>
                        <input type="text" name="prev_position" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Period (From - To)</label>
                        <input type="text" name="prev_period" class="form-input" placeholder="2020 - 2023">
                    </div>
                </div>
            </div>

            <!-- Step 5: Documents Upload -->
            <div x-show="step === 5" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 5: Supporting Documents</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">CV / Resume (PDF)</label>
                        <input type="file" name="cv" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Academic Certificate</label>
                        <input type="file" name="academic_certificate" class="form-input">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Passport Photo</label>
                        <input type="file" name="photo" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">ID Card (National/Voter)</label>
                        <input type="file" name="id_card" class="form-input">
                    </div>
                </div>
            </div>

            <!-- Step 6: Skills & Conduct -->
            <div x-show="step === 6" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 6: Skills & Conduct</h2>
                <div class="form-group">
                    <label class="form-label">Have you ever been dismissed from a job?</label>
                    <select name="dismissed" class="form-input">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Any criminal convictions?</label>
                    <select name="convicted" class="form-input">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Will you abide by school policies?</label>
                    <select name="abide_policies" class="form-input">
                        <option value="Yes">Yes, I will</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>

            <!-- Step 7: Personal Statement -->
            <div x-show="step === 7" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Section 7: Personal Statement</h2>
                <div class="form-group">
                    <label class="form-label">Why do you want to teach at CMFI School?</label>
                    <textarea name="personal_statement" class="form-input" rows="8" placeholder="Tell us about your teaching philosophy and motivation..."></textarea>
                </div>
            </div>

            <!-- Step 8: Review & Submit -->
            <div x-show="step === 8" x-transition>
                <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">Final Review</h2>
                <div style="background: #FAFBFA; padding: 24px; border-radius: 16px; border: 1px solid var(--border-color);">
                    <p style="margin: 0; font-size: 15px; color: var(--text-main);">
                        I certify that the information provided in this application is true and complete. 
                        I understand that any false statement or omission may result in my disqualification 
                        from consideration for employment or, if employed, in my dismissal.
                    </p>
                </div>
                <div style="margin-top: 24px; display: flex; align-items: center; gap: 12px;">
                    <input type="checkbox" id="confirm" required style="width: 20px; height: 20px; cursor: pointer;">
                    <label for="confirm" style="font-size: 14px; font-weight: 600; cursor: pointer;">I agree to the declaration above.</label>
                </div>
            </div>

            <!-- Navigation -->
            <div style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" x-show="step > 1" @click="step--" class="btn-prev">Previous</button>
                <div x-show="step === 1"></div> <!-- Spacer -->
                
                <button type="button" x-show="step < 8" @click="step++" class="btn-next">
                    Next Step 
                    <x-icon name="arrow-right" class="w-5 h-5" />
                </button>
                
                <button type="submit" x-show="step === 8" class="btn-next" style="background: #0F172A;">
                    Submit Application
                    <x-icon name="check" class="w-5 h-5" />
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function applicationForm() {
        return {
            step: 1,
            applicantType: 'new',
        }
    }
</script>

@if(session('success'))
    <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: white; padding: 40px; border-radius: 24px; max-width: 400px; text-align: center;">
            <div style="width: 64px; height: 64px; background: #E8F2FF; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <x-icon name="check" class="w-8 h-8" />
            </div>
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 12px;">Submitted!</h2>
            <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 24px;">{{ session('success') }}</p>
            <a href="{{ route('apply') }}" class="btn-next" style="justify-content: center; width: 100%; text-decoration: none;">Done</a>
        </div>
    </div>
@endif

</body>
</html>
