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
                <button class="btn btn-primary" style="height: 44px; padding: 0 20px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px; background: #0F172A; color: white; border: none;">
                    <x-icon name="calendar" class="w-5 h-5" /> Schedule Call
                </button>
            </div>
        </div>

        <div class="dashboard-grid" style="grid-template-columns: 360px 1fr; gap: 32px; align-items: start;">
            
            <!-- Left Pane: Hero & Social -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <div class="hero-card" style="background: white; border-radius: 24px; padding: 40px; text-align: center; border: 1px solid #F1F5F9; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                    <div style="position: relative; display: inline-block; margin-bottom: 24px;">
                        <img src="{{ asset('images/avatars/avatar_' . (strtolower($applicant->gender) == 'male' ? 'male' : (strtolower($applicant->gender) == 'female' ? 'female' : 'neutral')) . '.png') }}" 
                             style="width: 140px; height: 140px; border-radius: 40px; object-fit: cover; border: 4px solid #F1F5F9; background: #F8FAFC;" alt="Avatar">
                        <div style="position: absolute; bottom: 8px; right: 8px; width: 24px; height: 24px; background: #10B981; border: 4px solid white; border-radius: 50%;"></div>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.02em;">{{ $applicant->full_name }}</h2>
                    <p style="font-size: 15px; color: var(--primary); font-weight: 700; margin: 8px 0 24px;">{{ $applicant->applications->first()->jobOpening->position->title }}</p>
                    
                    <div style="display: flex; justify-content: center; gap: 12px;">
                        <span class="badge-premium" style="background: #F1F5F9; color: #64748B; border: none; padding: 6px 14px; border-radius: 10px; font-weight: 600; font-size: 13px;">#{{ $applicant->applications->first()->reference_number }}</span>
                        <span class="badge-premium" style="background: #EFF6FF; color: var(--primary); border: none; padding: 6px 14px; border-radius: 10px; font-weight: 700; font-size: 13px;">{{ $applicant->applications->first()->current_stage }}</span>
                    </div>
                </div>

                <div class="profile-card" style="padding: 24px; background: white; border-radius: 20px; border: 1px solid #F1F5F9;">
                    <h4 style="font-size: 13px; font-weight: 700; color: #94A3B8; margin: 0 0 16px; text-transform: uppercase; letter-spacing: 0.1em;">Social Presence</h4>
                    <div style="display: flex; gap: 12px;">
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748B; transition: all 0.2s;" onmouseover="this.style.background='#EFF6FF'; this.style.color='var(--primary)'" onmouseout="this.style.background='#F8FAFC'; this.style.color='#64748B'"><x-icon name="users" class="w-5 h-5" /></a>
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748B; transition: all 0.2s;" onmouseover="this.style.background='#EFF6FF'; this.style.color='var(--primary)'" onmouseout="this.style.background='#F8FAFC'; this.style.color='#64748B'"><x-icon name="users" class="w-5 h-5" /></a>
                        <a href="#" style="width: 44px; height: 44px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748B; transition: all 0.2s;" onmouseover="this.style.background='#EFF6FF'; this.style.color='var(--primary)'" onmouseout="this.style.background='#F8FAFC'; this.style.color='#64748B'"><x-icon name="users" class="w-5 h-5" /></a>
                    </div>
                </div>

                <!-- Match Score Section -->
                <div class="profile-card" style="padding: 24px; text-align: center; background: white; border-radius: 20px; border: 1px solid #F1F5F9;">
                    <h4 style="font-size: 13px; font-weight: 700; color: #94A3B8; margin: 0 0 20px; text-transform: uppercase; letter-spacing: 0.1em;">Hiring Match</h4>
                    <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                        @php $matchScore = 82; $degree = ($matchScore / 100) * 360; @endphp
                        <div style="width: 130px; height: 130px; border-radius: 50%; background: conic-gradient(var(--primary) 0deg {{ $degree }}deg, #F1F5F9 {{ $degree }}deg 360deg); display: flex; align-items: center; justify-content: center; position: relative;">
                            <div style="width: 105px; height: 105px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06);">
                                <span style="font-size: 28px; font-weight: 900; color: #0F172A;">{{ $matchScore }}%</span>
                            </div>
                        </div>
                    </div>
                    <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0; font-weight: 500;">This candidate matches <b>{{ $matchScore }}%</b> of the core requirements for this position.</p>
                </div>
            </div>

            <!-- Right Pane: Details & Collections -->
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <!-- Bio & Details Card -->
                <div class="profile-card" style="padding: 32px; background: white; border-radius: 24px; border: 1px solid #F1F5F9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h4 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.01em;">Bio & Professional Summary</h4>
                        <div style="width: 10px; height: 10px; background: #10B981; border-radius: 50%; box-shadow: 0 0 0 4px #ECFDF5;"></div>
                    </div>
                    <p style="font-size: 16px; line-height: 1.8; color: #475569; margin-bottom: 32px;">{{ $applicant->bio ?? 'No professional biography provided.' }}</p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                        <div>
                            <span style="display: block; font-size: 12px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Contact Information</span>
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 15px; font-weight: 600;">
                                    <x-icon name="mail" style="width: 18px; height: 18px; color: #94A3B8;" /> {{ $applicant->email }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 15px; font-weight: 600;">
                                    <x-icon name="users" style="width: 18px; height: 18px; color: #94A3B8;" /> {{ $applicant->phone }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <span style="display: block; font-size: 12px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">Key Qualifications</span>
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 15px; font-weight: 600;">
                                    <x-icon name="briefcase" style="width: 18px; height: 18px; color: #94A3B8;" /> 8 Years Experience
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; color: #475569; font-size: 15px; font-weight: 600;">
                                    <x-icon name="file-text" style="width: 18px; height: 18px; color: #94A3B8;" /> Master of Education
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Collection -->
                <div class="profile-card" style="padding: 32px; background: white; border-radius: 24px; border: 1px solid #F1F5F9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h4 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0; letter-spacing: -0.01em;">Evidence Collection</h4>
                        <span style="font-size: 13px; font-weight: 700; color: var(--primary); background: #EFF6FF; padding: 4px 12px; border-radius: 8px;">{{ $applicant->applications->first()->documents->count() }} Files</span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                        @forelse($applicant->applications->first()->documents as $doc)
                            <div @click="openPreview('{{ $doc->document_type }}', '{{ asset('storage/' . $doc->file_path) }}')" 
                                 style="background: #F8FAFC; border-radius: 16px; padding: 20px; border: 1.5px solid #F1F5F9; cursor: pointer; transition: all 0.2s; position: relative; group;" 
                                 onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)'" 
                                 onmouseout="this.style.borderColor='#F1F5F9'; this.style.transform='translateY(0)'">
                                <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); margin-bottom: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                    <x-icon name="{{ str_contains(strtolower($doc->document_type), 'cv') || str_contains(strtolower($doc->document_type), 'resume') ? 'file-text' : 'briefcase' }}" style="width: 24px; height: 24px;" />
                                </div>
                                <h5 style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 4px; line-height: 1.4;">{{ $doc->document_type }}</h5>
                                <p style="font-size: 12px; color: #94A3B8; margin: 0; font-weight: 500;">Click to Quick-View</p>
                                
                                <div style="position: absolute; top: 12px; right: 12px; opacity: 0; transition: opacity 0.2s;" class="preview-eye">
                                    <x-icon name="eye" style="width: 18px; height: 18px; color: var(--primary);" />
                                </div>
                                <style>.group:hover .preview-eye { opacity: 1 !important; }</style>
                            </div>
                        @empty
                            <div style="grid-column: span 3; padding: 48px; text-align: center; background: #F8FAFC; border-radius: 20px; border: 2px dashed #E2E8F0;">
                                <x-icon name="file-text" style="width: 48px; height: 48px; color: #CBD5E1; margin: 0 auto 16px;" />
                                <p style="color: #94A3B8; font-weight: 500;">No evidence documents have been uploaded yet.</p>
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
             style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 32px; display: none;"
             :style="{ display: previewOpen ? 'flex' : 'none' }">
            
            <div @click.away="previewOpen = false" 
                 style="background: white; width: 100%; max-width: 1100px; height: 100%; border-radius: 32px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                
                <!-- Modal Header -->
                <div style="padding: 24px 32px; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; background: #F8FAFC;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 44px; height: 44px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                            <x-icon name="file-text" style="width: 24px; height: 24px;" />
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #0F172A;" x-text="previewTitle"></h3>
                            <p style="margin: 4px 0 0; font-size: 13px; color: #64748B; font-weight: 600;">Secure Quick-View Mode</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <a :href="previewUrl" download style="height: 44px; padding: 0 20px; background: white; border: 1.5px solid #E2E8F0; border-radius: 12px; display: flex; align-items: center; gap: 8px; font-weight: 700; color: #475569; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='white'">
                            <x-icon name="download" style="width: 18px; height: 18px;" /> Download
                        </a>
                        <button @click="previewOpen = false" style="width: 44px; height: 44px; background: #0F172A; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; border: none; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <x-icon name="close" style="width: 24px; height: 24px;" />
                        </button>
                    </div>
                </div>

                <!-- Preview Content -->
                <div style="flex: 1; background: #64748B; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                    <!-- PDF Viewer -->
                    <template x-if="previewType === 'pdf'">
                        <iframe :src="previewUrl" style="width: 100%; height: 100%; border: none; background: #64748B;"></iframe>
                    </template>
                    
                    <!-- Image Viewer -->
                    <template x-if="previewType === 'image'">
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 40px; overflow: auto;">
                            <img :src="previewUrl" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                        </div>
                    </template>

                    <!-- Loading State (Optional overlay) -->
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; z-index: -1;">
                        <div style="width: 40px; height: 40px; border: 4px solid rgba(255,255,255,0.3); border-top-color: white; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    </div>
                    <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
                </div>
            </div>
        </div>
    </div>
@endsection
