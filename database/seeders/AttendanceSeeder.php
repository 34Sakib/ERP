<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Core\Branch;
use App\Models\Employee\Employee;
use App\Models\Attendance\Shift;
use App\Models\Attendance\Holiday;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\AttendanceRegularization;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $branch = Branch::first();
        $employees = Employee::take(10)->get();

        if (!$company || $employees->isEmpty()) {
            return;
        }

        // 1. Seed Shifts
        $shiftMorning = Shift::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'General Morning Shift'],
            [
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'break_minutes' => 60,
                'grace_minutes' => 15,
                'is_night_shift' => false,
            ]
        );

        $shiftNight = Shift::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Overnight Tech Shift'],
            [
                'start_time' => '20:00:00',
                'end_time' => '05:00:00',
                'break_minutes' => 45,
                'grace_minutes' => 15,
                'is_night_shift' => true,
            ]
        );

        $shiftFlexible = Shift::firstOrCreate(
            ['company_id' => $company->id, 'name' => 'Executive Flexible Shift'],
            [
                'start_time' => '10:00:00',
                'end_time' => '19:00:00',
                'break_minutes' => 60,
                'grace_minutes' => 30,
                'is_night_shift' => false,
            ]
        );

        // 2. Seed Holidays
        Holiday::firstOrCreate(
            ['company_id' => $company->id, 'date' => '2026-08-15'],
            [
                'branch_id' => $branch?->id,
                'name' => 'Independence Day Holiday',
                'is_recurring' => true,
            ]
        );

        Holiday::firstOrCreate(
            ['company_id' => $company->id, 'date' => '2026-12-25'],
            [
                'branch_id' => $branch?->id,
                'name' => 'Christmas Day Celebration',
                'is_recurring' => true,
            ]
        );

        Holiday::firstOrCreate(
            ['company_id' => $company->id, 'date' => '2026-10-02'],
            [
                'branch_id' => $branch?->id,
                'name' => 'National Founders Day',
                'is_recurring' => false,
            ]
        );

        // 3. Seed Attendance Records for Today & Recent Days
        $today = date('Y-m-d');
        $statuses = ['present', 'present', 'late', 'present', 'half_day', 'absent', 'on_leave'];

        foreach ($employees as $idx => $emp) {
            $status = $statuses[$idx % count($statuses)];
            $checkIn = null;
            $checkOut = null;
            $worked = 0;

            if ($status === 'present') {
                $checkIn = Carbon::parse("$today 08:55:00");
                $checkOut = Carbon::parse("$today 18:05:00");
                $worked = 550;
            } elseif ($status === 'late') {
                $checkIn = Carbon::parse("$today 09:35:00");
                $checkOut = Carbon::parse("$today 18:00:00");
                $worked = 505;
            } elseif ($status === 'half_day') {
                $checkIn = Carbon::parse("$today 09:00:00");
                $checkOut = Carbon::parse("$today 13:30:00");
                $worked = 270;
            }

            $att = Attendance::updateOrCreate(
                ['employee_id' => $emp->id, 'date' => $today],
                [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                    'check_in_source' => 'manual',
                    'total_worked_minutes' => $worked,
                    'late_minutes' => $status === 'late' ? 35 : 0,
                ]
            );

            // Seed Regularization for Late or Missed Log
            if ($status === 'late' && $idx === 2) {
                AttendanceRegularization::firstOrCreate(
                    ['employee_id' => $emp->id, 'requested_check_in' => "$today 09:00:00"],
                    [
                        'attendance_id' => $att->id,
                        'requested_check_out' => "$today 18:00:00",
                        'reason' => 'Severe subway traffic delay on Line 4. Requesting punch regularization for morning shift arrival.',
                        'status' => 'pending',
                    ]
                );
            }
        }
    }
}
