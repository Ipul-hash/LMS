<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function jadwalKelas()
    {
        $data = kelas::with('mataKuliah','dosen','materi','detailKrs')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function membuatKelas(Request $request)
    {
        $data  = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kapasitas' => $request->kapasitas,
            'periode_semester' => $request->periode_semester,
            'matkul_id' => $request->matakul_id,
            'dosen_id' => $request->dosen_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dibuat',
            'data' => $data,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
