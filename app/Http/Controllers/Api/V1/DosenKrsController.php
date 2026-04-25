<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\User;
use App\Models\AcademicPeriod;

class DosenKrsController extends Controller
{
    public function index()
    {
        $periodeAktif = AcademicPeriod::where('is_active', true)->first();
        
        if (!$periodeAktif) {
            return response()->json(['success' => false, 'message' => 'Sistem belum dikonfigurasi untuk periode ini.'], 500);
        }
        
        $mahasiswa = User::where('dosen_pa_id', auth()->id())
            ->with(['krs' => function($query) use ($periodeAktif) {
                $query->where('academic_period_id', $periodeAktif->id)
                      ->withSum('items', 'sks_point'); 
            }])
            ->get();

        $labelPeriode = $periodeAktif->full_label ?? 'Aktif'; 

        return response()->json([
            'success' => true,
            'message' => 'Daftar bimbingan KRS periode ' . $labelPeriode,
            'data'    => $mahasiswa
        ]);
    }

   
    public function show(string $id)
{
    // Kalau $id itu adalah ID MAHASISWA (6), pakainya 'where'
    $krs = Krs::with(['mahasiswa', 'items.kelas.mataKuliah', 'items.kelas.dosen'])
        ->where('mahasiswa_id', $id) // <--- NYARI BERDASARKAN MAHASISWA
        ->firstOrFail(); // <--- Pake firstOrFail, bukan findOrFail

    if ($krs->mahasiswa->dosen_pa_id !== auth()->id()) {
        return response()->json(['message' => 'Anda bukan dosen pembimbing mahasiswa ini.'], 403);
    }

    return response()->json([
        'success' => true,
        'data'    => $krs
    ]);
}

   
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,draft,menunggu',
            'notes'  => 'nullable|string' 
        ]);

        $krs = Krs::with('mahasiswa')->findOrFail($id);

        if ($krs->mahasiswa->dosen_pa_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $krs->update([
            'status' => $request->status,
            'notes'  => $request->notes,
            'approved_at' => $request->status === 'approved' ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => "KRS Mahasiswa berhasil di-{$request->status}!"
        ]);
    }
}