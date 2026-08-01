<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::truncate();

        $admin = User::first();
        $userId = $admin ? $admin->id : null;

        Notification::create([
            'user_id' => $userId,
            'sender_name' => 'John Doe',
            'sender_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => 'bi-calendar-event',
            'badge_color' => 'bg-warning',
            'title' => 'Submitted Leave Request for',
            'target_name' => '3 Days Annual Leave',
            'body' => 'Requesting annual leave from Feb 10 to Feb 12 for personal family event.',
            'has_actions' => true,
            'action_decline_label' => 'Reject',
            'action_accept_label' => 'Approve',
            'is_read' => false,
            'created_at' => now()->subMinutes(15),
        ]);

        Notification::create([
            'user_id' => $userId,
            'sender_name' => 'Sarah Connor',
            'sender_avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => 'bi-clock-history',
            'badge_color' => 'bg-primary',
            'title' => 'Requested Punch Regularization for',
            'target_name' => 'Shift Check-in (09:05 AM)',
            'body' => 'Biometric sensor missed morning check-in punch on Jan 24.',
            'has_actions' => true,
            'action_decline_label' => 'Decline',
            'action_accept_label' => 'Accept',
            'is_read' => false,
            'created_at' => now()->subHour(),
        ]);

        Notification::create([
            'user_id' => $userId,
            'sender_name' => 'Finance Dept',
            'sender_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => 'bi-cash-stack',
            'badge_color' => 'bg-success',
            'title' => 'Processed Monthly Payroll Batch for',
            'target_name' => 'January 2026 Payroll',
            'body' => 'Payroll for 9 active staff members processed cleanly. Total outlay $48,500.',
            'has_actions' => false,
            'is_read' => false,
            'created_at' => now()->subHours(3),
        ]);

        Notification::create([
            'user_id' => $userId,
            'sender_name' => 'Recruitment System',
            'sender_avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => 'bi-person-badge',
            'badge_color' => 'bg-info',
            'title' => 'New Job Applicant for',
            'target_name' => 'Senior Fullstack Developer',
            'body' => 'Emily Watson submitted resume for Engineering department opening.',
            'has_actions' => false,
            'is_read' => true,
            'created_at' => now()->subHours(5),
        ]);

        Notification::create([
            'user_id' => $userId,
            'sender_name' => 'IT Helpdesk',
            'sender_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=80',
            'badge_icon' => 'bi-laptop',
            'badge_color' => 'bg-danger',
            'title' => 'Assigned Company Hardware Asset',
            'target_name' => 'MacBook Pro M3 Max (#AST-042)',
            'body' => 'Asset assigned to Michael Brown with serial number C02G9012MD6M.',
            'has_actions' => false,
            'is_read' => true,
            'created_at' => now()->subDays(1),
        ]);
    }
}
