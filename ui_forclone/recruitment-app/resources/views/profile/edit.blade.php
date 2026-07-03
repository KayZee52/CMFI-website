@extends('layouts.recruitment')

@section('content')
<div class="page-content" style="padding: 32px; max-width: 1000px; margin: 0 auto;" x-data="{ editing: false }">
    <div class="page-header" style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 32px; font-weight: 800; color: #0F172A; letter-spacing: -0.03em;">Account Settings</h1>
            <p style="color: #64748B; font-size: 16px; margin-top: 4px;">Manage your digital identity and security preferences.</p>
        </div>
        <button type="button" @click="editing = !editing" class="btn-secondary" style="height: 44px; padding: 0 20px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <x-icon name="edit" style="width: 18px; height: 18px;" x-show="!editing" />
            <x-icon name="close" style="width: 18px; height: 18px;" x-show="editing" />
            <span x-text="editing ? 'Cancel' : 'Edit Profile'"></span>
        </button>
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Profile Block -->
        <div class="profile-card" style="display: grid; grid-template-columns: 300px 1fr; gap: 48px; align-items: start;">
            <!-- Left: Avatar Upload -->
            <div style="text-align: center;">
                <div style="position: relative; display: inline-block; margin-bottom: 20px;">
                    <div style="width: 160px; height: 160px; border-radius: 40px; overflow: hidden; border: 4px solid #F1F5F9; background: #F8FAFC; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                        <img id="avatar-preview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/avatars/admin.png') }}" 
                             alt="Avatar Preview" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <label for="avatar-input" style="position: absolute; bottom: -10px; right: -10px; width: 44px; height: 44px; background: var(--primary); border-radius: 14px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <x-icon name="camera" style="width: 20px; height: 20px;" />
                        <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])">
                    </label>
                </div>
                <div style="font-size: 13px; color: #64748B; font-weight: 500;">Recommended: 400x400px<br>Max size: 2MB</div>
            </div>

            <!-- Right: Details -->
            <div class="space-y-6">
                <div>
                    <h3 class="profile-section-title" style="margin-bottom: 4px;">Public Profile</h3>
                    <p class="profile-section-desc" style="margin-bottom: 24px;">This information will be displayed across the recruitment platform.</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div x-show="!editing" style="padding: 12px 16px; background: #F8FAFC; border-radius: 12px; border: 1.5px solid #F1F5F9; color: #0F172A; font-weight: 600; font-size: 15px;">
                        {{ $user->name }}
                    </div>
                    <input x-show="editing" id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus />
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div x-show="!editing" style="padding: 12px 16px; background: #F8FAFC; border-radius: 12px; border: 1.5px solid #F1F5F9; color: #64748B; font-size: 15px;">
                        {{ $user->email }}
                    </div>
                    <input x-show="editing" id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required />
                </div>

                <div x-show="editing" x-transition class="flex items-center gap-4" style="padding-top: 12px;">
                    <button type="submit" class="btn-primary" style="height: 48px; border-radius: 14px; font-weight: 700;">
                        Update Information
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" style="color: #10B981; font-size: 14px; font-weight: 600;">
                            Saved successfully.
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Security Block -->
        <div class="profile-card">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #F1F5F9;">
                <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #D97706;">
                    <x-icon name="shield" style="width: 24px; height: 24px;" />
                </div>
                <div>
                    <h3 class="profile-section-title" style="margin-bottom: 0;">Security & Password</h3>
                    <p class="profile-section-desc" style="margin-bottom: 0;">Update your password to keep your account secure.</p>
                </div>
            </div>

            <div style="max-width: 500px;">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input name="current_password" type="password" class="form-input" placeholder="••••••••" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input name="password" type="password" class="form-input" placeholder="••••••••" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input name="password_confirmation" type="password" class="form-input" placeholder="••••••••" />
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="height: 48px; border-radius: 14px; font-weight: 700;">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </form>
</div>
@endsection
