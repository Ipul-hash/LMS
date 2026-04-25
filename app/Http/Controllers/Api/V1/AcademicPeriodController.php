<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AcademicPeriodController extends Controller
{
    
    public function index()
    {
        $data = AcademicPeriod::orderBy('tahun_akademik', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_akademik' => 'required|string',
            'semester'       => 'required|in:Ganjil,Genap,Antara',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $period = AcademicPeriod::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Periode baru berhasil ditambahkan.',
            'data'    => $period
        ], 201);
    }

    
    public function setActive($id)
    {
        $target = AcademicPeriod::find($id);

        if (!$target) {
            return response()->json(['message' => 'Periode tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();

            AcademicPeriod::where('is_active', true)->update(['is_active' => false]);

            $target->update(['is_active' => true]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Sistem sekarang berjalan di periode {$target->full_label}!",
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal merubah periode aktif'], 500);
        }
    }

    
    public function destroy($id)
    {
        $period = AcademicPeriod::findOrFail($id);
        

        $period->delete();
        return response()->json(['success' => true, 'message' => 'Periode berhasil dihapus']);
    }
}