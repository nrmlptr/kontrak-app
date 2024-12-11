<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // FUNGSI VIEW EDIT AKTA PERURI ====================================================================================
    public function edit(Setting $setting)
    {
        return view('peruri.editSetting', compact('setting'));
    }

    // FUNGSI SAVE EDITAN AKTA PERURI ==================================================================================
    public function update(Request $request, Setting $setting)
    {
        // dd($request->all());
        extract($request->all());

        $setting->update([
            'peruri_pihakname'  => $pihakname,
            'peruri_posisi'     => $posisi,
            'peruri_akta'       => $akta,
        ]);
        return back();
    }
    // end class
}
