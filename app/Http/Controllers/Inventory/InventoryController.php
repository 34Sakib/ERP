<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Product;
use App\Models\Inventory\Warehouse;
use App\Models\Inventory\Supplier;
use App\Models\Inventory\PurchaseOrder;
use App\Models\Inventory\StockMovement;
use App\Models\Core\Branch;

class InventoryController extends Controller
{
    /**
     * 1. Product Catalog
     */
    public function products(Request $request)
    {
        $query = Product::with('stockMovements');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(15);

        $stats = [
            'total_products' => Product::count(),
            'total_valuation' => Product::sum('sale_price'),
            'reorder_alert' => Product::where('reorder_level', '>=', 10)->count(),
            'total_skus' => Product::count(),
        ];

        return view('inventory.products', compact('products', 'stats'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:100|unique:products,sku',
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:100',
            'unit' => 'required|string|max:20',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        Product::create($validated);
        return redirect()->back()->with('success', 'New product SKU added to catalog.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:100',
            'unit' => 'required|string|max:20',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $product->update($validated);
        return redirect()->back()->with('success', 'Product details updated successfully.');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Product removed from catalog.');
    }

    /**
     * 2. Storage Warehouses
     */
    public function warehouses(Request $request)
    {
        $query = Warehouse::with(['branch', 'stockMovements']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $warehouses = $query->latest()->paginate(15);
        $branches = Branch::all();

        $stats = [
            'total_warehouses' => Warehouse::count(),
            'active_warehouses' => Warehouse::count(),
            'total_movements' => StockMovement::count(),
        ];

        return view('inventory.warehouses', compact('warehouses', 'branches', 'stats'));
    }

    public function storeWarehouse(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        Warehouse::create($validated);
        return redirect()->back()->with('success', 'Warehouse facility registered successfully.');
    }

    public function updateWarehouse(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $warehouse->update($validated);
        return redirect()->back()->with('success', 'Warehouse facility details updated.');
    }

    public function destroyWarehouse(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->back()->with('success', 'Warehouse facility deleted.');
    }

    /**
     * 3. Vendors & Suppliers
     */
    public function suppliers(Request $request)
    {
        $query = Supplier::with('purchaseOrders');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $suppliers = $query->latest()->paginate(15);

        $stats = [
            'total_suppliers' => Supplier::count(),
            'total_orders' => PurchaseOrder::count(),
            'total_spent' => PurchaseOrder::where('status', 'received')->sum('total_amount'),
        ];

        return view('inventory.suppliers', compact('suppliers', 'stats'));
    }

    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        Supplier::create($validated);
        return redirect()->back()->with('success', 'Supplier account registered successfully.');
    }

    public function updateSupplier(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $supplier->update($validated);
        return redirect()->back()->with('success', 'Supplier account updated successfully.');
    }

    public function destroySupplier(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back()->with('success', 'Supplier account deleted.');
    }

    /**
     * 4. Purchase Orders
     */
    public function purchaseOrders(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'warehouse']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $purchaseOrders = $query->latest()->paginate(15);
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        $stats = [
            'total_po_value' => PurchaseOrder::sum('total_amount'),
            'received_value' => PurchaseOrder::where('status', 'received')->sum('total_amount'),
            'ordered_count' => PurchaseOrder::where('status', 'ordered')->count(),
            'draft_count' => PurchaseOrder::where('status', 'draft')->count(),
        ];

        return view('inventory.purchase_orders', compact('purchaseOrders', 'suppliers', 'warehouses', 'stats'));
    }

    public function storePurchaseOrder(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,ordered,received,cancelled',
        ]);

        PurchaseOrder::create($validated);
        return redirect()->back()->with('success', 'Purchase order created successfully.');
    }

    public function updatePOStatus(Request $request, PurchaseOrder $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,ordered,received,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Purchase order status updated to ' . strtoupper($validated['status']) . '.');
    }

    /**
     * 5. Stock Movements Log
     */
    public function stockMovements(Request $request)
    {
        $query = StockMovement::with(['product', 'warehouse']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $stockMovements = $query->latest()->paginate(15);
        $products = Product::all();
        $warehouses = Warehouse::all();

        $stats = [
            'total_in' => StockMovement::where('type', 'in')->sum('quantity'),
            'total_out' => StockMovement::where('type', 'out')->sum('quantity'),
            'total_transfers' => StockMovement::where('type', 'transfer')->count(),
            'total_adjustments' => StockMovement::where('type', 'adjustment')->count(),
        ];

        return view('inventory.stock_movements', compact('stockMovements', 'products', 'warehouses', 'stats'));
    }

    public function storeStockMovement(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:in,out,transfer,adjustment',
            'quantity' => 'required|integer|min:1',
        ]);

        StockMovement::create($validated);
        return redirect()->back()->with('success', 'Stock movement entry logged successfully.');
    }
}
