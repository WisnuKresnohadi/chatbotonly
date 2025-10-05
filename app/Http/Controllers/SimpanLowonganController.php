<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use App\Models\PekerjaanTersimpan;

class SimpanLowonganController extends Controller
{
    public function index(Request $request) {
        $data['lowongan_tersimpan'] = PekerjaanTersimpan::select('id_lowongan')->where('nim', auth()->user()->mahasiswa->nim)
        ->get()->pluck('id_lowongan')->toArray();

        $data['lowongan'] = LowonganMagang::select(
            'lowongan_magang.*', 'industri.image', 'industri.namaindustri', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position'
        )
        ->join('industri', 'lowongan_magang.id_industri', '=', 'industri.id_industri')
        ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('statusaprove', 'diterima')
        ->whereIn('id_lowongan', $data['lowongan_tersimpan']);

        if ($request->lowongan_search) {
            $data['lowongan'] = $data['lowongan']->where('intern_position', 'like', '%' . $request->lowongan_search . '%')
                ->orWhere('industri.namaindustri', 'like', '%' . $request->lowongan_search . '%');
        }

        $data['lowongan'] = $data['lowongan']->paginate(3)->toJson();
        $data['pagination'] = json_decode($data['lowongan'], true);
        $data['lowongan'] = $data['pagination']['data'];
        $data['isMahasiswa'] = true;

        if ($request->ajax()) {
            return Response::success([
                'pagination' => view('perusahaan/components/pagination', $data)->render(),
                'view' => view('perusahaan/components/card_lowongan_fp', $data)->render(),
            ]);
        }

        return view('perusahaan/lowongan_tersimpan', $data);
    }

    public function simpanLowongan($id) {
        try {
            $user = auth()->user();
            $tersimpan = PekerjaanTersimpan::where('nim', $user->mahasiswa->nim)->where('id_lowongan', $id)->first();
            if ($tersimpan) {
                $tersimpan->delete();
            } else {
                PekerjaanTersimpan::create([
                    'nim' => $user->mahasiswa->nim,
                    'id_lowongan' => $id
                ]);
            }

            return Response::success(null, 'Success.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
