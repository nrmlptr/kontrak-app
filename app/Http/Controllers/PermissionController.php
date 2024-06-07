<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permissions;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    // FUNGSI VIEW ALL DATA PERMISSION =========================================================================================
    public function index()
    {
        // echo 'ini tempat manage permission';

        $permissions = Permissions::all();

        // dd($permissions);

        return view('permissions.index', compact('permissions'));
    }

    // FUNGSI VIEW ADD PERMISSION  =============================================================================================
    public function create()
    {
        return view('permissions.create');
    }

    // FUNGSI SAVE ADD PERMISSION  =============================================================================================
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|unique:permissions',
            'detail' => 'required'
        ]);

        Permissions::create($request->all());
        return redirect()->route('permissions')->with('success', 'Berhasil Tambah Permission!');
    }

    // FUNGSI VIEW EDIT PERMISSION  ===========================================================================================
    public function edit(Permissions $permissions, $id)
    {
        $permissions = Permissions::find($id);

        return view('permissions.edit', compact('permissions'));
    }

    // FUNGSI SAVE EDITAN PERMISSION  =========================================================================================
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'detail'        => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']           = $request->name;
        $data['detail']         = $request->detail;

        Permissions::whereId($id)->update($data);

        return redirect()->route('permissions')->with('success', 'Berhasil Perbarui Permission!');
    }

    // FUNGSI DELETE PERMISSION  =============================================================================================
    public function delete(Request $request, $id)
    {
        $data = Permissions::find($id);

        if ($data) {
            $data->delete();
        }

        // notifikasi
        flash()->addFlash('success', 'Berhasil Hapus Permissions!');

        return redirect()->route('permissions');
    }
}
