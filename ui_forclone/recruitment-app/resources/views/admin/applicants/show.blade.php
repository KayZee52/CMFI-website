@extends('layouts.recruitment')

@section('content')
    <!-- Detail Hero Section -->
    <section class="dashboard-hero" style="align-items: center;">
        <div style="display: flex; align-items: center; gap: 24px;">
            <a href="{{ route('applicants.index') }}" class="btn-action" style="padding: 10px; border-radius: 50%;">
                <x-icon name="arrow-left" class="w-5 h-5" />
            </a>
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                     alt="Avatar" 
                     style="width: 72px; height: 72px; border-radius: 20px; object-fit: cover; border: 2px solid white; box-shadow: var(--shadow-md);">
                <div class="hero-text">
                    <h1 style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                        {{ $applicant->full_name }}
                        @if($applicant->applicant_type === 'current_teacher')
                            <span class="badge-premium badge-yellow">Internal Staff</span>
                        @endif
                    </h1>
                    <p style="font-size: 14px;">Application ID: <b style="color: var(--text-main);">#{{ $applicant->applications->first()->reference_number }}</b> • Submitted {{ $applicant->applications->first()->submitted_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        <div class="hero-actions">
            <button class="btn btn-secondary">
                <x-icon name="mail" class="w-4 h-4" /> Message
            </button>
            <div style="position: relative;">
                <form action="{{ route('applications.update-stage', $applicant->applications->first()->id) }}" method="POST" id="stage-form">
                    @csrf
                    <select name="current_stage" onchange="document.getElementById('stage-form').submit()" 
                            style="padding: 12px 24px; border-radius: 14px; border: 1.5px solid var(--primary); background: white; font-weight: 600; color: var(--primary); font-family: inherit; cursor: pointer; appearance: none; padding-right: 48px; font-size: 14px;">
                        @php $stages = ['Application Received', 'Phone Screening', 'Shortlisted', 'Interviewing', 'Demo / Observation', 'Background Check', 'Offer Sent', 'Hired / Contract Signed', 'Rejected']; @endphp
                        @foreach($stages as $stage)
                            <option value="{{ $stage }}" {{ $applicant->applications->first()->current_stage === $stage ? 'selected' : '' }}>{{ $stage }}</option>
                        @endforeach
                    </select>
                    <x-icon name="chevron-down" class="w-4 h-4" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--primary);" />
                </form>
            </div>
        </div>
    </section>

    <div class="dashboard-grid" style="grid-template-columns: 2fr 1fr; gap: 32px; margin-top: 40px; align-items: start;">
        <!-- Main Content -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            
            <!-- Analysis & Info Tabs -->
            <div x-data="{ tab: 'details' }" class="profile-card">
                <!-- Tab Headers -->
                <div class="profile-tabs">
                    <button @click="tab = 'details'" :class="tab === 'details' ? 'active' : ''" class="profile-tab">
                        Profile Analysis
                    </button>
                    <button @click="tab = 'documents'" :class="tab === 'documents' ? 'active' : ''" class="profile-tab">
                        Documents & Proofs <span style="background: #F1F5F9; color: #64748B; font-size: 10px; padding: 2px 8px; border-radius: 10px; margin-left: 6px;">{{ $applicant->applications->first()->documents->count() }}</span>
                    </button>
                    <button @click="tab = 'interviews'" :class="tab === 'interviews' ? 'active' : ''" class="profile-tab">
                        Evaluation History
                    </button>
                </div>

                <!-- Tab Content -->
                <div style="padding: 32px;">
                    <!-- Details Content -->
                    <div x-show="tab === 'details'">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Contact Info</label>
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    <div style="display: flex; align-items: center; gap: 8px; color: var(--primary); font-weight: 600;">
                                        <x-icon name="mail" class="w-4 h-4" /> {{ $applicant->email }}
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px; color: #475569;">
                                        <x-icon name="users" class="w-4 h-4" /> {{ $applicant->phone }}
                                    </div>
                                </div>
                            </div>
                            <div class="info-block">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Position Targeted</label>
                                <p style="font-size: 15px; font-weight: 600; margin: 0; color: #0F172A;">{{ $applicant->applications->first()->jobOpening->position->title ?? 'N/A' }}</p>
                                <p style="font-size: 13px; color: #64748B; margin-top: 4px;">{{ $applicant->applications->first()->jobOpening->position->department->name ?? 'General' }}</p>
                            </div>
                        </div>

                        <div style="margin-top: 32px; padding: 24px; background: #F8FAFC; border-radius: 16px; border: 1px solid #F1F5F9;">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">Professional Statement / Bio</label>
                            <p style="font-size: 14px; line-height: 1.8; color: #475569; margin: 0;">{{ $applicant->bio ?? 'No professional statement provided by the candidate.' }}</p>
                        </div>
                    </div>

                    <!-- Documents Content -->
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
                                            <p style="font-size: 12px; color: #94A3B8; margin-top: 2px;">{{ $doc->original_filename }} • PDF Document</p>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 12px;">
                                        <button class="btn-action" style="padding: 8px 16px; font-size: 12px;">
                                            <x-icon name="search" class="w-4 h-4" /> Preview
                                        </button>
                                        <a href="#" class="btn-action btn-action-primary" style="padding: 8px 16px; font-size: 12px;">
                                            <x-icon name="download" class="w-4 h-4" /> Download
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 60px 0;">
                                    <x-icon name="briefcase" class="w-12 h-12" style="color: #E2E8F0; margin: 0 auto 16px;" />
                                    <p style="color: #94A3B8; font-size: 14px;">No documents uploaded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Evaluation Timeline -->
                    <div x-show="tab === 'interviews'">
                        <div class="timeline">
                            @forelse($applicant->applications->first()->interviews as $interview)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                            <div>
                                                <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0F172A;">{{ ucfirst($interview->type) }} Assessment</h4>
                                                <p style="margin: 4px 0 0; font-size: 12px; color: #94A3B8;">
                                                    <x-icon name="calendar" class="w-3 h-3" /> {{ $interview->scheduled_at->format('M d, Y @ H:i') }}
                                                </p>
                                            </div>
                                            <span class="status-tag {{ $interview->status === 'Completed' ? 'completed' : 'pending' }}" style="padding: 4px 12px; font-size: 10px;">{{ $interview->status }}</span>
                                        </div>
                                        @if($interview->status === 'Completed')
                                            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700;">HR</div>
                                                    <span style="font-size: 12px; color: #64748B;">Evaluated by Committee</span>
                                                </div>
                                                <a href="#" class="btn-action-primary" style="font-size: 12px; font-weight: 700; text-decoration: none;">View Scorecard <x-icon name="chevron-right" class="w-3 h-3" /></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 40px 0;">
                                    <p style="color: #94A3B8; font-size: 14px; margin-bottom: 20px;">No evaluations scheduled yet.</p>
                                    <a href="{{ route('interviews.create', ['application_id' => $applicant->applications->first()->id]) }}" class="btn btn-primary" style="display: inline-flex; text-decoration: none;">
                                        <x-icon name="calendar" class="w-4 h-4" /> Schedule Evaluation
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes & Activity Log -->
            <div class="profile-card" style="padding: 32px;">
                <div class="section-header" style="margin-bottom: 24px;">
                    <h2 style="font-size: 18px; font-weight: 700;">Internal Decision Log</h2>
                    <button class="btn-action btn-action-primary"><x-icon name="dashboard" class="w-4 h-4" /> Add Note</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @foreach($applicant->applications->first()->notes as $note)
                        <div style="display: flex; gap: 16px; padding: 20px; background: {{ $note->type === 'system' ? '#F8FAFC' : '#FFFFFF' }}; border: 1px solid {{ $note->type === 'system' ? 'transparent' : '#E2E8F0' }}; border-radius: 20px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $note->type === 'system' ? '#1E293B' : 'var(--primary)' }}; color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <x-icon name="{{ $note->type === 'system' ? 'cog-6-tooth' : 'users' }}" class="w-5 h-5" />
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                    <span style="font-weight: 700; font-size: 13px; color: #0F172A;">{{ $note->type === 'system' ? 'System Notification' : $note->user->name }}</span>
                                    <span style="font-size: 11px; color: #94A3B8;">{{ $note->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #475569;">{{ $note->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div style="display: flex; flex-direction: column; gap: 32px;">
            
            <!-- Hiring Signal Card -->
            <div class="profile-card" style="padding: 32px; background: linear-gradient(135deg, #0F172A, #1E293B); color: white; border: none;">
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 1px solid rgba(255,255,255,0.2);">
                        <x-icon name="dashboard" class="w-8 h-8" />
                    </div>
                    <h3 style="margin: 0; font-size: 20px; font-weight: 700;">Hiring Decision</h3>
                    <p style="font-size: 13px; opacity: 0.6; margin: 8px 0 0;">Record the final outcome for this candidate.</p>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="decision_status" value="Shortlisted">
                        <button type="submit" class="btn" style="width: 100%; background: rgba(255,255,255,0.05); color: white; border: 1px solid rgba(255,255,255,0.1); justify-content: center;">
                            <x-icon name="calendar" class="w-4 h-4" /> Add to Shortlist
                        </button>
                    </form>

                    <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="decision_status" value="Hired">
                        <button type="submit" class="btn" style="width: 100%; background: var(--primary); color: white; border: none; justify-content: center; font-weight: 700; box-shadow: 0 4px 12px rgba(42, 133, 255, 0.3);">
                            <x-icon name="users" class="w-4 h-4" /> Hire Candidate
                        </button>
                    </form>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="btn" style="width: 100%; background: #EF4444; color: white; border: none; justify-content: center; font-weight: 600;">
                            <x-icon name="dashboard" class="w-4 h-4" /> Reject Candidate
                        </button>
                        <div x-show="open" x-transition style="margin-top: 12px; background: rgba(255,255,255,0.05); padding: 16px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                            <form action="{{ route('applications.decision', $applicant->applications->first()->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="decision_status" value="Rejected">
                                <textarea name="rejection_reason" placeholder="Reason for rejection..." style="width: 100%; height: 80px; padding: 12px; border-radius: 12px; border: none; font-size: 12px; margin-bottom: 12px; background: white; color: #1E293B;"></textarea>
                                <button type="submit" class="btn btn-secondary" style="width: 100%; font-size: 12px; border-color: rgba(255,255,255,0.3); color: white;">Confirm Rejection</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Context Info -->
            <div class="profile-card" style="padding: 24px;">
                <h4 style="margin: 0 0 16px; font-size: 14px; font-weight: 700; color: #0F172A;">Departmental Context</h4>
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: #F8FAFC; border-radius: 16px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; color: #64748B; border: 1px solid #E2E8F0;">
                        <x-icon name="briefcase" class="w-5 h-5" />
                    </div>
                    <div>
                        <p style="font-size: 14px; font-weight: 700; margin: 0; color: #0F172A;">{{ $applicant->applications->first()->jobOpening->position->department->name ?? 'N/A' }}</p>
                        <p style="font-size: 12px; color: #94A3B8; margin-top: 2px;">Reviewing Department</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
