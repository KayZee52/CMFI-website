@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('job-openings.index') }}" class="icon-btn" style="background: white;"><i data-lucide="arrow-left"></i></a>
            <div class="hero-text">
                <h1>New Job Opening</h1>
                <p>Post a new vacancy for the academic year.</p>
            </div>
        </div>
    </section>

    <section class="grid-item" style="margin-top: 24px; max-width: 800px; padding: 32px;">
        <form action="{{ route('job-openings.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Academic Year</label>
                    <select name="academic_year_id" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $currentYear && $currentYear->id == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Position</label>
                    <select name="position_id" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                        <option value="">Select Position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->title }} ({{ $position->department->name }})</option>
                        @endforeach
                    </select>
                    @error('position_id') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Number of Vacancies</label>
                    <input type="number" name="vacancies" value="1" min="1" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    @error('vacancies') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Closing Date</label>
                    <input type="date" name="closing_date" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    @error('closing_date') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Initial Status</label>
                <div style="display: flex; gap: 20px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 14px;">
                        <input type="radio" name="status" value="open" checked> Open for applications
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 14px;">
                        <input type="radio" name="status" value="closed"> Closed / Draft
                    </label>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 16px;">
                <a href="{{ route('job-openings.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Opening</button>
            </div>
        </form>
    </section>
@endsection
