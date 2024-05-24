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
use App\Notifications\RevisiKontrakNotification;
use App\Notifications\UpdateKontrakNotification;
use App\Notifications\SetujuiKontrakNotification;
use App\Notifications\inputKontrakNotification;
use App\Notifications\NetkontrakNotification;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
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
        $url         = 'https://scm.peruri.co.id/Api/getsiapda';
        $bearerToken = 'ciTeTrDRKcOyHLOi0OQ5TtjBzlKJSE9dHh4j7MGpKW68bTrIZRJmFC1L27cB060Ev';
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept' => 'application/json',
            ],
            'verify' => false, // Untuk bypass SSL verification jika diperlukan
        ]);
        // $client     = new Client();
        // $request    = $client->request('GET', $url, ['verify' => false]);
        // $collection = collect(json_decode($request->getBody()));
        // dd($collection->count());
        // dd($request->getBody());
        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            // buat array kosong untuk nanti tampung datanya
            $inputData  = array();
            Integrate::truncate();

            foreach ($data as $col) {
                // dd($col);
                // $tanggalSPPH = $col->tgl_spph;
                // $tglSPPHSQL = date('Y-m-d H:i:s', strtotime($tanggalSPPH));
                // $tanggalWaktu = $col->tgl_sp3_approve; // Ambil nilai tanggal dan waktu dari kolom tgl_sp3_approve
                // $tanggalWaktuMySQL = date('Y-m-d H:i:s', strtotime($tanggalWaktu)); // Format nilai ke dalam format yang sesuai dengan MySQL
                // Konversi tanggal menjadi format MySQL
                $tglSPPHSQL = date('Y-m-d H:i:s', strtotime($col['tgl_spph']));
                $tanggalWaktuMySQL = date('Y-m-d H:i:s', strtotime($col['tgl_sp3_approve']));


                $inputData = [
                    'no_spph'                            => $col['no_spph'],
                    'tgl_spph'                           => $tglSPPHSQL,
                    'no_sp3'                             => $col['no_sp3'],
                    'tgl_sp3_approve'                    => $tanggalWaktuMySQL,
                    'schedule_from_time'                 => $col['schedule_from_time'],
                    'schedule_thru_time'                 => $col['schedule_thru_time'],
                    'tender_name'                        => $col['tender_name'],
                    'purchasing_document_number'         => $col['purchasing_document_number'],
                    'document_date'                      => $col['document_date'],
                    'po_delivery_date'                   => $col['po_delivery_date'],
                    'vendors_account_number'             => $col['vendors_account_number'],
                    'registration_no'                    => $col['registration_no'],
                    'vendor_name'                        => $col['vendor_name'],
                    'purchasing_document_type'           => $col['purchasing_document_type'],
                    'purchasing_group'                   => $col['purchasing_group'],
                    'material_group'                     => $col['material_group'],
                    'material_number'                    => $col['material_number'],
                    'material_name'                      => $col['material_name'],
                    'purchase_requisition_number'        => $col['purchase_requisition_number'],
                    'requisition_date'                   => $col['requisition_date'],
                    'plant'                              => $col['plant'],
                    'storage_location'                   => $col['storage_location'],
                    'item_number_of_purchasing_document' => $col['item_number_of_purchasing_document'],
                    'purchase_order_quantity'            => (int) str_replace(['.', ','], '', $col['purchase_order_quantity']),
                    'purchase_order_unit_of_measure'     => $col['purchase_order_unit_of_measure'],
                    'net_price'                          => (int) str_replace(['.', ','], '', $col['net_price']),
                    'condition_value'                    => $col['condition_value'],
                    'alamat'                             => $col['alamat'],
                    'kecamatan'                          => $col['sub_district'],
                    'kota'                               => $col['kota'],
                    'provinsi'                           => $col['provinsi'],
                    'kode_pos'                           => $col['kode_pos'],
                    'negara'                             => $col['negara'],
                    'no_hp'                              => $col['phone_number'],
                    'website'                            => $col['website'],
                    'email_perusahaan'                   => $col['company_email'],
                    'kategori_lokasi'                    => $col['location_category']
                ];

                // dd($inputData);
                Integrate::create($inputData);
            }

            // Berhasil menambahkan data
            return response()->json(['success' => true, 'message' => 'Data successfully synced.']);
        } catch (\Exception $e) {
            // Gagal mengakses API
            return response()->json([
                'success' => false, 'message' => $e->getMessage()
            ]);
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
                    'vendor_name'           => $v['vendor_name'],
                    'company_type'          => $v['company_type'],
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
            $alamatnya = $dataVendor[0]['company_type'] . '<br>' . $dataVendor[0]['vendor_name'] . '<br>' . $dataVendor[0]['alamat'] . '<br>' . $dataVendor[0]['sub_district'] . '<br>' . $dataVendor[0]['kota'] . '<br>' . $dataVendor[0]['provinsi'] . '<br>' . $dataVendor[0]['kode_pos'] . '<br>' .  $dataVendor[0]['negara'];
        } else {
            $row = $cek->first();
            $alamatnya = $row->company_type . '<br>' . $row->vendor_name . '<br>' . $row->alamat . '<br>' . $row->sub_district . '<br>' . $row->kota . '<br>' . $row->provinsi . '<br>' . $row->kode_pos . '<br>' . $row->negara;
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


    public function indexKontrak(Request $request)
    {
        // dd($request->all());
        // echo 'monitoring kontrak';
        // $data = Kontrak::get();
        $data = Kontrak::orderBy('created_at', 'desc')->get();

        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by status
        if ($request->status) {
            // return dd($request->status);
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')->get();
        }

        // search by unit kerja
        if ($request->unit_kerja) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')->get();
        }

        // sesarch by jenis kontrak
        if ($request->jenis_kontrak) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')->get();
        }

        // search by status jaminan
        if ($request->status_jaminan) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')->get();
        }

        // search by rentang tgl sp (contoh : 01 april 2024 - 06 april 2024)
        if ($request->startdate && $request->enddate) {

            $data = Kontrak::where(
                'date_kontrak',
                '>=',
                $request->startdate
            )
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & status
        if ($request->nm_vendor && $request->status) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->get();
        }

        // search by nama vendor & unit kerja
        if (
            $request->nm_vendor && $request->unit_kerja
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor & jenis kontrak
        if ($request->nm_vendor && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor & status jaminan
        if ($request->nm_vendor && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor & tanggal sp
        if (
            $request->nm_vendor && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //==============================SEARCH BY STATUS ================

        // search by status dan unit kerja
        if ($request->status && $request->unit_kerja) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by status dan jenis kontrak
        if ($request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status dan status jaminan
        if ($request->status && $request->status_jaminan) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by status & tanggal sp
        if (
            $request->status && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============================== search by unit kerja ==========
        // search by unit kerja dan jenis kontrak
        if ($request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by unit kerja dan status jaminan
        if ($request->unit_kerja && $request->status_jaminan) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja & tanggal sp
        if (
            $request->unit_kerja && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //================= search by jenis kontrak =========================================================================================

        // search by jenis kontrak dan status jaminan
        if ($request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by jenis kontrak & tanggal sp
        if (
            $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============= search by status jaminan ==================================================================================
        // search by status jaminan & tanggal sp
        if (
            $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status, unit kerja ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->unit_kerja) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor, status, jenis kontrak ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor, status, status jaminan ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor, status, tanggal sp ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, jenis kontrak =======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, status jaminan=======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // ========================================== search by nama vendor, unit kerja, tanggal sp ==============================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak status jaminan ===================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, status jaminan, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak =======================================================================================================
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status, unit kerja, nama vendor dan jenis_kontrak
        if (
            $request->status && $request->unit_kerja && $request->nm_vendor && $request->jenis_kontrak
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by all data spesifik
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
            && $request->nm_vendor
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }


        // search by unit kerja, jenis_kontrak dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja, jenis_kontrak, nama vendor dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->nm_vendor
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }

        // search by nama vendor dan unit kerja dan tgl sp
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status dan tgl sp
        if ($request->nm_vendor && $request->status && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }


        // search by status dan unit kerja dan tgl sp
        if ($request->status && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan jenis kontrak dan tgl sp
        if (
            $request->status && $request->jenis_kontrak
            && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan status jaminan dan tgl sp
        if ($request->status && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak dan tgl sp
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status,unit kerja, jenis kontrak, status jaminan & tgl sp
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by all data spesifik & tgl sp
        if ($request->nm_vendor && $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan jenis kontrak & tgl sp
        if ($request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan status jaminan & tgl sp
        if ($request->unit_kerja && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja, jenis_kontrak dan status jaminan serta tgl sp
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by jenis kontrak dan status jaminan & tgl sp
        if ($request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

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
            'number'         => 'required',
            'perihal'        => 'required',
            'date_kontrak'   => 'required',
            'nomor_sop'      => 'required',
            'tanggal_sop'    => 'required',
            'jenis_kontrak'  => 'required',
            'status_jaminan' => 'required',
            'nm_vendor'      => 'required',

        ], [
            'number.required'           => 'Wajib di isi',
            'perihal.required'          => 'Wajib di isi',
            'date_kontrak.required'     => 'Wajib di isi',
            'nomor_sop.required'        => 'Wajib di isi',
            'tanggal_sop.required'      => 'Wajib di isi',
            'jenis_kontrak.required'    => 'Wajib di isi',
            'status_jaminan.required'   => 'Wajib di isi',
            'nm_vendor.required'        => 'Wajib di isi'
        ]);

        // Mengonversi nilai jenis kontrak menjadi angka
        $jenisKontrakValue = ($request->jenis_kontrak == 'lumpsum') ? 1 : 2;

        // Mengonversi nilai status jaminan menjadi angka
        $statusJaminanValue = ($request->status_jaminan == 'jaminan') ? 1 : 2;

        // Mendapatkan tahun saat ini menggunakan Carbon
        $tahunSekarang = Carbon::now()->year;

        // Menggunakan tahun tersebut dalam pembuatan string
        $detailNumber                   = 'SP-' . $request->number . '/VIII/' . $tahunSekarang;
        $status                         = 'draft';
        $validated['detail_number']     = $detailNumber;
        $validated['pembuat']           = Auth::user()->name;
        $validated['jenis_kontrak']     = $jenisKontrakValue;
        $validated['status_jaminan']    = $statusJaminanValue;
        $validated['status']            = $status;
        $validated['peruritext']        = $peruri_text;
        $validated['vendortext']        = $akta;
        $validated['unit_kerja']        = Auth::user()->unit_kerja;

        // dd($validated);
        $save = Kontrak::create($validated);

        flash()->addFlash('success', 'Kontrak Berhasil Dibuat!');

        // insert log Kontrak
        $save->logs()->create([
            'status' => $status,
            'user_id' => auth()->id(),
        ]);

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
            'data'          => $data,
            'valueNomorSop' => $valueNomorSop,
            'no_sppb'       => $noSPPB
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

            // flash()->addFlash('success', 'Lampiran 1 Berhasil Dibuat!');

        } else {
            // kita update disni kalo udah ada datanya
            // step 1 hapus dulu data lama
            // step 2 create ulang
            $lampiran = $lampiran->delete();
            Lampiran1::create(
                ['kontraks_id' => $request->kontraks_id, 'data_json' => $data_store]
            );
            // flash()->addFlash('success', 'Lampiran 1 Berhasil Dibuat!');
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

        // notif flash
        // flash()->addFlash('success', 'Lampiran 2 Berhasil Dibuat!');

        // Mengembalikan respons JSON yang memberitahu bahwa data berhasil disimpan
        return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat']);

        // return response()->json(['message' => 'Lampiran 2 Berhasil Dibuat', 'redirect' => route('indexKontrak')]);
    }

    public function storeLampiran3(Request $request)
    {
        // dd($request->all());
        extract($request->all());

        // Validasi data
        $validatedData = $request->validate([
            'kontraks_id'           => 'required',
            'jspek'                 => 'required',
            'gambar.*'              => 'required_if:jspek,1|image|mimes:jpeg,png,jpg|max:5048',
            'gambarnon.*'           => 'image|mimes:jpeg,png,jpg|max:5048',
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
                // upload gambar jika ada
                $gambarnonPath = null;
                if ($request->hasfile('gambarnon') && isset($request->file('gambarnon')[$key])) {
                    $gambarnon      = $request->file('gambarnon')[$key];
                    $imagenonName   = time() . '_' . $gambarnon->getClientOriginalName();
                    $gambarnonPath  = $gambarnon->storeAs('public/uploads/spesifikasi_teknis/nonstandarlab', $imagenonName);
                }

                $datanya[] = [
                    'kontraks_id'         => $kontraksId,
                    'jenis_spesifikasi'   => $Jspek,
                    'spesifikasi_teknis'  => $spesifikasi_teknis[$key],
                    'gambarnon'           => $gambarnonPath,
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
            'plant'                     => 'required',
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
                'lokasi'                   => $plant[$key],
                'satuan'                   => $satuan[$key],
                'jadwal_penyerahan_barang' => $jadwal_penyerahan_barang[$key],
                'created_at'               => now(),
                'updated_at'               => now(),
            ];
        }
        // Simpan data ke database
        Lampiran4::insert($datax);

        // // Kirim notifikasi menggunakan PHPFlasher
        // $flasher->addSuccess('Lampiran 4 Berhasil Dibuat!');

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
            'plant'             => 'required',
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
                'lokasi'            => $plant[$key],
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
        $jenis_pembayaran           = $request->jpemb;
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

        $kontrak = Kontrak::find($request->kontraks_id);

        if (isset($nextstatus) && $nextstatus == 'edited') {
            // ambil row revisi terakhir
            $revisi = revisiKontrak::with('user')
                ->latest()->take(1)
                ->where('kontraks_id', $kontraks_id)->first();
            $userPermissionrevisi   = $revisi->user->permission;
            $previousRole           = [];
            switch ($userPermissionrevisi) {
                case 'kadept':
                    $previousRole['kasek'] = User::where('permission', 'kasek')->where('unit_kerja', $kontrak->unit_kerja)->get();
                    $status                = "edited" . $userPermissionrevisi;
                    break;
                case 'kadiv':
                    $previousRole['kasek'] = User::where('permission', 'kasek')->where('unit_kerja', $kontrak->unit_kerja)->get();
                    $previousRole['kadept'] = User::where('permission', 'kadept')->get();
                    $status                 = "edited" . $userPermissionrevisi;
                    break;
                default:
                    $previousRole   = ''; // Tidak ada role sebelumnya untuk kasek
                    $status         = "edited" . $userPermissionrevisi;
                    break;
            }
            // dd($previousRole);
            // $status = "edited" . $userPermissionrevisi;
        } else {
            // created
            $status = "reviewkasek";

            // buat notifikasi ketika kontrak berhasil dibuat oleh staff/admin ke kasek
            $pembuatKontrak = Kontrak::find($request->kontraks_id);
            $notifKasek = null;

            if ($status === 'reviewkasek') {
                // jika statusnya reviewkasek maka notif dikirim kepada user yang permissionnya sebagai kasek dan di unit kerja tersebut
                $notifKasek = User::where('permission', 'kasek')->where('unit_kerja', $pembuatKontrak->unit_kerja)->get();

                // jika kasek yg akan nerima notif ada, maka kirim notif
                foreach ($notifKasek as $user) {
                    $user->notify(new inputKontrakNotification($pembuatKontrak, $user));
                }
            }


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
        // simpan data update lampiran 7
        Lampiran7::create($data);

        // Perbarui status kontrak
        if ($kontrak) {
            $kontrak->status = $status;
            $kontrak->save();
        }

        if (isset($revisi) && $revisi) {
            // NOTIFIKASI DATABASE
            // buat notifikasi ketika kontrak berhasil diupdate oleh staff/admin ke kasek
            $updateKontrak = Kontrak::find($request->kontraks_id);
            $notifKasek2 = null;

            if ($updateKontrak->status === 'editedkasek' || $updateKontrak->status === 'editedkadept' || $updateKontrak->status === 'editedkadiv') {
                // jika statusnya benar maka notif dikirim kepada user yang permissionnya sebagai kasek dan di unit kerja tersebut
                $notifKasek2 = User::where('permission', 'kasek')->where('unit_kerja', $updateKontrak->unit_kerja)->get();

                // jika kasek yg akan nerima notif ada, maka kirim notif
                foreach ($notifKasek2 as $user) {
                    $user->notify(new UpdateKontrakNotification($updateKontrak, $user));
                }
            }

            // NOTIFIKASI EMAIL
            // Ambil alamat email dan nama yang memberikan revisi
            // $emailRevisi = $revisi->user->email;
            // $namaPenggunaRevisi = $revisi->user->name;

            // Kirim notifikasi email untuk pengguna yang memberikan revisi
            // $user = User::where('email', $emailRevisi)->first();
            // $user->notify(new KontrakReviewEditNotification($kontrak, $namaPenggunaRevisi, $user));

            // kirim notif email untuk pengguna sebelumnya (jika yang revisi kadept, maka notif update untuk kasek, jika yang revisi kadiv maka notif update untuk kasek dan kadept)
            // if (!empty($previousRole)) {
            //     // $previousUsers = User::where('permission', $previousRole)->get();
            //     // $namaPreviousUsers = '';

            //     foreach ($previousRole as $roleUser) {
            //         // Dapatkan nama pengguna dan tambahkan ke array $namaPreviousUsers
            //         // $namaPreviousUsers = $roleUser->name;
            //         foreach ($roleUser as $user) {
            //             $user->notify(new
            //                 KontrakReviewEditNotification($kontrak, $namaPenggunaRevisi, $user));
            //         }
            //     }
            // }
        }

        // save data ke tabel log
        $kontrak->logs()->create([
            'status'    => $status,
            'user_id'   => auth()->id(),
        ]);

        // return response()->json(['message' => 'Update Data Kontrak Gagal Dibuat', 'redirect' => route('editLampiran', ['id' =>$id])]);

        // notifikasi 
        flash()->addFlash('success', 'Lampiran Berhasil Dibuat!');


        // Response JSON dengan pesan sukses dan redirect ke reviewkontrak
        return response()->json(['message' => 'Lampiran 7 Berhasil Dibuat', 'redirect' => route('rKontrak'), 'status' => 'success']);
    }


    // METHOD PRINT KONTAK TES
    public function printKontrak()
    {
        $pasalKJaminan = Kontrak::all();
        return view('printKontrak', compact('pasalKJaminan'));
    }

    public function rKontrak(Request $request)
    {
        // return auth()->user()->permission;
        $exceptList = ['admin', 'kadept', 'kadiv'];
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

        // ==============================================
        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by status
        if ($request->status) {
            // return dd($request->status);
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')->get();
        }

        // search by unit kerja
        if ($request->unit_kerja) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')->get();
        }

        // sesarch by jenis kontrak
        if ($request->jenis_kontrak) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')->get();
        }

        // search by status jaminan
        if ($request->status_jaminan) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')->get();
        }

        // search by rentang tgl sp (contoh : 01 april 2024 - 06 april 2024)
        if ($request->startdate && $request->enddate) {

            $data = Kontrak::where(
                'date_kontrak',
                '>=',
                $request->startdate
            )
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & status
        if ($request->nm_vendor && $request->status) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->get();
        }

        // search by nama vendor & unit kerja
        if (
            $request->nm_vendor && $request->unit_kerja
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor & jenis kontrak
        if ($request->nm_vendor && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor & status jaminan
        if ($request->nm_vendor && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor & tanggal sp
        if (
            $request->nm_vendor && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //==============================SEARCH BY STATUS ================

        // search by status dan unit kerja
        if ($request->status && $request->unit_kerja) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by status dan jenis kontrak
        if ($request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status dan status jaminan
        if ($request->status && $request->status_jaminan) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by status & tanggal sp
        if (
            $request->status && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============================== search by unit kerja ==========
        // search by unit kerja dan jenis kontrak
        if ($request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by unit kerja dan status jaminan
        if ($request->unit_kerja && $request->status_jaminan) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja & tanggal sp
        if (
            $request->unit_kerja && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //================= search by jenis kontrak =========================================================================================

        // search by jenis kontrak dan status jaminan
        if ($request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by jenis kontrak & tanggal sp
        if (
            $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============= search by status jaminan ==================================================================================
        // search by status jaminan & tanggal sp
        if (
            $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status, unit kerja ============================================================================================================
        if (
            $request->nm_vendor && $request->status && $request->unit_kerja
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor, status, jenis kontrak ============================================================================================================
        if (
            $request->nm_vendor && $request->status && $request->jenis_kontrak
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor, status, status jaminan ============================================================================================================
        if (
            $request->nm_vendor && $request->status && $request->jenis_kontrak
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor, status, tanggal sp ============================================================================================================
        if (
            $request->nm_vendor && $request->status && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, jenis kontrak =======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, status jaminan=======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // ========================================== search by nama vendor, unit kerja, tanggal sp ==============================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak status jaminan ===================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, status jaminan, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak =======================================================================================================
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status, unit kerja, nama vendor dan jenis_kontrak
        if (
            $request->status && $request->unit_kerja && $request->nm_vendor && $request->jenis_kontrak
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by all data spesifik
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
            && $request->nm_vendor
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }


        // search by unit kerja, jenis_kontrak dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja, jenis_kontrak, nama vendor dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->nm_vendor
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }

        // search by nama vendor dan unit kerja dan tgl sp
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status dan tgl sp
        if (
            $request->nm_vendor && $request->status && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }


        // search by status dan unit kerja dan tgl sp
        if ($request->status && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan jenis kontrak dan tgl sp
        if (
            $request->status && $request->jenis_kontrak
            && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan status jaminan dan tgl sp
        if ($request->status && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak dan tgl sp
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status,unit kerja, jenis kontrak, status jaminan & tgl sp
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by all data spesifik & tgl sp
        if (
            $request->nm_vendor && $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan jenis kontrak & tgl sp
        if ($request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan status jaminan & tgl sp
        if ($request->unit_kerja && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja, jenis_kontrak dan status jaminan serta tgl sp
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by jenis kontrak dan status jaminan & tgl sp
        if ($request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        return view('rKontrak', compact('data'));
    }

    // method show detail kontrak
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
        $tanggal_kontrak    = Carbon::parse($data->date_kontrak);
        $arrDateSplit       = explode('-', $data->date_kontrak); //thn - bulan -tanggal
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

    // method show kontrak notif kadept,kadiv approved
    public function showKontrakNotif(Request $request, $id)
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
        $tanggal_kontrak    = Carbon::parse($data->date_kontrak);
        $arrDateSplit       = explode('-', $data->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        // return $data;
        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$data->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;

        // agar ketika di klik notif berkurang tanda sudah dibaca
        auth()->user()->unreadNotifications->where('id', request('id'))->first()->markAsRead();

        return view(
            'showKontrakNotif',
            compact('data', 'pihak2name', 'pihak1name', 'pihak1data', 'pihak2data', 'tanggal_tertulis')
        );
    }

    // method kontrak notif ke kasek SAAT BERHASIL BUAT KONTRAK
    public function Kontrakshow1(Request $request, $id)
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
        $tanggal_kontrak    = Carbon::parse($data->date_kontrak);
        $arrDateSplit       = explode('-', $data->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        // return $data;
        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$data->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;

        // agar ketika di klik notif berkurang tanda sudah dibaca
        auth()->user()->unreadNotifications->where('id', request('id'))->first()->markAsRead();

        return view(
            'showKontraknotifInput',
            compact(
                'data',
                'pihak2name',
                'pihak1name',
                'pihak1data',
                'pihak2data',
                'tanggal_tertulis'
            )
        );
    }

    // NOTIF KE KASEK SAAT KONTRAK BERHASIL DI UPDATE
    public function showUpdateKontrak(Request $request, $id)
    {

        // Ambil data revisi berdasarkan kontraks_id
        $revisi = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where('kontraks_id', $id)->first();

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
        $tanggal_kontrak    = Carbon::parse($data->date_kontrak);
        $arrDateSplit       = explode('-', $data->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        // return $data;
        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$data->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;

        // agar ketika di klik notif berkurang tanda sudah dibaca
        auth()->user()->unreadNotifications->where('id', request('id'))->first()->markAsRead();

        return view(
            'showKontrakNotifUpdate',
            compact(
                'data',
                'pihak2name',
                'pihak1name',
                'pihak1data',
                'pihak2data',
                'tanggal_tertulis',
                'revisi'
            )
        );
    }


    // public function cetakKontrak($id)
    // {
    //     // $options = new Options();
    //     // $options->set('isHtml5ParserEnabled', true);
    //     // $dompdf = new Dompdf($options);
    //     $kontrak = Kontrak::with([
    //         'integrates',
    //         'pasal' => function ($q) {
    //             return $q->orderBy('urutan', "ASC");
    //         },
    //         'lampiran1',
    //         'lampiran2',
    //         'lampiran3',
    //         'lampiran4',
    //         'lampiran5',
    //         'lampiran6',
    //         'lampiran7',
    //         'logs',
    //         'revisiKontraks'
    //     ])->findOrFail($id);
    //     // $teks = "";
    //     // foreach ($kontrak->pasal as $p) {
    //     //     $teks .= " <h4>" . $p->nama_pasal . "
    //     //                     <br>" . $p->keterangan_pasal . "
    //     //                 </h4> " . $p->isi_pasal;
    //         // $teks .= ' <div class="boxpasal" style="text-align: justify; font-size: 14px; page-break-inside: avoid;">
    //         //             <h4 style="text-align: center">' . $p->nama_pasal . '
    //         //                 <br>' . $p->keterangan_pasal . '
    //         //             </h4>
    //         //             ' . $p->isi_pasal . '
    //         //         </div>
    //         //         <div style="margin-bottom: 40px;"></div>';
    //     // }
    //     // // Buat HTML dengan teks yang akan dimasukkan ke dalam PDF
    //     // $html = "<html><body>";
    //     // $html .= "<p>$teks</p>"; // Tambahkan teks ke dalam paragraf
    //     // $html .= "</body></html>";

    //     // Muat HTML ke dalam DOMPDF
    //     // $dompdf->loadHtml($html);

    //     // // Render PDF
    //     // $dompdf->render();

    //     // // Dapatkan jumlah halaman
    //     // $jumlah_halaman = $dompdf->getCanvas()->get_page_count();

    //     // ukur brp banyak character string untuk 1 halaman
    //     // $jumlah_string = str_word_count($teks);

    //     // // Hitung jumlah halaman yang diperlukan
    //     // $kapasitas_per_halaman = 500; // Misalnya, 1000 string per halaman
    //     // $jumlah_halaman = ceil($jumlah_string / $kapasitas_per_halaman);
    //     // $chunktext = splitString($teks, $kapasitas_per_halaman);
    //     // return $jumlah_halaman;


    //     // Ambil tanggal dari $data
    //     $tanggal_kontrak = Carbon::parse($kontrak->date_kontrak);
    //     $arrDateSplit = explode('-', $kontrak->date_kontrak); //thn - bulan -tanggal
    //     // dd($arrDateSplit);
    //     // Buat hari dan tanggal kontrak
    //     $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
    //     // dd($tanggal_tertulis);

    //     $pihak1data = Setting::find(1);
    //     $pihak2data = VendorText::where('registration_no', @$kontrak->integrates[0]->registration_no)->first();
    //     $pihak2name = @$pihak2data->pihakname;
    //     $pihak1name = @$pihak1data->peruri_pihakname;
    //     // print_r($chunktext);
    //     // die;
    //     $data = [
    //         'data' => $kontrak,
    //         'pihak2name' => $pihak2name,
    //         'pihak1name' => $pihak1name,
    //         'pihak1data' => $pihak1data,
    //         'pihak2data' => $pihak2data,
    //         'tanggal_tertulis' => $tanggal_tertulis,
    //         // 'page_estimated_pasal' => $jumlah_halaman,
    //         // 'kapasitas_per_halaman' => $kapasitas_per_halaman,
    //         // 'chunktext' => $chunktext,
    //     ];
    //     $pdf = PDF::loadview('cetak_kontrak_pdf', $data);
    //     // Set opsi setRemoteEnable
    //     return $pdf->stream("kontrak_" . $kontrak->detail_number . "pdf");
    // }


    function cetakKontrak($id)
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
        $tanggal_kontrak    = Carbon::parse($kontrak->date_kontrak);
        $arrDateSplit       = explode('-', $kontrak->date_kontrak); //thn - bulan -tanggal
        // dd($arrDateSplit);
        // Buat hari dan tanggal kontrak
        $tanggal_tertulis = $tanggal_kontrak->isoFormat('dddd') . ", tanggal " . terbilang($arrDateSplit[2]) . " bulan " . getMonthIndo($tanggal_kontrak->isoFormat('M')) . " tahun " . terbilang($arrDateSplit[0]);
        // dd($tanggal_tertulis);

        $pihak1data = Setting::find(1);
        $pihak2data = VendorText::where('registration_no', @$kontrak->integrates[0]->registration_no)->first();
        $pihak2name = @$pihak2data->pihakname;
        $pihak1name = @$pihak1data->peruri_pihakname;
        $teks       = "";
        // Hitung jumlah pasal
        $total_pasal = count($kontrak->pasal);
        foreach ($kontrak->pasal as $key => $p) {
            $teks .= '
                    <div class="boxpasal" style="text-align: justify; font-size: 14px;">
                        <h4 style="text-align: center">' . $p->nama_pasal . '
                            <br>' . $p->keterangan_pasal . '
                        </h4>
                        ' . $p->isi_pasal . '
                    </div>
                    <div style="margin-top: -19px; margin-bottom: -50px;"></div>';
            // Jika ini adalah iterasi terakhir, tambahkan teks tambahan
            if ($key === $total_pasal - 1) {
                $teks .= '<div><br></div>
                <p style="text-align: justify; font-size: 14px;">Demikian Perjanjian ini dibuat dalam 2 (dua) rangkap ASLI masing-masing sama bunyi dan bermeterai cukup serta mempunyai kekuatan hukum yang sama setelah ditandatangani dan dibubuhi cap perusahaan kedua belah pihak.</p>
                        <div><br></div>
                        <div><br></div>
                        <div><br></div>
                        <div><br></div>
                        <table style="width: 100%;
                                border-collapse: collapse;
                                margin-top: -50px;">
                            <tr>
                                <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                                <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                                        <div style=""><b>' . $pihak2name . '</b></div>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                                        <div style=""><b>' . $pihak1name . '</b></div>
                                    </div>
                                </td>
                            </tr>
                        </table>';
            }
        }

        $datalampiran1 = $kontrak->lampiran1;
        $showdtlampiran1 = json_decode($datalampiran1->data_json, true);


        $data = [
            'data'              => $kontrak,
            'pihak2name'        => $pihak2name,
            'pihak1name'        => $pihak1name,
            'pihak1data'        => $pihak1data,
            'pihak2data'        => $pihak2data,
            'tanggal_tertulis'  => $tanggal_tertulis,
            'teks'              => $teks,
            'showdtlampiran1'   => $showdtlampiran1,
        ];
        // saving pasalpdf
        $page1                  = $this->downloadpageone($data);
        $pathpage1              = storage_path('app/public/pdf/' . $page1);
        $pagepasal              = $this->downloadpasal($data);
        $pathpagepasal          = storage_path('app/public/pdf/' . $pagepasal);
        // return $pathpagepasal; //http://localhost:8000/storage/pdf/pasal_jenis2.pdf
        $pagelampiran1          = $this->downloadcontentlampiran1($data);
        $pathpagelampiran1      = storage_path('app/public/pdf/' . $pagelampiran1);
        // return $pathpagelampiran1;
        // return $pagelampiran1;
        $pagelampiran2          = $this->downloadcontentlampiran2($data);
        $pathpagelampiran2      = storage_path('app/public/pdf/' . $pagelampiran2);
        // return $pathpagelampiran2;
        $pagelampiran3          = $this->downloadcontentlampiran3($data);
        $pathpagelampiran3      = storage_path('app/public/pdf/' . $pagelampiran3);
        // return $pagelampiran3;
        $pagenextcontent        = $this->downloadnextcontent($data);
        $pathpagenextcontent    = storage_path('app/public/pdf/' . $pagenextcontent);

        $mergepdf               = PDFMerger::init();

        $mergepdf->addPDF($pathpage1, 'all');
        $mergepdf->addPDF($pathpagepasal, 'all');
        $mergepdf->addPDF($pathpagelampiran1, 'all');
        $mergepdf->addPDF($pathpagelampiran2, 'all');
        $mergepdf->addPDF($pathpagelampiran3, 'all');
        $mergepdf->addPDF($pathpagenextcontent, 'all');


        $mergefileName = "kontrak_" . $kontrak->id . ".pdf";
        $mergepdf->merge();
        $mergepdf->save(public_path($mergefileName));

        return response()->download(public_path($mergefileName));
        // return $pdf->stream("kontrak_" . $kontrak->detail_number . "pdf");
    }
    private function downloadpageone($data)
    {
        $pdf            = PDF::loadview('pageonepdf', $data);
        $fileName       = "kontrak_" . $data['data']->id . "_page1.pdf"; // Nama file yang diinginkan
        $content        = $pdf->download()->getOriginalContent();
        $pageone        = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }
    private function downloadpasal($data)
    {
        $pdf            = PDF::loadview('pasalpdf2', $data);
        $fileName       = "pasal_jenis" . $data['data']->pasal[0]->jenis_pasal . ".pdf"; // Nama file yang diinginkan
        $content        = $pdf->download()->getOriginalContent();
        $pasalpdf       = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }
    private function downloadcontentlampiran1($data)
    {
       
        $fileName       = "lampiran1" . $data['data']->lampiran1[0] . ".pdf"; // Nama file yang diinginkan

        $total = 0;
        $data['totalPages'] = $total;
        $pdf            = PDF::loadview('contentlampiran1', $data);
        $pdf->render();
        $totalnya = $pdf->getDomPDF()->get_canvas()->get_page_count();
        $data['totalPages'] = $totalnya;
        $pdf            = PDF::loadview('contentlampiran1', $data);


        $content        = $pdf->download()->getOriginalContent();
        $lampiran1pdf   = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }
    private function downloadcontentlampiran2($data)
    {
        $pdf            = PDF::loadview('contentlampiran2', $data);
        $fileName       = "lampiran2" . $data['data']->lampiran2[0] . ".pdf"; // Nama file yang diinginkan
        $content        = $pdf->download()->getOriginalContent();
        $lampiran2pdf   = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }
    private function downloadcontentlampiran3($data)
    {
        $fileName       = "lampiran3" . $data['data']->lampiran3[0]->jenis_spesifikasi . ".pdf"; // Nama file yang diinginkan
        if ($data['data']->lampiran3[0]->jenis_spesifikasi == '2') {
            // nonstandar
            $total = 0;
            $data['totalPages'] = $total;
            $pdf            = PDF::loadview('contentlampiran3', $data);

            $pdf->render();
            $totalnya = $pdf->getDomPDF()->get_canvas()->get_page_count();
            $data['totalPages'] = $totalnya;
            $pdf            = PDF::loadview('contentlampiran3', $data);
        } else {
            $pdf            = PDF::loadview('contentlampiran3standar', $data);
        }

        // return $pdf->stream($fileName);
        $content        = $pdf->download()->getOriginalContent();
        $lampiran3pdf   = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }

    private function downloadnextcontent($data)
    {
        $pdf            = PDF::loadview('nextcontentpdf', $data);
        $fileName       = "kontrak_" . $data['data']->id . "_nextpage.pdf"; // Nama file yang diinginkan
        $content        = $pdf->download()->getOriginalContent();
        $nextcontent    = Storage::put('public/pdf/' . $fileName, $content);
        return $fileName;
    }

    public function logKontrak(Request $request, $id)
    {
        $kontrak = Kontrak::with(['logs.user'])->findOrFail($id);

        // inisialisasi array untuk simpan log waktu
        $logWaktu = [];

        // tentukan start waktu pembuatan kontrak
        $waktuAwal = $kontrak->created_at;

        // iterasi
        foreach ($kontrak->logs as $log) {
            // jika status approvedkadiv
            if ($log->status === 'approvedkadiv') {
                // simpan waktu ketika status berubah
                $logWaktu[] = $log->created_at;
            }
        }

        // Jika tidak ada log status "approvedkadiv", gunakan waktu sekarang
        if (empty($logWaktu)) {
            $logWaktu[] = now();
        }

        // urutkan waktu 
        sort($logWaktu);

        // ambil waktu paling akhir dari log
        $waktuAkhir = end($logWaktu);

        // hitung lama proses pembuatan kontrak
        $lamaProses = $waktuAwal->diffInDays($waktuAkhir);

        return view('logkontrak', compact('kontrak', 'lamaProses', 'waktuAwal', 'waktuAkhir'));
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

        // // dapatkan informasi kadept untuk notif
        // $kadept = User::where('permission', 'kadept')->first();

        // // dapatkan informasi kadept untuk notif
        // $kadiv = User::where('permission', 'kadiv')->first();

        // // kirim notif kepada kadept
        // if ($kadept) {
        //     $kadept->notify(new SetujuiKontrakNotification(auth()->user(), $kontrak, $kadept));
        // }

        // // kirim notif kepada kadiv
        // if ($kadiv) {
        //     $kadiv->notify(new SetujuiKontrakNotification(auth()->user(), $kontrak, $kadiv));
        // }


        // Tentukan user yang akan menerima notifikasi
        $recipient = null;
        $penerimaNotif = null;
        if ($nextstatus === 'reviewkadept') {
            // Jika status reviewkadept, notifikasi dikirim kepada user dengan permission kadept
            $recipient = User::where('permission', 'kadept')->first();
        } elseif ($nextstatus === 'reviewkadiv') {
            // Jika status reviewkadiv, notifikasi dikirim kepada user dengan permission kadiv
            $recipient = User::where('permission', 'kadiv')->first();
        } elseif ($nextstatus === 'approvedkadiv') {
            // jika status sudah net approved kadiv, maka semua staff,kasek,kadept dapat notif

            // Cari Kadept
            $kadept = User::where('permission', 'kadept')->first();

            // Cari Kasek berdasarkan unit kerja di dalam kontrak
            $kasek = User::where('permission', 'kasek')
                ->where('unit_kerja', $kontrak->unit_kerja)
                ->first();

            // Cari user dengan permission 'writer' atau 'admin' yang sama dengan pembuat kontrak
            $userWriters = User::where('name', $kontrak->pembuat)
                ->whereIn('permission', ['writer', 'admin'])
                ->first();


            // Gabungkan semua penerima notifikasi 
            $penerimaNotif = collect([$kadept, $kasek, $userWriters])->unique('id')->values()->all();

            // dd($penerimaNotif);
        }

        // Jika ada penerima notifikasi, kirim notifikasi
        if ($recipient) {
            $recipient->notify(new SetujuiKontrakNotification(auth()->user(), $kontrak, $recipient));
        }

        // notif jika approvedkadiv
        if ($penerimaNotif) {
            foreach ($penerimaNotif as $user) {
                $user->notify(new NetKontrakNotification(auth()->user(), $kontrak));
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
        // dd($request->all());
        // Validasi data
        $validated = $request->validate([
            'kontraks_id'   => 'required',
            'revisi'        => 'required',
        ]);

        $kontrak = Kontrak::find($validated['kontraks_id']);
        // Simpan data revisi
        $data['kontraks_id']    = $validated['kontraks_id'];
        $data['revisi']         = $validated['revisi'];
        $data['user_id']        = auth()->id();
        $status                 = '';

        // Tentukan status berdasarkan izin pengguna
        $userPermission = auth()->user()->permission;
        // buat variabel untuk pengguna sebelumnya yang akan dapet notif email
        $previousRole = [];
        switch ($userPermission) {
            case 'kadept':
                $previousRole['kasek']  = User::where('permission', 'kasek')->where('unit_kerja', $kontrak->unit_kerja)->get();
                $status                 = 'revisikadept';
                break;
            case 'kadiv':
                $previousRole['kasek']  = User::where('permission', 'kasek')->where('unit_kerja', $kontrak->unit_kerja)->get();
                $previousRole['kadept'] = User::where('permission', 'kadept')->get();
                $status                 = 'revisikadiv';
                break;
            default:
                $previousRole   = ''; // Tidak ada role sebelumnya untuk kasek
                $status         = 'revisikasek';
                break;
        }


        try {
            DB::beginTransaction();

            // Buat entri revisiKontrak
            $revisi = revisiKontrak::create($data);

            // notif flash
            // flash()->addFlash('success', 'Revisi Berhasil Dikirim!');

            // KONDISI UNTUK KASIH NOTIF DATABASE KETIKA REVISI DIBERIKAN OLEH KASEK,KADEPT,KADIV KEPADA STAFF
            if ($kontrak) {
                // Temukan pembuat kontraknya
                $userWriters = User::where('name', $kontrak->pembuat)
                    ->whereIn('permission', ['writer', 'admin'])
                    ->get();

                // Kirim notifikasi ke setiap penulis yang cocok
                foreach ($userWriters as $user) {
                    $user->notify(new RevisiKontrakNotification($revisi));
                }
            }

            // NOTIF UNTUK USER SEBELUMNYA JIKA YANG REVISI KADEPT ATAU KADIV
            if (!empty($previousRole)) {
                foreach ($previousRole as $roleUser) {
                    foreach ($roleUser as $user) {
                        $user->notify(new RevisiKontrakNotification($revisi));
                    }
                }
            }

            // Perbarui status kontrak
            if ($kontrak) {
                $kontrak->status = $status;
                $kontrak->save();

                // $noteRevisi = revisiKontrak::where('kontraks_id', $kontrak->id)->latest()->first();

                // Ambil alamat email pembuat kontrak dari tabel User
                // $pembuat = $kontrak->pembuat;
                // $emailPembuat = User::where('name', $pembuat)->value('email');
                // $user = User::where('email', $emailPembuat)->first();

                // Kirim email notifikasi kepada pembuat kontrak
                // if ($kontrak && $noteRevisi) {
                // $user->notify(new KontrakRevisiNotification($kontrak, $noteRevisi, $user));
                // }

                // Kirim notifikasi email kepada pengguna dengan role sebelumnya
                // jika yang beri revisi kadept, maka kasek dan staff dapat email, jika yang beri revisi kasek maka staff aja yang dapat email, jika kadiv yang revisi, kadept,kasek dan staff dapat notif email.
                // if (!empty($previousRole)) {
                // $previousUsers = User::where('permission', $previousRole)->get();
                // foreach ($previousUsers as $previousUser) {
                //     $previousUser->notify(new KontrakRevisiNotification($kontrak, $noteRevisi));
                // }
                // foreach ($previousRole as $roleUser) {
                // foreach ($roleUser as $user) {
                // $user->notify(new KontrakRevisiNotification($kontrak, $noteRevisi, $user));
                // }
                // }
                // }
            }

            // Buat entri log
            $kontrak->logs()->create([
                'status' => $status,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Revisi Gagal Dibuat', 'redirect' => route('createRevisi')]);
        }

        // Response JSON dengan pesan sukses dan redirect ke halaman monitoring
        return response()->json(['message' => 'Revisi Berhasil Dibuat', 'redirect' => route('rKontrak')]);
    }



    public function showRevisi($id)
    {
        // Ambil data revisi berdasarkan kontraks_id
        $revisi = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where('kontraks_id', $id)->first();

        // auth()->user()->unreadNotifications->where('id', request('id'))->first()->markAsRead();
        // Tampilkan view untuk menampilkan data revisi
        return view('viewRevisi', compact('revisi'));
    }


    public function showNotifRevisi($id)
    {
        // Ambil data revisi berdasarkan kontraks_id
        $revisi = revisiKontrak::with('user')
            ->latest()->take(1)
            ->where('kontraks_id', $id)->first();

        auth()->user()->unreadNotifications->where('id', request('id'))->first()->markAsRead();
        // Tampilkan view untuk menampilkan data revisi
        return view('showRevisiNotif', compact('revisi'));
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

    public function indexSOP(Request $request)
    {
        // echo 'TAMPIL DATA SOP';
        // $data = Integrate::orderBy('document_date', 'desc')->get();
        // $data = Integrate::withCount('purchaseRequisitions')->orderBy('document_date', 'desc')->get()
        // ==========================================================================================================================

        $data = Integrate::select('purchasing_document_number', 'document_date', 'tender_name', 'vendor_name')->distinct()->with('purchaseRequisitions')->orderBy('document_date', 'desc')->get();


        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by nOMOR SOP
        if ($request->no_sop) {
            $data = Integrate::where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')->get();
        }

        // search by PERIHAL
        if ($request->perihal) {
            $data = Integrate::where('tender_name', 'LIKE', '%' . $request->perihal . '%')->get();
        }

        // search by rentang tgl sop (contoh : 01 april 2024 - 06 april 2024)
        if ($request->startdate && $request->enddate) {

            $data = Integrate::where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }


        // search by nama vendor & no sop
        if ($request->nm_vendor && $request->no_sop) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->get();
        }

        // search by nama vendor & perihal
        if ($request->nm_vendor && $request->perihal) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->get();
        }

        // search by nama vendor & tanggal sop
        if ($request->nm_vendor && $request->startdate && $request->enddate) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by NO SOP & perihal
        if ($request->no_sop && $request->perihal) {
            $data = Integrate::where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->get();
        }

        // search by nO SOP & tanggal sop
        if ($request->no_sop && $request->startdate && $request->enddate) {
            $data = Integrate::where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by perihal & tanggal sop
        if ($request->perihal && $request->startdate && $request->enddate) {
            $data = Integrate::where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & no sop & rentang tanggal
        if ($request->nm_vendor && $request->no_sop && $request->startdate && $request->enddate) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & perihal & rentang tanggal
        if ($request->nm_vendor && $request->perihal && $request->startdate && $request->enddate) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by no sop & perihal & rentang tanggal
        if (
            $request->no_sop && $request->perihal && $request->startdate && $request->enddate
        ) {
            $data = Integrate::where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }

        // search by no sop & perihal & rentang tanggal
        if (
            $request->nm_vendor && $request->no_sop && $request->perihal && $request->startdate && $request->enddate
        ) {
            $data = Integrate::where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('tender_name', 'LIKE', '%' . $request->perihal . '%')
                ->where('document_date', '>=', $request->startdate)
                ->where('document_date', '<=', $request->enddate)
                ->get();
        }


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

        $exportPertanggal = Kontrak::orderBy('created_at', 'desc')->whereBetween('tanggal_sop', [$tglawal, $tglakhir])->get();

        return view('export.cetak-kontrak-pertanggal-pdf', compact('exportPertanggal'));
    }


    public function viewExport()
    {
        return view('export.cetak-excel-kontrak');
    }


    public function export(Request $request)
    {
        // dd($request->all());
        $filterType     = $request->input('filter_type');
        $filterValue    = $request->input('filter_value');
        $year           = $request->input('year'); //ambil nilai tahun dari inputan
        $month          = $request->input('month'); // Menangkap nilai bulan dari input

        $contracts = Kontrak::query();

        if ($filterType && $filterValue) {

            if ($filterType === 'year') {
                $contracts->whereYear('tanggal_sop', $filterValue);
            } elseif ($filterType === 'month') {
                // Validasi apakah tahun dan bulan telah dipilih
                if (!$year || !$month) {
                    return redirect()->back()->with('error', 'Bulan dan Tahun Belum Terisi!');
                }

                //tangkep nilai bulan dari inputan
                $monthValue = strlen($month) == 1 ? '0' . $month : $month;
                $contracts->whereYear('tanggal_sop', $year)->whereMonth('tanggal_sop', $monthValue);
            } elseif ($filterType === 'date') {
                // Pisahkan rentang tanggal
                $dates      = explode(' - ', $filterValue);
                $startDate  = $dates[0];
                $endDate    = $dates[1];

                // Terapkan filter rentang tanggal
                $contracts->whereBetween('tanggal_sop', [$startDate, $endDate]);
            }
        }

        $contracts = $contracts->get();

        return Excel::download(new KontrakExport($contracts), 'data-kontrak.xlsx');
    }



    // method untuk view data kontrak yang statusnya approvedkadiv saja untuk taro tombol upload
    public function KontrakAK(Request $request)
    {
        $data = Kontrak::orderBy('updated_at', 'DESC')->where('status', 'approvedkadiv')->get();

        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by nomor sop
        if ($request->no_sop) {
            $data = Kontrak::where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')->get();
        }

        // search by unit kerja
        if ($request->unit_kerja) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')->get();
        }

        // sesarch by jenis kontrak
        if ($request->jenis_kontrak) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')->get();
        }

        // search by status jaminan
        if ($request->status_jaminan) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')->get();
        }

        // search by rentang tgl sp (contoh : 01 april 2024 - 06 april 2024)
        if ($request->startdate && $request->enddate) {

            $data = Kontrak::where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & no sop
        if ($request->nm_vendor && $request->no_sop) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->get();
        }

        // search by nama vendor & unit kerja
        if ($request->nm_vendor && $request->unit_kerja) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor & jenis kontrak
        if ($request->nm_vendor && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor & status jaminan
        if ($request->nm_vendor && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor & tanggal sp
        if ($request->nm_vendor && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by no sop & unit kerja
        if ($request->no_sop && $request->unit_kerja) {
            $data = Kontrak::where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by no sop & jenis kontrak
        if ($request->no_sop && $request->jenis_kontrak) {
            $data = Kontrak::where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by no sop & status jaminan
        if ($request->no_sop && $request->status_jaminan) {
            $data = Kontrak::where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by no sop & tanggal sp
        if ($request->no_sop && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja & jenis kontrak
        if ($request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by unit kerja & status jaminan
        if ($request->unit_kerja && $request->status_jaminan) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja & tanggal sp
        if ($request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by jenis kontrak & status jaminan
        if ($request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by jenis kontrak & tanggal sp
        if ($request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status jaminan & tanggal sp
        if ($request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }


        // search by status jaminan & tanggal sp
        if ($request->nm_vendor && $request->no_sop && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('nomor_sop', 'LIKE', '%' . $request->no_sop . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jeni_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // dd($data);

        return view('viewKontrakAK', compact('data'));
    }

    public function storeUploadKontrak(Request $request, $id)
    {
        // dd($request->all());
        extract($request->all());

        // $validated = $request->validate([
        //     'statusdoc'     => 'required'
        // ]);

        // $data['statusdoc'] = $validated['statusdoc'];

        // ambil kontrak based on id nya
        $docKontrak = Kontrak::find($id);

        // buat kondisi cek apakah kontrak tersebut ada?
        if ($docKontrak) {
            // lanjut cek apakah sudah pernah upload belum? dengan cek kolom dockontrak
            if ($docKontrak->dockontrak) {
                Storage::delete($docKontrak->dockontrak);
                // set nilai kolom jadi kosong
                $docKontrak->dockontrak     = null;
                $docKontrak->tipedoc        = null;
                $docKontrak->ukdok          = null;
                $docKontrak->statusdoc      = null;
                $docKontrak->save();
            }

            // simpan dokumen yang baru diunggah
            $fileDoc = $request->file('docKontrak');
            $docName = time() . '-' . $fileDoc->getClientOriginalName();
            $pathDoc = $fileDoc->storeAs('public/uploads/document_kontrak', $docName);

            // update kolom namadoc,tipedoc,ukdoc dengan document baru
            $docKontrak->dockontrak     = $pathDoc;
            $docKontrak->tipedoc        = $fileDoc->guessExtension();
            $docKontrak->ukdok          = $fileDoc->getSize();
            $docKontrak->statusdoc      = $request->statusdoc;
            $docKontrak->save();

            return redirect()->back()->with('success', 'Dokumen Kontrak Berhasil di Unggah!');
        } else {

            return redirect()->back()->with('error', 'Kontrak Tidak Ditemukan!');
        }
    }

    public function downloadDocKontrak(Request $request, $id)
    {
        // Temukan kontrak berdasarkan ID
        $kontrak = Kontrak::find($id);

        // Pastikan kontrak ditemukan
        if (!$kontrak) {
            return redirect()->back()->with('error', 'Kontrak tidak ditemukan!');
        }

        // Mendapatkan path dokumen
        $path = $kontrak->dockontrak;

        // Pastikan dokumen ada di storage
        if (!Storage::exists($path)) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan di storage!');
        }

        // Mendapatkan nama dokumen
        $fileName = basename($path);

        // Mengembalikan dokumen sebagai response unduhan
        return response()->download(storage_path('app/' . $path), $fileName);
    }

    // Fungsi untuk mendapatkan peran pengguna yang sedang login
    public function getLoggedInUserRole()
    {
        // Memeriksa apakah pengguna telah diautentikasi
        if (Auth::check()) {
            // Mendapatkan objek pengguna yang sedang diautentikasi
            $user = Auth::user();

            // dd($user);
            // Mengembalikan izin pengguna
            return $user->permission;
        } else {
            // Jika pengguna belum diautentikasi, kembalikan null atau nilai default
            return null;
        }
    }


    // METHOD VIEW KONTRAK YANG PROSES
    public function KontrakonProcess(Request $request)
    {
        $data = Kontrak::orderBy('updated_at', 'DESC')->where('status', '!=', 'approvedkadiv')->get();

        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by status
        if ($request->status) {
            // return dd($request->status);
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')->get();
        }

        // search by unit kerja
        if ($request->unit_kerja) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')->get();
        }

        // sesarch by jenis kontrak
        if ($request->jenis_kontrak) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')->get();
        }

        // search by status jaminan
        if ($request->status_jaminan) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')->get();
        }

        // search by rentang tgl sp (contoh : 01 april 2024 - 06 april 2024)
        if ($request->startdate && $request->enddate) {

            $data = Kontrak::where(
                'date_kontrak',
                '>=',
                $request->startdate
            )
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor & status
        if ($request->nm_vendor && $request->status) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->get();
        }

        // search by nama vendor & unit kerja
        if (
            $request->nm_vendor && $request->unit_kerja
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor & jenis kontrak
        if ($request->nm_vendor && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor & status jaminan
        if ($request->nm_vendor && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor & tanggal sp
        if (
            $request->nm_vendor && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //==============================SEARCH BY STATUS ================

        // search by status dan unit kerja
        if ($request->status && $request->unit_kerja) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by status dan jenis kontrak
        if ($request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status dan status jaminan
        if ($request->status && $request->status_jaminan) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by status & tanggal sp
        if (
            $request->status && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============================== search by unit kerja ==========
        // search by unit kerja dan jenis kontrak
        if ($request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by unit kerja dan status jaminan
        if ($request->unit_kerja && $request->status_jaminan) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja & tanggal sp
        if (
            $request->unit_kerja && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //================= search by jenis kontrak =========================================================================================

        // search by jenis kontrak dan status jaminan
        if ($request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by jenis kontrak & tanggal sp
        if (
            $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //============= search by status jaminan ==================================================================================
        // search by status jaminan & tanggal sp
        if (
            $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status, unit kerja ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->unit_kerja) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->get();
        }

        // search by nama vendor, status, jenis kontrak ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by nama vendor, status, status jaminan ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by nama vendor, status, tanggal sp ============================================================================================================
        if ($request->nm_vendor && $request->status && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, jenis kontrak =======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        //=============================== search by nama vendor, unit kerja, status jaminan=======================================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // ========================================== search by nama vendor, unit kerja, tanggal sp ==============================================================
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak status jaminan ===================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->status_jaminan) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        //=============================== search by nama vendor, jenis kontrak, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        //=============================== search by nama vendor, status jaminan, tanggal sp ======================================================================
        if ($request->nm_vendor && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak =======================================================================================================
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by status, unit kerja, nama vendor dan jenis_kontrak
        if (
            $request->status && $request->unit_kerja && $request->nm_vendor && $request->jenis_kontrak
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->get();
        }

        // search by all data spesifik
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
            && $request->nm_vendor
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }


        // search by unit kerja, jenis_kontrak dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->get();
        }

        // search by unit kerja, jenis_kontrak, nama vendor dan status jaminan
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->nm_vendor
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->get();
        }

        // search by nama vendor dan unit kerja dan tgl sp
        if ($request->nm_vendor && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by nama vendor, status dan tgl sp
        if ($request->nm_vendor && $request->status && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }


        // search by status dan unit kerja dan tgl sp
        if ($request->status && $request->unit_kerja && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan jenis kontrak dan tgl sp
        if (
            $request->status && $request->jenis_kontrak
            && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status dan status jaminan dan tgl sp
        if ($request->status && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status, unit kerja dan jenis_kontrak dan tgl sp
        if (
            $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by status,unit kerja, jenis kontrak, status jaminan & tgl sp
        if ($request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by all data spesifik & tgl sp
        if ($request->nm_vendor && $request->status && $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('nm_vendor', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('status', 'LIKE', '%' . $request->status . '%')
                ->where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan jenis kontrak & tgl sp
        if ($request->unit_kerja && $request->jenis_kontrak && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja dan status jaminan & tgl sp
        if ($request->unit_kerja && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by unit kerja, jenis_kontrak dan status jaminan serta tgl sp
        if (
            $request->unit_kerja && $request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate
        ) {
            $data = Kontrak::where('unit_kerja', 'LIKE', '%' . $request->unit_kerja . '%')
                ->where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }

        // search by jenis kontrak dan status jaminan & tgl sp
        if ($request->jenis_kontrak && $request->status_jaminan && $request->startdate && $request->enddate) {
            $data = Kontrak::where('jenis_kontrak', 'LIKE', '%' . $request->jenis_kontrak . '%')
                ->where('status_jaminan', 'LIKE', '%' . $request->status_jaminan . '%')
                ->where('date_kontrak', '>=', $request->startdate)
                ->where('date_kontrak', '<=', $request->enddate)
                ->get();
        }



        // dd($data);

        return view('viewKontrakProses', compact('data'));
    }
}
