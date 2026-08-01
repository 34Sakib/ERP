<?php

namespace App\Http\Controllers\NoticeBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeBoard\Announcement;
use App\Models\NoticeBoard\PolicyDocument;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Storage;

class NoticeBoardController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('company');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('body', 'like', "%{$request->search}%");
        }

        $announcements = $query->latest('published_at')->paginate(10);
        $companies = Company::all();

        // Dynamic Upcoming Birthdays
        $upcomingBirthdays = Employee::with('department')
            ->whereNotNull('dob')
            ->take(5)
            ->get();

        // Dynamic Policy Documents
        $policyDocuments = PolicyDocument::latest()->take(5)->get();

        $stats = [
            'total_notices' => Announcement::count(),
            'active_broadcasts' => Announcement::where('published_at', '<=', now())
                ->where(function($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                })->count(),
            'birthdays_count' => $upcomingBirthdays->count(),
            'policies_count' => PolicyDocument::count(),
        ];

        return view('noticeboard.index', compact(
            'announcements',
            'companies',
            'upcomingBirthdays',
            'policyDocuments',
            'stats'
        ));
    }

    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'published_at' => 'required|date',
            'expires_at' => 'nullable|date|after_or_equal:published_at',
        ]);

        Announcement::create($validated);

        return redirect()->back()->with('success', 'Announcement posted successfully.');
    }

    public function storePolicy(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240', // 10MB max
        ]);

        $fileSizeFormatted = '1.0 MB';
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $sizeInBytes = $file->getSize();

            if ($sizeInBytes < 1024 * 1024) {
                $fileSizeFormatted = number_format($sizeInBytes / 1024, 1) . ' KB';
            } else {
                $fileSizeFormatted = number_format($sizeInBytes / (1024 * 1024), 2) . ' MB';
            }

            $filePath = $file->store('policies', 'public');
        }

        PolicyDocument::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'file_size' => $fileSizeFormatted,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Policy document uploaded successfully.');
    }

    public function downloadPolicy(PolicyDocument $policy)
    {
        if ($policy->file_path && Storage::disk('public')->exists($policy->file_path)) {
            return Storage::disk('public')->download($policy->file_path);
        }

        return redirect()->back()->with('error', 'The requested policy file is not available for download.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted.');
    }
}
