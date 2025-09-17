<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get(); // ✅ Load roles
        return view('pages.staff.index', compact('users'));
    }

    public function create()
    {
        return view('pages.staff.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::firstOrCreate(['name' => $request->role]);
        $user->assignRole($role);

        return response()->json([
            'status' => 'success',
            'message' => 'Staff created successfully!',
            'redirect' => route('staff.index'),
        ]);
    }

    public function edit($id)
    {
        $edit = User::findOrFail($id);

        $roles = Role::all();
        $currentRole = $edit->roles->pluck('name')->first();

        return view('pages.staff.edit', compact('edit', 'roles', 'currentRole'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role'  => 'nullable|string',
        ]);

        $user = User::findOrFail($id);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Agar Admin nahi hai tabhi role update kare
        if ($request->role && !$user->hasRole('Admin')) {
            $user->syncRoles([$request->role]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'redirect' => route('staff.index'),
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully!'
        ]);
    }
}
