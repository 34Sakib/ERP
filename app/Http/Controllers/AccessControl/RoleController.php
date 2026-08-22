<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Core\AuditLog;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->get();
        $permissions = Permission::all();

        $groupedPermissions = [];
        foreach ($permissions as $perm) {
            $prefix = explode('.', $perm->name)[0] ?? 'General';
            $groupedPermissions[ucwords($prefix)][] = $perm;
        }

        return view('roles.index', compact('roles', 'groupedPermissions'));
    }

    public function auditLogs()
    {
        $auditLogs = AuditLog::with('user')->latest()->paginate(15);
        return view('roles.audit_logs', compact('auditLogs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:191',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return back()->with('success', 'Role created successfully.');
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($request->input('permissions', []));

        return back()->with('success', 'Role & permissions updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Admin', 'HR', 'Employee'])) {
            return back()->with('error', 'System default roles cannot be deleted.');
        }

        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
}
