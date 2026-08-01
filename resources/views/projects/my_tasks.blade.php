@extends('layouts.app')

@push('styles')
<style>
    @keyframes gradientMesh {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tasks-hero {
        background: linear-gradient(-45deg, #7C3AED, #6366F1, #4F46E5, #4338CA);
        background-size: 300% 300%;
        animation: gradientMesh 12s ease infinite, fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px rgba(124, 58, 237, 0.3);
    }

    /* Refined Image-Style Soft Pastel Cards */
    .pastel-ui8-card {
        border-radius: 20px;
        padding: 1.25rem 1.35rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 145px;
        position: relative;
        border: 1px solid transparent;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .pastel-ui8-card:hover {
        transform: translateY(-5px) scale(1.015);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }

    .card-pastel-emerald {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border-color: #A7F3D0;
    }

    .card-pastel-amber {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border-color: #FDE68A;
    }

    .card-pastel-purple {
        background: linear-gradient(135deg, #F3E8FF 0%, #EDE9FE 100%);
        border-color: #DDD6FE;
    }

    .card-pastel-indigo {
        background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%);
        border-color: #BAE6FD;
    }

    .ui8-pill-val {
        background: #ffffff;
        padding: 0.3rem 0.85rem;
        border-radius: 999px;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        display: inline-flex;
        align-items: center;
    }

    .ui8-card-title {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #1E1B4B;
        margin-top: 0.5rem;
        margin-bottom: 0.15rem;
    }

    .ui8-card-sub {
        font-size: 0.76rem;
        color: #64748B;
        font-weight: 600;
    }

    .ui8-tag-chip {
        background: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.6rem;
        border-radius: 8px;
        color: #475569;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .directory-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #EFEFF7;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .table-directory thead th {
        background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        padding: 1rem 1.25rem;
        border-bottom: 1.5px solid #E2E8F0;
    }

    .table-directory tbody tr {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #F1F5F9;
    }

    .table-directory tbody tr:hover {
        background-color: #F8FAFC !important;
        box-shadow: inset 3px 0 0 #7C3AED;
    }

    .table-directory tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .pastel-ui8-card,
    [data-bs-theme="dark"] .directory-card {
        background: #1F2937 !important;
        border-color: #374151 !important;
    }
    [data-bs-theme="dark"] .ui8-card-title { color: #F8FAFC !important; }
    [data-bs-theme="dark"] .ui8-pill-val,
    [data-bs-theme="dark"] .ui8-tag-chip {
        background: #111827 !important;
        color: #F8FAFC !important;
        border-color: #374151 !important;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="tasks-hero">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-8">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill bg-white bg-opacity-20 text-white fs-8 px-2.5 py-1">
                    <i class="bi bi-check2-square me-1"></i> Work Items
                </span>
                <span class="fs-8 text-white-50">• {{ $stats['total_tasks'] }} Active Work Tasks</span>
            </div>
            <h3 class="mb-1 fw-extrabold text-white" style="letter-spacing: -0.02em;">
                Project Work Tasks & Action Items
            </h3>
            <p class="mb-0 text-white-50 fs-7">
                Manage project task boards, advance workflow stages, track priorities, and log billable hours.
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end">
            <button class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-purple shadow-sm" data-bs-toggle="modal" data-bs-target="#createTaskModal" style="color: #7C3AED;">
                <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Add Work Task
            </button>
        </div>
    </div>
</div>

<!-- Image-Style Soft Pastel KPI Cards (4 Cards in 1 Row) -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Tasks (Soft Purple) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-purple">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-list-task me-1"></i> All Tasks
                    </span>
                    <span class="ui8-pill-val" style="color: #7C3AED;">
                        {{ $stats['total_tasks'] }} Tasks
                    </span>
                </div>
                <h4 class="ui8-card-title">Total Work Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Project Deliverables
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-purple shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; color: #7C3AED;">
                        <i class="bi bi-collection-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Tasks</span>
                    <span class="ui8-tag-chip">#Deliverables</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: In Progress (Soft Amber) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-amber">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-play-circle me-1"></i> Active Work
                    </span>
                    <span class="ui8-pill-val" style="color: #D97706;">
                        {{ $stats['in_progress'] }} In Progress
                    </span>
                </div>
                <h4 class="ui8-card-title">In Progress</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Active Development
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-warning shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-hourglass-split"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#InProgress</span>
                    <span class="ui8-tag-chip">#Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Done Tasks (Soft Emerald) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-emerald">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i> Completed
                    </span>
                    <span class="ui8-pill-val" style="color: #059669;">
                        {{ $stats['done_tasks'] }} Done
                    </span>
                </div>
                <h4 class="ui8-card-title">Completed Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> Verified Deliverables
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-success shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-check-circle-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Done</span>
                    <span class="ui8-tag-chip">#Verified</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Urgent Priority (Soft Sky Blue) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="pastel-ui8-card card-pastel-indigo">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-8 text-secondary fw-semibold">
                        <i class="bi bi-lightning-charge me-1"></i> Urgent Priority
                    </span>
                    <span class="ui8-pill-val" style="color: #0284C7;">
                        {{ $stats['urgent_tasks'] }} Urgent
                    </span>
                </div>
                <h4 class="ui8-card-title">Urgent Tasks</h4>
                <div class="ui8-card-sub mb-3">
                    <i class="bi bi-building me-1 opacity-75"></i> High Priority Items
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center">
                    <span class="badge rounded-circle bg-white text-info shadow-sm p-1.5 fs-8" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800;">
                        <i class="bi bi-lightning-fill"></i>
                    </span>
                </div>
                <div class="d-flex gap-1">
                    <span class="ui8-tag-chip">#Urgent</span>
                    <span class="ui8-tag-chip">#Priority</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tasks Table -->
<div class="directory-card">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <div class="fs-8 text-muted fw-bold">
            Showing <strong class="text-dark">{{ $tasks->firstItem() ?? 0 }} - {{ $tasks->lastItem() ?? 0 }}</strong> of <strong class="text-dark">{{ $tasks->total() }}</strong> Work Tasks
        </div>
        <form method="GET" action="{{ route('projects.tasks.my') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control rounded-pill fs-8 ps-3" value="{{ request('search') }}" placeholder="Search task title...">
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-directory align-middle mb-0 fs-7">
            <thead>
                <tr>
                    <th>TASK TITLE</th>
                    <th>PROJECT & CLIENT</th>
                    <th>PRIORITY</th>
                    <th>DUE DATE</th>
                    <th>ASSIGNEE</th>
                    <th>WORKFLOW STAGE</th>
                    <th class="text-end pe-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $t)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-7">{{ $t->title }}</div>
                            <div class="fs-8 text-muted">{{ $t->timeLogs->sum('hours') }} Logged Hours</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-8">{{ $t->project?->name }}</div>
                            <div class="fs-8 text-secondary">{{ $t->project?->client_name }}</div>
                        </td>
                        <td>
                            @if($t->priority === 'urgent')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fs-8">Urgent</span>
                            @elseif($t->priority === 'high')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fs-8">High</span>
                            @elseif($t->priority === 'medium')
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 rounded-pill fs-8">Medium</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1 rounded-pill fs-8">Low</span>
                            @endif
                        </td>
                        <td class="fw-bold text-dark fs-8 font-monospace">
                            {{ $t->due_date ? $t->due_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td>
                            <div class="fs-8 fw-bold text-dark">{{ $t->assignee?->name ?? 'Unassigned' }}</div>
                        </td>
                        <td>
                            <form action="{{ route('projects.tasks.status', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm rounded-pill fs-8 d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="todo" {{ $t->status == 'todo' ? 'selected' : '' }}>To-Do List</option>
                                    <option value="in_progress" {{ $t->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="review" {{ $t->status == 'review' ? 'selected' : '' }}>In Review</option>
                                    <option value="done" {{ $t->status == 'done' ? 'selected' : '' }}>Done & Verified</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('projects.tasks.destroy', $t->id) }}" method="POST" onsubmit="event.preventDefault(); confirmDeleteTask('{{ $t->id }}', '{{ addslashes($t->title) }}', this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger" title="Delete Task">
                                    <i class="bi bi-trash-fill fs-8"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fs-7">
                            <i class="bi bi-check2-square fs-2 d-block mb-2 text-slate-300"></i>
                            <div class="fw-bold text-dark">No work tasks created</div>
                            <p class="fs-8 text-muted mb-3">Click "Add Work Task" to assign project action items.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tasks->hasPages())
        <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
            <div class="fs-8 text-muted">Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} entries</div>
            <div>{{ $tasks->links() }}</div>
        </div>
    @endif
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6 text-dark">Add Project Work Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Enterprise Project <span class="text-danger">*</span></label>
                        <select name="project_id" class="form-select rounded-3 fs-8" required>
                            @foreach($projects as $prj)
                                <option value="{{ $prj->id }}">{{ $prj->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7 text-dark">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3 fs-8" placeholder="e.g. Design relational database schema" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Priority</label>
                            <select name="priority" class="form-select rounded-3 fs-8">
                                <option value="low">Low Priority</option>
                                <option value="medium" selected>Medium Priority</option>
                                <option value="high">High Priority</option>
                                <option value="urgent">Urgent Priority</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Assigned Engineer</label>
                            <select name="assigned_to" class="form-select rounded-3 fs-8">
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Workflow Stage</label>
                            <select name="status" class="form-select rounded-3 fs-8">
                                <option value="todo">To-Do List</option>
                                <option value="in_progress">In Progress</option>
                                <option value="review">In Review</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold fs-7 text-dark">Due Date</label>
                            <input type="date" name="due_date" class="form-control rounded-3 fs-8" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fs-8 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-purple rounded-pill px-4 fs-8 fw-bold text-white" style="background: #7C3AED; border: none;">Save Work Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteTask(id, title, formEl) {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        
        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2 text-danger fw-bold fs-5 mb-1">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i> Delete Work Task?
                    </div>`,
            html: `
                <div class="text-center py-2">
                    <p class="fs-7 text-secondary mb-3" style="line-height: 1.6;">
                        Are you sure you want to delete <strong class="text-dark">${title}</strong>?
                    </p>
                    <div class="alert alert-danger border-0 fs-8 py-2.5 px-3 text-start mb-0 rounded-3" style="background: ${isDark ? '#374151' : '#FEF2F2'}; color: ${isDark ? '#F87171' : '#991B1B'};">
                        <i class="bi bi-trash me-1"></i>
                        Deleting this task will remove its time log records.
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Yes, Delete Task',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#EF4444',
            cancelButtonColor: isDark ? '#4B5563' : '#64748B',
            background: isDark ? '#1F2937' : '#ffffff',
            color: isDark ? '#F8FAFC' : '#1E1B4B',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg p-4',
                confirmButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7 shadow-sm',
                cancelButton: 'px-4 py-2.5 rounded-pill fw-bold fs-7'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                formEl.submit();
            }
        });
    }
</script>
@endpush
