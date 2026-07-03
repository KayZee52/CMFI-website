@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('job-openings.index') }}" class="icon-btn" style="background: white;"><i data-lucide="arrow-left"></i></a>
            <div class="hero-text">
                <h1>Edit Job Opening</h1>
                <p>Update vacancy details for <span style="color: var(--primary);">{{ $jobOpening->position->title }}</span>.</p>
            </div>
        </div>
    </section>

    <section class="grid-item" style="margin-top: 24px; max-width: 800px; padding: 32px;">
        <form action="{{ route('job-openings.update', $jobOpening->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Academic Year</label>
                    <select name="academic_year_id" disabled style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit; background: #F8F9FA;">
                        <option>{{ $jobOpening->academicYear->name }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Position</label>
                    <select name="position_id" disabled style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit; background: #F8F9FA;">
                        <option>{{ $jobOpening->position->title }}</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Number of Vacancies</label>
                    <input type="number" name="vacancies" value="{{ $jobOpening->vacancies }}" min="1" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    @error('vacancies') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Closing Date</label>
                    <input type="date" name="closing_date" value="{{ $jobOpening->closing_date ? \Carbon\Carbon::parse($jobOpening->closing_date)->format('Y-m-d') : '' }}" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    @error('closing_date') <p style="color: #FF6A55; font-size: 12px; margin-top: 4px;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Status</label>
                <div style="display: flex; gap: 20px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 14px;">
                        <input type="radio" name="status" value="open" {{ $jobOpening->status === 'open' ? 'checked' : '' }}> Open
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 14px;">
                        <input type="radio" name="status" value="filled" {{ $jobOpening->status === 'filled' ? 'checked' : '' }}> Filled
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 14px;">
                        <input type="radio" name="status" value="closed" {{ $jobOpening->status === 'closed' ? 'checked' : '' }}> Closed
                    </label>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 16px;">
                <a href="{{ route('job-openings.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Opening</button>
            </div>
        </form>
    </section>
@endsection
