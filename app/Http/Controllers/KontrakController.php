<?php

namespace App\Http\Controllers;

use App\Exports\KontrakExport;
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
use App\Models\LogContract;
use App\Models\PasalKontrak;
use App\Models\revisiKontrak;
use App\Models\Setting;
use App\Models\Vendor;
use App\Models\VendorText;
use App\Notifications\KontrakApprovedNotification;
use App\Notifications\KontrakReviewEditNotification;
use App\Notifications\KontrakRevisiNotification;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// use Spatie\LaravelIgnition\Exceptions\ViewException;



class KontrakController extends Controller
{
    public function index()
    {
        echo "tes integrate kontrak";
    }

    // methode untuk sinkron data dari sistem lain
    // BENERIN KOLOM DI METHOD SYNCRON BUAT TABEL INTEGRATENYA 
    public function syncron()
    {
        $url        = 'https://scm.peruri.co.id/Api/getsiapda';
        $client     = new Client();
        $request    = $client->request('GET', $url, ['verify' => false]);
        $collection = collect(json_decode($request->getBody()));
        // dd($collection->count());
        // dd($request->getBody());
        // buat array kosong untuk nanti tampung datanya
        $inputData  = array();
        Integrate::truncate();

        foreach ($collection as $col) {
            // dd($col);
            $tanggalSPPH = $col->tgl_spph;
            $tglSPPHSQL = date('Y-m-d H:i:s', strtotime($tanggalSPPH));
            $tanggalWaktu = $col->tgl_sp3_approve; // Ambil nilai tanggal dan waktu dari kolom tgl_sp3_approve
            $tanggalWaktuMySQL = date('Y-m-d H:i:s', strtotime($tanggalWaktu)); // Format nilai ke dalam format yang sesuai dengan MySQL

            $inputData = [
                'no_spph'                            => $col->no_spph,
                'tgl_spph'                           => $tglSPPHSQL,
                'no_sp3'                             => $col->no_sp3,
                'tgl_sp3_approve'                    => $tanggalWaktuMySQL,
                'schedule_from_time'                 => $col->schedule_from_time,
                'schedule_thru_time'                 => $col->schedule_thru_time,
                'tender_name'                        => $col->tender_name,
                'purchasing_document_number'         => $col->purchasing_document_number,
                'document_date'                      => $col->document_date,
                'po_delivery_date'                   => $col->po_delivery_date,
                'vendors_account_number'             => $col->vendors_account_number,
                'registration_no'                    => $col->registration_no,
                'vendor_name'                        => $col->vendor_name,
                'purchasing_document_type'           => $col->purchasing_document_type,
                'purchasing_group'                   => $col->purchasing_group,
                'material_group'                     => $col->material_group,
                'material_number'                    => $col->material_number,
                'material_name'                      => $col->material_name,
                'purchase_requisition_number'        => $col->purchase_requisition_number,
                'requisition_date'                   => $col->requisition_date,
                'item_number_of_purchasing_document' => $col->item_number_of_purchasing_document,
                'purchase_order_quantity'            => (int) str_replace(['.', ','], '', $col->purchase_order_quantity),
                'purchase_order_unit_of_measure'     => $col->purchase_order_unit_of_measure,
                'net_price'                          => (int) str_replace(['.', ','], '', $col->net_price),
                'condition_value'                    => $col->condition_value,
                'alamat'                             => $col->alamat,
                'kecamatan'                          => $col->sub_district,
                'kota'                               => $col->kota,
                'provinsi'                           => $col->provinsi,
                'kode_pos'                           => $col->kode_pos,
                'negara'                             => $col->negara,
                'no_hp'                              => $col->phone_number,
                'website'                            => $col->website,
                'email_perusahaan'                   => $col->company_email,
                'kategori_lokasi'                    => $col->location_category


            ];

            // dd($inputData);
            Integrate::create($inputData);
        }
    }


    // public function getdataSOP(Request $request)
    // {
    //     $data = [];

