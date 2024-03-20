<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\User;
use App\Models\Integrate;
use App\Models\Lampiran1;
use App\Models\Lampiran2;
use App\Models\Lampiran3;
use App\Models\Lampiran4;
use App\Models\Lampiran5;
use App\Models\Lampiran6;
use App\Models\Lampiran7;
use App\Models\PasalKontrak;
use App\Models\revisiKontrak;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use File;

// use Spatie\LaravelIgnition\Exceptions\ViewException;



class KontrakController extends Controller
{
    public function index()
    {
        echo "tes integrate kontrak";
    }

    // methode untuk sinkron data dari sistem lain
    public function syncron()
    {
        $url        = 'https://scm.peruri.co.id/Api/getsiapda';
        $client     = new Client();
        $request    = $client->request('GET', $url, ['verify' => false]);
        $collection = collect(json_decode($request->getBody()));
        // dd($request->getBody());
        // buat array kosong untuk nanti tampung datanya
        $inputData  = array();
        Integrate::truncate();

        foreach ($collection as $col) {
            // dd($col);
            $inputData = [
                'no_spph'                         => $col->no_spph,
                'tender_name'                     => $col->tender_name,
                'purchasing_document_number'      => $col->purchasing_document_number,
                'document_date'                   => $col->document_date,
                'po_delivery_date'                => $col->po_delivery_date,
                'vendors_account_number'          => $col->vendors_account_number,
                'registration_no'                 => $col->registration_no,
                'vendor_name'                     => $col->vendor_name,
                'purchasing_group'                => $col->purchasing_group,
                'material_number'                 => $col->material_number,
                'material_name'                   => $col->material_name,
                'purchase_order_quantity'         => (int)$col->purchase_order_quantity,
                'purchase_order_unit_of_measure'  => $col->purchase_order_unit_of_measure,
                'purchase_requisition_number'     => $col->purchase_requisition_number,
                'net_price'                       => (int)$col->net_price * 10,
                'alamat'                          => $col->alamat,
                'kode_pos'                        => $col->kode_pos,
                'kota'                            => $col->kota,
                'provinsi'                        => $col->provinsi
            ];

            // dd($inputData);
            Integrate::updateOrCreate($inputData);
        }

        // return redirect('/dashboard');
    }


    public function getdataSOP(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Integrate::select("purchasing_document_number", "vendor_name", "document_date", "tender_name")
                ->where('purchasing_document_number', 'LIKE', "%$search%")
                ->orWhere('vendor_name', 'LIKE', "%$search%")
                ->groupBy('purchasing_document_number', 'vendor_name', 'document_date', 'tender_name') // Memasukkan kolom 'vendor_name' ke dalam klausa 'GROUP BY'
                ->orderBy('purchasing_document_number')
                ->get();

            if ($data->isEmpty()) {
                return response()->json('Tidak ada data yang cocok ditemukan.');
            } else {
                return response()->json($data);
            }
        }

