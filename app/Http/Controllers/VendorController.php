<?php

namespace App\Http\Controllers;

use App\Models\Integrate;
use App\Models\Vendor;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Http;
use PDF;


class VendorController extends Controller
{
    public function index(Request $request)
    {
        $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->get();

        // search by nama vendor
        if ($request->nm_vendor) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')->get();
        }

        // search by nO REGIS
        if ($request->no_regis) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('registration_no', 'LIKE', '%' . $request->no_regis . '%')->get();
        }

        // search by no sop
        if ($request->no_sop) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')->get();
        }


        // search by nama vendor dan no regis
        if ($request->nm_vendor && $request->no_regis) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('registration_no', 'LIKE', '%' . $request->no_regis . '%')
                ->get();
        }

        // search by nama vendor dan no sop
        if ($request->nm_vendor && $request->no_sop) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->get();
        }

        // search by no regis & no sop
        if ($request->no_sop && $request->no_regis) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('registration_no', 'LIKE', '%' . $request->no_regis . '%')
                ->get();
        }

        // search by no regis & no sop & nama vendor
        if ($request->nm_vendor &&  $request->no_sop && $request->no_regis) {
            $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->where('vendor_name', 'LIKE', '%' . $request->nm_vendor . '%')
                ->where('purchasing_document_number', 'LIKE', '%' . $request->no_sop . '%')
                ->where('registration_no', 'LIKE', '%' . $request->no_regis . '%')
                ->get();
        }

        return view('indexVendor', compact('data'));
    }

    public function edit($registration_no)
    {
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
            ->where(['integrates.registration_no' => $registration_no])
            ->firstOrFail();
        return view('editVendor', compact('data'));
    }

    public function update(Request $request, $registration_no)
    {
        // dd($request->all());
        extract($request->all());
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
            ->where(['integrates.registration_no' => $registration_no])
            ->firstOrFail();

        // hapus dulu vendortext
        $data->vendortext()->delete();
        $data->vendortext()->create([
            'pihakname'             => $pihakname,
            'npwp'                  => $npwp,
            'akta'                  => $akta,
        ]);
        return redirect()->route('vendor.index');
    }



    // public function npwp_data($no_vendor)
    // {
    //     $dataNpwp = json_decode(Http::timeout(60)
    //         ->withOptions(['verify' => false])
    //         ->get("https://scm.peruri.co.id/Api/getSIapdaNPWP/$no_vendor"), true);
    //     $npwpnya = $dataNpwp['tax_document_number'];
    //     dd($npwpnya);
    //     return response()->json(['tax_document_number' => $npwpnya]);
    // }


    public function npwp_data($no_vendor)
    {
        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->get("https://scm.peruri.co.id/Api/getSIapdaNPWP/$no_vendor");

        // Check if the HTTP request was successful (status code 2xx)
        if ($response->successful()) {
            $dataNpwp = $response->json();
            // dd($dataNpwp);

            // Inisialisasi variabel untuk menyimpan nomor NPWP
            $npwpnya = null;

            // Iterasi melalui setiap baris data
            foreach ($dataNpwp as $row) {
                // Periksa jika tax_document_type nya adalah "Nomor Pokok Wajib Pajak / Tax Identification Number"
                if ($row['tax_document_type'] === 'Nomor Pokok Wajib Pajak / Tax Identification Number') {
                    // dd($row);
                    // Simpan nomor NPWP
                    $npwpnya = $row['tax_document_number'];
                    // Keluar dari loop karena sudah ditemukan data yang sesuai
                    break;
                }
            }

            // dd($npwpnya);

            // Periksa apakah nomor NPWP ditemukan
            if ($npwpnya !== '') {
                // Kembalikan nomor NPWP dalam response JSON
                return response()->json(['tax_document_number' => $npwpnya]);
            } else {
                // Jika tidak ada nomor NPWP yang ditemukan, kembalikan response kosong
                return response()->json(['message' => 'Nomor NPWP tidak ditemukan.'], 404);
            }
        } else {
            // Jika request tidak berhasil, kembalikan response error
            return response()->json(['message' => 'Gagal mengambil data NPWP.'], $response->status());
        }
    }

    // end class
}
