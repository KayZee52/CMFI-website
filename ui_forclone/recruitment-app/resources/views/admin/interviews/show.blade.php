@extends('layouts.recruitment')

@section('content')
    <section class="dashboard-hero">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('interviews.index') }}" class="icon-btn" style="background: white;"><i data-lucide="arrow-left"></i></a>
            <div class="hero-text">
                <h1>Interview Scorecard</h1>
                <p>{{ ucfirst($interview->type) }} Interview for <span style="color: var(--primary);">{{ $interview->application->applicant->full_name }}</span></p>
            </div>
        </div>
    </section>

    <section class="grid-item" style="margin-top: 24px; max-width: 800px; padding: 32px;">
        @if($interview->status === 'Completed')
            <div class="alert alert-info" style="background: #E3F2FD; color: #1565C0; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
                <p style="margin: 0; font-weight: 600;">This interview has already been scored.</p>
            </div>
        @endif

        <form action="{{ route('interviews.scorecard.submit', $interview->id) }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 16px; margin-bottom: 20px; border-bottom: 1px solid #EFEFEF; padding-bottom: 10px;">Scoring Criteria (1-5)</h3>
                
                @php
                    $criteria = ['Subject Mastery', 'Communication Skills', 'Pedagogical Knowledge', 'Professionalism', 'Classroom Management'];
                @endphp

                @foreach($criteria as $index => $item)
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding: 10px; background: #F8F9FA; border-radius: 12px;">
                        <span style="font-weight: 500; font-size: 14px;">{{ $item }}</span>
                        <input type="hidden" name="scores[{{ $index }}][criteria]" value="{{ $item }}">
                        <div style="display: flex; gap: 10px;">
                            @for($i = 1; $i <= 5; $i++)
                                <label style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1.5px solid #E0E0E0; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                    <input type="radio" name="scores[{{ $index }}][score]" value="{{ $i }}" style="display: none;" onchange="this.parentElement.style.background='var(--primary)'; this.parentElement.style.color='white'; this.parentElement.style.borderColor='var(--primary)'; Array.from(this.parentElement.parentElement.children).forEach(el => { if(el !== this.parentElement) { el.style.background='none'; el.style.color='inherit'; el.style.borderColor='#E0E0E0'; } })" required>
                                    {{ $i }}
                                </label>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Overall Comments</label>
                <textarea name="overall_comments" rows="4" style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;"></textarea>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Recommendation</label>
                <select name="recommendation" required style="width: 100%; padding: 12px; border: 1.5px solid #EFEFEF; border-radius: 12px; font-family: inherit;">
                    <option value="Recommend">Recommend for Next Stage</option>
                    <option value="Hold">Keep on Hold</option>
                    <option value="Reject">Reject Applicant</option>
                </select>
            </div>

            @if($interview->status !== 'Completed')
                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" style="padding: 14px 40px;">Submit Scorecard</button>
                </div>
            @endif
        </form>
    </section>
@endsection
