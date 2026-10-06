<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('roles')->paginate();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create', [
            'roles' => Role::all(),
            'admin' => new Admin(),
            'admin_roles' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:255|unique:admins,phone_number',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['roles', '_token']);
            $data['password'] = Hash::make($request->password);
            $admin = Admin::create($data);

            if ($request->filled('roles')) {
                $admin->roles()->attach($request->roles);
            }

            DB::commit();
            return redirect()->route('admins.index')->with('success', 'Admin created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to create admin: ' . $e->getMessage());
        }
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
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin_roles = $admin->roles()->pluck('role_id')->toArray();
        return view('dashboard.admins.edit', compact('admin', 'roles', 'admin_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:6',
            'phone_number' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['roles', '_token', 'password']);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            $admin->update($data);
            $admin->roles()->sync($request->roles ?? []);

            DB::commit();
            return redirect()->route('admins.index')->with('success', 'Admin updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to update admin: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully!');
    }
}
