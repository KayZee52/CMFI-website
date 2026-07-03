@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div class="hero-text">
            <h1>Recruitment Settings</h1>
            <p>Configure notification gateways and system preferences.</p>
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success" style="background: #E8F5E9; color: #1B5E3F; padding: 16px; border-radius: 12px; margin-top: 24px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <section class="grid-item" style="margin-top: 24px; max-width: 900px; padding: 32px;">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 40px;">
                <h2 style="font-size: 18px; margin-bottom: 20px; color: var(--primary-dark); display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="message-square"></i> Messaging Gateway (WhatsApp/SMS)
                </h2>
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <div class="form-group">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Gateway URL (GET/POST)</label>
                        <input type="text" name="gateway_url" value="{{ $settings->flatten()->where('key', 'gateway_url')->first()->value ?? '' }}" placeholder="https://api.gateway.com/send" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">The endpoint for sending notifications.</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="form-group">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">API Key / Token</label>
                            <input type="password" name="gateway_api_key" value="{{ $settings->flatten()->where('key', 'gateway_api_key')->first()->value ?? '' }}" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                        </div>

                        <div class="form-group">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Request Method</label>
                            <select name="gateway_method" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                                @php $currentMethod = $settings->flatten()->where('key', 'gateway_method')->first()->value ?? 'POST'; @endphp
                                <option value="POST" {{ $currentMethod === 'POST' ? 'selected' : '' }}>POST Request</option>
                                <option value="GET" {{ $currentMethod === 'GET' ? 'selected' : '' }}>GET Request</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #EFEFEF; padding-top: 40px; margin-top: 40px;">
                <h2 style="font-size: 18px; margin-bottom: 20px; color: var(--primary-dark); display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="mail"></i> Email Templates
                </h2>
                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Welcome Message (Automatic)</label>
                    <textarea name="welcome_message" rows="4" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">{{ $settings->flatten()->where('key', 'welcome_message')->first()->value ?? 'Dear Applicant, thank you for applying to CMFI School...' }}</textarea>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 14px 40px;">Save All Settings</button>
            </div>
        </form>
    </section>
@endsection
