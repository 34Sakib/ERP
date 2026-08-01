<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Company;
use App\Models\Employee\Employee;
use App\Models\Asset\Asset;
use App\Models\Asset\AssetAssignment;
use App\Models\Asset\AssetMaintenance;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    /**
     * 1. Assets Inventory
     */
    public function index(Request $request)
    {
        $query = Asset::with(['company', 'currentAssignment.employee']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('asset_tag', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $assets = $query->latest()->paginate(15);
        $companies = Company::all();

        $stats = [
            'total_assets' => Asset::count(),
            'assigned_count' => Asset::where('status', 'assigned')->count(),
            'available_count' => Asset::where('status', 'available')->count(),
            'maintenance_count' => Asset::where('status', 'maintenance')->count(),
            'total_value' => Asset::sum('purchase_cost'),
        ];

        return view('assets.index', compact('assets', 'companies', 'stats'));
    }

    public function storeAsset(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'asset_tag' => 'required|string|max:100|unique:assets,asset_tag',
            'category' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,assigned,maintenance,retired',
        ]);

        Asset::create($validated);
        return redirect()->back()->with('success', 'Hardware asset registered in inventory successfully.');
    }

    public function updateAsset(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'asset_tag' => 'required|string|max:100|unique:assets,asset_tag,' . $asset->id,
            'category' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,assigned,maintenance,retired',
        ]);

        $asset->update($validated);
        return redirect()->back()->with('success', 'Asset details updated successfully.');
    }

    public function destroyAsset(Asset $asset)
    {
        $asset->delete();
        return redirect()->back()->with('success', 'Asset removed from inventory.');
    }

    /**
     * 2. Asset Assignments & Returns
     */
    public function assignments(Request $request)
    {
        $assignments = AssetAssignment::with(['asset', 'employee.department'])
            ->latest()
            ->paginate(15);

        $availableAssets = Asset::where('status', 'available')->get();
        $employees = Employee::where('employment_status', 'active')->get();

        $stats = [
            'active_assignments' => AssetAssignment::whereNull('returned_date')->count(),
            'returned_count' => AssetAssignment::whereNotNull('returned_date')->count(),
            'total_assignments' => AssetAssignment::count(),
        ];

        return view('assets.assignments', compact('assignments', 'availableAssets', 'employees', 'stats'));
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'employee_id' => 'required|exists:employees,id',
            'assigned_date' => 'required|date',
            'condition_on_assign' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            AssetAssignment::create($validated);
            Asset::where('id', $validated['asset_id'])->update(['status' => 'assigned']);
        });

        return redirect()->back()->with('success', 'Asset assigned to employee successfully.');
    }

    public function returnAssignment(Request $request, AssetAssignment $assignment)
    {
        $validated = $request->validate([
            'returned_date' => 'required|date',
            'condition_on_return' => 'nullable|string',
        ]);

        DB::transaction(function () use ($assignment, $validated) {
            $assignment->update([
                'returned_date' => $validated['returned_date'],
                'condition_on_return' => $validated['condition_on_return'],
            ]);

            $assignment->asset->update(['status' => 'available']);
        });

        return redirect()->back()->with('success', 'Asset return checked-in successfully.');
    }

    /**
     * 3. Asset Maintenance & Repairs
     */
    public function maintenance(Request $request)
    {
        $maintenances = AssetMaintenance::with('asset')
            ->latest()
            ->paginate(15);

        $assets = Asset::all();

        $stats = [
            'total_maintenance_cost' => AssetMaintenance::sum('cost'),
            'total_service_logs' => AssetMaintenance::count(),
            'assets_in_maintenance' => Asset::where('status', 'maintenance')->count(),
        ];

        return view('assets.maintenance', compact('maintenances', 'assets', 'stats'));
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'date' => 'required|date',
            'vendor' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            AssetMaintenance::create($validated);
            Asset::where('id', $validated['asset_id'])->update(['status' => 'maintenance']);
        });

        return redirect()->back()->with('success', 'Maintenance repair log registered successfully.');
    }
}
