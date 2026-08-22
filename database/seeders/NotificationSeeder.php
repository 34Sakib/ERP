<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate dummy seed notifications so the system remains clean with real notifications only
        Notification::truncate();
    }
}
