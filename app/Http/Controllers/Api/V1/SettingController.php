<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return response()->json([
            'success' => true,
            'message' => 'Data settings berhasil dimuat',
            'data'    => $settings,
        ], 200);
    }

    
    public function updateSettings(Request $request)
    {
        $settingsData = $request->input('settings'); 

        foreach ($settingsData as $item) {
            \App\Models\Setting::updateOrCreate(
                ['key'   => $item['key']],  
                ['value' => $item['value']] 
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi berhasil disimpan, Bro!'
        ]);
    }

    
    public function show(string $key)
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return response()->json(['message' => 'Key tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $setting,
        ], 200);
    }
}