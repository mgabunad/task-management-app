<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display all roles.
     */
    public function index()
    {
        $roles = Role::withCount('users')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form to create a new role.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['name'] = strtolower(str_replace(' ', '_', $validated['name']));

        Role::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show role details and its assigned users.
     */
    public function show(Role $role)
    {
        $role->load('users');
        $allUsers = User::orderBy('name')->get();
        return view('admin.roles.show', compact('role', 'allUsers'));
    }

    /**
     * Show the form to edit a role.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update an existing role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['name'] = strtolower(str_replace(' ', '_', $validated['name']));

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Assign or revoke roles for a specific user.
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->roles()->syncWithoutDetaching($request->input('roles', []));

        return redirect()->back()
            ->with('success', 'Roles updated for ' . $user->name);
    }
}