<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(Setting $setting)
    {
        return view('editSetting', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        extract($request->all());

        // hapus dulu vendortext
        $setting->update([
            'peruri_pihakname' => $pihakname,
            'peruri_akta' => $akta,
        ]);
        return back();
    }
    // end class
}
