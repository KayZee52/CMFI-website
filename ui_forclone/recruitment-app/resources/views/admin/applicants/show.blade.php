@extends('layouts.recruitment')

@section('content')
    <div x-data="{ 
        tab: 'details', 
        previewOpen: false, 
        previewUrl: '', 
        previewTitle: '' 
    }">
        <!-- Dashboard-style Hero -->
        <section class="dashboard-hero">
            <div style="display: flex; align-items: center; gap: 24px;">
                <a href="{{ route('applicants.index') }}" class="btn-action" style="padding: 10px; border-radius: 50%; text-decoration: none;">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="position: relative;">
                        <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                             alt="Avatar" 
                             style="width: 72px; height: 72px; border-radius: 20px; object-fit: cover; border: 2px solid white; box-shadow: var(--shadow-md);">
                        <div style="position: absolute; bottom: -2px; right: -2px; width: 20px; height: 20px; background: #10B981; border: 3px solid white; border-radius: 50%;"></div>
                    </div>
                    <div class="hero-text">
                        <h1 style="margin-bottom: 4px;">{{ $applicant->full_name }}</h1>
                        <p style="margin: 0; font-size: 14px; opacity: 0.8;">
                            ID: #{{ $applicant->applications->first()->reference_number }} • 
                            Applied {{ $applicant->applications->first()->submitted_at->format('M d, Y') }} • 
                            <span style="color: var(--primary); font-weight: 700;">{{ $applicant->applications->first()->current_stage }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="hero-actions">
                <button class="btn btn-secondary">
                    <x-icon name="mail" class="w-4 h-4" /> Message
                </button>
                <button class="btn btn-primary">
                    <x-icon name="calendar" class="w-4 h-4" /> Schedule Interview
                </button>
            </div>
        </section>

        <div class="dashboard-grid" style="margin-top: 40px; grid-template-columns: 2fr 1fr; gap: 32px;">
            <!-- Left Panel: Analysis Hub -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- AI Analysis Card - Same style as Dashboard cards -->
                <section class="grid-item" style="background: white; border-radius: 24px; padding: 32px; box-shadow: var(--shadow-sm);">
                    <div class="section-header" style="margin-bottom: 24px;">
                        <h2 style="font-size: 14px; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <x-icon name="dashboard" class="w-4 h-4" style="color: var(--primary);" /> AI Recruiter Summary
                        </h2>
                    </div>
                    <div style="background: #F8FAFC; padding: 24px; border-radius: 16px; border: 1px solid #F1F5F9;">
                        <p style="font-size: 15px; line-height: 1.7; color: #334155; margin: 0;">
                            <b>Candidate Insights:</b> John Doe demonstrates a high level of pedagogical maturity. His background in STEM education at {{ $applicant->applicant_type === 'current_teacher' ? 'our school' : 'previous institutions' }} aligns perfectly with our curriculum goals.
                        </p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 20px; padding-top: 20px; border-top: 1px dashed #E2E8F0;">
                            <div>
                                <h4 style="font-size: 11px; font-weight: 700; color: #059669; margin-bottom: 12px; text-transform: uppercase;">Top Strengths</h4>
                                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: #475569;">
                                    <div style="display: flex; align-items: center; gap: 8px;"><x-icon name="check-circle" class="w-3 h-3" /> Advanced Curriculum Design</div>
                                    <div style="display: flex; align-items: center; gap: 8px;"><x-icon name="check-circle" class="w-3 h-3" /> Excellent Principal Feedback</div>
                                </div>
                            </div>
                            <div>
                                <h4 style="font-size: 11px; font-weight: 700; color: #DC2626; margin-bottom: 12px; text-transform: uppercase;">Skill Gaps</h4>
                                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: #475569;">
                                    <div style="display: flex; align-items: center; gap: 8px;"><x-icon name="dashboard" class="w-3 h-3" /> Minimal LMS Experience</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Profile Tabs -->
                <section class="grid-item" style="background: white; border-radius: 24px; padding: 0; box-shadow: var(--shadow-sm); overflow: hidden;">
                    <div class="profile-tabs" style="background: #FAFBFC; padding: 0 32px; border-bottom: 1px solid #F1F5F9;">
                        <button @click="tab = 'details'" :class="tab === 'details' ? 'active' : ''" class="profile-tab">Biography</button>
                        <button @click="tab = 'documents'" :class="tab === 'documents' ? 'active' : ''" class="profile-tab">Documents</button>
                        <button @click="tab = 'skills'" :class="tab === 'skills' ? 'active' : ''" class="profile-tab">Assessment</button>
                    </div>

                    <div style="padding: 32px;">
                        <div x-show="tab === 'details'" x-transition>
                            <h4 style="font-size: 12px; font-weight: 800; color: #94A3B8; text-transform: uppercase; margin-bottom: 16px;">Professional Bio</h4>
                            <p style="font-size: 15px; line-height: 1.8; color: #475569; margin: 0;">{{ $applicant->bio ?? 'No professional biography provided.' }}</p>
                        </div>

                        <div x-show="tab === 'documents'" x-transition>
                            <div style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                                @forelse($applicant->applications->first()->documents as $doc)
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #F8FAFC; border: 1px solid #F1F5F9; border-radius: 12px;">
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <x-icon name="briefcase" class="w-5 h-5" style="color: var(--primary);" />
                                            <span style="font-size: 14px; font-weight: 600; color: #0F172A;">{{ $doc->document_type }}</span>
                                        </div>
                                        <button @click="previewOpen = true; previewTitle = '{{ $doc->document_type }}'" class="btn-action" style="font-size: 12px; font-weight: 700; color: var(--primary); background: transparent;">View</button>
                                    </div>
                                @empty
                                    <p style="color: #94A3B8; font-size: 14px;">No documents available.</p>
                                @endforelse
                            </div>
                        </div>

                        <div x-show="tab === 'skills'" x-transition>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                                @php $skills = [['label' => 'Pedagogy', 'score' => 90], ['label' => 'Classroom Mgmt', 'score' => 85], ['label' => 'Technology', 'score' => 60], ['label' => 'Communication', 'score' => 95]]; @endphp
                                @foreach($skills as $skill)
                                    <div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                            <span style="font-size: 12px; font-weight: 700; color: #64748B;">{{ $skill['label'] }}</span>
                                            <span style="font-size: 12px; font-weight: 800; color: #0F172A;">{{ $skill['score'] }}%</span>
                                        </div>
                                        <div style="height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden;">
                                            <div style="height: 100%; background: var(--primary); width: {{ $skill['score'] }}%;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Panel: Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- Dashboard-style Gauge Chart -->
                <section class="grid-item project-progress" style="background: white; border-radius: 24px; padding: 32px; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; align-items: center;">
                    <div class="section-header" style="width: 100%; text-align: center; margin-bottom: 24px;">
                        <h2 style="font-size: 13px; font-weight: 800; color: #94A3B8; text-transform: uppercase;">Match Score</h2>
                    </div>
                    <div class="progress-container" style="width: auto; margin: 0;">
                        <div class="gauge-chart" style="width: 150px; height: 150px; background: conic-gradient(var(--primary) 0deg {{ 0.82 * 360 }}deg, #EFEFEF {{ 0.82 * 360 }}deg 360deg);">
                            <div class="gauge-center" style="width: 110px; height: 110px;">
                                <span class="percentage" style="font-size: 28px;">82%</span>
                                <span class="label" style="font-size: 9px;">Role Fit</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Info Card -->
                <section class="grid-item" style="background: white; border-radius: 24px; padding: 32px; box-shadow: var(--shadow-sm);">
                    <div class="section-header" style="margin-bottom: 20px;">
                        <h2 style="font-size: 13px; font-weight: 800; color: #94A3B8; text-transform: uppercase;">Contact Profile</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #F8FAFC; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <x-icon name="mail" class="w-4 h-4" />
                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 10px; color: #94A3B8; margin: 0;">Email</p>
                                <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0; overflow: hidden; text-overflow: ellipsis;">{{ $applicant->email }}</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: #F8FAFC; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <x-icon name="users" class="w-4 h-4" />
                            </div>
                            <div>
                                <p style="font-size: 10px; color: #94A3B8; margin: 0;">Phone</p>
                                <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $applicant->phone }}</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Hiring Decision Card - Dark like Dashboard's Total Applicants -->
                <section class="grid-item" style="background: #0F172A; border-radius: 24px; padding: 32px; box-shadow: var(--shadow-md); color: white; position: relative; overflow: hidden;">
                    <div class="section-header" style="margin-bottom: 24px;">
                        <h2 style="font-size: 13px; font-weight: 800; color: rgba(255,255,255,0.6); text-transform: uppercase;">Hiring Signal</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px; position: relative; z-index: 2;">
                        <button class="btn" style="width: 100%; background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); justify-content: center;">Shortlist</button>
                        <button class="btn" style="width: 100%; background: var(--primary); color: white; border: none; justify-content: center; font-weight: 700;">Hire Candidate</button>
                        <button class="btn" style="width: 100%; background: #EF4444; color: white; border: none; justify-content: center;">Reject</button>
                    </div>
                    <div class="card-bg-waves"></div>
                </section>
            </div>
        </div>

        <!-- Slide-over Previewer -->
        <div x-show="previewOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full" style="position: fixed; top: 0; right: 0; bottom: 0; width: 500px; background: white; z-index: 1000; box-shadow: -20px 0 50px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
            <div style="padding: 32px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 800;" x-text="previewTitle"></h3>
                <button @click="previewOpen = false" style="color: #94A3B8;"><x-icon name="dashboard" class="w-6 h-6" /></button>
            </div>
            <div style="flex: 1; padding: 32px; background: #F8FAFC;">
                <div style="width: 100%; height: 100%; background: white; border-radius: 12px; box-shadow: var(--shadow-sm); padding: 40px; position: relative;">
                    <div style="width: 40%; height: 20px; background: #F1F5F9; border-radius: 4px; margin-bottom: 24px;"></div>
                    <div style="width: 100%; height: 12px; background: #F1F5F9; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="width: 100%; height: 12px; background: #F1F5F9; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="width: 70%; height: 12px; background: #F1F5F9; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
        <div x-show="previewOpen" @click="previewOpen = false" style="position: fixed; inset: 0; background: rgba(15,23,42,0.1); backdrop-filter: blur(4px); z-index: 999;"></div>
    </div>
@endsection
