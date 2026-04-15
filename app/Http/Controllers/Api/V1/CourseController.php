<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataKuliah;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function daftarMataKuliah()
    {
        $data = MataKuliah::with('kelas')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil didapatkan',
            'data' => $data,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function membuatMataKuliah(Request $request)
    {
       $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required',
        ]);

        $data = MataKuliah::create([
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'sks' => $request->sks,
        ]);

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dibuat',
                'data' => $data,
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf ada kesalahan',
            ],404);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function melihatMataKuliah(string $id)
    {
        $data = MataKuliah::find($id);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf data tidak ada',
            ],404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di tampilkan',
            'data' => $data,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function mengubahMataKuliah(Request $request, string $id)
    {
        $request->validate([
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required',
        ]);

        $data = MataKuliah::find($id);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf data tidak ada',
            ],404);
        }

        $data->update([
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'sks' => $request->sks,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'data' => $data,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function menghapusMataKuliah(string $id)
    {
        $data = MataKuliah::find($id);

        if(!$data){
            return response()->json([
                'success' => false,
                'success' => 'Mohon maaf ada kesalahan',
            ],404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $data,
        ],201);
    }
}
