<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project\Project;
use App\Models\Project\Task;
use App\Models\Project\TimeLog;
use App\Models\Core\Company;
use App\Models\User;
use App\Models\Employee\Employee;

class ProjectController extends Controller
{
    /**
     * 1. Projects Overview
     */
    public function index(Request $request)
    {
        $query = Project::with(['company', 'tasks']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
        }

        $projects = $query->latest()->paginate(15);
        $companies = Company::all();

        $stats = [
            'total_projects' => Project::count(),
            'total_budget' => Project::sum('budget'),
            'active_projects' => Project::where('status', 'active')->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
        ];

        return view('projects.index', compact('projects', 'companies', 'stats'));
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:planning,active,on_hold,completed',
            'budget' => 'required|numeric|min:0',
        ]);

        Project::create($validated);
        return redirect()->back()->with('success', 'Project created successfully.');
    }

    public function updateProjectStatus(Request $request, Project $project)
    {
        $validated = $request->validate([
            'status' => 'required|in:planning,active,on_hold,completed',
        ]);

        $project->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Project status updated to ' . strtoupper($validated['status']) . '.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted.');
    }

    /**
     * 2. Project Work Tasks
     */
    public function myTasks(Request $request)
    {
        $query = Task::with(['project', 'assignee', 'timeLogs']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $tasks = $query->latest()->paginate(15);
        $projects = Project::all();
        $users = User::all();

        $stats = [
            'total_tasks' => Task::count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'done_tasks' => Task::where('status', 'done')->count(),
            'urgent_tasks' => Task::where('priority', 'urgent')->count(),
        ];

        return view('projects.my_tasks', compact('tasks', 'projects', 'users', 'stats'));
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        Task::create($validated);
        return redirect()->back()->with('success', 'Project work task created successfully.');
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Task stage updated to ' . strtoupper($validated['status']) . '.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Work task deleted.');
    }

    /**
     * 3. Timelogs & Hours
     */
    public function timelogs(Request $request)
    {
        $query = TimeLog::with(['task.project', 'employee']);

        $timelogs = $query->latest()->paginate(15);
        $tasks = Task::all();
        $employees = Employee::all();

        $stats = [
            'total_hours' => TimeLog::sum('hours'),
            'total_logs' => TimeLog::count(),
            'active_loggers' => TimeLog::distinct('employee_id')->count('employee_id'),
        ];

        return view('projects.timelogs', compact('timelogs', 'tasks', 'employees', 'stats'));
    }

    public function storeTimeLog(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'employee_id' => 'required|exists:employees,id',
            'hours' => 'required|numeric|min:0.5|max:24',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        TimeLog::create($validated);
        return redirect()->back()->with('success', 'Work hours logged successfully.');
    }
}
