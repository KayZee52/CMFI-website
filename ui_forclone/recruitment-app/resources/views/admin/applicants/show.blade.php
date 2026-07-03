@extends('layouts.recruitment')

@section('content')
    <div x-data="{ 
        previewOpen: false, 
        previewTitle: '', 
        previewUrl: '', 
        previewType: '',
        openPreview(title, url) {
            this.previewTitle = title;
            this.previewUrl = url;
            this.previewType = url.toLowerCase().endsWith('.pdf') ? 'pdf' : 'image';
            this.previewOpen = true;
        }
    }" class="profile-hub">
        
        <!-- Top Navigation -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('applicants.index') }}" style="color: #64748B;"><x-icon name="arrow-left" class="w-6 h-6" /></a>
                <h1 style="font-size: 32px; font-weight: 800; margin: 0; letter-spacing: -0.03em; color: #0F172A;">Candidate Profile</h1>
            </div>
            <div style="display: flex; gap: 12px;">
                <button class="btn btn-secondary" style="height: 44px; padding: 0 20px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px; border: 1.5px solid #E2E8F0; background: #fff;">
                    <x-icon name="mail" class="w-5 h-5" /> Message
                </button>
                <div class="dropdown">
                    <button class="btn btn-primary" style="height: 44px; padding: 0 20px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px; background: #0F172A; color: white; border: none;">
                        Update Status <x-icon name="arrow-left" class="w-4 h-4 rotate-270" />
                    </button>
                </div>
            </div>
        </div>

        <div class="dashboard-grid" style="display: grid; grid-template-columns: 360px 1fr; gap: 32px; align-items: start;">
            
            <!-- Left Pane: Hero & Quick Info -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <div class="hero-card" style="background: white; border-radius: 24px; padding: 40px; text-align: center; border: 1px solid #F1F5F9; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                    <div style="position: relative; display: inline-block; margin-bottom: 24px;">
                        @php 
                            $photoDoc = $applicant->applications->first()->documents->where('document_type', 'Passport Photo')->first();
                            $avatarUrl = $photoDoc ? asset('storage/' . $photoDoc->file_path) : asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png');
                        @endphp
                        <img src="{{ $avatarUrl }}" 
                             style="width: 140px; height: 140px; border-radius: 40px; object-fit: cover; border: 4px solid #F1F5F9; background: #F8FAFC;" alt="Avatar">
                        <div style="position: absolute; bottom: 8px; right: 8px; width: 24px; height: 24px; background: {{ $applicant->applicant_type === 'current_teacher' ? '#3B82F6' : '#10B981' }}; border: 4px solid white; border-radius: 50%;" title="{{ $applicant->applicant_type === 'current_teacher' ? 'Current Staff' : 'New Applicant' }}"></div>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.02em;">{{ $applicant->full_name }}</h2>
                    <p style="font-size: 15px; color: #3B82F6; font-weight: 700; margin: 8px 0 24px;">{{ $applicant->applications->first()->jobOpening->position->title ?? 'Teacher' }}</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: center;">
                        <span style="background: #F1F5F9; color: #64748B; padding: 6px 14px; border-radius: 10px; font-weight: 600; font-size: 13px;">Ref: #{{ $applicant->applications->first()->reference_number }}</span>
                        <span style="background: #EFF6FF; color: #3B82F6; padding: 6px 14px; border-radius: 10px; font-weight: 700; font-size: 13px;">{{ $applicant->applications->first()->current_stage }}</span>
                    </div>
                </div>

                <!-- Personal Info Mini Card -->
                <div class="profile-card" style="padding: 24px; background: white; border-radius: 20px; border: 1px solid #F1F5F9;">
                    <h4 style="font-size: 12px; font-weight: 700; color: #94A3B8; margin: 0 0 16px; text-transform: uppercase; letter-spacing: 0.1em;">Identity & Contact</h4>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: #F8FAFC; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748B;">
                                <x-icon name="mail" style="width: 16px; height: 16px;" />
                            </div>
                            <div style="overflow: hidden;">
                                <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Email</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0; word-break: break-all;">{{ $applicant->email }}</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: #F8FAFC; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748B;">
                                <x-icon name="users" style="width: 16px; height: 16px;" />
                            </div>
                            <div>
                                <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Mobile</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">{{ $applicant->phone }}</p>
                            </div>
                        </div>
                        @if($applicant->whatsapp_number)
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: #F0FDF4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #16A34A;">
                                <x-icon name="users" style="width: 16px; height: 16px;" />
                            </div>
                            <div>
                                <p style="font-size: 11px; font-weight: 700; color: #16A34A; margin: 0; text-transform: uppercase;">WhatsApp</p>
                                <p style="font-size: 14px; font-weight: 600; color: #0F172A; margin: 0;">{{ $applicant->whatsapp_number }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Conduct/Legal Check -->
                <div class="profile-card" style="padding: 24px; background: white; border-radius: 20px; border: 1px solid #F1F5F9;">
                    <h4 style="font-size: 12px; font-weight: 700; color: #94A3B8; margin: 0 0 16px; text-transform: uppercase; letter-spacing: 0.1em;">Background Check</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div style="padding: 12px; background: {{ $applicant->dismissed === 'Yes' ? '#FEF2F2' : '#F0FDF4' }}; border-radius: 12px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: {{ $applicant->dismissed === 'Yes' ? '#B91C1C' : '#15803D' }}; margin: 0; text-transform: uppercase;">Dismissed</p>
                            <p style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 4px 0 0;">{{ $applicant->dismissed }}</p>
                        </div>
                        <div style="padding: 12px; background: {{ $applicant->convicted === 'Yes' ? '#FEF2F2' : '#F0FDF4' }}; border-radius: 12px; text-align: center;">
                            <p style="font-size: 10px; font-weight: 700; color: {{ $applicant->convicted === 'Yes' ? '#B91C1C' : '#15803D' }}; margin: 0; text-transform: uppercase;">Convicted</p>
                            <p style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 4px 0 0;">{{ $applicant->convicted }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Pane: Details & Collections -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- Main Details Card -->
                <div class="profile-card" style="padding: 32px; background: white; border-radius: 24px; border: 1px solid #F1F5F9;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
                        
                        <!-- Personal Details -->
                        <div>
                            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; background: #3B82F6; border-radius: 2px;"></div>
                                Personal Profile
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Nationality</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->nationality }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">City</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->city_of_residence }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Gender</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ ucfirst($applicant->gender) }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Birth Date</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->date_of_birth ? \Carbon\Carbon::parse($applicant->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div style="grid-column: span 2;">
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Home Address</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->home_address }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Details -->
                        <div>
                            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; background: #8B5CF6; border-radius: 2px;"></div>
                                Academic Background
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Highest Qualification</p>
                                    <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 4px 0 0;">{{ $applicant->highest_qualification }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Institution & Graduation</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->institution }} ({{ $applicant->graduation_year }})</p>
                                </div>
                                @if($applicant->major)
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Major/Specialization</p>
                                    <p style="font-size: 15px; font-weight: 600; color: #475569; margin: 4px 0 0;">{{ $applicant->major }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="height: 1px; background: #F1F5F9; margin: 32px 0;"></div>

                    <!-- Professional Experience -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
                        <div>
                            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; background: #F59E0B; border-radius: 2px;"></div>
                                Experience & Expertise
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div style="display: flex; gap: 32px;">
                                    <div>
                                        <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Experience</p>
                                        <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 4px 0 0;">{{ $applicant->years_experience }} Years</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Availability</p>
                                        <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 4px 0 0;">{{ $applicant->applications->first()->available_start_date ? \Carbon\Carbon::parse($applicant->applications->first()->available_start_date)->format('M d, Y') : 'Immediate' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Preferred Subjects & Grades</p>
                                    <p style="font-size: 14px; font-weight: 600; color: #475569; margin: 4px 0 0;">
                                        {{ $applicant->applications->first()->subjects_can_teach ?? 'Not Specified' }} <br>
                                        <span style="color: #94A3B8; font-size: 12px;">Preferred: {{ $applicant->applications->first()->grades_preferred ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                @if($applicant->applications->first()->previous_school)
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Most Recent Employer</p>
                                    <p style="font-size: 14px; font-weight: 600; color: #475569; margin: 4px 0 0;">
                                        {{ $applicant->applications->first()->previous_school }} ({{ $applicant->applications->first()->prev_position }})
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- CMFI Specific (Conditional) -->
                        <div>
                            @if($applicant->applicant_type === 'current_teacher')
                            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; background: #EF4444; border-radius: 2px;"></div>
                                Internal History (Staff)
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Department</p>
                                    <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 4px 0 0;">{{ $applicant->applications->first()->current_dept }}</p>
                                </div>
                                <div>
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Years at CMFI</p>
                                    <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 4px 0 0;">{{ $applicant->applications->first()->years_served }}</p>
                                </div>
                                <div style="grid-column: span 2;">
                                    <p style="font-size: 11px; font-weight: 700; color: #94A3B8; margin: 0; text-transform: uppercase;">Achievements</p>
                                    <p style="font-size: 14px; font-weight: 600; color: #475569; margin: 4px 0 0; line-height: 1.6;">{{ $applicant->applications->first()->achievements ?? 'None documented.' }}</p>
                                </div>
                            </div>
                            @else
                            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 8px; height: 8px; background: #64748B; border-radius: 2px;"></div>
                                References
                            </h4>
                            <div style="padding: 16px; background: #F8FAFC; border-radius: 16px; border: 1px solid #F1F5F9;">
                                <p style="font-size: 14px; color: #475569; margin: 0; line-height: 1.6; font-weight: 500;">
                                    {!! nl2br(e($applicant->applications->first()->reference_data ?? 'No references provided.')) !!}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Personal Statement Card -->
                <div class="profile-card" style="padding: 32px; background: white; border-radius: 24px; border: 1px solid #F1F5F9;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 16px;">Teaching Philosophy & Statement</h4>
                    <p style="font-size: 15px; line-height: 1.8; color: #475569; margin: 0; white-space: pre-line;">{{ $applicant->applications->first()->personal_statement ?? 'No statement provided.' }}</p>
                </div>

                <!-- Documents Collection -->
                <div class="profile-card" style="padding: 32px; background: white; border-radius: 24px; border: 1px solid #F1F5F9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h4 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.01em;">Uploaded Evidence</h4>
                        <span style="font-size: 13px; font-weight: 700; color: #3B82F6; background: #EFF6FF; padding: 4px 12px; border-radius: 8px;">{{ $applicant->applications->first()->documents->count() }} Files</span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                        @forelse($applicant->applications->first()->documents as $doc)
                            <div @click="openPreview('{{ $doc->document_type }}', '{{ asset('storage/' . $doc->file_path) }}')" 
                                 style="background: #F8FAFC; border-radius: 16px; padding: 20px; border: 1.5px solid #F1F5F9; cursor: pointer; transition: all 0.2s; position: relative;" 
                                 class="doc-item"
                                 onmouseover="this.style.borderColor='#3B82F6'; this.style.transform='translateY(-2px)'" 
                                 onmouseout="this.style.borderColor='#F1F5F9'; this.style.transform='translateY(0)'">
                                <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #3B82F6; margin-bottom: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                    <x-icon name="{{ str_contains(strtolower($doc->document_type), 'cv') || str_contains(strtolower($doc->document_type), 'resume') ? 'file-text' : (str_contains(strtolower($doc->document_type), 'photo') ? 'users' : 'briefcase') }}" style="width: 24px; height: 24px;" />
                                </div>
                                <h5 style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 4px; line-height: 1.4;">{{ $doc->document_type }}</h5>
                                <p style="font-size: 12px; color: #94A3B8; margin: 0; font-weight: 500;">Quick-View Available</p>
                            </div>
                        @empty
                            <div style="grid-column: span 3; padding: 48px; text-align: center; background: #F8FAFC; border-radius: 20px; border: 2px dashed #E2E8F0;">
                                <x-icon name="file-text" style="width: 48px; height: 48px; color: #CBD5E1; margin: 0 auto 16px;" />
                                <p style="color: #94A3B8; font-weight: 500;">No documents uploaded.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Functional Quick-View Previewer -->
        <div x-show="previewOpen" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 32px;"
             @keydown.escape.window="previewOpen = false">
            
            <div @click.away="previewOpen = false" 
                 style="background: white; width: 100%; max-width: 1100px; height: 100%; border-radius: 32px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                
                <!-- Modal Header -->
                <div style="padding: 24px 32px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 44px; height: 44px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #3B82F6; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                            <x-icon name="file-text" style="width: 24px; height: 24px;" />
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #0F172A;" x-text="previewTitle"></h3>
                            <p style="margin: 4px 0 0; font-size: 13px; color: #64748B; font-weight: 600;">Secure Preview Mode</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <a :href="previewUrl" download style="height: 44px; padding: 0 20px; background: white; border: 1.5px solid #E2E8F0; border-radius: 12px; display: flex; align-items: center; gap: 8px; font-weight: 700; color: #475569; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='white'">
                            <x-icon name="download" style="width: 18px; height: 18px;" /> Download
                        </a>
                        <button @click="previewOpen = false" style="width: 44px; height: 44px; background: #0F172A; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; border: none; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Preview Content -->
                <div style="flex: 1; background: #64748B; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                    <template x-if="previewType === 'pdf'">
                        <iframe :src="previewUrl" style="width: 100%; height: 100%; border: none; background: #64748B;"></iframe>
                    </template>
                    <template x-if="previewType === 'image'">
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 40px; overflow: auto;">
                            <img :src="previewUrl" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
