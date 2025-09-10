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
}
