@extends('layouts.recruitment')

@section('content')
    <div x-data="{ 
        tab: 'details', 
        previewOpen: false, 
        previewUrl: '', 
        previewTitle: '' 
    }">
        <!-- Detail Hero Section -->
        <section class="dashboard-hero" style="align-items: center; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <a href="{{ route('applicants.index') }}" class="btn-action" style="padding: 10px; border-radius: 50%;">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                         alt="Avatar" 
                         style="width: 80px; height: 80px; border-radius: 24px; object-fit: cover; border: 3px solid white; box-shadow: var(--shadow-md);">
                    <div class="hero-text">
                        <h1 style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px; font-size: 28px;">
                            {{ $applicant->full_name }}
                            @if($applicant->applicant_type === 'current_teacher')
                                <span class="badge-premium badge-yellow">Internal Staff</span>
                            @endif
                        </h1>
                        <div style="display: flex; align-items: center; gap: 12px; font-size: 14px; color: #64748B;">
                            <span>ID: <b>#{{ $applicant->applications->first()->reference_number }}</b></span>
                            <span style="opacity: 0.3;">|</span>
                            <span>Applied {{ $applicant->applications->first()->submitted_at->format('M d, Y') }}</span>
                            <span style="opacity: 0.3;">|</span>
                            <span style="display: flex; align-items: center; gap: 4px; color: var(--primary); font-weight: 700;">
                                <x-icon name="dashboard" class="w-4 h-4" /> {{ $applicant->applications->first()->current_stage }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-actions">
                <button class="btn btn-secondary" style="border-radius: 12px;">
                    <x-icon name="mail" class="w-4 h-4" /> Send Email
                </button>
                <button class="btn btn-primary" style="border-radius: 12px; background: #0F172A;">
                    <x-icon name="calendar" class="w-4 h-4" /> Schedule Call
                </button>
            </div>
        </section>

        <!-- Main Layout Grid -->
        <div class="dashboard-grid" style="grid-template-columns: 2.2fr 1fr; gap: 32px; margin-top: 40px; align-items: start;">
            
            <!-- Left Column: Primary Analysis -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- AI Summary Card (TL;DR) -->
                <div class="profile-card" style="padding: 24px; background: linear-gradient(135deg, #F8FAFC, #EFF6FF); border: 1px solid #DBEAFE;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <div style="padding: 6px; background: var(--primary); color: white; border-radius: 8px;">
                            <x-icon name="dashboard" class="w-4 h-4" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: 700; color: #1E40AF; text-transform: uppercase; letter-spacing: 0.5px;">Gemini AI Candidate Insights</h3>
                        <span class="badge-premium" style="margin-left: auto; background: white; color: #1E40AF; border-color: #DBEAFE;">BETA</span>
                    </div>
                    <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #DBEAFE; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <p style="font-size: 15px; line-height: 1.7; color: #1E293B; margin: 0;">
                            <b>Candidate Overview:</b> {{ $applicant->full_name }} shows strong pedagogical alignment with our "Growth Mindset" curriculum. 
                            Their experience at {{ $applicant->applicant_type === 'current_teacher' ? 'our institution' : 'previous roles' }} demonstrates consistent student engagement.
                        </p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 16px; padding-top: 16px; border-top: 1px dashed #DBEAFE;">
                            <div>
                                <h4 style="font-size: 12px; font-weight: 700; color: #059669; display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                    <x-icon name="check-circle" class="w-4 h-4" /> STRENGTHS
                                </h4>
                                <ul style="font-size: 13px; color: #334155; padding-left: 18px; margin: 0;">
                                    <li>Proven curriculum design skills</li>
                                    <li>Strong recommendation from Principal</li>
                                </ul>
                            </div>
                            <div>
                                <h4 style="font-size: 12px; font-weight: 700; color: #DC2626; display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                    <x-icon name="dashboard" class="w-4 h-4" /> POTENTIAL GAPS
                                </h4>
                                <ul style="font-size: 13px; color: #334155; padding-left: 18px; margin: 0;">
                                    <li>Limited experience with SmartBoard tech</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabbed Analysis Hub -->
                <div class="profile-card">
                    <div class="profile-tabs">
                        <button @click="tab = 'details'" :class="tab === 'details' ? 'active' : ''" class="profile-tab">
                            Full Profile Analysis
                        </button>
                        <button @click="tab = 'documents'" :class="tab === 'documents' ? 'active' : ''" class="profile-tab">
                            Documents <span style="background: #F1F5F9; color: #64748B; font-size: 10px; padding: 2px 8px; border-radius: 10px; margin-left: 6px;">{{ $applicant->applications->first()->documents->count() }}</span>
                        </button>
                        <button @click="tab = 'skills'" :class="tab === 'skills' ? 'active' : ''" class="profile-tab">
                            Skill Matrix
                        </button>
                    </div>

                    <div style="padding: 32px;">
                        <!-- Details Content -->
                        <div x-show="tab === 'details'">
                            <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">Candidate Biography</label>
                                    <div style="font-size: 15px; line-height: 1.8; color: #475569; padding: 24px; background: #F8FAFC; border-radius: 16px; border: 1px solid #F1F5F9;">
                                        {{ $applicant->bio ?? 'No professional biography provided.' }}
                                    </div>
                                </div>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                                    <div style="padding: 20px; border: 1px solid #F1F5F9; border-radius: 16px;">
                                        <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 8px;">Education Level</label>
                                        <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">Master of Education (M.Ed)</p>
                                    </div>
                                    <div style="padding: 20px; border: 1px solid #F1F5F9; border-radius: 16px;">
                                        <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 8px;">Years of Experience</label>
                                        <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">8 Years in Active Teaching</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Tab with Inline Preview -->
                        <div x-show="tab === 'documents'">
                            <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                                @forelse($applicant->applications->first()->documents as $doc)
                                    <div class="doc-card">
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div class="doc-icon">
                                                <x-icon name="briefcase" class="w-6 h-6" />
                                            </div>
                                            <div>
                                                <p style="font-size: 15px; font-weight: 700; margin: 0; color: #0F172A;">{{ $doc->document_type }}</p>
                                                <p style="font-size: 12px; color: #94A3B8; margin-top: 2px;">{{ $doc->original_filename }}</p>
                                            </div>
                                        </div>
                                        <div style="display: flex; gap: 12px;">
                                            <button @click="previewOpen = true; previewUrl = '#'; previewTitle = '{{ $doc->document_type }}'" 
                                                    class="btn-action" style="padding: 8px 16px; font-size: 12px;">
                                                <x-icon name="search" class="w-4 h-4" /> Quick View
                                            </button>
                                            <a href="#" class="btn-action btn-action-primary" style="padding: 8px 16px; font-size: 12px;">
                                                <x-icon name="download" class="w-4 h-4" /> Download
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div style="text-align: center; padding: 60px 0;">
                                        <x-icon name="briefcase" class="w-12 h-12" style="color: #E2E8F0; margin: 0 auto 16px;" />
                                        <p style="color: #94A3B8; font-size: 14px;">No documents available.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Skill Matrix Content -->
                        <div x-show="tab === 'skills'">
                            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; align-items: center;">
                                <div class="skill-bar-container">
                                    <div class="skill-bar-item">
                                        <div class="skill-label">Class Management</div>
                                        <div class="skill-track"><div class="skill-fill" style="width: 90%;"></div></div>
                                        <div style="font-size: 12px; font-weight: 700; color: #0F172A;">90%</div>
                                    </div>
                                    <div class="skill-bar-item">
                                        <div class="skill-label">Curriculum Design</div>
                                        <div class="skill-track"><div class="skill-fill" style="width: 85%;"></div></div>
                                        <div style="font-size: 12px; font-weight: 700; color: #0F172A;">85%</div>
                                    </div>
                                    <div class="skill-bar-item">
                                        <div class="skill-label">Digital Literacy</div>
                                        <div class="skill-track"><div class="skill-fill" style="width: 60%;"></div></div>
                                        <div style="font-size: 12px; font-weight: 700; color: #0F172A;">60%</div>
                                    </div>
                                    <div class="skill-bar-item">
                                        <div class="skill-label">Student Empathy</div>
                                        <div class="skill-track"><div class="skill-fill" style="width: 95%;"></div></div>
                                        <div style="font-size: 12px; font-weight: 700; color: #0F172A;">95%</div>
                                    </div>
                                </div>
                                <div style="text-align: center; padding: 24px; background: #F8FAFC; border-radius: 20px; border: 1px solid #F1F5F9;">
                                    <h4 style="font-size: 12px; font-weight: 700; color: #94A3B8; margin-bottom: 16px; text-transform: uppercase;">Competency Summary</h4>
                                    <p style="font-size: 14px; color: #475569; line-height: 1.6;">
                                        Candidate exceeds expectations in <b>Social & Emotional Learning</b> but may require onboarding for <b>LMS tools</b>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Activity Log -->
                <div class="profile-card" style="padding: 32px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h2 style="font-size: 18px; font-weight: 700; margin: 0;">Internal Discussion</h2>
                        <button class="btn-action"><x-icon name="dashboard" class="w-4 h-4" /> Add Note</button>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        @foreach($applicant->applications->first()->notes as $note)
                            <div style="display: flex; gap: 16px; padding: 20px; background: {{ $note->type === 'system' ? '#F8FAFC' : '#FFFFFF' }}; border: 1px solid {{ $note->type === 'system' ? 'transparent' : '#E2E8F0' }}; border-radius: 20px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $note->type === 'system' ? '#1E293B' : 'var(--primary)' }}; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <x-icon name="{{ $note->type === 'system' ? 'cog-6-tooth' : 'users' }}" class="w-5 h-5" />
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                        <span style="font-weight: 700; font-size: 13px;">{{ $note->type === 'system' ? 'System Notification' : $note->user->name }}</span>
                                        <span style="font-size: 11px; color: #94A3B8;">{{ $note->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #475569;">{{ $note->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Persistent Metadata Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 32px; position: sticky; top: 32px;">
                
                <!-- Match Score Gauge -->
                <div class="profile-card" style="padding: 32px; text-align: center;">
                    <h3 style="font-size: 14px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 24px; letter-spacing: 0.5px;">Role Fit Analysis</h3>
                    <div class="match-gauge">
                        <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle class="match-gauge-bg" cx="60" cy="60" r="50"></circle>
                            <circle class="match-gauge-fill" cx="60" cy="60" r="50" 
                                    style="stroke-dasharray: 314; stroke-dashoffset: {{ 314 - (314 * 0.82) }};"></circle>
                        </svg>
                        <div class="match-score-text">
                            <span class="match-score-number">82%</span>
                            <span class="match-score-label">Fit Score</span>
                        </div>
                    </div>
                    <div style="margin-top: 24px; font-size: 13px; color: #64748B;">
                        Based on skills, experience, and department requirements.
                    </div>
                </div>

                <!-- Contact & Social Meta -->
                <div class="profile-card" style="padding: 32px;">
                    <h3 style="font-size: 14px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 24px; letter-spacing: 0.5px;">Contact Profile</h3>
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <x-icon name="mail" class="w-5 h-5" />
                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin: 0;">Email</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0; overflow: hidden; text-overflow: ellipsis;">{{ $applicant->email }}</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <x-icon name="users" class="w-5 h-5" />
                            </div>
                            <div>
                                <p style="font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin: 0;">Phone</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">{{ $applicant->phone }}</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <x-icon name="briefcase" class="w-5 h-5" />
                            </div>
                            <div>
                                <p style="font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin: 0;">Address</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">{{ $applicant->address ?? 'Lagos, Nigeria' }}</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid #F1F5F9;">
                        <h4 style="font-size: 11px; font-weight: 700; color: #94A3B8; margin-bottom: 16px; text-transform: uppercase;">Professional Links</h4>
                        <div style="display: flex; gap: 12px;">
                            <a href="#" class="btn-action" style="padding: 10px; border-radius: 10px;"><x-icon name="users" class="w-4 h-4" /></a>
                            <a href="#" class="btn-action" style="padding: 10px; border-radius: 10px;"><x-icon name="briefcase" class="w-4 h-4" /></a>
                            <a href="#" class="btn-action" style="padding: 10px; border-radius: 10px;"><x-icon name="mail" class="w-4 h-4" /></a>
                        </div>
                    </div>
                </div>

                <!-- Decision Panel -->
                <div class="profile-card" style="padding: 32px; background: #0F172A; color: white; border: none;">
                    <h3 style="font-size: 14px; font-weight: 700; color: #64748B; text-transform: uppercase; margin-bottom: 24px; letter-spacing: 0.5px;">Hiring Signal</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="decision_status" value="Shortlisted">
                            <button type="submit" class="btn" style="width: 100%; background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); justify-content: center;">
                                <x-icon name="calendar" class="w-4 h-4" /> Shortlist
                            </button>
                        </form>
                        <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="decision_status" value="Hired">
                            <button type="submit" class="btn" style="width: 100%; background: var(--primary); color: white; border: none; justify-content: center; font-weight: 700;">
                                <x-icon name="check-circle" class="w-4 h-4" /> Hire Candidate
                            </button>
                        </form>
                        <button class="btn" style="width: 100%; background: #EF4444; color: white; border: none; justify-content: center;">
                            <x-icon name="dashboard" class="w-4 h-4" /> Reject
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inline PDF Previewer (Slide-over) -->
        <div class="slide-over-overlay" :class="previewOpen ? 'active' : ''" @click="previewOpen = false"></div>
        <div class="slide-over" :class="previewOpen ? 'active' : ''">
            <div style="height: 100%; display: flex; flex-direction: column;">
                <div style="padding: 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: white;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #F1F5F9; color: var(--primary); display: flex; align-items: center; justify-content: center;">
                            <x-icon name="briefcase" class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0F172A;" x-text="previewTitle"></h3>
                            <p style="margin: 0; font-size: 12px; color: #94A3B8;">Candidate Document Preview</p>
                        </div>
                    </div>
                    <button @click="previewOpen = false" class="btn-action" style="padding: 10px; border-radius: 50%;">
                        <x-icon name="dashboard" class="w-5 h-5" />
                    </button>
                </div>
                <div style="flex: 1; background: #F1F5F9; position: relative;">
                    <!-- Mock PDF Content -->
                    <div style="position: absolute; inset: 24px; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-radius: 8px; display: flex; flex-direction: column; overflow: hidden;">
                        <div style="height: 60px; background: #E2E8F0; padding: 20px; display: flex; gap: 12px;">
                            <div style="width: 100px; height: 10px; background: #CBD5E1; border-radius: 4px;"></div>
                            <div style="width: 150px; height: 10px; background: #CBD5E1; border-radius: 4px;"></div>
                        </div>
                        <div style="padding: 40px; flex: 1;">
                            <div style="width: 100%; height: 20px; background: #F1F5F9; border-radius: 4px; margin-bottom: 24px;"></div>
                            <div style="width: 80%; height: 20px; background: #F1F5F9; border-radius: 4px; margin-bottom: 40px;"></div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 40px;">
                                <div style="height: 150px; background: #F8FAFC; border-radius: 8px;"></div>
                                <div style="height: 150px; background: #F8FAFC; border-radius: 8px;"></div>
                            </div>

                            <div style="width: 100%; height: 10px; background: #F1F5F9; border-radius: 4px; margin-bottom: 12px;"></div>
                            <div style="width: 100%; height: 10px; background: #F1F5F9; border-radius: 4px; margin-bottom: 12px;"></div>
                            <div style="width: 60%; height: 10px; background: #F1F5F9; border-radius: 4px;"></div>
                        </div>
                    </div>
                </div>
                <div style="padding: 24px; border-top: 1px solid #F1F5F9; background: white; display: flex; justify-content: flex-end; gap: 16px;">
                    <button class="btn btn-secondary" style="font-size: 13px;">Print Document</button>
                    <button class="btn btn-primary" style="font-size: 13px;">Download Full PDF</button>
                </div>
            </div>
        </div>
    </div>
@endsection
