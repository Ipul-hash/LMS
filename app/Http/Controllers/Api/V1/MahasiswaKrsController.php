<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\AcademicPeriod;
use App\Models\Krs; 
use App\Models\Kelas; 
use App\Models\User;
use App\Models\KrsItem;
use Illuminate\Support\Facades\DB;

class MahasiswaKrsController extends Controller
{
    
    public function index()
{
    $periodeAktif = AcademicPeriod::where('is_active', true)->first();
    
    if (!$periodeAktif) {
        return response()->json(['success' => false, 'message' => 'Periode tidak aktif'], 404);
    }

    $krs = Krs::where('mahasiswa_id', auth()->id())
        ->where('academic_period_id', $periodeAktif->id)
        ->with(['items.kelas.mataKuliah', 'items.kelas.dosen']) 
        ->first();

    return response()->json([
        'success' => true,
        'periode' => $periodeAktif->id, 
        'data'    => $krs
    ]);
}

    
    public function store(Request $request)
    {
        if (Setting::get('maintenance_mode') === '1') {
            return response()->json(['message' => Setting::get('maintenance_message')], 503);
        }

        $now = now()->toDateString();
        if ($now < Setting::get('krs_start_date') || $now > Setting::get('krs_end_date')) {
            return response()->json(['message' => 'Maaf, periode pengisian KRS belum dibuka atau sudah berakhir.'], 403);
        }

        $periodeAktif = AcademicPeriod::where('is_active', true)->first();
        if (!$periodeAktif) {
            return response()->json(['message' => 'Sistem belum dikonfigurasi untuk periode ini.'], 500);
        }

        $request->validate(['kelas_id' => 'nullable|exists:kelas,id']);
        try {
            DB::beginTransaction();

            $krs = Krs::firstOrCreate([
                'mahasiswa_id' => auth()->id(),
                'academic_period_id' => $periodeAktif->id,
            ], [
                'status' => 'Draft',
                'dosen_pa_id' => auth()->user()->dosen_pa_id 
            ]);

            
            $kelas = Kelas::with('mataKuliah')->withCount('items')->find($request->kelas_id);

            if (!$kelas || !$kelas->mataKuliah) {
                return response()->json(['message' => 'Data Kelas atau Mata Kuliah tidak ditemukan!'], 404);
            }

            $isExists = $krs->items()->where('kelas_id', $request->kelas_id)->exists();
            if ($isExists) {
                return response()->json(['message' => 'Mata kuliah ini sudah ada di KRS Anda.'], 422);
            }

            if ($kelas->items_count >= $kelas->kapasitas) {
                return response()->json([
                    'message' => "Gagal! Kuota kelas {$kelas->nama_kelas} sudah penuh."
                ], 422);
            }

            $maxSks = (int) Setting::get('max_sks_default', 24);
            $sksBaru = $kelas->mataKuliah->sks; 
            $totalSksSekarang = $krs->items()->sum('sks_point');

            if (($totalSksSekarang + $sksBaru) > $maxSks) {
                return response()->json([
                    'message' => "Gagal! Total SKS melebihi batas maksimal ($maxSks SKS)."
                ], 422);
            }

            $krs->items()->create([
                'kelas_id' => $request->kelas_id,
                'sks_point' => $sksBaru 
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Mata kuliah berhasil ditambahkan!',
                'data'    => $krs->load('items.kelas.mataKuliah')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $now = now()->toDateString();
        if ($now > Setting::get('krs_end_date')) {
            return response()->json(['message' => 'Masa pengubahan KRS sudah ditutup.'], 403);
        }

        return response()->json(['message' => 'Mata kuliah berhasil dihapus.']);
    }
}