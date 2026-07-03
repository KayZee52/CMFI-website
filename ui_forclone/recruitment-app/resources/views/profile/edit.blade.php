@extends('layouts.recruitment')

@section('content')
<div class="page-content" style="padding: 32px; max-width: 1000px; margin: 0 auto;">
    <div class="page-header" style="margin-bottom: 32px;">
        <h1 style="font-size: 32px; font-weight: 800; color: #0F172A; letter-spacing: -0.03em;">Account Settings</h1>
        <p style="color: #64748B; font-size: 16px; margin-top: 4px;">Manage your profile information and security preferences.</p>
    </div>

    <div class="profile-card">
        <div class="profile-section-title">Profile Information</div>
        <p class="profile-section-desc">Update your account's profile information and email address.</p>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('patch')

            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @if($errors->get('name'))
                    <p style="color: #EF4444; font-size: 12px; margin-top: 4px;">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @if($errors->get('email'))
                    <p style="color: #EF4444; font-size: 12px; margin-top: 4px;">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    <x-icon name="check" style="width: 18px; height: 18px;" />
                    Save Changes
                </button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="color: #10B981; font-size: 14px; font-weight: 500;">
                        Saved successfully.
                    </p>
                @endif
            </div>
        </form>
    </div>

    <div class="profile-card">
        <div class="profile-section-title">Update Password</div>
        <p class="profile-section-desc">Ensure your account is using a long, random password to stay secure.</p>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div class="form-group">
                <label class="form-label" for="current_password">Current Password</label>
                <input id="current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" />
                @if($errors->updatePassword->get('current_password'))
                    <p style="color: #EF4444; font-size: 12px; margin-top: 4px;">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password">New Password</label>
                <input id="password" name="password" type="password" class="form-input" autocomplete="new-password" />
                @if($errors->updatePassword->get('password'))
                    <p style="color: #EF4444; font-size: 12px; margin-top: 4px;">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    <x-icon name="shield" style="width: 18px; height: 18px;" />
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="color: #10B981; font-size: 14px; font-weight: 500;">
                        Password updated.
                    </p>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
