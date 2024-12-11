<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;  // Assuming you're using Spatie Laravel Permission package
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        // Get all roles and permissions
        $roles = Role::all();
        $permissions = Permission::all();

        // Pass the roles and permissions to the view
        return view('admin.roles-permissions', compact('roles', 'permissions'));
    }
}
