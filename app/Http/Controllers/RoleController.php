<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permissions;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    // FUNGSI VIEW DATA ROLE ALL  =============================================================================================
    public function index()
    {
        // echo 'ini tempat manage role';
        $roles = Role::all();
        // dd($roles);

        return view('roles.index', compact('roles'));
    }

    // FUNGSI VIEW ADD DATA ROLE  =============================================================================================
    public function create()
    {
        $permissions = Permissions::all();
        return view('roles.create', compact('permissions'));
    }

    // FUNGSI SAVE DATA ROLE  =================================================================================================
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'        => 'required|unique:roles',
            'permissions' => 'required|array',
        ]);

        $role = Role::create($request->only('name'));
        $role->permissions()->sync($request->permissions);

        return redirect()->route('role')->with('success', 'Berhasil Tambah Role!');
    }

    // FUNGSI VIEW EDIT DATA ROLE  ============================================================================================
    public function show(Role $role, $id)
    {
        $role = Role::find($id);

        $permissions = Permissions::all();

        return view('roles.show', compact('role', 'permissions'));
    }

    // FUNGSI VIEW EDIT DATA ROLE  =============================================================================================
    public function edit(Role $role, $id)
    {

        $role = Role::find($id);

        $permissions = Permissions::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    // FUNGSI SAVE EDITAN DATA ROLE  ============================================================================================
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $role = Role::find($id);

        $validator = Validator::make($request->all(), [
            'name'             => 'required',
            'permissions'      => 'required|array',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']          = $request->name;

        $role->update($data);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('role')->with('success', 'Berhasil Perbarui Role!');
    }

    // FUNGSI DELETE DATA ROLE  ==================================================================================================
    public function delete(Request $request, $id)
    {
        $data = Role::find($id);

        if ($data) {
            $data->delete();
        }

        // notifikasi
        flash()->addFlash('success', 'Berhasil Hapus Role!');

        return redirect()->route('role');
    }
}
