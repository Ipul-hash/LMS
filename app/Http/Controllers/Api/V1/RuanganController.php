<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function daftarRuangan()
    {
        $data = Ruangan::with('kelas')->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar ruangan berhasil didapatkan',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_ruangan' => 'required|unique:ruangans,kode_ruangan',
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|integer',
            'lokasi' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $ruangan = Ruangan::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil dibuat',
                'data' => $ruangan,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function detailRuangan(string $id)
    {
        $data = Ruangan::with('kelas')->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail ruangan ditemukan',
            'data' => $data,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json(['success' => false, 'message' => 'Ruangan tidak ada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_ruangan' => 'required|unique:ruangans,kode_ruangan,' . $id,
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $ruangan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil diupdate',
            'data' => $ruangan,
        ], 200);
    }

    public function destroy(string $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json(['success' => false, 'message' => 'Ruangan tidak ditemukan'], 404);
        }

        if ($ruangan->kelas()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Gak bisa dihapus, Bro! Ruangan ini lagi dipake buat kelas.'
            ], 422);
        }

        $ruangan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil dihapus',
        ], 200);
    }
}