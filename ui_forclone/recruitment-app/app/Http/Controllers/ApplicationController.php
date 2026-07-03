<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Update the pipeline stage of an application.
     */
    public function updateStage(Request $request, Application $application)
    {
        $validated = $request->validate([
            'current_stage' => 'required|string',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application stage updated to: ' . $validated['current_stage']);
    }

    /**
     * Make a final decision on an application.
     */
    public function makeDecision(Request $request, Application $application)
    {
        $validated = $request->validate([
            'decision_status' => 'required|in:Pending,Shortlisted,Hired,Rejected,Withdrawn',
            'rejection_reason' => 'nullable|string',
        ]);

        $application->update($validated);

        // If hired, we might want to update the stage as well
        if ($validated['decision_status'] === 'Hired') {
            $application->update(['current_stage' => 'Hired / Contract Signed']);
        } elseif ($validated['decision_status'] === 'Rejected') {
            $application->update(['current_stage' => 'Rejected']);
        }

        return redirect()->back()->with('success', 'Decision recorded: ' . $validated['decision_status']);
    }
}