        return response()->json($data);
    }


    // public function vendor_data($no_vendor)
    // {
    //     $url = 'https://scm.peruri.co.id/Api/getsiapdainfo/' . $no_vendor;
    //     $client = new Client();
    //     $request = $client->request('GET', $url, ['verify' => false]);
    //     $collection = collect(json_decode($request->getBody()));
    //     // dd($collection);
    //     $data = $collection->where('board_type', "BOD (Board of Director) – Direksi")->first();
    //     return $data;
    // }

    public function vendor_data($no_vendor)
    {
        $url            = 'https://scm.peruri.co.id/Api/getsiapdainfo/' . $no_vendor;
        $client         = new Client();
        $request        = $client->request('GET', $url, ['verify' => false]);
        $collection     = collect(json_decode($request->getBody()));
        // dd($collection);
        $data           = $collection->where('board_type', "BOD (Board of Director) – Direksi")->first();
        // dd($data);
        // Ambil informasi alamat vendor
        $alamat_vendor = $collection->pluck('alamat')->first();
        $kota = $collection->pluck('kota')->first();
        $provinsi = $collection->pluck('provinsi')->first();
        $kode_pos = $collection->pluck('kode_pos')->first();

        // Formatkan data dan kirimkan kembali sebagai respons
        $data2 = [
            'alamat' => $alamat_vendor,
            'kota' => $kota,
            'provinsi' => $provinsi,
            'kode_pos' => $kode_pos
        ];

        dd($data2);

        return response()->json($data2);
        return $data;
    }

    // public function vendor_data(Request $request){
    //     $dataVendor     = DB::table('integrates')
    //     ->join('kontraks', 'integrates.purchasing_document_number', '=', 'kontraks.nomor_sop')
    //     ->where('kontraks.nomor_sop', $request->po)
    //         ->select('integrates.*')
    //         ->get();

    //     return response()->json($dataVendor);
    // }

    // public function dataBarang(Request $request)
    // {
    //     $data = Integrate::where('purchasing_document_number', $request->po)->get();

    //     return response()->json($data);
    // }

    // public function dataBarang(Request $request)
    // {
    //     try {
    //         // Mendapatkan data kontrak berdasarkan nomor SOP
    //         $kontrak = Kontrak::where('nomor_sop', $request->po)->firstOrFail();

    //         // Mendapatkan data barang berdasarkan nomor PO
    //         $dataBarang = Integrate::where('purchasing_document_number', $request->po)->first();

    //         // Jika data barang ditemukan, kirim sebagai response JSON
    //         return response()->json([
    //             'kontrak' => $kontrak,
    //             'dataBarang' => $dataBarang
    //         ]);
    //     } catch (ModelNotFoundException $exception) {
    //         // Jika kontrak atau data barang tidak ditemukan, kirim pesan error
    //         return response()->json(['error' => 'Data tidak ditemukan'], 404);
    //     }
    // }

    public function dataBarang(Request $request)
    {
        $dataBarang = DB::table('integrates')
            ->join('kontraks', 'integrates.purchasing_document_number', '=', 'kontraks.nomor_sop')
            ->where('kontraks.nomor_sop', $request->po)
            ->select('integrates.*')
            ->get();

        return response()->json($dataBarang);
    }

    public function indexKontrak()
    {
        // echo 'monitoring kontrak';
        // $data = Kontrak::get();
        $data = Kontrak::Unitkerja()->orderBy('date_kontrak', 'desc')->get();
        // "select * from contracts where unit_kerja='4120'";


        // // cek apakah dalam tabel lampiran7 sudah input lampiran7 dengan nomor id tersebut belum?
        // $DLampiran7 = Lampiran7::where('kontraks_id', $request->kontraks_id);
        // // return $DLampiran7;
        // // kalau sudah nanti hilangkan tombol add lampirannya
        // $cekDataLampiran7 = $DLampiran7->doesntExist();

        return view('indexKontrak', compact('data'));
    }


    public function addKontrak()
    {

        // echo 'form add kontrak';
        // if (auth()->user()->can('view_input')) {
        return view('addKontrak');
        // }

        // return abort(403);
    }


    public function storeKontrak(Request $request)
    {
        // dd($request->all());

        // Validasi data
        $validated = $request->validate([
            'number'        => 'required',
            'perihal'       => 'required',
            'date_kontrak'  => 'required',
            'nomor_sop'     => 'required',
            'tanggal_sop'   => 'required',
            'jenis_kontrak' => 'required',

        ], [
            'number.required'           => 'Wajib di isi',
            'perihal.required'          => 'Wajib di isi',
            'date_kontrak.required'     => 'Wajib di isi',
            'nomor_sop.required'        => 'Wajib di isi',
            'tanggal_sop.required'      => 'Wajib di isi',
            'jenis_kontrak.required'    => 'Wajib di isi'
        ]);

        // Mengonversi nilai jenis kontrak menjadi angka
        $jenisKontrakValue = ($request->jenis_kontrak == 'jaminan') ? 1 : 2;

        // Mendapatkan tahun saat ini menggunakan Carbon
        $tahunSekarang = Carbon::now()->year;

        // Menggunakan tahun tersebut dalam pembuatan string
        $detailNumber = 'SP-' . $request->number . '/VIII/' . $tahunSekarang;

        $validated['detail_number'] = $detailNumber;
        $validated['pembuat']       = Auth::user()->name;
        $validated['jenis_kontrak'] = $jenisKontrakValue;
        $validated['status']        = 'draft';
        $validated['unit_kerja']    = Auth::user()->unit_kerja;

        // dd($validated);
        Kontrak::updateOrCreate($validated);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        // return response()->json(['message' => 'Kontrak Berhasil Dibuat.']);

        // return redirect()->route('indexKontrak')->with('success', 'Kontrak Berhasil Dibuat.');
        return response()->json(['message' => 'Kontrak Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }


    // METHOD TAMPIL VIEW LAMPIRAN INPUT
    public function addLampiran(Request $request, $id)
    {
        // echo 'form add lampiran';
        // if (auth()->user()->can('view_input')) {
        // $data = Kontrak::get();
        // dd($data);
        // return view('addLampiran', compact('id', 'data'));
        // }

        // return abort(403);

        $data = Kontrak::find($id);
        // $data2 = $this->vendor_data($no_vendor); 
        // $api=Integrates::where('puca', $data->nomosop);
        // dd($data->id);

        return view('addLampiran')->with('data', $data);
        // return view('addLampiran', compact('data','api'));
    }


    // METHOD input lampiran 1
    public function storeLampiran1(Request $request)
    {
        // dd($request->all());

        $data_lampiran1 = [];

        foreach ($request->perihal as $key => $val) {
            $data_lampiran1[] = [
                'nomor_urut'    => $key + 1,
                'perihal'       => $val,
                'nomor_surat'   => $request->nomor_surat[$key],
                'tanggal_surat' => $request->tanggal_surat[$key]
            ];
        }

        $data_store = json_encode($data_lampiran1);
        // cek dulu sini
        $lampiran = Lampiran1::where('kontraks_id', $request->kontraks_id);
        // return $lampiran;
        $chek = $lampiran->doesntExist();
        if ($chek) {
            // kalo ga ada pasti di insert
            Lampiran1::create(
                ['kontraks_id' => $request->kontraks_id, 'data_json' => $data_store]
            );
        } else {
            // kita update disni kalo udah ada datanya
            // step 1 hapus dulu data lama
            // step 2 create ulang
            $lampiran = $lampiran->delete();
            Lampiran1::create(
                ['kontraks_id' => $request->kontraks_id, 'data_json' => $data_store]
            );
        }
        // dd($data_store);


        // return response()->json(['message' => 'Lampiran 1 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);

        return response()->json(['message' => 'Lampiran 1 Berhasil Dibuat']);
        // return redirect()->route('createLampiran');
    }


    // METHOD INPUT LAMPIRAN 2
    public function storeLampiran2(Request $request)
    {
        // dd($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'   => 'required',
            'perihal'       => 'required',
            'nomor_sop'     => 'required',
            'tanggal_sop'   => 'required',
        ]);

        // yang berada dalam index array merupakan field yg ada di db
        $data['kontraks_id']        = $request->kontraks_id;
        $data['perihal']            = $request->perihal;
        $data['nomor_sop']          = $request->nomor_sop;
        $data['tanggal_sop']        = $request->tanggal_sop;

        // Simpan data ke database
        Lampiran2::updateOrCreate($data);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat']);

        // return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    public function storeLampiran3(Request $request)
    {
        dd($request->file());
        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'           => 'required',
            'jspek'                 => 'required',
            'gambar'                => 'required_if:jspek,1|array',
            // 'gambar.*'              => 'image|mimes:png,jpg,peg,webp',
            'spesifikasi_teknis'    => 'required_if:jspek,2',
            'no_sppb'               => 'required',
            'kode_barang'           => 'required',
            'nama_barang'           => 'required',
        ]);

        $kontraksId = $validatedData['kontraks_id'];
        $jenisSpesifikasi = $validatedData['jspek'];
        $gambar = $validatedData['gambar'];
        $spesifikasiTeknis = $validatedData['spesifikasi_teknis'];
        $noSppb = $validatedData['no_sppb'];
        $kodeBarang = $validatedData['kode_barang'];
        $namaBarang = $validatedData['nama_barang'];

        // Simpan nilai dari radio button
        $Jspek = $jenisSpesifikasi;

        $data = [
            'kontraks_id'       => $request->$kontraksId,
            'jenis_spesifikasi' => $Jspek,
            'spesifikasi_teknis' => $request->$spesifikasiTeknis,
            'no_sppb'           => $request->$noSppb,
            'kode_barang'       => $request->$kodeBarang,
            'jenis_barang'      => $request->$namaBarang
        ];

        $dataGambar = [];
        // Jika jenis spesifikasi adalah standar lab
        if ($Jspek == 1) {
            if ($files = $gambar) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '' . $extension;

                    $path = "uploads/spesifikasi_teknis/";

                    $file->move($path, $filename);

                    $dataGambar[] = [
                        'kontraks_id'         => $request->$kontraksId,
                        'jenis_spesifikasi'   => $Jspek,
                        'gambar'              => $path . $filename,
                    ];
                }

                Lampiran3::insert($dataGambar);
            }
        } elseif ($request->jspek == 2) {
            // Masukkan data spesifikasi teknis dari form textarea
            $data = [
                'kontraks_id'         => $request->$kontraksId,
                'jenis_spesifikasi'   => $Jspek,
                'spesifikasi_teknis'  => $request->$spesifikasiTeknis,
                'no_sppb'             => $request->$noSppb,
                'kode_barang'         => $request->$kodeBarang,
                'jenis_barang'        => $request->$namaBarang,
            ];

            Lampiran3::insert($data);
        }

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 3 Berhasil Dibuat']);
    }



    public function storeLampiran4(Request $request)
    {
        // dd($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'               => 'required',
            'nomor_sop'                 => 'required',
            'tanggal_sop'               => 'required',
            'lokasi'                    => 'required',
            'jadwal_penyerahan_barang'  => 'required',
        ]);

        // yang berada dalam index array merupakan field yg ada di db
        $data['kontraks_id']               = $request->kontraks_id;
        $data['nomor_sop']                 = $request->nomor_sop;
        $data['tanggal_sop']               = $request->tanggal_sop;
        $data['lokasi']                    = $request->lokasi;
        $data['jadwal_penyerahan_barang']  = $request->jadwal_penyerahan_barang;


        // Simpan data ke database
        Lampiran4::updateOrCreate($data);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 4 Berhasil Dibuat']);

        // return response()->json(['message' => 'Lampiran 4 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }


    public function storeLampiran5(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'kontraks_id'       => 'required',
            'no_sppb'           => 'required',
            'nama_barang'       => 'required',
            'harga_awal'        => 'required',
            'jumlah'            => 'required',
            'ppn'               => 'required',
            'harga_akhir'       => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // yang berada dalam index array merupakan field yg ada di db
        $data['kontraks_id']    = $request->kontraks_id;
        $data['no_sppb']        = $request->no_sppb;
        $data['nama_barang']    = $request->nama_barang;
        $data['harga_awal']     = $request->harga_awal;
        $data['qty']            = $request->jumlah;
        $data['ppn']            = $request->ppn;
        $data['harga_akhir']    = $request->harga_akhir;


        Lampiran5::create($data);

        return response()->json(['message' => 'Lampiran 5 Berhasil Dibuat']);
        // return response()->json(['message' => 'Lampiran 5 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    public function storeLampiran6(Request $request)
    {
        // dd($request->all());

        // Simpan nilai dari radio button
        $jenis_pembayaran = $request->jpemb;

        $data = [
            'kontraks_id'       => $request->kontraks_id,
            'nomor_sop'         => $request->no_sppb,
            'tanggal_sop'       => $request->kode_barang,
            'no_kontrak'        => $request->lokasi,
            'date_kontrak'      => $request->nama_barang,
            'jenis_pembayaran'  => $jenis_pembayaran,
            'lama_pembayaran'   => $request->lama_pembayaran1 || $request->lama_pembayaran2,
        ];


        // Jika jenis spesifikasi adalah standar lab
        if ($request->jpemb == 1) {
            // Masukkan data pembayaran langsung dari form 
            $data['kontraks_id']        = $request->kontraks_id;
            $data['nomor_sop']          = $request->nomor_sop;
            $data['tanggal_sop']        = $request->tanggal_sop;
            $data['no_kontrak']         = $request->no_kontrak;
            $data['date_kontrak']       = $request->date_kontrak;
            $data['jenis_pembayaran']   = $jenis_pembayaran;
            $data['lama_pembayaran']    = $request->lama_pembayaran1;
        } elseif ($request->jpemb == 2) {
            // Masukkan data pembayaran bertahap dari form 
            $data['kontraks_id']        = $request->kontraks_id;
            $data['nomor_sop']          = $request->nomor_sop;
            $data['tanggal_sop']        = $request->tanggal_sop;
            $data['no_kontrak']         = $request->no_kontrak;
            $data['date_kontrak']       = $request->date_kontrak;
            $data['jenis_pembayaran']   = $jenis_pembayaran;
            $data['lama_pembayaran']    = $request->lama_pembayaran2;
        }

        // dd($data);

        // Simpan data ke database
        Lampiran6::updateOrCreate($data);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 6 Berhasil Dibuat']);
        // return response()->json(['message' => 'Lampiran 6 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }


    // public function storeLampiran7(Request $request)
    // {
    //     // dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'kontraks_id'   => 'required',
    //         'alamat_peruri' => 'required',
    //         'alamat_vendor' => 'required',
    //     ]);

    //     if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

    //     // yang berada dalam index array merupakan field yg ada di db
    //     $data['kontraks_id']   = $request->kontraks_id;
    //     $data['alamat_peruri'] = $request->alamat_peruri;
    //     $data['alamat_vendor'] = $request->alamat_vendor;

    //     Lampiran7::create($data);

    //     // return response()->json(['message' => 'Lampiran 7 Berhasil Dibuat']);
    //     return response()->json(['message' => 'Lampiran 7 Berhasil Dibuat', 'redirect' => route('rKontrak')]);
    // }
    public function storeLampiran7(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kontraks_id'   => 'required',
            'alamat_peruri' => 'required',
            'alamat_vendor' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withInput()->withErrors($validator);

        // Simpan data ke dalam tabel Lampiran7
        $data['kontraks_id']   = $request->kontraks_id;
        $data['alamat_peruri'] = $request->alamat_peruri;
        $data['alamat_vendor'] = $request->alamat_vendor;

        Lampiran7::create($data);

        // Perbarui status kontrak menjadi 'reviewkasek'
        $kontrak = Kontrak::find($request->kontraks_id);
        if ($kontrak) {
            $kontrak->status = 'reviewkasek';
            $kontrak->save();
        }

        // Response JSON dengan pesan sukses dan redirect ke halaman monitoring
        return response()->json(['message' => 'Lampiran 7 Berhasil Dibuat', 'redirect' => route('rKontrak')]);
    }


    // METHOD PRINT KONTAK TES
    public function printKontrak()
    {
        $pasalKJaminan = Kontrak::all();
        return view('printKontrak', compact('pasalKJaminan'));
    }

    public function rKontrak()
    {
        $data = Kontrak::Unitkerja()->orderBy('date_kontrak', 'desc')->get();
        // "select * from contracts where unit_kerja='4120'";
        return view('rKontrak', compact('data'));
    }

    // method detail kontrak
    // public function showKontrak(Request $request, $id)
    // {
    //     // AMBIL DATA PASAL
    //     $dataPasal = PasalKontrak::get();
    //     // dd($dataPasal);
    //     // Mengambil data kontrak
    //     $data = Kontrak::get();
    //     // $data = Kontrak::with('lampiran1')->find($id);

    //     // Mengambil data lampiran1 terkait dengan kontrak
    //     // $lampiran1 = $data->lampiran1;

    //     // dd($lampiran1);
    //     return view('showKontrak', compact('data', 'dataPasal'));
    // }

    // method detail kontrak
    public function showKontrak(Request $request, $id)
    {
        // AMBIL DATA PASAL
        $dataPasal = PasalKontrak::get();
        // dd($dataPasal);

        // Mengambil data kontrak berdasarkan ID yang diberikan
        $data = Kontrak::findOrFail($id);

        return view('showKontrak', compact('data', 'dataPasal'));
    }



    public function addRevisi(Request $request, $id)
    {
        $data = Kontrak::find($id);

        return view('addRevisi')->with('data', $data);
    }

    public function storeRevisi(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'kontraks_id'   => 'required',
            'revisi'        => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // Simpan data ke dalam tabel Lampiran7
        $data['kontraks_id']   = $request->kontraks_id;
        $data['revisi']        = $request->revisi;

        revisiKontrak::create($data);

        // Response JSON dengan pesan sukses dan redirect ke halaman monitoring
        return response()->json(['message' => 'Revisi Berhasil Dibuat', 'redirect' => route('rKontrak')]);
    }

    public function showRevisi($id)
    {
        // Ambil data revisi berdasarkan kontraks_id
        $revisi = revisiKontrak::where('kontraks_id', $id)->first();

        // Tampilkan view untuk menampilkan data revisi
        return view('viewRevisi', compact('revisi'));
    }

    public function updateLampiran(Request $request, $id)
    {
        // echo 'form edit lampiran';
        // if (auth()->user()->can('view_input')) {
        // $data = Kontrak::get();
        // dd($data);
        // return view('addLampiran', compact('id', 'data'));
        // }

        // return abort(403);

        $data = Kontrak::find($id);
        // $data2 = $this->vendor_data($no_vendor); 
        // $api=Integrates::where('puca', $data->nomosop);
        // dd($data->id);

        return view('editLampiran')->with('data', $data);
    }


    public function editLampiran1(Request $request)
    {
        // dd($request->all());
        $data_lampiran1 = [];

        foreach ($request->perihal as $key => $val) {
            $data_lampiran1[] = [
                'nomor_urut'    => $key + 1,
                'perihal'       => $val,
                'nomor_surat'   => $request->nomor_surat[$key],
                'tanggal_surat' => $request->tanggal_surat[$key]
            ];
        }

        $data_store = json_encode($data_lampiran1);
        // cek dulu sini
        $lampiran = Lampiran1::where('kontraks_id', $request->kontraks_id);
        // return $lampiran;
        $chek = $lampiran->exists();
        if ($chek) {
            // Jika catatan dengan kontraks_id tersebut sudah ada, perbarui data_json
            Lampiran1::where('kontraks_id', $request->kontraks_id)->update([
                'data_json' => $data_store
            ]);
        }
        // dd($data_store);

        // return response()->json(['message' => 'Lampiran 1 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);

        return response()->json(['message' => 'Lampiran 1 Berhasil Diperbarui']);
        // return redirect()->route('createLampiran');
    }
}
