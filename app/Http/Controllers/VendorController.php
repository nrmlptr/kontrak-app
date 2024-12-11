<?php

namespace App\Http\Controllers;

use App\Models\Integrate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

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

    // public function edit($registration_no)
    // {
    //     $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
    //         return $q->where(['primary_data' => '1'])->first();
    //     }])
    //         ->where(['integrates.registration_no' => $registration_no])
    //         ->firstOrFail();
    //     return view('vendor.editVendor', compact('data'));
    // }

    public function edit($registration_no)
    {
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
            ->where(['integrates.registration_no' => $registration_no])
            ->firstOrFail();

        // Format nama vendor agar sesuai kebutuhan
        // $data->vendor_name = formatVendorName($data->vendor_name);

        // dd($data->vendor_name);
        return view('vendor.editVendor', compact('data'));
    }


    // FUNCTION UPDATE AKTA VENDOR ============================================================================================

    // public function update(Request $request, $registration_no)
    // {
    //     // dd($request->all());
    //     extract($request->all());
    //     $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
    //         return $q->where(['primary_data' => '1'])->first();
    //     }])
    //         ->where(['integrates.registration_no' => $registration_no])
    //         ->firstOrFail();

    //     // hapus dulu vendortext
    //     $data->vendortext()->delete();
    //     $data->vendortext()->create([
    //         'pihakname'             => $pihakname,
    //         'npwp'                  => $npwp,
    //         'akta'                  => $akta,
    //     ]);
    //     return redirect()->route('vendor.index');

    // }

    public function update(Request $request, $registration_no)
    {
        // Ambil semua data dari request
        extract($request->all());

        // Ambil data vendor terkait dari database
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
        ->where(['integrates.registration_no' => $registration_no])
        ->firstOrFail();

        // Hapus data vendortext yang lama
        $data->vendortext()->delete();

        // Format pihakname menjadi kapital setiap kata
        $formattedPihakname = ucwords(strtolower($pihakname));

        // Buat ulang data vendortext dengan nama pihak yang diformat
        $data->vendortext()->create([
            'pihakname' => $formattedPihakname,
            'npwp'      => $npwp,
            'akta'      => $akta,
        ]);

        // Redirect ke halaman vendor.index setelah selesai
        return redirect()->route('vendor.index');
    }


    // FUNCTION GET NPWP VENDOR ============================================================================================

    public function npwp_data($no_vendor)
    {
        $bearerToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJleGFtcGxlLmNvbSIsImlhdCI6MTczMzcxMDkzOCwiZXhwIjoxNzM2MzAyOTM4LCJzdWIiOiIyMTcwZDVlNS1hYzc3LTQ3ZWUtYmMyMS1jOGQ5MDM3ZTJjMDAiLCJlbWFpbCI6bnVsbH0.xHmfjOM_vXFMzoP790Sf1lh1vtpmvD7-70FSMJTZvsk';

        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept'        => 'application/json',
            ])
            // ->withToken($bearerToken)
            ->get("http://10.30.11.142/api/V1/getSiapdaNPWP/$no_vendor");

            // get("https://scm.peruri.co.id/Api/getSIapdaNPWP/$no_vendor");
        try {
            $responseBody = $response->body();
            $responseBody = json_decode($responseBody);


            // Pisahkan respons JSON jika terdapat dua array JSON yang digabungkan
            // $responseBodyParts = explode('][', trim($responseBody, '[]'));

            // dd($responseBodyParts);
            $datas = $responseBody->data;
            // dd($datas);

            $dataNpwp = [];
            // foreach ($responseBodyParts as $part) {
            //     $decodedPart = json_decode("[$part]", true);
            //     if (json_last_error() !== JSON_ERROR_NONE) {
            //         return response()->json(['message' => 'Error parsing JSON data: ' . json_last_error_msg()], 500);
            //     }
            //     $dataNpwp = array_merge($dataNpwp, $decodedPart);
            // }

            // Inisialisasi variabel untuk menyimpan nomor NPWP
            $npwpnya = null;

            // Iterasi melalui setiap baris data
            foreach ($datas as $row) {
                if (isset($row->tax_document_type) && $row->tax_document_type === 'Nomor Pokok Wajib Pajak / Tax Identification Number') {
                    $npwpnya = $row->tax_document_number ?? null;
                    break;
                }
            }

            // dd($npwpnya);

            // Periksa apakah nomor NPWP ditemukan
            if ($npwpnya !== null) {
                return response()->json(['tax_document_number' => $npwpnya]);
            } else {
                return response()->json(['message' => 'Nomor NPWP tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            // Jika request tidak berhasil, kembalikan response error
            return response()->json(['message' => 'Gagal mengambil data NPWP.'], $response->status());
        }
    }

    // FUNCTION GET PEJABAT VENDOR ==========================================================================================

    public function Pejabat_vendor($no_vendor)
    {
        // dd($no_vendor);
        $bearerToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJleGFtcGxlLmNvbSIsImlhdCI6MTczMzcxMDkzOCwiZXhwIjoxNzM2MzAyOTM4LCJzdWIiOiIyMTcwZDVlNS1hYzc3LTQ3ZWUtYmMyMS1jOGQ5MDM3ZTJjMDAiLCJlbWFpbCI6bnVsbH0.xHmfjOM_vXFMzoP790Sf1lh1vtpmvD7-70FSMJTZvsk';

        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept'        => 'application/json',
            ])
            // ->withToken($bearerToken)
            ->get("http://10.30.11.142/api/V1/getSiapdaInfo/$no_vendor");

            // get("https://scm.peruri.co.id/Api/getsiapdainfo/$no_vendor");

        // try {
        //     $responseBody = $response->body();
        //     $responseBody = json_decode($responseBody);
        //     // dd($responseBody);

        //     // pisahkan response JSON karena terdapat 2 array json yang digabung
        //     // $PecahResponse = explode('][', trim($responseBody, '[]'));

        //     // dd($PecahResponse);

        //     // $dataPejabat = [];
        //     // foreach ($PecahResponse as $data) {
        //     //     $decodeData = json_decode("[$data]", true);

        //     //     if (json_last_error() !== JSON_ERROR_NONE) {
        //     //         return response()->json(['message' => 'Error parsing JSON data: ' . json_last_error_msg()], 500);
        //     //     }

        //     //     $dataPejabat = array_merge($dataPejabat, $decodeData);
        //     // }

        //     // dd($dataPejabat);

        //     // Inisialisasi variabel untuk menyimpan nama pejabat vendor
        //     $namaPejabat = null;

        //     // Iterasi melalui setiap baris data
        //     // foreach ($dataPejabat as $row) {
        //     //     // Periksa jika board_type nya adalah "BOD (Board of Director) – Direksi"
        //     //     if (isset($row['board_type']) && $row['board_type'] === 'BOD (Board of Director) – Direksi') {
        //     //         $namaPejabat = $row['full_name'] ?? null;
        //     //         break;
        //     //     }
        //     // }
        //     // dd($namaPejabat);
        //     $namaPejabat = $responseBody->data[0]->full_name;

        //     // Periksa apakah nama pejabatnya ditemukan
        //     if ($namaPejabat !== '') {
        //         // Kembalikan nama pejabatnya dalam response JSON
        //         return response()->json(['full_name' => $namaPejabat]);
        //     } else {
        //         // Jika tidak ada nama pejabat yang ditemukan, kembalikan response kosong
        //         return response()->json(['message' => 'Nama Pejabat tidak ditemukan.'], 404);
        //     }
        // } catch (\Exception $e) {
        //     // Jika request tidak berhasil, kembalikan response error
        //     return response()->json(['message' => 'Gagal mengambil data Pejabat Vendor.'], $response->status());
        // }

        // NEW FORMULA ==================================================================================================================================================

        try {
            $responseBody = $response->body();
            $responseBody = json_decode($responseBody);

            // Pastikan responseBody memiliki properti data
            if (!isset($responseBody->data) || !is_array($responseBody->data)) {
                return response()->json(['message' => 'Response data tidak valid.'], 500);
            }

            // Iterasi data untuk mencari board_type "BOD (Board of Director) – Direksi"
            $namaPejabat = null;
            foreach ($responseBody->data as $row) {
                if (isset($row->board_type) && $row->board_type === 'BOD (Board of Director) – Direksi') {
                    $namaPejabat = $row->full_name ?? null;

                    // Format nama pejabat agar seragam (awal kata besar, lainnya kecil)
                    $namaPejabat = ucwords(strtolower($namaPejabat));

                    break; // Hentikan iterasi setelah menemukan data yang cocok
                }
            }

            // Periksa apakah nama pejabat ditemukan
            if ($namaPejabat) {
                return response()->json(['full_name' => $namaPejabat]);
            } else {
                return response()->json(['message' => 'Nama Pejabat dengan board_type BOD tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tangani exception
            return response()->json(['message' => 'Gagal mengambil data Pejabat Vendor. Error: ' . $e->getMessage()], $response->status());
        }
    }

    // FUNCTION GET ALAMAT VENDOR ============================================================================================

    public function Alamat_vendor($no_vendor)
    {
        $bearerToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJleGFtcGxlLmNvbSIsImlhdCI6MTczMzcxMDkzOCwiZXhwIjoxNzM2MzAyOTM4LCJzdWIiOiIyMTcwZDVlNS1hYzc3LTQ3ZWUtYmMyMS1jOGQ5MDM3ZTJjMDAiLCJlbWFpbCI6bnVsbH0.xHmfjOM_vXFMzoP790Sf1lh1vtpmvD7-70FSMJTZvsk';

        $response = Http::timeout(60)
            ->withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
                'Accept'    => 'application/json',
            ])
            // ->withToken($bearerToken)
            ->get("http://10.30.11.142/api/V1/getSiapdaInfo/$no_vendor");


        try {
            $responseBody = $response->body();
            $responseBody = json_decode($responseBody);
            // dd($responseBody);

            // pisahkan response json karena terdapat 2 array json yang digabung
            // $PisahResponse = explode('][', trim($responseBody, '[]'));

            // // dd($PisahResponse);

            // $dataAlamat = [];
            // foreach ($PisahResponse as $da) {
            //     $decodeDA = json_decode("[$da]", true);

            //     // dd($decodeDA);
            //     if (json_last_error() !== JSON_ERROR_NONE) {
            //         return response()->json(['message' => 'Error parsing JSON data: ' . json_last_error_msg()], 500);
            //     }

            //     $dataAlamat = array_merge($dataAlamat, $decodeDA);
            // }

            // dd($dataAlamat);

            // Inisialisasi variabel untuk menyimpan nama pejabat vendor
            $AlamatVendor = null;
            $data = $responseBody->data[0];

            // Iterasi melalui setiap baris data
            // foreach ($dataAlamat as $row) {
            //     // Gabungkan data alamat menjadi satu string
            //     $AlamatVendor = $row['alamat'] . ', ' . $row['sub_district'] . ', ' . $row['kota'] . ', ' . $row['provinsi'];
            //     // Keluar dari loop karena sudah ditemukan data yang sesuai
            //     break;
            // }
            $AlamatVendor = stripslashes($data->alamat) . ', ' . $data->sub_district . ', ' . $data->kota . ', ' . $data->provinsi;

            // dd($AlamatVendor);

            // Periksa apakah alamat lengkapnya ditemukan
            if ($AlamatVendor !== null) {
                // Kembalikan alamat lengkapnya dalam response JSON
                return response()->json(['alamat' => $AlamatVendor]);
            } else {
                // Jika tidak ada alamat yang ditemukan, kembalikan response kosong
                return response()->json(['message' => 'Alamat tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            // Jika request tidak berhasil, kembalikan response error
            return response()->json(['message' => 'Gagal mengambil data Alamat Vendor.'], $response->status());
        }
    }
    // end class
}
