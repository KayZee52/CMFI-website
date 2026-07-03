@extends('layouts.recruitment')

@section('content')
    <div x-data="{ 
        tab: 'details', 
        previewOpen: false, 
        previewUrl: '', 
        previewTitle: '' 
    }" class="detail-view">
        
        <!-- Minimal Header -->
        <header style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 48px;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <a href="{{ route('applicants.index') }}" style="color: var(--text-muted); transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <x-icon name="arrow-left" class="w-6 h-6" />
                </a>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="position: relative;">
                        <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                             alt="Avatar" 
                             style="width: 80px; height: 80px; border-radius: 24px; object-fit: cover;">
                        <div style="position: absolute; bottom: -4px; right: -4px; width: 24px; height: 24px; background: #10B981; border: 3px solid white; border-radius: 50%;"></div>
                    </div>
                    <div>
                        <h1 style="font-size: 32px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.5px;">{{ $applicant->full_name }}</h1>
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 4px; font-size: 14px; color: #64748B;">
                            <span style="font-weight: 600;">#{{ $applicant->applications->first()->reference_number }}</span>
                            <span style="width: 4px; height: 4px; background: #CBD5E1; border-radius: 50%;"></span>
                            <span>{{ $applicant->applications->first()->jobOpening->position->title }}</span>
                            <span style="width: 4px; height: 4px; background: #CBD5E1; border-radius: 50%;"></span>
                            <span style="color: var(--primary); font-weight: 700;">{{ $applicant->applications->first()->current_stage }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 12px;">
                <button class="btn btn-secondary" style="background: white; border: 1px solid #E2E8F0; color: #0F172A; font-weight: 600;">
                    <x-icon name="mail" class="w-4 h-4" /> Message
                </button>
                <button class="btn btn-primary" style="background: #0F172A; border: none; font-weight: 600;">
                    <x-icon name="calendar" class="w-4 h-4" /> Schedule Interview
                </button>
            </div>
        </header>

        <div class="dashboard-grid" style="grid-template-columns: 1fr 340px; gap: 48px; align-items: start;">
            
            <!-- Main Content Area -->
            <div style="display: flex; flex-direction: column; gap: 40px;">
                
                <!-- AI Insight Banner (Minimalist) -->
                <div style="display: flex; gap: 20px; padding: 24px; background: #F8FAFC; border-radius: 20px; border: 1px solid #F1F5F9;">
                    <div style="flex-shrink: 0; width: 40px; height: 40px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); color: var(--primary);">
                        <x-icon name="dashboard" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 style="font-size: 12px; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Recruiter Insights</h3>
                        <p style="font-size: 15px; color: #334155; line-height: 1.6; margin: 0;">
                            <b>Highly Recommended:</b> John shows exceptional subject matter expertise. AI analysis suggests a <b>92% match</b> for the Senior Mathematics role with a strong focus on student-centered learning.
                        </p>
                    </div>
                </div>

                <!-- Tabs & Content -->
                <div>
                    <div class="profile-tabs" style="border: none; padding: 0; margin-bottom: 32px; gap: 40px;">
                        <button @click="tab = 'details'" :class="tab === 'details' ? 'active' : ''" class="profile-tab" style="padding: 0 0 12px; font-size: 16px;">General</button>
                        <button @click="tab = 'documents'" :class="tab === 'documents' ? 'active' : ''" class="profile-tab" style="padding: 0 0 12px; font-size: 16px;">Documents</button>
                        <button @click="tab = 'skills'" :class="tab === 'skills' ? 'active' : ''" class="profile-tab" style="padding: 0 0 12px; font-size: 16px;">Assessment</button>
                    </div>

                    <!-- Tab Content -->
                    <div style="min-height: 400px;">
                        <!-- General Tab -->
                        <div x-show="tab === 'details'" x-transition>
                            <div style="display: flex; flex-direction: column; gap: 40px;">
                                <section>
                                    <h4 style="font-size: 14px; font-weight: 700; color: #0F172A; margin-bottom: 16px;">Professional Bio</h4>
                                    <p style="font-size: 16px; line-height: 1.8; color: #475569; margin: 0;">{{ $applicant->bio ?? 'The candidate has not provided a biography yet.' }}</p>
                                </section>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                                    <div style="padding: 24px; background: #F8FAFC; border-radius: 16px;">
                                        <span style="font-size: 12px; font-weight: 700; color: #94A3B8; text-transform: uppercase;">Highest Qualification</span>
                                        <p style="font-size: 16px; font-weight: 600; color: #0F172A; margin: 8px 0 0;">Master of Education (M.Ed)</p>
                                    </div>
                                    <div style="padding: 24px; background: #F8FAFC; border-radius: 16px;">
                                        <span style="font-size: 12px; font-weight: 700; color: #94A3B8; text-transform: uppercase;">Active Experience</span>
                                        <p style="font-size: 16px; font-weight: 600; color: #0F172A; margin: 8px 0 0;">8 Years Teaching</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Tab -->
                        <div x-show="tab === 'documents'" x-transition>
                            <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                                @forelse($applicant->applications->first()->documents as $doc)
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px; background: white; border: 1px solid #F1F5F9; border-radius: 16px; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.boxShadow='var(--shadow-sm)'" onmouseout="this.style.borderColor='#F1F5F9'; this.style.boxShadow='none'">
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="width: 44px; height: 44px; background: #F8FAFC; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                <x-icon name="briefcase" class="w-5 h-5" />
                                            </div>
                                            <div>
                                                <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0;">{{ $doc->document_type }}</p>
                                                <p style="font-size: 12px; color: #94A3B8; margin: 2px 0 0;">{{ $doc->original_filename }}</p>
                                            </div>
                                        </div>
                                        <button @click="previewOpen = true; previewTitle = '{{ $doc->document_type }}'" class="btn-action" style="font-size: 13px; font-weight: 700; color: var(--primary); background: transparent;">View Document</button>
                                    </div>
                                @empty
                                    <p style="color: #94A3B8;">No documents uploaded.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Assessment Tab -->
                        <div x-show="tab === 'skills'" x-transition>
                            <div style="display: flex; flex-direction: column; gap: 32px;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                                    @php $skills = [['label' => 'Pedagogy', 'score' => 90], ['label' => 'Classroom Mgmt', 'score' => 85], ['label' => 'Technology', 'score' => 60], ['label' => 'Communication', 'score' => 95]]; @endphp
                                    @foreach($skills as $skill)
                                        <div>
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                <span style="font-size: 13px; font-weight: 700; color: #475569;">{{ $skill['label'] }}</span>
                                                <span style="font-size: 13px; font-weight: 800; color: #0F172A;">{{ $skill['score'] }}%</span>
                                            </div>
                                            <div style="height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden;">
                                                <div style="height: 100%; background: var(--primary); width: {{ $skill['score'] }}%;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Metadata & Actions -->
            <div style="display: flex; flex-direction: column; gap: 48px;">
                
                <!-- Quick Match Score -->
                <div style="text-align: center;">
                    <div style="position: relative; display: inline-block;">
                        <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#F1F5F9" stroke-width="8" />
                            <circle cx="60" cy="60" r="54" fill="none" stroke="var(--primary)" stroke-width="8" stroke-dasharray="339.3" stroke-dashoffset="{{ 339.3 * (1 - 0.82) }}" stroke-linecap="round" />
                        </svg>
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <span style="display: block; font-size: 28px; font-weight: 900; color: #0F172A;">82%</span>
                            <span style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase;">Match</span>
                        </div>
                    </div>
                </div>

                <!-- Info Blocks -->
                <div style="display: flex; flex-direction: column; gap: 32px;">
                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Contact Information</h4>
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <x-icon name="mail" class="w-4 h-4" style="color: #64748B;" />
                                <span style="font-size: 14px; font-weight: 600; color: #334155;">{{ $applicant->email }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <x-icon name="users" class="w-4 h-4" style="color: #64748B;" />
                                <span style="font-size: 14px; font-weight: 600; color: #334155;">{{ $applicant->phone }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;">Application Status</h4>
                        <div style="padding: 20px; background: #F8FAFC; border-radius: 16px; display: flex; flex-direction: column; gap: 16px;">
                            <form action="{{ route('applications.update-stage', $applicant->applications->first()->id) }}" method="POST">
                                @csrf
                                <select name="current_stage" onchange="this.form.submit()" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #E2E8F0; background: white; font-size: 14px; font-weight: 600; color: #0F172A;">
                                    @php $stages = ['Application Received', 'Phone Screening', 'Shortlisted', 'Interviewing', 'Background Check', 'Offer Sent', 'Hired', 'Rejected']; @endphp
                                    @foreach($stages as $stage)
                                        <option value="{{ $stage }}" {{ $applicant->applications->first()->current_stage === $stage ? 'selected' : '' }}>{{ $stage }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <button class="btn btn-primary" style="width: 100%; justify-content: center; background: #0F172A;">Hire Candidate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Minimal Side Previewer -->
        <div x-show="previewOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full" style="position: fixed; top: 0; right: 0; bottom: 0; width: 500px; background: white; z-index: 1000; box-shadow: -20px 0 50px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
            <div style="padding: 32px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 800;" x-text="previewTitle"></h3>
                <button @click="previewOpen = false" style="color: #94A3B8;"><x-icon name="dashboard" class="w-6 h-6" /></button>
            </div>
            <div style="flex: 1; padding: 32px; background: #F8FAFC;">
                <div style="width: 100%; height: 100%; background: white; border-radius: 12px; box-shadow: var(--shadow-sm); padding: 40px;">
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
