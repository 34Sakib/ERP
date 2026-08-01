<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Core\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount(['branches', 'departments'])->latest()->paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
        ]);

        Company::create($validated);

        return back()->with('success', 'Company created successfully.');
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
        ]);

        $company->update($validated);

        return back()->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Company deleted successfully.');
    }
}
