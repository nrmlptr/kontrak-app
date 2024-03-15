<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\User;
use App\Models\Integrate;
use App\Models\Lampiran1;
use App\Models\Lampiran2;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



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
            $data = Integrate::select("purchasing_document_number", "vendor_name")
            ->where('purchasing_document_number', 'LIKE', "%$search%")
            ->orWhere('vendor_name', 'LIKE', "%$search%")
            ->groupBy('purchasing_document_number', 'vendor_name') // Memasukkan kolom 'vendor_name' ke dalam klausa 'GROUP BY'
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



    public function vendor_data($no_vendor)
    {
        $url            = 'https://scm.peruri.co.id/Api/getsiapdainfo/' . $no_vendor;
        $client         = new Client();
        $request        = $client->request('GET', $url, ['verify' => false]);
        $collection     = collect(json_decode($request->getBody()));
        // dd($collection);
        $data           = $collection->where('board_type', "BOD (Board of Director) – Direksi")->first();
        return $data;
    }

    public function dataBarang(Request $request)
    {
        $data = Integrate::where('purchasing_document_number', $request->po)->get();

        return response()->json($data);
    }



    public function indexKontrak()
    {
        // echo 'monitoring kontrak';
        $data = Kontrak::get();
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
        return response()->json(['message' => 'Kontrak Berhasil Dibuat.']);

        return redirect()->route('indexKontrak');
    }


    // METHOD TAMPIL VIEW LAMPIRAN INPUT
    public function addLampiran()
    {
        // echo 'form add lampiran';
        if (auth()->user()->can('view_input')) {
            return view('addLampiran');
        }

        return abort(403);
    }


    // METHOD input lampiran 1
    public function storeLampiran1(Request $request){
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

        // dd($data_store);
        Lampiran1::updateOrCreate(
            ['id'           => $request->id],
            ['kontraks_id' => '','data_json' => $data_store]
        );

        return response()->json(['message' => 'Data masuk']);
    }


    // METHOD INPUT LAMPIRAN 2
    public function storeLampiran2(Request $request){
        // dd($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'   => '',
            'perihal'       => 'required',
            'nomor_sop'     => 'required',
            'tanggal_sop'   => 'required',
        ]);

        // yang berada dalam index array merupakan field yg ada di db
        $data['kontraks_id']        = null;
        $data['perihal']            = $request->perihal;
        $data['nomor_sop']          = $request->nomor_sop;
        $data['tanggal_sop']        = $request->tanggal_sop;

        // Simpan data ke database
        Lampiran2::updateOrCreate($data);
       
        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Data telah disimpan.']);
    }




    // METHOD PRINT KONTAK TES
    public function printKontrak()
    {
        $pasalKJaminan = Kontrak::all();
        return view('printKontrak', compact('pasalKJaminan'));
    }
}
