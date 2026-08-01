<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Core\Branch;
use App\Models\Inventory\Product;
use App\Models\Inventory\Warehouse;
use App\Models\Inventory\Supplier;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\StockMovement;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $branch = Branch::first();

        // 1. Seed Warehouses
        $wh1 = Warehouse::firstOrCreate(
            ['name' => 'Main Central Distribution Depot'],
            ['branch_id' => $branch?->id, 'address' => 'Building 4B, Logistics Park, Tech Corridor']
        );

        $wh2 = Warehouse::firstOrCreate(
            ['name' => 'West Coast Fulfilment Center'],
            ['branch_id' => $branch?->id, 'address' => 'Unit 12, Industrial Boulevard']
        );

        // 2. Seed Suppliers
        $sup1 = Supplier::firstOrCreate(
            ['email' => 'sales@techdata.example.com'],
            [
                'name' => 'Tech Data Global Distribution',
                'contact_person' => 'Robert Vance',
                'phone' => '+1 (555) 987-6543',
            ]
        );

        $sup2 = Supplier::firstOrCreate(
            ['email' => 'orders@ingrammicro.example.com'],
            [
                'name' => 'Ingram Micro Tech Partners',
                'contact_person' => 'Amanda Miller',
                'phone' => '+1 (555) 876-5432',
            ]
        );

        // 3. Seed Products
        $p1 = Product::firstOrCreate(
            ['sku' => 'SKU-MBP-16'],
            [
                'barcode' => '885909456782',
                'name' => 'MacBook Pro 16 M3 Max 36GB',
                'unit' => 'pcs',
                'cost_price' => 2800.00,
                'sale_price' => 3499.00,
                'reorder_level' => 5,
            ]
        );

        $p2 = Product::firstOrCreate(
            ['sku' => 'SKU-DEL-U27'],
            [
                'barcode' => '885909456799',
                'name' => 'Dell UltraSharp 27 4K USB-C Monitor',
                'unit' => 'pcs',
                'cost_price' => 450.00,
                'sale_price' => 649.00,
                'reorder_level' => 10,
            ]
        );

        $p3 = Product::firstOrCreate(
            ['sku' => 'SKU-DOC-TB4'],
            [
                'barcode' => '885909456812',
                'name' => 'Thunderbolt 4 Quad-Display Docking Hub',
                'unit' => 'pcs',
                'cost_price' => 180.00,
                'sale_price' => 280.00,
                'reorder_level' => 15,
            ]
        );

        // 4. Seed Purchase Orders
        PurchaseOrder::firstOrCreate(
            ['supplier_id' => $sup1->id, 'warehouse_id' => $wh1->id, 'total_amount' => 35000.00],
            ['status' => 'received']
        );

        PurchaseOrder::firstOrCreate(
            ['supplier_id' => $sup2->id, 'warehouse_id' => $wh2->id, 'total_amount' => 18500.00],
            ['status' => 'ordered']
        );

        // 5. Seed Stock Movements
        StockMovement::firstOrCreate(
            ['product_id' => $p1->id, 'warehouse_id' => $wh1->id, 'type' => 'in'],
            ['quantity' => 25]
        );

        StockMovement::firstOrCreate(
            ['product_id' => $p2->id, 'warehouse_id' => $wh1->id, 'type' => 'in'],
            ['quantity' => 50]
        );

        StockMovement::firstOrCreate(
            ['product_id' => $p3->id, 'warehouse_id' => $wh2->id, 'type' => 'transfer'],
            ['quantity' => 10]
        );
    }
}
