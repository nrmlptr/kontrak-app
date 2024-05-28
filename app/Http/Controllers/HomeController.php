<?php

namespace App\Http\Controllers;

use App\Models\Integrate;
use App\Models\Kontrak;
use App\Models\PasalKontrak;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuinate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    //
    public function dashboard()
    {

        $dataKontrak = Kontrak::get();
        $dataSOP     = Integrate::groupBy('purchasing_document_number')->get();

        // ambil nilai data kontrak yang statusnya sudah approvedkadiv
        $dataKontrakAKDV = Kontrak::where('status', 'approvedkadiv')->get();

        // ambil nilai data kontrak yang statusnya selain approvedkadiv
        $dataKontrakProses = Kontrak::whereNotIn('status', ['approvedkadiv'])->get();


        // Ambil data kontrak dari tabel kontrak
        // $dataKontrak = Kontrak::all();

        // Ubah struktur data untuk sesuaikan dengan format yang diterima oleh Highcharts
        $dataStatus = $dataKontrak->groupBy('status')->map(function ($group) {
            return $group->count();
        });
        // kecualikan approvekadiv
        $dataStatus = $dataStatus->forget('approvedkadiv');


        // data kontrak per status jaminan
        $KontrakPerStatusJaminan = $dataKontrak->groupBy('status_jaminan')->map(function ($group) {
            return $group->count();
        });

        // data kontrak per jenis kontrak
        $KontrakperJenisKontrak = $dataKontrak->groupBy('jenis_kontrak')->map(function ($groupJK) {
            return $groupJK->count();
        });

        // Mengelompokkan data kontrak berdasarkan nama vendor dan menghitung jumlah kontrak untuk setiap vendor
        $KontrakPerVendor = $dataKontrak->groupBy('nm_vendor')->map(function ($group) {
            return $group->count();
        });

        // Mengambil 10 vendor dengan jumlah kontrak tertinggi
        $topVendors = $KontrakPerVendor->sortDesc()->take(10);

        // dd(auth()->user()->getRoleNames());
        return view('dashboard', compact('dataKontrak', 'dataSOP', 'dataKontrakAKDV', 'dataKontrakProses', 'dataStatus', 'KontrakPerStatusJaminan', 'KontrakperJenisKontrak', 'topVendors'));
    }


    // method view data user
    public function index()
    {
        // echo 'ini method index';

        // if (auth()->user()->can('view_user')) {
        $data = User::get();
        return view('index', compact('data'));
        // }

        // return abort(403);

    }

    // method buka form adduser
    public function addUser()
    {
        return view('addUser');
    }

    // method save adduser
    public function loadUser(Request $request)
    {
        // dd($request->all());
        $messages = [
            'nama.required'         => 'Kolom nama harus diisi.',
            'username.required'     => 'Kolom username harus diisi.',
            'email.required'        => 'Kolom email harus diisi.',
            'unit_kerja.required'   => 'Kolom unit kerja harus diisi.',
            'password.required'     => 'Kolom password harus diisi.',
            'permission.required'   => 'Kolom permission harus diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'username'      => 'required',
            'email'         => 'required|email',
            'unit_kerja'    => 'required',
            'password'      => 'required',
            'permission'    => 'required'
        ], $messages);

        if ($validator->fails())
            // flash()->addFlash('error', 'Gagal menyimpan data user, pastikan semua kolom terisi!');
            return redirect()->back()->withInput()->withErrors($validator);


        // yang berada dalam index array merupakan field yg ada di db
        $data['name']           = $request->nama;
        $data['username']       = $request->username;
        $data['email']          = $request->email;
        $data['unit_kerja']     = $request->unit_kerja;
        $data['password']       = Hash::make($request->password);
        $data['permission']     = $request->permission;

        User::create($data);

        // NOTIFIKASI
        flash()->addFlash('success', 'Berhasil Menyimpan Data User!');

        return redirect()->route('index');
    }


    // method buka form edituser
    public function editUser(Request $request, $id)
    {
        $data = User::find($id);

        // dd($data);    -> cek datanya keambil gak?

        return view('editUser', compact('data'));
    }

    // method proses simpan data edit user
    public function updateUser(Request $request, $id)
    {
        // dd($request->all()); //cek datanya berhasil kekirim gak?

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

        // dd($data);

        User::whereId($id)->update($data);

        // NOTIFIKASI 
        flash()->addFlash('success', 'Berhasil Perbarui Data User!');

        return redirect()->route('index');
    }


    public function deleteUser(Request $request, $id)
    {
        $data = User::find($id);

        if ($data) {
            $data->delete();
        }

        // notifikasi
        flash()->addFlash('success', 'Berhasil Hapus Data User!');

        return redirect()->route('index');
    }



    public function vPasal(Request $request)
    {

        $dataPasal = PasalKontrak::get();
        // dd($dataPasal)->count();
        // dd($dataPasal);


        // search by jenis pasal (jaminan atau tanpa jaminan)
        if ($request->jenis_pasal) {
            $data = PasalKontrak::where('jenis_pasal', 'LIKE', '%' . $request->jenis_pasal . '%')->get();
        }


        return view('dPasal', compact('dataPasal'));
    }

    public function addPasal()
    {
        return view('addPasal');
    }

    public function loadPasal(Request $request)
    {
        // dd($request->all());

        $messagesPasal = [
            'nama_pasal.required'       => 'Kolom Nama Pasal Harus Diisi.',
            'keterangan_pasal.required' => 'Kolom Keterangan Pasal harus diisi.',
            'isi_pasal.required'        => 'Kolom Isi Pasal harus diisi.',
            'status_jaminan.required'   => 'Kolom Status Jaminan harus diisi.',
            'jenis_kontrak.required'    => 'Kolom Jenis Kontrak harus diisi.',
            'urutan.required'           => 'Kolom urutan harus diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'nama_pasal'        => 'required',
            'keterangan_pasal'  => 'required',
            'isi_pasal'         => 'required',
            'status_jaminan'    => 'required',
            'jenis_kontrak'     => 'required',
            'urutan'            => 'required',
        ], $messagesPasal);

        if ($validator->fails())
            // flash()->addFlash('error', 'Gagal menyimpan data pasal, pastikan semua kolom terisi!');
            return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['nama_pasal']          = $request->nama_pasal;
        $data['keterangan_pasal']    = $request->keterangan_pasal;
        $data['isi_pasal']           = $request->isi_pasal;
        $data['status_jaminan']      = $request->status_jaminan;
        $data['jenis_kontrak']       = $request->jenis_kontrak;
        $data['urutan']              = $request->urutan;

        PasalKontrak::create($data);

        // nnotifikasi berhasil
        flash()->addFlash('success', 'Berhasil Menyimpan Data Pasal!');

        return redirect()->route('vPasal');
    }

    public function editPasal(Request $request, $id)
    {
        $data = PasalKontrak::find($id);

        // dd($data);    

        return view('editPasal', compact('data'));
    }

    public function updatePasal(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nama_pasal'        => 'required',
            'keterangan_pasal'  => 'required',
            'isi_pasal'         => 'required',
            'status_jaminan'    => 'required',
            'jenis_kontrak'     => 'required',
            'urutan'            => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['nama_pasal']          = $request->nama_pasal;
        $data['keterangan_pasal']    = $request->keterangan_pasal;
        $data['isi_pasal']           = $request->isi_pasal;
        $data['status_jaminan']      = $request->status_jaminan;
        $data['jenis_kontrak']       = $request->jenis_kontrak;
        $data['urutan']              = $request->urutan;


        PasalKontrak::whereId($id)->update($data);

        // NOTIFIKASI 
        flash()->addFlash('success', 'Berhasil Perbarui Data Pasal!');

        return redirect()->route('vPasal');
    }

    public function deletePasal(Request $request, $id)
    {
        $data = PasalKontrak::find($id);

        if ($data) {
            $data->delete();
        }

        // notifikasi
        flash()->addFlash('success', 'Berhasil Hapus Data Pasal!');

        return redirect()->route('vPasal');
    }
}
