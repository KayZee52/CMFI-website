@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('applicants.show', $application->applicant_id) }}" class="icon-btn" style="background: white;"><i data-lucide="arrow-left"></i></a>
            <div class="hero-text">
                <h1>Schedule Interview</h1>
                <p>For <span style="color: var(--primary);">{{ $application->applicant->full_name }}</span></p>
            </div>
        </div>
    </section>

    <section class="grid-item" style="margin-top: 24px; max-width: 600px; padding: 32px;">
        <form action="{{ route('interviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Interview Type</label>
                <select name="type" required style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    <option value="phone">Phone Screening</option>
                    <option value="panel">Panel Interview</option>
                    <option value="subject">Subject Mastery Test</option>
                    <option value="demo">Teaching Demonstration</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Date & Time</label>
                <input type="datetime-local" name="scheduled_at" required style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                @error('scheduled_at') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Location / Link</label>
                <input type="text" name="location" placeholder="Meeting Room or Zoom link" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Preparation Notes</label>
                <textarea name="notes" rows="4" placeholder="Any specific instructions for the candidate..." style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;"></textarea>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 16px;">
                <button type="submit" class="btn btn-primary" style="padding: 14px 40px;">Schedule Interview</button>
            </div>
        </form>
    </section>
@endsection
