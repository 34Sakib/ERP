<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Core\Department;
use App\Models\Recruitment\JobPost;
use App\Models\Recruitment\Applicant;
use App\Models\Recruitment\Interview;

class RecruitmentSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $department = Department::first();

        if (!$company) {
            return;
        }

        // 1. Seed Job Postings
        $job1 = JobPost::firstOrCreate(
            ['title' => 'Senior Full Stack Laravel & Vue Architect'],
            [
                'company_id' => $company->id,
                'department_id' => $department?->id,
                'description' => 'Looking for an experienced Lead Full Stack Developer to drive ERP platform architecture.',
                'employment_type' => 'Full-Time',
                'status' => 'published',
                'closing_date' => '2026-08-30',
            ]
        );

        $job2 = JobPost::firstOrCreate(
            ['title' => 'HR Operations Lead & People Manager'],
            [
                'company_id' => $company->id,
                'department_id' => $department?->id,
                'description' => 'Oversee employee onboarding, payroll workflows, and organizational compliance.',
                'employment_type' => 'Full-Time',
                'status' => 'published',
                'closing_date' => '2026-08-15',
            ]
        );

        $job3 = JobPost::firstOrCreate(
            ['title' => 'UI/UX Product Designer & Visual Specialist'],
            [
                'company_id' => $company->id,
                'department_id' => $department?->id,
                'description' => 'Design glassmorphic web UI components and design systems.',
                'employment_type' => 'Full-Time',
                'status' => 'published',
                'closing_date' => '2026-09-01',
            ]
        );

        // 2. Seed Candidates / Applicants
        $app1 = Applicant::firstOrCreate(
            ['email' => 'alex.rivers@example.com'],
            [
                'job_post_id' => $job1->id,
                'name' => 'Alex Rivers',
                'phone' => '+1 (555) 234-5678',
                'source' => 'LinkedIn',
                'status' => 'interview',
            ]
        );

        $app2 = Applicant::firstOrCreate(
            ['email' => 'sophia.chen@example.com'],
            [
                'job_post_id' => $job1->id,
                'name' => 'Sophia Chen',
                'phone' => '+1 (555) 345-6789',
                'source' => 'Careers Portal',
                'status' => 'shortlisted',
            ]
        );

        $app3 = Applicant::firstOrCreate(
            ['email' => 'marcus.vance@example.com'],
            [
                'job_post_id' => $job2->id,
                'name' => 'Marcus Vance',
                'phone' => '+1 (555) 456-7890',
                'source' => 'Indeed',
                'status' => 'hired',
            ]
        );

        $app4 = Applicant::firstOrCreate(
            ['email' => 'elena.rodriguez@example.com'],
            [
                'job_post_id' => $job3->id,
                'name' => 'Elena Rodriguez',
                'phone' => '+1 (555) 567-8901',
                'source' => 'Referral',
                'status' => 'applied',
            ]
        );

        // 3. Seed Interview Schedules
        Interview::firstOrCreate(
            ['applicant_id' => $app1->id],
            [
                'scheduled_at' => '2026-07-28 14:00:00',
                'interviewer_id' => 1,
                'mode' => 'Google Meet Video',
                'feedback' => 'Strong architectural problem-solving skills and deep Laravel expertise.',
                'rating' => 5,
            ]
        );
    }
}
