<?php

namespace App\Http\Controllers;

use App\Models\Integrate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class VendorController extends Controller
{
    // FUNCTION VIEW ALL DATA VENDOR ============================================================================================
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

        return view('vendor.indexVendor', compact('data'));
    }

    // FUNCTION BUKA VIEW EDIT VENDOR ========================================================================================

    public function edit($registration_no)
    {
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
            ->where(['integrates.registration_no' => $registration_no])
            ->firstOrFail();
        return view('vendor.editVendor', compact('data'));
    }

    // FUNCTION UPDATE AKTA VENDOR ============================================================================================

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

    // FUNCTION GET NPWP VENDOR ============================================================================================

    public function npwp_data($no_vendor)
    {
        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->get("https://scm.peruri.co.id/Api/getSIapdaNPWP/$no_vendor");

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

    // FUNCTION GET PEJABAT VENDOR ==========================================================================================

    public function Pejabat_vendor($no_vendor)
    {
        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->get("https://scm.peruri.co.id/Api/getsiapdainfo/$no_vendor");

        if ($response->successful()) {
            $dataNama = $response->json();
            // dd($dataNama);

            // Inisialisasi variabel untuk menyimpan nama pejabat vendor
            $namaPejabat = null;

            // Iterasi melalui setiap baris data
            foreach ($dataNama as $row) {
                // Periksa jika board_type nya adalah "BOD (Board of Director) – Direksi"
                if ($row['board_type'] === 'BOD (Board of Director) – Direksi') {
                    // dd($row);
                    // Simpan nama pejabatnya
                    $namaPejabat = $row['full_name'];
                    // Keluar dari loop karena sudah ditemukan data yang sesuai
                    break;
                }
            }

            // Periksa apakah nama pejabatnya ditemukan
            if ($namaPejabat !== '') {
                // Kembalikan nama pejabatnya dalam response JSON
                return response()->json(['full_name' => $namaPejabat]);
            } else {
                // Jika tidak ada nama pejabat yang ditemukan, kembalikan response kosong
                return response()->json(['message' => 'Nama Pejabat tidak ditemukan.'], 404);
            }
        } else {
            // Jika request tidak berhasil, kembalikan response error
            return response()->json(['message' => 'Gagal mengambil data Pejabat Vendor.'], $response->status());
        }
    }

    // FUNCTION GET ALAMAT VENDOR ============================================================================================

    public function Alamat_vendor($no_vendor)
    {
        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->get("https://scm.peruri.co.id/Api/getsiapdainfo/$no_vendor");

        if ($response->successful()) {
            $data = $response->json();

            // Inisialisasi variabel untuk menyimpan alamat lengkap
            $alamatLengkap = null;

            // Iterasi melalui setiap baris data
            foreach ($data as $row) {
                // Gabungkan data alamat menjadi satu string
                $alamatLengkap = $row['alamat'] . ', ' . $row['sub_district'] . ', ' . $row['kota'] . ', ' . $row['provinsi'];
                // Keluar dari loop karena sudah ditemukan data yang sesuai
                break;
            }

            // dd($alamatLengkap);
            // Periksa apakah alamat lengkapnya ditemukan
            if ($alamatLengkap !== null) {
                // Kembalikan alamat lengkapnya dalam response JSON
                return response()->json(['alamat' => $alamatLengkap]);
            } else {
                // Jika tidak ada alamat yang ditemukan, kembalikan response kosong
                return response()->json(['message' => 'Alamat tidak ditemukan.'], 404);
            }
        } else {
            // Jika request tidak berhasil, kembalikan response error
            return response()->json(['message' => 'Gagal mengambil data Alamat Vendor.'], $response->status());
        }
    }


    // end class
}
