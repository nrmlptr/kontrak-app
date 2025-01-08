<?php

namespace App\Http\Controllers;

use App\Models\Improvementtes;
use App\Models\Integrate;
use App\Models\Kontrak;
use App\Models\PasalKontrak;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {

        $dataKontrak = Kontrak::get();
        // =====================================================================================================================
        // $dataSOP     = Integrate::groupBy('purchasing_document_number')->get();
        $dataSOP = Integrate::select('purchasing_document_number', 'document_date', 'tender_name', 'vendor_name')
        ->distinct()
        ->get();
        // =====================================================================================================================
        // ambil nilai data kontrak yang statusnya sudah approvedkadiv
        $dataKontrakAKDV = Kontrak::where('status', 'approvedkadiv')->get();

        // =====================================================================================================================
        // ambil nilai data kontrak yang statusnya selain approvedkadiv
        $dataKontrakProses = Kontrak::whereNotIn('status', ['approvedkadiv'])->get();

        // Ubah struktur data untuk sesuaikan dengan format yang diterima oleh Highcharts
        $dataStatus = $dataKontrak->groupBy('status')->map(function ($group) {
            return $group->count();
        });

        // dd($dataStatus);
        // kecualikan approvekadiv
        $dataStatus = $dataStatus->forget('approvedkadiv');

        // dd($dataStatus);

        // Buat array untuk mapping status ke nama yang ingin ditampilkan di chart
        $statusMapping = [
            'draft'             => 'Draft',
            'konsep'            => 'Konsep',
            'reviewkasek'       => 'Sedang Diperiksa Kasek',
            'revisikasek'       => 'Direvisi oleh Kasek',
            'approvedkasek'     => 'Disetujui Kasek',
            'reviewkadept'      => 'Sedang Diperiksa Kadept',
            'revisikadept'      => 'Direvisi oleh Kadept',
            'approvedkadept'    => 'Disetujui Kadept',
            'reviewkadiv'       => 'Sedang Diperiksa Kadiv',
            'revisikadiv'       => 'Direvisi oleh Kadiv',
            'editedkasek'       => 'Sedang Diperiksa Ulang Kasek',
            'editedkadept'      => 'Sedang Diperiksa Ulang Kasek',
            'editedkadiv'       => 'Sedang Diperiksa Ulang Kasek',
        ];



        $dataStatus = $dataStatus->mapWithKeys(function ($count, $status) use ($statusMapping) {
            $statusName = $statusMapping[$status] ?? $status; // Gunakan nama inisialisasi atau status asli jika tidak ditemukan
            return [$statusName => $count];
        });

        // dd($dataStatus);

        // =====================================================================================================================
        // data kontrak per status jaminan
        $KontrakPerStatusJaminan = $dataKontrak->groupBy('status_jaminan')->map(function ($group) {
            return $group->count();
        });

        // =====================================================================================================================
        // data kontrak per jenis kontrak
        $KontrakperJenisKontrak = $dataKontrak->groupBy('jenis_kontrak')->map(function ($groupJK) {
            return $groupJK->count();
        });

        // =====================================================================================================================
        // Mengelompokkan data kontrak berdasarkan nama vendor dan menghitung jumlah kontrak untuk setiap vendor
        $KontrakPerVendor = $dataKontrak->groupBy('nm_vendor')->map(function ($group) {
            return $group->count();
        });

        // Mengambil 10 vendor dengan jumlah kontrak tertinggi
        $topVendors = $KontrakPerVendor->sortDesc()->take(10);



        $dataImprovement = Improvementtes::get();
        $dataPengadaan = DB::table('improvementtes')->get(); // Ganti 'nama_tabel' dengan nama tabel Anda
        // dd($dataPengadaan); // Lihat data yang diambil

        $results = [];

        // foreach ($dataPengadaan as $item) {
        //     $results[] = [
        //         'tgl_rilis3' => $item->tgl_rilis3,
        //         'tgl_sop' => $item->tgl_sop,
        //     ];
        // }

        // dd($results); // Tampilkan semua hasil setelah loop selesai

        // Siapkan struktur data untuk menampung hasil perhitungan
        $dataPie = [
            'penunjukkan_langsung' => ['sesuai' => 0, 'tidak_sesuai' => 0],
            'tender_terbatas' => ['sesuai' => 0, 'tidak_sesuai' => 0]
        ];

        // Hitung kesesuaian berdasarkan SLA
        foreach ($dataPengadaan as $item) {
            $tglRilis = Carbon::parse($item->tgl_rilis3);
            $tglSOP = Carbon::parse($item->tgl_sop);
            $selisihHari = $tglSOP->diffInDays($tglRilis); // Hitung selisih hari

            // Simpan hasil dalam array untuk ditampilkan nanti
            $results[] = [
                'nomor_pr' => $item->nomor_pr, // Tambahkan nomor_pr jika ada
                'Jenis_metode' => $item->Jenis_metode,
                'tgl_rilis3' => $item->tgl_rilis3,
                'tgl_sop' => $item->tgl_sop,
                'nomor_sop' => $item->nomor_sop,
                'selisih_hari' => $selisihHari,
                'keterangan' => ''
            ];

            // dd($results);

            // Tentukan keterangan dan update dataPie
            if ($item->Jenis_metode == 'Penunjukkan Langsung') {
                if ($selisihHari <= 30) {
                    $dataPie['penunjukkan_langsung']['sesuai']++;
                    $results[count($results) - 1]['keterangan'] = 'Sesuai';
                } else {
                    $dataPie['penunjukkan_langsung']['tidak_sesuai']++;
                    $results[count($results) - 1]['keterangan'] = 'Tidak Sesuai';
                }
            } elseif ($item->Jenis_metode == 'Tender Terbatas') {
                if ($selisihHari <= 50) {
                    $dataPie['tender_terbatas']['sesuai']++;
                    $results[count($results) - 1]['keterangan'] = 'Sesuai';
                } else {
                    $dataPie['tender_terbatas']['tidak_sesuai']++;
                    $results[count($results) - 1]['keterangan'] = 'Tidak Sesuai';
                }
            }
        }

        // Debugging untuk memastikan hasil perhitungan
        // dd($dataPie, $results); // Tampilkan hasil akhir
        // ================================================================================================================================================

        // dd(auth()->user()->getRoleNames());
        return view('dashboard.dashboard', compact('dataKontrak', 'results', 'dataPie', 'dataSOP', 'dataKontrakAKDV', 'dataKontrakProses', 'dataStatus', 'KontrakPerStatusJaminan', 'KontrakperJenisKontrak', 'topVendors'));
    }


    // FUNGSI DETAIL GRAFIK PROSES PEMBUATAN KONTRAK ==========================================================================================================
    public function viewByStatus($status)
    {
        $statusMapping = [
            'draft'             => 'draft',
            'konsep'            => 'konsep',
            'reviewkasek'       => 'reviewkasek',
            'revisikasek'       => 'revisikasek',
            'approvedkasek'     => 'approvedkasek',
            'reviewkadept'      => 'reviewkadept',
            'revisikadept'      => 'revisikadept',
            'approvedkadept'    => 'approvedkadept',
            'reviewkadiv'       => 'reviewkadiv',
            'revisikadiv'       => 'revisikadiv',
            'editedkasek'       => 'editedkasek',
            'editedkadept'      => 'editedkadept',
            'editedkadiv'       => 'editedkadiv',
        ];

        if (!array_key_exists($status, $statusMapping)) {
            abort(404, 'Status not found');
        }

        $statusInDB = $statusMapping[$status];
        // dd($statusInDB);
        $contracts  = Kontrak::where('status', $statusInDB)->get();

        return view('dashboard.viewByStatus', compact('contracts', 'statusInDB'));
    }

    // FUNGSI DETAIL GRAFIK KONTRAK PER STATUS JAMINAN ==========================================================================================================
    public function viewByStatusJaminan($statusJaminan)
    {
        $statusMapping = [
            'jaminan'       => 1,
            'tanpa_jaminan' => 2
        ];

        if (!array_key_exists($statusJaminan, $statusMapping)) {
            abort(404, 'Status not found');
        }

        $statusJaminanInDB  = $statusMapping[$statusJaminan];
        $contracts          = Kontrak::where('status_jaminan', $statusJaminanInDB)->get();

        return view('dashboard.viewByStatusJaminan', compact('contracts', 'statusJaminanInDB'));
    }

    // FUNGSI DETAIL GRAFIK KONTRAK PER JENIS KONTRAK ==========================================================================================================
    public function viewByJenisKontrak($jenisKontrak)
    {
        $statusMapping = [
            'lumpsum'       => 1,
            'harga_satuan'  => 2
        ];

        if (!array_key_exists($jenisKontrak, $statusMapping)) {
            abort(404, 'Status not found');
        }

        $jenisKontrakInDB   = $statusMapping[$jenisKontrak];
        $contracts          = Kontrak::where('jenis_kontrak', $jenisKontrakInDB)->get();

        return view('dashboard.viewByJenisKontrak', compact('contracts', 'jenisKontrakInDB'));
    }

    // FUNGSI DETAIL GRAFIK KONTRAK PER VENDOR ====================================================================================================================
    public function viewByVendor($vendor)
    {
        $vendor     = urldecode($vendor); // Decode the URL-encoded vendor name
        // Log::info('Vendor name after decoding: ' . $vendor);
        $contracts  = Kontrak::where('nm_vendor', $vendor)->get();
        return view('dashboard.viewByVendor', compact('contracts', 'vendor'));
    }

    // FUNGSI VIEW ALL DATA USER ==================================================================================================================================
    public function index()
    {
        $data = User::get();
        return view('users.index', compact('data'));
    }

    // FUNGSI VIEW ADD DATA USER ==================================================================================================================================
    public function addUser()
    {
        $roles = Role::All();
        // dd($roles);
        return view('users.addUser', compact('roles'));
    }

    // FUNGSI SAVE INPUTAN DATA USER ==============================================================================================================================
    public function loadUser(Request $request)
    {
        // dd($request->all());
        $messages = [
            'nama.required'         => 'Kolom nama harus diisi.',
            'username.required'     => 'Kolom username harus diisi.',
            'email.required'        => 'Kolom email harus diisi.',
            'unit_kerja.required'   => 'Kolom unit kerja harus diisi.',
            'password.required'     => 'Kolom password harus diisi.',
            // 'permission.required'   => 'Kolom permission harus diisi.'
        ];

        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'username'      => 'required',
            'email'         => 'required|email',
            'unit_kerja'    => 'required',
            'password'      => 'required',
            // 'permission'    => 'required',
            'roles' => 'required',
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);


        // yang berada dalam index array merupakan field yg ada di db
        // $data['name']           = $request->nama;
        // $data['username']       = $request->username;
        // $data['email']          = $request->email;
        // $data['unit_kerja']     = $request->unit_kerja;
        // $data['password']       = Hash::make($request->password);
        // $data['permission']     = $request->permission;

        // User::create($data);

        $user = User::create([
            'name'          => $request->nama,
            'username'      => $request->username,
            'email'         => $request->email,
            'unit_kerja'    => $request->unit_kerja,
            'password'      => Hash::make($request->password),
        ]);

        $user->roles()->sync($request->roles);

        // NOTIFIKASI
        flash()->addFlash('success', 'Berhasil Menyimpan Data User!');

        return redirect()->route('index');
    }

    // FUNGSI VIEW EDIT DATA USER ============================================================================================================================
    public function editUser(Request $request, $id)
    {
        $data   = User::find($id);
        $roles  = Role::All();

        // dd($data);    -> cek datanya keambil gak?

        return view('users.editUser', compact('data', 'roles'));
    }

    // FUNGSI SIMPAN EDITAN DATA USER ==========================================================================================================================
    public function updateUser(Request $request, $id)
    {
        // dd($request->all()); //cek datanya berhasil kekirim gak?
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'username'      => 'required',
            'email'         => 'required|email',
            'unit_kerja'    => 'required',
            'password'      => 'nullable',
            // 'permission'    => 'required',
            'roles'         => 'required'
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
        // update user data
        // User::whereId($id)->update($data);

        $user->update($data);

        // sinkronisasi roles di tabel role_user
        $user->roles()->sync($request->roles);

        // NOTIFIKASI
        flash()->addFlash('success', 'Berhasil Perbarui Data User!');

        return redirect()->route('index');
    }


    // FUNGSI DELETE DATA USER ================================================================================================================================
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

    // FUNGSI VIEW ALL DATA PASAL ==========================================-===================================================================================
    public function vPasal(Request $request)
    {
        // Inisialisasi query dasar untuk PasalKontrak
        $query = PasalKontrak::query();

        // dd($query);

        // Filter berdasarkan jenis_kontrak jika parameter ada dalam request
        if ($request->jenis_kontrak) {
            $query->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%');
        }

        // Filter berdasarkan status_jaminan jika parameter ada dalam request
        if ($request->status_jaminan) {
            $query->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%');
        }

        if ($request->nama_pasal) {
            $query->where('nama_pasal', 'LIKE', '%' . $request->nama_pasal . '%');
        }

        if($request->keterangan_pasal){
            $query->where('keterangan_pasal', 'LIKE', '%' . $request->keterangan_pasal . '%');
        }

        IF($request->isi_pasal){
            $request->where('isi_pasal', 'LIKE', '%' . $request->isi_pasal . '%');
        }

        // Eksekusi query dan dapatkan hasil
        $dataPasal = $query->get();

        // dd($dataPasal);
        // Kirim hasil filter ke view
        return view('pasal.dPasal', compact('dataPasal'));
    }

    // FUNGSI VIEW ADD DATA PASAL =============================================================================================================================
    public function addPasal()
    {
        return view('pasal.addPasal');
    }

    // FUNGSI SAVE INPUTAN DATA PASAL ==========================================================================================================================
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

    // FUNGSI VIEW EDIT DATA PASAL ============================================================================================================================
    public function editPasal(Request $request, $id)
    {
        $data = PasalKontrak::find($id);

        // dd($data);

        return view('pasal.editPasal', compact('data'));
    }

    // FUNGSI SAVE EDITAN DATA PASAL ==========================================-=================================================================================
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

    // FUNGSI DELETE DATA PASAL ================================================================================================================================
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
