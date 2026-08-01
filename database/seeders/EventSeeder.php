<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calendar\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::firstOrCreate(
            ['title' => '🇨🇦 Canada Day'],
            [
                'description' => 'Official Public Holiday - All Offices Closed',
                'event_date' => '2026-07-01',
                'type' => 'red',
            ]
        );

        Event::firstOrCreate(
            ['title' => '⚡ ERP Sprint Review'],
            [
                'description' => '10:00 AM - Sprint v2.4 Milestone Demo',
                'event_date' => '2026-07-08',
                'type' => 'indigo',
            ]
        );

        Event::firstOrCreate(
            ['title' => '💵 July Payroll Run'],
            [
                'description' => 'Finance Dept Monthly Direct Deposit Execution',
                'event_date' => '2026-07-15',
                'type' => 'emerald',
            ]
        );

        Event::firstOrCreate(
            ['title' => '🛡️ System Security Audit'],
            [
                'description' => 'IT Infrastructure Security Audit Log & Compliance Check',
                'event_date' => '2026-07-25',
                'type' => 'amber',
            ]
        );

        Event::firstOrCreate(
            ['title' => '🚀 Q3 Executive Strategy Meeting'],
            [
                'description' => 'Leadership Alignment & Q3 Deliverables Roadmap',
                'event_date' => '2026-07-28',
                'type' => 'indigo',
            ]
        );
    }
}
