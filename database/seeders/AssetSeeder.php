<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetAssignment;
use App\Models\Asset\AssetMaintenance;

class AssetSeeder extends Seeder
{
    public function run()
    {
        $company = Company::first();
        $employees = Employee::take(5)->get();

        if (!$company) {
            return;
        }

        // 1. Seed Assets
        $asset1 = Asset::firstOrCreate(
            ['asset_tag' => 'AST-MBP-001'],
            [
                'company_id' => $company->id,
                'category' => 'laptop',
                'brand' => 'Apple',
                'model' => 'MacBook Pro 16 M3 Max',
                'serial_number' => 'C02GX001MD6R',
                'purchase_date' => '2026-01-15',
                'purchase_cost' => 3499.00,
                'status' => 'assigned',
            ]
        );

        $asset2 = Asset::firstOrCreate(
            ['asset_tag' => 'AST-DEL-002'],
            [
                'company_id' => $company->id,
                'category' => 'monitor',
                'brand' => 'Dell',
                'model' => 'UltraSharp 27 4K USB-C Hub',
                'serial_number' => 'CN-0X982D-74261',
                'purchase_date' => '2026-02-10',
                'purchase_cost' => 649.00,
                'status' => 'assigned',
            ]
        );

        $asset3 = Asset::firstOrCreate(
            ['asset_tag' => 'AST-IPH-003'],
            [
                'company_id' => $company->id,
                'category' => 'phone',
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro Max 256GB',
                'serial_number' => 'FK1X9023MM8Q',
                'purchase_date' => '2026-03-01',
                'purchase_cost' => 1199.00,
                'status' => 'available',
            ]
        );

        $asset4 = Asset::firstOrCreate(
            ['asset_tag' => 'AST-CHR-004'],
            [
                'company_id' => $company->id,
                'category' => 'accessory',
                'brand' => 'Herman Miller',
                'model' => 'Aeron Ergonomic Task Chair',
                'serial_number' => 'HM-AER-90123',
                'purchase_date' => '2025-11-20',
                'purchase_cost' => 1295.00,
                'status' => 'maintenance',
            ]
        );

        // 2. Seed Asset Assignments
        if ($employees->count() >= 2) {
            AssetAssignment::firstOrCreate(
                ['asset_id' => $asset1->id, 'employee_id' => $employees[0]->id],
                [
                    'assigned_date' => '2026-01-20',
                    'condition_on_assign' => 'Brand New in Sealed Box',
                ]
            );

            AssetAssignment::firstOrCreate(
                ['asset_id' => $asset2->id, 'employee_id' => $employees[1]->id],
                [
                    'assigned_date' => '2026-02-15',
                    'condition_on_assign' => 'Excellent Condition',
                ]
            );
        }

        // 3. Seed Asset Maintenance Logs
        AssetMaintenance::firstOrCreate(
            ['asset_id' => $asset4->id],
            [
                'description' => 'Replace lumbar support cushion and re-align tilt tension mechanism.',
                'cost' => 185.00,
                'date' => '2026-07-20',
                'vendor' => 'Herman Miller Authorized Service',
            ]
        );
    }
}
