<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CRM\CrmCompany;
use App\Models\CRM\Lead;
use App\Models\CRM\Deal;
use App\Models\CRM\CrmTask;

class CrmSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Companies
        $comp1 = CrmCompany::firstOrCreate(
            ['name' => 'Acme Corporation'],
            ['industry' => 'Manufacturing & Logistics', 'website' => 'https://acme.example.com']
        );

        $comp2 = CrmCompany::firstOrCreate(
            ['name' => 'Cyberdyne Systems'],
            ['industry' => 'Robotics & AI', 'website' => 'https://cyberdyne.example.com']
        );

        $comp3 = CrmCompany::firstOrCreate(
            ['name' => 'Stark Global Enterprises'],
            ['industry' => 'Clean Energy & Defense', 'website' => 'https://stark.example.com']
        );

        // 2. Seed Leads
        $lead1 = Lead::firstOrCreate(
            ['email' => 'john.acme@example.com'],
            [
                'crm_company_id' => $comp1->id,
                'name' => 'John Vance',
                'phone' => '+1 (555) 111-2222',
                'source' => 'Website Inquiry',
                'status' => 'qualified',
            ]
        );

        $lead2 = Lead::firstOrCreate(
            ['email' => 'sarah.cyber@example.com'],
            [
                'crm_company_id' => $comp2->id,
                'name' => 'Sarah Connor',
                'phone' => '+1 (555) 222-3333',
                'source' => 'Tech Summit 2026',
                'status' => 'contacted',
            ]
        );

        $lead3 = Lead::firstOrCreate(
            ['email' => 'tony.stark@example.com'],
            [
                'crm_company_id' => $comp3->id,
                'name' => 'Tony Stark',
                'phone' => '+1 (555) 333-4444',
                'source' => 'Direct Referral',
                'status' => 'new',
            ]
        );

        // 3. Seed Deals
        $deal1 = Deal::firstOrCreate(
            ['title' => 'Enterprise ERP License & Custom Module Integration'],
            [
                'lead_id' => $lead1->id,
                'value' => 125000.00,
                'stage' => 'negotiation',
                'owner_id' => 1,
                'expected_close_date' => '2026-08-15',
            ]
        );

        $deal2 = Deal::firstOrCreate(
            ['title' => 'Global HR & Payroll Suite Deployment'],
            [
                'lead_id' => $lead2->id,
                'value' => 85000.00,
                'stage' => 'proposal',
                'owner_id' => 1,
                'expected_close_date' => '2026-08-30',
            ]
        );

        $deal3 = Deal::firstOrCreate(
            ['title' => 'Annual Software Retainer Contract'],
            [
                'lead_id' => $lead3->id,
                'value' => 250000.00,
                'stage' => 'won',
                'owner_id' => 1,
                'expected_close_date' => '2026-07-20',
            ]
        );

        // 4. Seed CRM Tasks
        CrmTask::firstOrCreate(
            ['title' => 'Send revised enterprise ERP contract proposal'],
            [
                'deal_id' => $deal1->id,
                'due_date' => '2026-07-28',
                'assigned_to' => 1,
                'status' => 'pending',
            ]
        );

        CrmTask::firstOrCreate(
            ['title' => 'Schedule product demo video conference with Sarah'],
            [
                'deal_id' => $deal2->id,
                'due_date' => '2026-07-29',
                'assigned_to' => 1,
                'status' => 'pending',
            ]
        );
    }
}
