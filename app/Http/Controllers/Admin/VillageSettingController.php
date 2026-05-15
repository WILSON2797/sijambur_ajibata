<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VillageSettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => VillageSetting::all()->groupBy('group')
        ]);
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings');
        foreach ($settings as $id => $value) {
            VillageSetting::where('id', $id)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
