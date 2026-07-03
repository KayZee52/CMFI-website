<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Application;
use App\Models\Scorecard;
use App\Models\InterviewScoreItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    /**
     * Display a listing of interviews.
     */
    public function index()
    {
        $interviews = Interview::with(['application.applicant', 'application.jobOpening.position'])
            ->latest('scheduled_at')
            ->paginate(15);

        return view('admin.interviews.index', compact('interviews'));
    }

    /**
     * Show the form for creating a new interview.
     */
    public function create(Request $request)
    {
        $application = Application::with('applicant')->findOrFail($request->application_id);
        return view('admin.interviews.create', compact('application'));
    }

    /**
     * Store a newly created interview in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'type' => 'required|string', // phone, panel, subject, demo
            'scheduled_at' => 'required|date|after:now',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Interview::create($validated);

        return redirect()->route('applicants.show', Application::find($validated['application_id'])->applicant_id)
            ->with('success', 'Interview scheduled successfully.');
    }

    /**
     * Show the specified interview (scorecard view).
     */
    public function show(Interview $interview)
    {
        $interview->load(['application.applicant', 'application.jobOpening.position']);
        return view('admin.interviews.show', compact('interview'));
    }

    /**
     * Submit a scorecard for an interview.
     */
    public function submitScorecard(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*.criteria' => 'required|string',
            'scores.*.score' => 'required|integer|min:1|max:5',
            'overall_comments' => 'nullable|string',
            'recommendation' => 'required|string',
        ]);

        return DB::transaction(function () use ($interview, $validated) {
            $scorecard = Scorecard::create([
                'interview_id' => $interview->id,
                'interviewer_id' => Auth::id(),
                'overall_comments' => $validated['overall_comments'],
                'recommendation' => $validated['recommendation'],
            ]);

            $total = 0;
            foreach ($validated['scores'] as $item) {
                InterviewScoreItem::create([
                    'scorecard_id' => $scorecard->id,
                    'criteria' => $item['criteria'],
                    'score' => $item['score'],
                ]);
                $total += $item['score'];
            }

            $scorecard->update(['total_score' => $total / count($validated['scores'])]);
            
            $interview->update(['status' => 'Completed']);

            return redirect()->route('applicants.show', $interview->application->applicant_id)
                ->with('success', 'Scorecard submitted successfully.');
        });
    }
}
