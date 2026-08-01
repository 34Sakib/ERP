<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\NoticeBoard\Announcement;
use App\Models\NoticeBoard\PolicyDocument;

class NoticeBoardSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        if (!$company) return;

        Announcement::firstOrCreate(
            ['title' => 'Quarterly Townhall Meeting & Q3 Performance Awards'],
            [
                'company_id' => $company->id,
                'body' => 'Dear Team, We are pleased to invite everyone to our Q3 All-Hands Townhall meeting this Friday at 4:00 PM in the main auditorium. We will be celebrating team achievements, announcing employee of the quarter awards, and reviewing company milestones.',
                'published_at' => now()->subHours(2),
                'expires_at' => now()->addDays(7),
            ]
        );

        Announcement::firstOrCreate(
            ['title' => 'Updated Corporate Health Insurance & Wellness Benefits 2026'],
            [
                'company_id' => $company->id,
                'body' => 'HR is proud to announce upgraded medical coverage and wellness reimbursements effective August 1st. Please review the updated policy document in the policy library widget.',
                'published_at' => now()->subDays(1),
                'expires_at' => now()->addDays(30),
            ]
        );

        // Seed Policy Documents
        PolicyDocument::firstOrCreate(
            ['title' => 'Employee Code of Conduct & Handbook 2026'],
            ['category' => 'HR Policy', 'file_size' => '2.4 MB']
        );

        PolicyDocument::firstOrCreate(
            ['title' => 'IT Infrastructure & Cyber Security Guidelines'],
            ['category' => 'IT Security', 'file_size' => '1.8 MB']
        );

        PolicyDocument::firstOrCreate(
            ['title' => 'Remote Work & Flexible Hours Policy'],
            ['category' => 'Operations', 'file_size' => '1.2 MB']
        );
    }
}
