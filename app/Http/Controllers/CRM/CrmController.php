<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CRM\CrmCompany;
use App\Models\CRM\Lead;
use App\Models\CRM\Deal;
use App\Models\CRM\CrmTask;
use App\Models\User;

class CrmController extends Controller
{
    /**
     * 1. Leads Management
     */
    public function leads(Request $request)
    {
        $query = Lead::with(['company', 'deals']);

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

        $leads = $query->latest()->paginate(15);
        $companies = CrmCompany::all();

        $stats = [
            'total_leads' => Lead::count(),
            'new_count' => Lead::where('status', 'new')->count(),
            'qualified_count' => Lead::where('status', 'qualified')->count(),
            'contacted_count' => Lead::where('status', 'contacted')->count(),
        ];

        return view('crm.leads', compact('leads', 'companies', 'stats'));
    }

    public function storeLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'crm_company_id' => 'nullable|exists:crm_companies,id',
            'source' => 'nullable|string|max:100',
            'status' => 'required|in:new,contacted,qualified,lost',
        ]);

        Lead::create($validated);
        return redirect()->back()->with('success', 'Sales lead created successfully.');
    }

    public function updateLeadStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,qualified,lost',
        ]);

        $lead->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Lead status updated to ' . strtoupper($validated['status']) . '.');
    }

    public function destroyLead(Lead $lead)
    {
        $lead->delete();
        return redirect()->back()->with('success', 'Sales lead deleted successfully.');
    }

    /**
     * 2. Deals Pipeline
     */
    public function deals(Request $request)
    {
        $query = Deal::with(['lead.company', 'owner', 'crmTasks']);

        if ($request->filled('stage')) {
            $query->where('stage', $request->stage);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $deals = $query->latest()->paginate(15);
        $leads = Lead::all();
        $users = User::all();

        $stats = [
            'total_pipeline_value' => Deal::whereNotIn('stage', ['lost'])->sum('value'),
            'won_value' => Deal::where('stage', 'won')->sum('value'),
            'negotiation_count' => Deal::where('stage', 'negotiation')->count(),
            'proposal_count' => Deal::where('stage', 'proposal')->count(),
        ];

        return view('crm.deals', compact('deals', 'leads', 'users', 'stats'));
    }

    public function storeDeal(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'nullable|exists:leads,id',
            'title' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'stage' => 'required|in:prospecting,proposal,negotiation,won,lost',
            'owner_id' => 'nullable|exists:users,id',
            'expected_close_date' => 'nullable|date',
        ]);

        Deal::create($validated);
        return redirect()->back()->with('success', 'Deal opportunity created successfully.');
    }

    public function updateDealStage(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'stage' => 'required|in:prospecting,proposal,negotiation,won,lost',
        ]);

        $deal->update(['stage' => $validated['stage']]);
        return redirect()->back()->with('success', 'Deal stage updated to ' . strtoupper($validated['stage']) . '.');
    }

    public function destroyDeal(Deal $deal)
    {
        $deal->delete();
        return redirect()->back()->with('success', 'Deal deleted from pipeline.');
    }

    /**
     * 3. Client Companies
     */
    public function companies(Request $request)
    {
        $query = CrmCompany::with(['leads.deals']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $companies = $query->latest()->paginate(15);

        $stats = [
            'total_companies' => CrmCompany::count(),
            'total_leads' => Lead::count(),
            'active_deals' => Deal::whereNotIn('stage', ['lost'])->count(),
        ];

        return view('crm.companies', compact('companies', 'stats'));
    }

    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:255',
        ]);

        CrmCompany::create($validated);
        return redirect()->back()->with('success', 'Client company registered successfully.');
    }

    public function updateCompany(Request $request, CrmCompany $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:255',
        ]);

        $company->update($validated);
        return redirect()->back()->with('success', 'Client company updated successfully.');
    }

    public function destroyCompany(CrmCompany $company)
    {
        $company->delete();
        return redirect()->back()->with('success', 'Client company deleted.');
    }

    /**
     * 4. CRM Follow-Up Tasks
     */
    public function tasks(Request $request)
    {
        $tasks = CrmTask::with(['deal.lead', 'assignee'])
            ->latest()
            ->paginate(15);

        $deals = Deal::all();
        $users = User::all();

        $stats = [
            'total_tasks' => CrmTask::count(),
            'pending_tasks' => CrmTask::where('status', 'pending')->count(),
            'completed_tasks' => CrmTask::where('status', 'completed')->count(),
        ];

        return view('crm.tasks', compact('tasks', 'deals', 'users', 'stats'));
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'nullable|exists:deals,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        CrmTask::create([
            'deal_id' => $validated['deal_id'],
            'title' => $validated['title'],
            'due_date' => $validated['due_date'],
            'assigned_to' => $validated['assigned_to'] ?? auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Follow-up task created successfully.');
    }

    public function toggleTaskStatus(CrmTask $task)
    {
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'CRM task marked as ' . strtoupper($newStatus) . '.');
    }
}
