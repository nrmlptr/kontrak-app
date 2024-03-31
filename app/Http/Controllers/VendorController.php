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
    public function index()
    {
        $data = Integrate::with('vendortext')->groupBy('purchasing_document_number')->get();
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
        extract($request->all());
        $data = Integrate::with(['vendortext', 'vendor' => function ($q) {
            return $q->where(['primary_data' => '1'])->first();
        }])
            ->where(['integrates.registration_no' => $registration_no])
            ->firstOrFail();

        // hapus dulu vendortext
        $data->vendortext()->delete();
        $data->vendortext()->create([
            'pihakname' => $pihakname,
            'npwp' => $npwp,
            'akta' => $akta,
        ]);
        return redirect()->route('vendor.index');
    }



    public function npwp_data($no_vendor)
    {
        $dataNpwp = json_decode(Http::timeout(60)
            ->withOptions(['verify' => false])
            ->get("https://scm.peruri.co.id/Api/getSIapdaNPWP/$no_vendor"), true);
        $npwpnya = $dataNpwp['npwp'];
        return response()->json(['npwp' => $npwpnya]);
    }
    // end class
}
