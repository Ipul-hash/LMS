<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\DetailKrs;
use App\Models\Nilai;

class KhsController extends Controller
{
    
    public function publishNilai(Request $request)
    {
        $request->validate([
            'priode_semester' => 'required'
        ]);

        $semester = $request->periode_semester;

        $krsList = Krs::where('peridode_semester',$semester)
                        ->where('status','disetujui')
                        -> pluck('id');

    if ($krsList->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "Tidak ada data KRS yang disetujui pada semester {$semester}.",
            ], 404);
        }

        $detailKrsList = DetailKrs::whereIn('krs_id', $krsList)->get();

        $jumlahDiproses = 0;
        foreach ($detailKrsList as $detail) {
            $nilai = Nilai::where('detail_krs_id', $detail->id)->first();
            
            if ($nilai) {
                $nilaiAkhir = ($nilai->nilai_tugas * 0.2) + ($nilai->nilai_uts * 0.3) + ($nilai->nilai_uas * 0.5);

                $huruf = 'E';
                if ($nilaiAkhir >= 80) $huruf = 'A';
                elseif ($nilaiAkhir >= 70) $huruf = 'B';
                elseif ($nilaiAkhir >= 60) $huruf = 'C';
                elseif ($nilaiAkhir >= 50) $huruf = 'D';

                $nilai->update(['huruf_mutu' => $huruf]);
                $jumlahDiproses++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil mempublikasi nilai semester {$semester}. Total {$jumlahDiproses} data nilai telah dikunci dan dikonversi ke Huruf Mutu.",
        ], 200);
    }

    
    public function lihatKhs(Request $request, string $semester)
    {
        $userId = $request->user()->id;

        $krs = Krs::with(['detail.kelas.mataKuliah', 'detail.nilai'])
                  ->where('mahasiswa_id', $userId)
                  ->where('periode_semester', $semester)
                  ->where('status', 'disetujui') 
                  ->first();

        if (!$krs) {
            return response()->json([
                'success' => false,
                'message' => 'Data KHS tidak ditemukan untuk semester ini.',
            ], 404);
        }

        $totalSks = 0;
        $totalMutu = 0;
        $belumDipublish = false;

        $hasilStudi = [];

        foreach ($krs->detail as $item) {
            $matkul = $item->kelas->mataKuliah;
            $nilai = $item->nilai;

            $sks = $matkul->sks;
            $hurufMutu = $nilai ? $nilai->huruf_mutu : null;

            if (!$hurufMutu) {
                $belumDipublish = true;
            }

            $bobot = 0;
            if ($hurufMutu == 'A') $bobot = 4;
            elseif ($hurufMutu == 'B') $bobot = 3;
            elseif ($hurufMutu == 'C') $bobot = 2;
            elseif ($hurufMutu == 'D') $bobot = 1;

            $totalSks += $sks;
            $totalMutu += ($sks * $bobot);

            $hasilStudi[] = [
                'kode_matkul' => $matkul->kode_matkul,
                'nama_matkul' => $matkul->nama_matkul,
                'sks'         => $sks,
                'nilai_akhir' => $hurufMutu ?? 'Belum Dipublish'
            ];
        }

        $ips = $belumDipublish ? 0 : ($totalSks > 0 ? round($totalMutu / $totalSks, 2) : 0);

        return response()->json([
            'success' => true,
            'message' => 'Data KHS berhasil dimuat.',
            'data' => [
                'periode_semester' => $krs->periode_semester,
                'status_publish'   => $belumDipublish ? 'Belum Lengkap / Belum Dipublish' : 'Sudah Dipublish',
                'total_sks'        => $totalSks,
                'ips'              => $ips,
                'detail_matkul'    => $hasilStudi
            ]
        ], 200);
     }                
    }

   