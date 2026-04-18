<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\Kelas;
use App\Models\DetailKrs;

class KrsController extends Controller
{
   
    public function daftarKrsMahasiswa()
    {
        $data = Krs::with('mahasiswa','dosenPa','detail')->get();

        return response()->json([
            'success' => true, 
            'message' => 'Data berhasil didapatkan', 
            'data' => $data, 
        ],200);
    }

    
    public function melihatKrsAktif(Request $request)
    {
        $userId = $request->user()->id;
        
        $krsAktif = Krs::with('detail.kelas.mataKuliah')
                       ->where('mahasiswa_id', $userId)
                       ->where('periode_semester') 
                       ->first();
                       
        if (!$krsAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa belum memiliki draf KRS untuk semester ini.',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berikut data KRS yang aktif',
            'data'    => $krsAktif,
        ], 200);
    }
    
    public function approveKrs(Request $request, string $id)
    {
        $krs = Krs::find($id);

        if (!$krs) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf, data KRS tidak ditemukan.',
            ], 404);
        }

        if ($krs->status === 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'KRS ini sudah disetujui sebelumnya.',
            ], 400); 
        }

        $krs->update([
            'status' => 'disetujui'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'KRS mahasiswa berhasil disetujui.',
            'data' => $krs,
        ], 200);
    }

    public function tolakKrs(Request $request, string $id)
    {
        $krs = Krs::find($id);

        if (!$krs) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf, data KRS tidak ditemukan.',
            ], 404);
        }

        $krs->update([
            'status' => 'ditolak'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'KRS mahasiswa telah ditolak. Mahasiswa harus merevisi KRS-nya.',
            'data' => $krs,
        ], 200);
    }

    
    public function membuatKrs(Request $request)
    {
        $request->validate([
            'periode_semester' => 'required',
            'dosen_pa_id'      => 'required|exists:users,id' 
        ]);

        $userId = $request->user()->id;

        $cekKrs = Krs::where('mahasiswa_id', $userId)
                     ->where('periode_semester', $request->periode_semester)
                     ->first();

        if ($cekKrs) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa sudah memiliki draf KRS di semester ini.',
            ], 400);
        }

     
        $krsBaru = Krs::create([
            'mahasiswa_id'     => $userId,
            'dosen_pa_id'      => $request->dosen_pa_id,
            'periode_semester' => $request->periode_semester,
            'status'           => 'menunggu' 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Draf KRS berhasil dibuat.',
            'data'    => $krsBaru,
        ], 201);
    }

    
    public function tambahKelas(Request $request, string $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $krs = Krs::find($id);
        if (!$krs) {
            return response()->json([
                'success' => false,
                'message' => 'Data KRS tidak ditemukan.',
            ], 404);
        }

        if ($krs->status === 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'KRS sudah disetujui, tidak bisa menambah kelas lagi.',
            ], 400);
        }

        $kelas = Kelas::find($request->kelas_id);
        $jumlahTerisi = DetailKrs::where('kelas_id', $request->kelas_id)->count();
        
        if ($jumlahTerisi >= $kelas->kapasitas) {
            return response()->json([
                'success' => false,
                'message' => "Mohon maaf, kuota {$kelas->nama_kelas} sudah penuh.",
            ], 400);
        }

        $cekDuplikat = DetailKrs::where('krs_id', $id)
                                ->where('kelas_id', $request->kelas_id)
                                ->first();
        if ($cekDuplikat) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas ini sudah ada di dalam KRS kamu.',
            ], 400);
        }

        $detail = DetailKrs::create([
            'krs_id'   => $id,
            'kelas_id' => $request->kelas_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan ke KRS.',
            'data'    => $detail,
        ], 201);
    }

    public function hapusKelas(string $id, string $item_id)
    {
        $detail = DetailKrs::where('krs_id', $id)
                           ->where('id', $item_id)
                           ->first();

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Data kelas pada KRS ini tidak ditemukan.',
            ], 404);
        }

        $krs = Krs::find($id);
        if ($krs->status === 'disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'KRS sudah disetujui, tidak bisa menghapus kelas.',
            ], 400);
        }
      
        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus dari KRS.',
        ], 200);
    }
}
