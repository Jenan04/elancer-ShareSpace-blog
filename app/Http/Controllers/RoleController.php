<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected array $availableAbilities = [
        'manage_users'   => 'Manage Users',
        'manage_roles'   => 'Manage Roles',
        'create_post'    => 'Create Post',
        'edit_any_post'  => 'Edit Any Post',
        'delete_any_post'=> 'Delete Any Post',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $abilities = $this->availableAbilities;
        return view('admin.roles.create', compact('abilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'abilities' => 'required|array',
            'abilities.*' => 'string', // التأكد من أن كل عنصر هو نص صلاحية valid
        ]);

        Role::create([
            'name' => $validated['name'],
            'abilities' => $validated['abilities'], // سيتحول تلقائياً إلى JSON بفضل الـ Cast في الـ Model
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $abilities = $this->availableAbilities;
        return view('admin.roles.edit', compact('role', 'abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'abilities' => 'required|array',
            'abilities.*' => 'string',
        ]);

        $role->update([
            'name' => $validated['name'],
            'abilities' => $validated['abilities'],
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
