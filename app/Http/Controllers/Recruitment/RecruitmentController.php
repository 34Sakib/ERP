<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Company;
use App\Models\Core\Department;
use App\Models\Recruitment\JobPost;
use App\Models\Recruitment\Applicant;
use App\Models\Recruitment\Interview;
use App\Models\User;

class RecruitmentController extends Controller
{
    /**
     * 1. Job Requisitions / Openings
     */
    public function jobs(Request $request)
    {
        $query = JobPost::with(['company', 'department', 'applicants']);

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->latest()->paginate(12);
        $companies = Company::all();
        $departments = Department::all();

        $stats = [
            'total_jobs' => JobPost::count(),
            'published_count' => JobPost::where('status', 'published')->count(),
            'total_applicants' => Applicant::count(),
            'closed_count' => JobPost::where('status', 'closed')->count(),
        ];

        return view('recruitment.jobs', compact('jobs', 'companies', 'departments', 'stats'));
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employment_type' => 'required|string',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
        ]);

        JobPost::create($validated);
        return redirect()->back()->with('success', 'Job opening posted successfully.');
    }

    public function updateJob(Request $request, JobPost $job)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employment_type' => 'required|string',
            'status' => 'required|in:draft,published,closed',
            'closing_date' => 'nullable|date',
        ]);

        $job->update($validated);
        return redirect()->back()->with('success', 'Job opening updated successfully.');
    }

    public function destroyJob(JobPost $job)
    {
        $job->delete();
        return redirect()->back()->with('success', 'Job opening deleted successfully.');
    }

    /**
     * 2. Applicants Directory & Candidate Pipeline
     */
    public function applicants(Request $request)
    {
        $query = Applicant::with(['jobPost.department', 'interviews']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $applicants = $query->latest()->paginate(15);
        $jobPosts = JobPost::where('status', 'published')->get();

        $stats = [
            'total' => Applicant::count(),
            'applied' => Applicant::where('status', 'applied')->count(),
            'shortlisted' => Applicant::where('status', 'shortlisted')->count(),
            'interview' => Applicant::where('status', 'interview')->count(),
            'hired' => Applicant::where('status', 'hired')->count(),
            'rejected' => Applicant::where('status', 'rejected')->count(),
        ];

        return view('recruitment.applicants', compact('applicants', 'jobPosts', 'stats'));
    }

    public function storeApplicant(Request $request)
    {
        $validated = $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:100',
        ]);

        Applicant::create($validated);
        return redirect()->back()->with('success', 'Candidate application submitted successfully.');
    }

    public function updateApplicantStatus(Request $request, Applicant $applicant)
    {
        $validated = $request->validate([
            'status' => 'required|in:applied,shortlisted,interview,offered,hired,rejected',
        ]);

        $applicant->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Candidate pipeline status updated to ' . strtoupper($validated['status']) . '.');
    }

    /**
     * 3. Interview Schedules
     */
    public function interviews(Request $request)
    {
        $interviews = Interview::with(['applicant.jobPost', 'interviewer'])
            ->latest()
            ->paginate(15);

        $applicants = Applicant::whereIn('status', ['shortlisted', 'interview', 'applied'])->get();
        $users = User::all();

        $stats = [
            'total_interviews' => Interview::count(),
            'scheduled_count' => Interview::where('scheduled_at', '>=', now())->count(),
            'completed_count' => Interview::whereNotNull('feedback')->count(),
            'avg_rating' => round(Interview::avg('rating') ?? 0, 1),
        ];

        return view('recruitment.interviews', compact('interviews', 'applicants', 'users', 'stats'));
    }

    public function storeInterview(Request $request)
    {
        $validated = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'scheduled_at' => 'required|date',
            'interviewer_id' => 'nullable|exists:users,id',
            'mode' => 'required|string',
        ]);

        $interview = Interview::create($validated);

        // Transition applicant status to interview
        $interview->applicant->update(['status' => 'interview']);

        return redirect()->back()->with('success', 'Interview round scheduled successfully.');
    }

    public function updateInterviewFeedback(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'feedback' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $interview->update($validated);
        return redirect()->back()->with('success', 'Interviewer feedback & evaluation rating submitted.');
    }
}
