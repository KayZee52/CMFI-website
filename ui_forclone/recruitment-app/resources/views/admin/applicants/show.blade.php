@extends('layouts.recruitment')

@section('content')
    <div x-data="{ previewOpen: false, previewTitle: '' }" class="profile-hub">
        
        <!-- Top Navigation -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('applicants.index') }}" style="color: var(--text-muted);"><x-icon name="arrow-left" class="w-6 h-6" /></a>
                <h1 style="font-size: 24px; font-weight: 800; margin: 0;">Candidate Profile</h1>
            </div>
            <div style="display: flex; gap: 12px;">
                <button class="btn btn-secondary" style="border-radius: 12px;"><x-icon name="mail" class="w-4 h-4" /> Message</button>
                <button class="btn btn-primary" style="border-radius: 12px; background: #0F172A;"><x-icon name="calendar" class="w-4 h-4" /> Schedule Call</button>
            </div>
        </div>

        <div class="dashboard-grid" style="grid-template-columns: 360px 1fr; gap: 32px; align-items: start;">
            
            <!-- Left Pane: Hero & Social -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <div class="hero-card">
                    <div style="position: relative; display: inline-block;">
                        <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                             class="avatar-large" alt="Avatar">
                        <div style="position: absolute; bottom: 30px; right: 10px; width: 28px; height: 28px; background: #10B981; border: 4px solid white; border-radius: 50%;"></div>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0;">{{ $applicant->full_name }}</h2>
                    <p style="font-size: 14px; color: var(--primary); font-weight: 700; margin: 8px 0 24px;">{{ $applicant->applications->first()->jobOpening->position->title }}</p>
                    
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <span class="badge-premium" style="background: #F1F5F9; color: #64748B; border: none;">#{{ $applicant->applications->first()->reference_number }}</span>
                        <span class="badge-premium" style="background: #EFF6FF; color: var(--primary); border: none;">{{ $applicant->applications->first()->current_stage }}</span>
                    </div>
                </div>

                <div class="profile-card" style="padding: 32px;">
                    <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin: 0 0 24px; text-transform: uppercase; letter-spacing: 0.05em;">Social Presence</h4>
                    <div style="display: flex; gap: 16px;">
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #E11D48;"><x-icon name="users" class="w-6 h-6" /></a>
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #8B5CF6;"><x-icon name="users" class="w-6 h-6" /></a>
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #0EA5E9;"><x-icon name="users" class="w-6 h-6" /></a>
                    </div>
                </div>

                <!-- Match Score Section (Adapted from Maria Fernanda "Availability") -->
                <div class="profile-card" style="padding: 32px; text-align: center;">
                    <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin: 0 0 24px; text-transform: uppercase; letter-spacing: 0.05em;">Hiring Match</h4>
                    <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                        @php $matchScore = 82; $degree = ($matchScore / 100) * 360; @endphp
                        <div class="gauge-chart" style="width: 130px; height: 130px; background: conic-gradient(var(--primary) 0deg {{ $degree }}deg, #F1F5F9 {{ $degree }}deg 360deg);">
                            <style>.gauge-chart::before { width: 105px !important; height: 105px !important; }</style>
                            <div class="gauge-center">
                                <span style="font-size: 24px; font-weight: 900; color: #0F172A;">{{ $matchScore }}%</span>
                            </div>
                        </div>
                    </div>
                    <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">This candidate matches <b>82%</b> of the core requirements for this position.</p>
                </div>
            </div>

            <!-- Right Pane: Details & Collections -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- Bio & Details Card -->
                <div class="profile-card" style="padding: 32px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0;">Bio & other details</h4>
                        <div style="width: 8px; height: 8px; background: #10B981; border-radius: 50%;"></div>
                    </div>
                    <p style="font-size: 15px; line-height: 1.8; color: #475569; margin-bottom: 32px;">{{ $applicant->bio ?? 'No professional biography provided.' }}</p>
                    
                    <div class="meta-grid">
                        <div class="meta-item">
                            <span class="meta-label">Highest Qualification</span>
                            <span class="meta-value">Master of Education (M.Ed)</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Experience Level</span>
                            <span class="meta-value">8 Years (Intermediate)</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Contact Email</span>
                            <span class="meta-value">{{ $applicant->email }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Phone Number</span>
                            <span class="meta-value">{{ $applicant->phone }}</span>
                        </div>
                        <div class="meta-item" style="grid-column: span 2;">
                            <span class="meta-label">Core Skills</span>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">
                                <span class="badge-premium" style="background: #F1F5F9; border: none; font-size: 11px;">#Pedagogy</span>
                                <span class="badge-premium" style="background: #F1F5F9; border: none; font-size: 11px;">#ClassroomMgmt</span>
                                <span class="badge-premium" style="background: #F1F5F9; border: none; font-size: 11px;">#LessonPlanning</span>
                                <span class="badge-premium" style="background: #F1F5F9; border: none; font-size: 11px;">#EducationalTech</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Work Experience (Production Style) -->
                <div class="profile-card" style="padding: 32px;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px;">Professional History</h4>
                    <div class="production-list">
                        <div class="production-item">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 40px; height: 40px; background: #F8FAFC; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <x-icon name="briefcase" class="w-5 h-5" />
                                </div>
                                <div>
                                    <p style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0;">Senior Mathematics Teacher</p>
                                    <p style="font-size: 12px; color: #94A3B8; margin: 2px 0 0;">Greenwood International School</p>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 13px; font-weight: 600; color: #475569; margin: 0;">2018 - Present</p>
                                <p style="font-size: 11px; color: #94A3B8; margin: 2px 0 0;">6 Years</p>
                            </div>
                        </div>
                        <div class="production-item">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 40px; height: 40px; background: #F8FAFC; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <x-icon name="briefcase" class="w-5 h-5" />
                                </div>
                                <div>
                                    <p style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0;">Junior Tutor</p>
                                    <p style="font-size: 12px; color: #94A3B8; margin: 2px 0 0;">City Academy</p>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 13px; font-weight: 600; color: #475569; margin: 0;">2016 - 2018</p>
                                <p style="font-size: 11px; color: #94A3B8; margin: 2px 0 0;">2 Years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Collection (Grid Style) -->
                <div class="profile-card" style="padding: 32px;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px;">Evidence Collection</h4>
                    <div class="doc-gallery">
                        @forelse($applicant->applications->first()->documents as $doc)
                            <div class="doc-item" @click="previewOpen = true; previewTitle = '{{ $doc->document_type }}'">
                                <div class="doc-thumbnail">
                                    <x-icon name="briefcase" class="w-10 h-10" />
                                    <div class="doc-play-btn"><x-icon name="search" class="w-5 h-5" /></div>
                                </div>
                                <div class="doc-info">
                                    <p class="doc-title">{{ $doc->document_type }}</p>
                                    <p class="doc-sub">PDF Document</p>
                                </div>
                            </div>
                        @empty
                            <p style="color: #94A3B8; grid-column: span 3; text-align: center; padding: 40px;">No documents uploaded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Inline Previewer (Maria Fernanda Styled) -->
        <div x-show="previewOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 40px;">
            <div style="background: white; width: 100%; max-width: 900px; height: 100%; border-radius: 24px; overflow: hidden; display: flex; flex-direction: column;">
                <div style="padding: 24px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800;" x-text="previewTitle"></h3>
                    <button @click="previewOpen = false" style="color: #94A3B8;"><x-icon name="dashboard" class="w-6 h-6" /></button>
                </div>
                <div style="flex: 1; background: #F8FAFC; padding: 40px; overflow-y: auto;">
                    <div style="width: 100%; min-height: 1000px; background: white; box-shadow: var(--shadow-sm); border-radius: 8px; padding: 60px;">
                        <!-- PDF Mock -->
                        <div style="width: 120px; height: 12px; background: #F1F5F9; margin-bottom: 40px;"></div>
                        <div style="width: 100%; height: 32px; background: #F1F5F9; margin-bottom: 60px;"></div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px;">
                            <div style="height: 200px; background: #F8FAFC;"></div>
                            <div style="height: 200px; background: #F8FAFC;"></div>
                        </div>
                        <div style="width: 100%; height: 12px; background: #F1F5F9; margin-bottom: 12px;"></div>
                        <div style="width: 100%; height: 12px; background: #F1F5F9; margin-bottom: 12px;"></div>
                        <div style="width: 60%; height: 12px; background: #F1F5F9;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
