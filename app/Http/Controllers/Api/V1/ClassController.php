<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function jadwalKelas()
    {
        $data = Kelas::with(['mataKuliah', 'dosen', 'ruangan', 'materi', 'detailKrs'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil didapatkan',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function membuatKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas'       => 'required|string',
            'kapasitas'        => 'required|integer',
            'periode_semester' => 'required',
            'matkul_id'        => 'required|exists:mata_kuliah,id',
            'dosen_id'         => 'required|exists:users,id',
            'ruangan_id'       => 'required|exists:ruangans,id',
            'hari'             => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'        => 'required|date_format:H:i:s',
            'jam_selesai'      => 'required|date_format:H:i:s|after:jam_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $isRoomBusy = Kelas::where('ruangan_id', $request->ruangan_id)
            ->where('hari', $request->hari)
            ->where(function($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($isRoomBusy) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah terpakai di jam tersebut, Bro!'
            ], 422);
        }

        $data = Kelas::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dibuat dengan jadwal yang rapi',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $data = Kelas::with(['mataKuliah', 'dosen', 'ruangan', 'materi', 'detailKrs.mahasiswa'])->find($id);
     
         if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan, Bro!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kelas berhasil dimuat',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelasnya gak ada!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_kelas'       => 'required|string',
            'kapasitas'        => 'required|integer',
            'periode_semester' => 'required',
            'matkul_id'        => 'required|exists:mata_kuliah,id',
            'dosen_id'         => 'required|exists:users,id',
            'ruangan_id'       => 'required|exists:ruangans,id',
            'hari'             => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'        => 'required|date_format:H:i:s', 
            'jam_selesai'      => 'required|date_format:H:i:s|after:jam_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $isRoomBusy = Kelas::where('id', '!=', $id) 
            ->where('ruangan_id', $request->ruangan_id)
            ->where('hari', $request->hari)
            ->where(function($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($isRoomBusy) {
            return response()->json(['success' => false, 'message' => 'Waduh, ruangannya udah dipake kelas lain!'], 422);
        }

        $kelas->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jadwal kelas berhasil diupdate!',
            'data' => $kelas,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelas tidak ditemukan'], 404);
        }

        
        if ($kelas->detailKrs()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Gak bisa dihapus, Bro! Udah ada mahasiswa yang ambil KRS di kelas ini. Kosongkan dulu mahasiswanya.'
            ], 422);
        }

        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus dari sistem',
        ], 200);
    }

    public function kelasSaya()
    {
        $user = auth()->user();

        $data = Kelas::whereHas('detailKrs.krs', function($query) use ($user) {
            $query->where('mahasiswa_id', $user->id)
                ->where('status', 'approved'); 
        })
        ->with(['mataKuliah', 'dosen', 'ruangan']) 
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kelas yang lu ikuti periode ini',
            'data' => $data,
        ], 200);
    }
}
