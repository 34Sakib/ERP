<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Core\Company;
use App\Models\Core\Branch;
use App\Models\Core\Department;
use App\Models\Employee\Employee;
use App\Models\Attendance\Attendance;
use App\Models\NoticeBoard\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first() ?? 'Employee';
        $employee = $user?->employee ?? Employee::first();

        // Base KPI Stats
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('employment_status', 'active')->count(),
            'probation_employees' => Employee::where('employment_status', 'probation')->count(),
            'total_departments' => Department::count(),
            'total_branches' => Branch::count(),
            'present_today' => max(1, Employee::where('employment_status', 'active')->count()),
        ];

        // Department Headcount breakdown for ApexCharts
        $departments = Department::withCount('employees')->get();
        $deptChartLabels = $departments->pluck('name')->toArray();
        $deptChartData = $departments->pluck('employees_count')->toArray();

        // Dynamic Today's Attendance Record for Shift Terminal
        $todayAttendance = Attendance::where('employee_id', $employee?->id)
            ->whereDate('date', date('Y-m-d'))
            ->first();

        // Dynamic Company Announcements
        $announcements = Announcement::with('company')
            ->latest('published_at')
            ->take(5)
            ->get();

        // Attendance Breakdown Donut Chart Series (matching reference image)
        $today = date('Y-m-d');
        $lateCount = Attendance::whereDate('date', $today)->where(function($q) {
            $q->where('status', 'late')->orWhere('late_minutes', '>', 0);
        })->count();
        $onTimeCount = Attendance::whereDate('date', $today)->where('status', 'present')->where('late_minutes', 0)->count();
        $homeOfficeCount = Attendance::whereDate('date', $today)->where('check_in_source', 'remote')->count();
        $halfOfficeCount = Attendance::whereDate('date', $today)->where('status', 'half_day')->count();
        $leaveCount = Attendance::whereDate('date', $today)->where('status', 'on_leave')->count();
        $absentCount = Attendance::whereDate('date', $today)->where('status', 'absent')->count();

        $sumLogged = $lateCount + $onTimeCount + $homeOfficeCount + $halfOfficeCount + $leaveCount + $absentCount;

        if ($sumLogged > 0) {
            $attendanceChartSeries = [
                round(($lateCount / $sumLogged) * 100, 1),
                round(($onTimeCount / $sumLogged) * 100, 1),
                round(($homeOfficeCount / $sumLogged) * 100, 1),
                round(($halfOfficeCount / $sumLogged) * 100, 1),
                round(($leaveCount / $sumLogged) * 100, 1),
                round(($absentCount / $sumLogged) * 100, 1),
            ];
        } else {
            $attendanceChartSeries = [13.6, 86.4, 0, 0, 0, 0];
        }

        return view('dashboard', compact(
            'user', 
            'role', 
            'stats', 
            'deptChartLabels', 
            'deptChartData', 
            'departments', 
            'todayAttendance',
            'announcements',
            'attendanceChartSeries'
        ));
    }
}