    //     if ($request->has('q')) {
    //         $search = $request->q;
    //         $data = Integrate::select("purchasing_document_number", "vendor_name", "document_date", "tender_name")
    //             ->with('vendorText') // Mengambil data VendorText
    //             ->where('purchasing_document_number', 'LIKE', "%$search%")
    //             ->orWhere('vendor_name', 'LIKE', "%$search%")
    //             ->groupBy('purchasing_document_number', 'vendor_name', 'document_date', 'tender_name') // Memasukkan kolom 'vendor_name' ke dalam klausa 'GROUP BY'
    //             ->orderBy('purchasing_document_number')
    //             ->get();
    //         if ($data->isEmpty()) {
    //             return response()->json('Tidak ada data yang cocok ditemukan.');
    //         } else {
    //             // dd($data);
    //             return response()->json($data);
    //         }
    //     }

    //     return response()->json($data);
    // }

    public function getdataSOP(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Integrate::select("integrates.purchasing_document_number", "integrates.vendor_name", "integrates.document_date", "integrates.tender_name", "vendor_texts.akta")
                ->leftJoin('vendor_texts', 'integrates.registration_no', '=', 'vendor_texts.registration_no') // Melakukan left join dengan tabel vendortext
                ->where('integrates.purchasing_document_number', 'LIKE', "%$search%")
                ->orWhere('integrates.vendor_name', 'LIKE', "%$search%")
                ->groupBy('integrates.purchasing_document_number', 'integrates.vendor_name', 'integrates.document_date', 'integrates.tender_name', 'vendor_texts.akta') // Memasukkan kolom-kolom ke dalam klausa GROUP BY
                ->orderBy('integrates.purchasing_document_number')
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
        $cek = Vendor::where('registration_no', $no_vendor);
        if ($cek->doesntExist()) {
            $dataVendor = json_decode(Http::timeout(60)
                ->withOptions(['verify' => false])
                ->get("https://scm.peruri.co.id/Api/getsiapdainfo/$no_vendor"), true);

            // return $dataVendor;
            $dataSave = [];
            foreach ($dataVendor as $v) {
                $dataSave[] = [
                    'registration_no'       => $v['registration_no'],
                    'sap_code'              => $v['sap_code'],
                    'alamat'                => $v['alamat'],
                    'sub_district'          => $v['sub_district'],
                    'kota'                  => $v['kota'],
                    'provinsi'              => $v['provinsi'],
                    'kode_pos'              => $v['kode_pos'],
                    'negara'                => $v['negara'],
                    'board_type'            => showEncodeChar($v['board_type']),
                    'primary_data'          => $v['primary_data'],
                    'full_name'             => $v['full_name'],
                    'citizenship'           => $v['citizenship'],
                    'position'              => $v['position'],
                    'email'                 => $v['email'],
                    'phone_number'          => $v['phone_number'],
                    'website'               => $v['website'],
                    'company_email'         => $v['company_email'],
                    'location_category'     => $v['location_category'],
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
            }

            $save = Vendor::insert($dataSave);
            $alamatnya = $dataVendor[0]['alamat'] . '<br>' . $dataVendor[0]['sub_district'] . '<br>' . $dataVendor[0]['kota'] . '<br>' . $dataVendor[0]['provinsi'] . '<br>' . $dataVendor[0]['kode_pos'] . '<br>' .  $dataVendor[0]['negara'];
        } else {
            $row = $cek->first();
            $alamatnya = $row->alamat . '<br>' . $row->sub_district . '<br>' . $row->kota . '<br>' . $row->provinsi . '<br>' . $row->kode_pos . '<br>' . $row->negara;
        }
        return response()->json(['alamat' => $alamatnya]);
        // return $data;
    }

    // public function dataBarang(Request $request)
    // {
    //     $dataBarang = DB::table('integrates')
    //         ->join('kontraks', 'integrates.purchasing_document_number', '=', 'kontraks.nomor_sop')
    //         ->where('kontraks.nomor_sop', $request->po)
    //         ->select('integrates.*')
    //         ->get();

    //     return response()->json($dataBarang);
    // }

    public function dataBarang(Request $request)
    {
        $dataBarang = DB::table('integrates')
            ->join('kontraks', 'integrates.purchasing_document_number', '=', 'kontraks.nomor_sop')
            ->where('kontraks.nomor_sop', $request->po)
            ->select('integrates.*', DB::raw('TRIM(LEADING "0" FROM integrates.purchase_requisition_number) as purchase_requisition_number'))
            ->get();

        return response()->json($dataBarang);
    }


    public function indexKontrak()
    {
        // echo 'monitoring kontrak';
        // $data = Kontrak::get();
        $data = Kontrak::orderBy('created_at', 'desc')->get();
        // $data = Kontrak::Unitkerja()->orderBy('date_kontrak', 'desc')->get();
        // "select * from contracts where unit_kerja='4120'";

        return view('indexKontrak', compact('data'));
    }


    public function addKontrak()
    {

        // echo 'form add kontrak';
        // if (auth()->user()->can('view_input')) {
        $setting    = Setting::find(1);
        // $setVendor = VendorText::where('registration_no', $request->nomor_sop)->first();
        return view('addKontrak', compact('setting'));
        // }

        // return abort(403);
    }


    public function storeKontrak(Request $request)
    {
        // dd($request->all());
        extract($request->all());
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
        $status = 'draft';
        $validated['detail_number'] = $detailNumber;
        $validated['pembuat']       = Auth::user()->name;
        $validated['jenis_kontrak'] = $jenisKontrakValue;
        $validated['status']        = $status;
        $validated['peruritext']    = $peruri_text;
        $validated['vendortext']    = $akta;
        $validated['unit_kerja']    = Auth::user()->unit_kerja;

        // dd($validated);
        $save = Kontrak::create($validated);
        // insert log Kontrak
        $save->logs()->create([
            'status' => $status,
            'user_id' => auth()->id(),
        ]);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        // return response()->json(['message' => 'Kontrak Berhasil Dibuat.']);

        // return redirect()->route('indexKontrak')->with('success', 'Kontrak Berhasil Dibuat.');
        return response()->json(['message' => 'Kontrak Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    // method hapus kontrak  ==================================================================================================
    public function deleteKontrak(Request $request, $id)
    {
        $kontrak = Kontrak::find($id);

        if ($kontrak) {
            $kontrak->delete(); // kontrak data table delete
            // revisi hapus
            $kontrak->revisiKontraks()->delete();
            //lampiran 1 delete jg
            $kontrak->lampiran1()->delete();
            $kontrak->lampiran2()->delete();
            $kontrak->lampiran3()->delete();
            $kontrak->lampiran4()->delete();
            $kontrak->lampiran5()->delete();
            $kontrak->lampiran6()->delete();
            $kontrak->lampiran7()->delete();
            $kontrak->logs()->delete();
        }

        return redirect()->route('indexKontrak');
    }

    // METHOD TAMPIL VIEW LAMPIRAN INPUT
    public function addLampiran(Request $request, $id)
    {
        //    dd($id);
        // $data = Kontrak::find($id);
        // $data2 = $this->vendor_data($no_vendor); 
        // $api=Integrates::where('puca', $data->nomosop);

        // TAMBAHIN QUERY BUAT NGAMBIL BEBERAPA DATA DARI API UNTUK INPUT DI LAMPIRAN 1
        $data = Kontrak::join('integrates', 'kontraks.nomor_sop', '=', 'integrates.purchasing_document_number')
            ->where('kontraks.id', $id)
            ->select('kontraks.*', 'integrates.purchase_requisition_number', 'integrates.no_spph', 'integrates.tgl_spph', 'integrates.no_sp3', 'integrates.tgl_sp3_approve', 'integrates.purchasing_group')
            ->first();

        // dd($data);

        // Ilangin dua nol depan nomor pr
        $noSPPB = ltrim($data->purchase_requisition_number, '0');
        // dd($noSPPB);
        // Mengambil dua angka terakhir dari tahun tanggal_sop
        $tahunSop = date('y', strtotime($data->tanggal_sop));

        // Gabungkan nilai nomor_sop, purchasing_group, dan tahunSop/tahunDocument
        $valueNomorSop = $data->purchasing_group . $tahunSop . $data->nomor_sop;

        // return view('addLampiran')->with('data', $data);
        // return view('addLampiran', compact('data','api'));
        return view('addLampiran', [
            'data' => $data,
            'valueNomorSop' => $valueNomorSop,
            'no_sppb' => $noSPPB
        ]);
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
        // extract($request->all());
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
        // cek dulu sini
        $lampiran2 = Lampiran2::where('kontraks_id', $request->kontraks_id);
        // return $lampiran2;
        $chek = $lampiran2->exists();
        if ($chek) {
            $lampiran2->delete();
        }
        // Simpan data ke database
        Lampiran2::create($data);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat']);

        // return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    public function storeLampiran3(Request $request)
    {
        extract($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'           => 'required',
            'jspek'                 => 'required',
            'gambar.*'              => 'required_if:jspek,1|image|mimes:jpeg,png,jpg|max:2048',
            'spesifikasi_teknis'    => 'required_if:jspek,2',
            'no_sppb'               => 'required_if:jspek,2',
            'kode_barang'           => 'required_if:jspek,2',
            'nama_barang'           => 'required_if:jspek,2',
            'satuan'                => 'required_if:jspek,2',
        ], [
            'gambar.required_if'    => 'file image Wajib di isi',
        ]);

        $kontraksId = $validatedData['kontraks_id'];
        $jenisSpesifikasi = $validatedData['jspek'];
        // Simpan nilai dari radio button
        $Jspek = $jenisSpesifikasi;


        // cek dulu sini
        $lampiran3 = Lampiran3::where('kontraks_id', $kontraks_id);
        // return $lampiran3;
        $chek = $lampiran3->exists();
        if ($chek) {
            $lampiran3->delete();
        }
        $paths = [];
        // Jika jenis spesifikasi adalah standar lab
        if ($Jspek == 1) {
            // Upload gambar ke direktori tertentu
            if ($request->hasfile('gambar')) {
                foreach ($request->file('gambar') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $path      = $image->storeAs('public/uploads/spesifikasi_teknis', $imageName);
                    $paths[]   = $path;
                    Lampiran3::create([
                        'kontraks_id'         => $kontraksId,
                        'jenis_spesifikasi'   => $Jspek,
                        'gambar'              => $path,
                    ]);
                }
            }
        } elseif ($request->jspek == 2) {
            $datanya = [];
            foreach ($no_sppb as $key => $r) {
                $datanya[] = [
                    'kontraks_id'         => $kontraksId,
                    'jenis_spesifikasi'   => $Jspek,
                    'spesifikasi_teknis'  => $spesifikasi_teknis[$key],
                    'no_sppb'             => $r,
                    'kode_barang'         => $kode_barang[$key],
                    'jenis_barang'        => $nama_barang[$key],
                    'satuan'              => $satuan[$key],
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ];
            };
            if (!empty($datanya)) {
                Lampiran3::insert($datanya);
            }
        }

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 3 Berhasil Dibuat']);
    }

    public function storeLampiran4(Request $request)
    {
        // dd($request->all());
        extract($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'               => 'required',
            'nomor_sop'                 => 'required',
            'tanggal_sop'               => 'required',
            'lokasi'                    => 'required',
            'satuan'                    => 'required',
            'jadwal_penyerahan_barang'  => 'required',
        ]);

        // cek dulu sini
        $lampiran4 = Lampiran4::where('kontraks_id', $kontraks_id);
        // return $lampiran4;
        $chek = $lampiran4->exists();
        if ($chek) {
            $lampiran4->delete();
        }
        $datax = [];
        foreach ($nomor_sop as $key => $r) {
            $datax[] = [
                'kontraks_id'              => $kontraks_id,
                'nomor_sop'                => $r,
                'no_sppb'                  => $no_sppb[$key],
                'kode_barang'              => $kode_barang[$key],
                'nama_barang'              => $nama_barang[$key],
                'tanggal_sop'              => $tanggal_sop[$key],
                'lokasi'                   => $lokasi[$key],
                'satuan'                   => $satuan[$key],
                'jadwal_penyerahan_barang' => $jadwal_penyerahan_barang[$key],
                'created_at'               => now(),
                'updated_at'               => now(),
            ];
        }
        // Simpan data ke database
        Lampiran4::insert($datax);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 4 Berhasil Dibuat']);

        // return response()->json(['message' => 'Lampiran 4 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }


    public function storeLampiran5(Request $request)
    {
        // dd($request->all());
        extract($request->all());
        $validatedData = $request->validate([
            'kontraks_id'       => 'required',
            'no_sppb'           => 'required',
            'kode_barang'       => 'required',
            'nama_barang'       => 'required',
            'satuan'            => 'required',
            'lokasi'            => 'required',
            'harga_awal'        => 'required',
            'jumlah'            => 'required',
            'ppn'               => 'required',
            'harga_akhir'       => 'required',
            'total_keseluruhan' => 'required',
        ]);

        // cek dulu sini
        $lampiran5 = Lampiran5::where('kontraks_id', $kontraks_id);
        // return $lampiran5;
        $chek = $lampiran5->exists();
        if ($chek) {
            $lampiran5->delete();
        }
        $datax = [];
        foreach ($no_sppb as $key => $r) {
            $datax[] = [
                'kontraks_id'       => $kontraks_id,
                'no_sppb'           => $r,
                'kode_barang'       => $kode_barang[$key],
                'nama_barang'       => $nama_barang[$key],
                'satuan'            => $satuan[$key],
                'lokasi'            => $lokasi[$key],
                'harga_awal'        => $harga_awal[$key],
                'qty'               => $jumlah[$key],
                'ppn'               => $ppn[$key],
                'harga_akhir'       => $harga_akhir[$key],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }
        if (!empty($datax)) {
            Lampiran5::insert($datax);
        }

        // isi kolom total_keseluruhan di tabel kontraks
        $kontrak = Kontrak::find($request->kontraks_id);
        if ($kontrak) {
            $kontrak->total_keseluruhan = $request->total_keseluruhan;
            $kontrak->save();
        }

        return response()->json(['message' => 'Lampiran 5 Berhasil Dibuat']);
        // return response()->json(['message' => 'Lampiran 5 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    public function storeLampiran6(Request $request)
    {
        extract($request->all());
        $validatedData = $request->validate([
            'kontraks_id'       => 'required',
            'nomor_sop'         => 'required',
            'tanggal_sop'       => 'required',
            'no_kontrak'        => 'required',
            'date_kontrak'      => 'required',
            'jpemb'             => 'required',
            'lama_pembayaran'   => 'required',
        ]);
        // Simpan nilai dari radio button
        $jenis_pembayaran = $request->jpemb;
        $data['kontraks_id']        = $kontraks_id;
        $data['nomor_sop']          = $nomor_sop;
        $data['tanggal_sop']        = $tanggal_sop;
        $data['no_kontrak']         = $no_kontrak;
        $data['date_kontrak']       = $date_kontrak;
        $data['jenis_pembayaran']   = $jenis_pembayaran;
        $data['lama_pembayaran']    = $lama_pembayaran;

        // cek dulu sini
        $lampiran6 = Lampiran6::where('kontraks_id', $kontraks_id);
        // return $lampiran6;
        $chek = $lampiran6->exists();
        if ($chek) {
            $lampiran6->delete();
        }

        // Simpan data ke database
        Lampiran6::create($data);

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 6 Berhasil Dibuat']);
        // return response()->json(['message' => 'Lampiran 6 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }


    public function storeLampiran7(Request $request)
    {
        extract($request->all());
        $validatedData = $request->validate([
            'kontraks_id'       => 'required',
            'alamat_peruri'     => 'required',
            'alamat_vendor'     => 'required',

        ]);
        // Simpan data ke dalam tabel Lampiran7
        $data['kontraks_id']   = $kontraks_id;
        $data['alamat_peruri'] = $alamat_peruri;
        $data['alamat_vendor'] = $alamat_vendor;
        if (isset($nextstatus) && $nextstatus == 'edited') {
            // ambil row revisi terakhir
            $revisi = revisiKontrak::with('user')
                ->latest()->take(1)
                ->where('kontraks_id', $kontraks_id)->first();
            $status = "edited" . $revisi->user->permission;
        } else {
            // created
            $status = "reviewkasek";
            // cek dulu lampiran 1-6 sudah ada
            $ceklamp1 = Lampiran1::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp1) {
                return response()->json(['message' => 'Lampiran 1 belum Dibuat',  'status' => 'error']);
            }
            $ceklamp2 = Lampiran2::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp2) {
                return response()->json(['message' => 'Lampiran 2 belum Dibuat',  'status' => 'error']);
            }
            $ceklamp3 = Lampiran3::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp3) {
                return response()->json(['message' => 'Lampiran 3 belum Dibuat',  'status' => 'error']);
            }
            $ceklamp4 = Lampiran4::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp4) {
                return response()->json(['message' => 'Lampiran 4 belum Dibuat',  'status' => 'error']);
            }
            $ceklamp5 = Lampiran5::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp5) {
                return response()->json(['message' => 'Lampiran 5 belum Dibuat',  'status' => 'error']);
            }
            $ceklamp6 = Lampiran6::where('kontraks_id', $kontraks_id)->doesntExist();
            if ($ceklamp6) {
                return response()->json(['message' => 'Lampiran 6 belum Dibuat',  'status' => 'error']);
            }
        }
        // cek dulu sini
        $lampiran7 = Lampiran7::where('kontraks_id', $kontraks_id);
        // return $lampiran7;
        $chek = $lampiran7->exists();
        if ($chek) {
            $lampiran7->delete();
        }
        Lampiran7::create($data);


        // Perbarui status kontrak menjadi 'reviewkasek'
        $kontrak = Kontrak::find($request->kontraks_id);
        if ($kontrak) {
            $kontrak->status = $status;
            $kontrak->save();
        }

        // Kirim notifikasi ke pengguna yang memberikan revisi
        if (isset($revisi) && $revisi) {
            // Ambil alamat email dan nama yang memberikan revisi
            $emailRevisi = $revisi->user->email;
            $namaPengguna = $revisi->user->name;

            // Kirim notifikasi email
            $user = User::where('email', $emailRevisi)->first();
            $user->notify(new KontrakReviewEditNotification($kontrak, $namaPengguna));
        }

        $kontrak->logs()->create([
            'status'    => $status,
            'user_id'   => auth()->id(),
        ]);

        // Response JSON dengan pesan sukses dan redirect ke halaman monitoring
        return response()->json(['message' => 'Lampiran 7 Berhasil Dibuat', 'redirect' => route('rKontrak'), 'status' => 'success']);
    }


    // METHOD PRINT KONTAK TES
    public function printKontrak()
    {
        $pasalKJaminan = Kontrak::all();
        return view('printKontrak', compact('pasalKJaminan'));
    }

    public function rKontrak()
    {
        // return auth()->user()->permission;
        $exceptList = ['kadept', 'kadiv'];
        $data = Kontrak::with(['revisiKontraks' => function ($q) {
            return $q->where('statusrevisi', 'N');
        }]);

        if (!in_array(
            auth()->user()->permission, //jarum
            $exceptList //jerami
        )) {
            $data = $data->Unitkerja(); //where unit kerja
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        // "select * from contracts where unit_kerja='4120'";
        return view('rKontrak', compact('data'));
    }

    // method detail kontrak
    public function showKontrak(Request $request, $id)
    {
        // Mengambil data kontrak berdasarkan ID yang diberikan
        $data = Kontrak::with([
            'integrates',
            'pasal' => function ($q) {
                return $q->orderBy('urutan', "ASC");
            },
            'lampiran1',
            'lampiran2',
            'lampiran3',
            'lampiran4',
            'lampiran5',
            'lampiran6',
            'lampiran7',
            'logs',
            'revisiKontraks'
        ])->findOrFail($id);

        // Mengurutkan koleksi pasal berdasarkan nama_pasal sebelum mengirimkannya ke tampilan
        // $data->pasal = $data->pasal->sortBy('nama_pasal');


        // $statusnya = "approved" . auth()->user()->permission;
        // $statuslist = $data->logs->pluck('status')->toArray();
        // // cek tombol menyetujui kontak
        // $cekApprovedKontrak = (in_array($statusnya, $statuslist) ? 'd-none' : '');

        // Ambil tanggal dari $data
        $tanggal_kontrak = Carbon::parse($data->date_kontrak);
        $arrDateSplit = explode('-', $data->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        // return $data;
        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$data->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;
        return view('showKontrakcoba', compact('data', 'pihak2name', 'pihak1name', 'pihak1data', 'pihak2data', 'tanggal_tertulis'));
    }

    public function cetakKontrak($id)
    {

        $kontrak = Kontrak::with([
            'integrates',
            'pasal' => function ($q) {
                return $q->orderBy('urutan', "ASC");
            },
            'lampiran1',
            'lampiran2',
            'lampiran3',
            'lampiran4',
            'lampiran5',
            'lampiran6',
            'lampiran7',
            'logs',
            'revisiKontraks'
        ])->findOrFail($id);

        // Ambil tanggal dari $data
        $tanggal_kontrak = Carbon::parse($kontrak->date_kontrak);
        $arrDateSplit = explode('-', $kontrak->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$kontrak->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;
        $data = [
            'data' => $kontrak,
            'pihak2name' => $pihak2name,
            'pihak1name' => $pihak1name,
            'pihak1data' => $pihak1data,
            'pihak2data' => $pihak2data,
            'tanggal_tertulis' => $tanggal_tertulis,
        ];
        $pdf = PDF::loadview('cetak_kontrak_pdf', $data);
        // Set opsi setRemoteEnable
        return $pdf->stream("kontrak_" . $kontrak->detail_number . "pdf");
    }


    public function logKontrak(Request $request, $id)
    {
        $kontrak = Kontrak::with(['logs.user'])->findOrFail($id);
        return view('logkontrak', compact('kontrak'));
    }

    public function setujuiKontrak($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        // cek ada revisian yg statusnya N dan yg buat revisi adalah yg mengapprove dan ambil 1 row terakhir aja.
        $cekrevisi = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where(['kontraks_id' => $id, 'statusrevisi' => 'N', 'user_id' => auth()->id()]);
        if ($cekrevisi->exists()) {
            // kalo ada revisinya maka kita update statusnya
            $revisi = $cekrevisi->first();
            // set status revisi jadi Y
            $revisi->update(['statusrevisi' => 'Y']);
        }

        // kalo di aproved maka naikkan status ke review selanjutnya
        $status = "approved" . auth()->user()->permission;
        $kontrak->logs()->create([
            'status'    => $status,
            'user_id'   => auth()->id(),
        ]);


        if ($status == 'approvedkasek') {
            $nextstatus = "reviewkadept";
        } elseif ($status == 'approvedkadept') {
            $nextstatus = "reviewkadiv";
        } else {
            // finish
            $nextstatus = "approvedkadiv";
        }
        if ($status != "approvedkadiv") {
            // selain approvekadive maka akan di set review ke tahap selanjutnya
            sleep(2);
            $kontrak->logs()->create([
                'status'    => $nextstatus,
                'user_id'   => auth()->id(),
            ]);
        }

        // update status kontrak
        $kontrak->update(['status' => $nextstatus]);

        // Kirim notifikasi email sesuai dengan status kontrak
        // $this->sendApprovalNotification($kontrak, $status);
        $cekKontrakStatus = LogContract::with('user')
            ->latest()
            ->where(['kontraks_id' => $kontrak->id, 'status' => 'draft', 'user_id' => auth()->id()])
            ->first();

        if ($cekKontrakStatus) {
            // Ambil alamat email pembuat kontrak
            $emailPembuat = $cekKontrakStatus->user->email;
            $namaPembuat = $cekKontrakStatus->user->name;

            // Kirim notifikasi email sesuai dengan status kontrak
            if ($cekKontrakStatus) {
                // Jika disetujui oleh kasek, kirim notifikasi kepada pembuat kontrak
                $user = User::where('email', $emailPembuat)->first();
                $user->notify(new KontrakApprovedNotification($kontrak, $namaPembuat, $status));
            }
        }

        return response()->json(['message' => 'berhasil di setujui', 'redirect' => route('rKontrak'), 'status' => 'success']);
    }


    public function addRevisi(Request $request, $id)
    {
        $data = Kontrak::find($id);

        return view('addRevisi')->with('data', $data);
    }



    public function storeRevisi(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'kontraks_id' => 'required',
            'revisi' => 'required',
        ]);

        // Simpan data revisi
        $data['kontraks_id'] = $validated['kontraks_id'];
        $data['revisi'] = $validated['revisi'];
        $data['user_id'] = auth()->id();
        $status = '';

        // Tentukan status berdasarkan izin pengguna
        $userPermission = auth()->user()->permission;
        switch ($userPermission) {
            case 'kasek':
                $status = 'revisikasek';
                break;
            case 'kadept':
                $status = 'revisikadept';
                break;
            case 'kadiv':
                $status = 'revisikadiv';
                break;
        }

        // Buat entri revisiKontrak
        revisiKontrak::create($data);

        // Perbarui status kontrak
        $kontrak = Kontrak::find($validated['kontraks_id']);
        if ($kontrak) {
            $kontrak->status = $status;
            $kontrak->save();

            $noteRevisi = revisiKontrak::where('kontraks_id', $kontrak->id)->latest()->first();
            // Ambil alamat email pembuat kontrak dari tabel User
            $pembuat = $kontrak->pembuat;
            $emailPembuat = User::where('name', $pembuat)->value('email');
            $user = User::where('email', $emailPembuat)->first();

            // Kirim email notifikasi kepada pembuat kontrak
            if ($kontrak && $noteRevisi) {
                $user->notify(new KontrakRevisiNotification($kontrak, $noteRevisi));
            }
        }

        // Buat entri log
        $kontrak->logs()->create([
            'status' => $status,
            'user_id' => auth()->id(),
        ]);

        // Response JSON dengan pesan sukses dan redirect ke halaman monitoring
        return response()->json(['message' => 'Revisi Berhasil Dibuat', 'redirect' => route('rKontrak')]);
    }


    public function showRevisi($id)
    {
        // Ambil data revisi berdasarkan kontraks_id
        $revisi = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where('kontraks_id', $id)->first();

        // Tampilkan view untuk menampilkan data revisi
        return view('viewRevisi', compact('revisi'));
    }

    public function updateLampiran(Request $request, $id)
    {
        // cek dul ada ga revisi, kalo ga ada tolak
        $cek = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where('kontraks_id', $id)->exists();
        if ($cek) {
            $data = Kontrak::with(['lampiran1', 'lampiran2', 'lampiran3', 'lampiran4', 'lampiran5', 'lampiran6', 'lampiran7'])->find($id);

            return view('editLampiran')->with('data', $data);
        }
        return "belum ada revisi dari pihak manapun..";
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


    public function historyRevisiK(Request $request, $id)
    {
        $RVkontrak = Kontrak::with(['historyRevisi.user'])->findOrFail($id);
        return view('historyRevisi', compact('RVkontrak'));
    }

    public function indexSOP()
    {
        // echo 'TAMPIL DATA SOP';
        // $data = Integrate::orderBy('document_date', 'desc')->get();
        // $data = Integrate::withCount('purchaseRequisitions')->orderBy('document_date', 'desc')->get()

        $data = Integrate::select('purchasing_document_number', 'document_date', 'tender_name', 'vendor_name')->distinct()->with('purchaseRequisitions')->orderBy('document_date', 'desc')->get();

        // dd($data);
        return view('indexSOP', compact('data'));
    }

    public function detailPR($purchasing_document_number)
    {
        $purchaseRequisitions = Integrate::where('purchasing_document_number', $purchasing_document_number)->get();
        return view('detailPR', compact('purchaseRequisitions', 'purchasing_document_number'));
    }

    public function ExportKPDF()
    {
        // echo 'INI TEMPAT EXPORT KONTRAK BY PDF';
        // $data = Kontrak::orderBy('created_at', 'desc')->get();

        // return view('export.cetakKontrak-PDF', compact('data'));
        return view('export.cetakKontrak-PDF');
    }

    public function ExportKontrakPertanggalPDF($tglawal, $tglakhir)
    {
        // dd(["Tanggal Awal : ".$tglawal, "Tanggal Akhir : ".$tglakhir]);

        $exportPertanggal = Kontrak::orderBy('created_at', 'desc')->whereBetween('date_kontrak', [$tglawal, $tglakhir])->get();

        return view('export.cetak-kontrak-pertanggal-pdf', compact('exportPertanggal'));
    }


    public function viewExport(){
        return view('export.cetak-excel-kontrak');
    }


    public function export(Request $request)
    {
        // dd($request->all());
        $filterType = $request->input('filter_type');
        $filterValue = $request->input('filter_value');
        $year = $request->input('year'); //ambil nilai tahun dari inputan
        $month = $request->input('month'); // Menangkap nilai bulan dari input

        $contracts = Kontrak::query();

        if ($filterType && $filterValue) {

            if ($filterType === 'year') {
                $contracts->whereYear('date_kontrak', $filterValue);

            } elseif ($filterType === 'month') {
                // Validasi apakah tahun dan bulan telah dipilih
                if (!$year || !$month) {
                    return redirect()->back()->with('error', 'Bulan dan Tahun Belum Terisi!');
                }

                //tangkep nilai bulan dari inputan
                $monthValue = strlen($month) == 1 ? '0' . $month : $month;
                $contracts->whereYear('date_kontrak', $year)->whereMonth('date_kontrak', $monthValue);

            } elseif ($filterType === 'date') {
                // Pisahkan rentang tanggal
                $dates = explode(' - ', $filterValue);
                $startDate = $dates[0];
                $endDate = $dates[1];

                // Terapkan filter rentang tanggal
                $contracts->whereBetween('date_kontrak', [$startDate, $endDate]);
            }
        }

        $contracts = $contracts->get();

        return Excel::download(new KontrakExport($contracts), 'data-kontrak.xlsx');
    }


}
