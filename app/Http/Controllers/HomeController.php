<?php

namespace App\Http\Controllers;

use App\Models\PasalKontrak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuinate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function dashboard()
    {

        // dd(auth()->user()->getRoleNames());
        return view('dashboard');
    }


    public function index()
    {
        // echo 'ini method index';

        // if (auth()->user()->can('view_user')) {
        $data = User::get();
        return view('index', compact('data'));
        // }

        // return abort(403);

    }

    public function addUser()
    {
        return view('addUser');
    }

    public function loadUser(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'username'      => 'required',
            'email'         => 'required|email',
            'unit_kerja'    => 'required',
            'password'      => 'required',
            'permission'    => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']           = $request->nama;
        $data['username']       = $request->username;
        $data['email']          = $request->email;
        $data['unit_kerja']     = $request->unit_kerja;
        $data['password']       = Hash::make($request->password);
        $data['permission']     = $request->permission;

        User::create($data);

        return redirect()->route('index');
    }

    public function editUser(Request $request, $id)
    {
        $data = User::find($id);

        // dd($data);    -> cek datanya keambil gak?

        return view('editUser', compact('data'));
    }

    public function updateUser(Request $request, $id)
    {
        // dd($request->all()); cek datanya berhasil kekirim gak?

        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'username'      => 'required',
            'email'         => 'required|email',
            'unit_kerja'    => 'required',
            'password'      => 'nullable',
            'permission'    => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']          = $request->nama;
        $data['username']      = $request->username;
        $data['email']         = $request->email;
        $data['unit_kerja']    = $request->unit_kerja;
        $data['permission']    = $request->permission;

        if ($request->password) {
            $data['password']  = Hash::make($request->password);
        }

        User::whereId($id)->update($data);

        return redirect()->route('index');
    }


    public function deleteUser(Request $request, $id)
    {
        $data = User::find($id);

        if ($data) {
            $data->delete();
        }

        return redirect()->route('index');
    }



    public function vPasal(){

        $dataPasal = PasalKontrak::get();
        // dd($dataPasal);
        return view('dPasal', compact('dataPasal'));
    }

    public function addPasal(){
        return view('addPasal');
    }

    public function loadPasal(Request $request){
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nama_pasal'        => 'required',
            'keterangan_pasal'  => 'required',
            'isi_pasal'         => 'required',
            'jenis_pasal'       => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['nama_pasal']          = $request->nama_pasal;
        $data['keterangan_pasal']    = $request->keterangan_pasal;
        $data['isi_pasal']           = $request->isi_pasal;
        $data['jenis_pasal']         = $request->jenis_pasal;

        PasalKontrak::create($data);

        return redirect()->route('vPasal');
    }

    public function editPasal(Request $request, $id){
        $data = PasalKontrak::find($id);

        // dd($data);    

        return view('editPasal', compact('data'));
    }

    public function updatePasal(Request $request, $id){
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nama_pasal'        => 'required',
            'keterangan_pasal'  => 'required',
            'isi_pasal'         => 'required',
            'jenis_pasal'       => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['nama_pasal']          = $request->nama_pasal;
        $data['keterangan_pasal']    = $request->keterangan_pasal;
        $data['isi_pasal']           = $request->isi_pasal;
        $data['jenis_pasal']         = $request->jenis_pasal;


        PasalKontrak::whereId($id)->update($data);

        return redirect()->route('vPasal');
    }

    public function deletePasal(Request $request, $id){
        $data = PasalKontrak::find($id);

        if ($data) {
            $data->delete();
        }

        return redirect()->route('vPasal');
    }

}
