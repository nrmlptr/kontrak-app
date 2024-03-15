<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuinate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function dashboard(){

        // dd(auth()->user()->getRoleNames());
        return view('dashboard');
    }


    public function index(){
        // echo 'ini method index';

        // if (auth()->user()->can('view_user')) {
            $data = User::get();
            return view('index', compact('data'));
        // }

        // return abort(403);

    }

    public function addUser(){
        return view('addUser');
    }

    public function loadUser(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'nama'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'permission'    => 'required'
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']      = $request->nama;
        $data['email']     = $request->email;
        $data['password']  = Hash::make($request->password);
        $data['permission']     = $request->permission;

        User::create($data);

        return redirect()->route('admin.index');
    }

    public function editUser(Request $request,$id){
        $data = User::find($id);

        // dd($data);    -> cek datanya keambil gak?


        return view('editUser', compact('data'));
    }

    public function updateUser(Request $request,$id){
        // dd($request->all()); cek datanya berhasil kekirim gak?

        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'email'     => 'required|email',
            'password'  => 'nullable',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['name']      = $request->nama;
        $data['email']     = $request->email;

        if($request->password){
            $data['password']  = Hash::make($request->password);
        }

        User::whereId($id)->update($data);

        return redirect()->route('admin.index');
    }


    public function deleteUser(Request $request,$id){
        $data = User::find($id);

        if($data){
            $data->delete();
        }

        return redirect()->route('admin.index');
    }
}
