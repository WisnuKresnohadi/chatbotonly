<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use App\Models\PekerjaanTersimpan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Enums\LowonganMagangStatusEnum;

class MitraPerusahaanController extends Controller
{
    protected $page_per = 9; // jumlah data per halaman
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data['industries'] = Industri::withCount(['lowongan_magang' => function ($q) {
            $q->where('status', 1)
            ->where('statusaprove', LowonganMagangStatusEnum::APPROVED);
        }])->where('statusapprove', 1);

        if ($request->name) {
            $data['industries'] = $data['industries']->where('namaindustri', 'like', '%' . $request->name . '%');
        }

        if ($request->location) {
            $data['industries'] = $data['industries']->where('alamatindustri', 'like', '%' . $request->location . '%');
        }

        $data['industries'] = $data['industries']->paginate($this->page_per)->toJson();
        $data['pagination'] = json_decode($data['industries'], true);
        $data['industries'] = $data['pagination']['data'];

        if ($request->ajax()) {
            return Response::success([
                'pagination' => view('perusahaan/components/pagination', $data)->render(),
                'view' => view('perusahaan/components/card_perusahaan', $data)->render(),
            ]);
        }

        $data['regencies'] = DB::table('reg_regencies')->get();

        return view('perusahaan.daftar_perusahaan', $data);
    }

    public function detailLowongan($id) {
        $lowongan = LowonganMagang::select(
            'id_lowongan', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position', 'industri.namaindustri', 'industri.image', 'industri.description as deskripsi_industri',
            'pelaksanaan', 'durasimagang', 'lokasi', 'nominal_salary', 'lowongan_magang.created_at', 'jenjang', 'kuota',
            'gender', 'statusaprove', 'keterampilan', 'lowongan_magang.deskripsi', 'requirements', 'benefitmagang',
            'tahapan_seleksi', 'enddate', 'lowongan_magang.status'
        )
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('lowongan_magang.id_lowongan', $id)->first()->dataTambahan('program_studi');
        if (!$lowongan) abort(404);

        $urlBack = route('dashboard');
        $auth = auth()->user();
        $isMahasiswa = ($auth && $auth->hasRole('Mahasiswa')) ?? false ;

        $tersimpan = false;
        if ($isMahasiswa) $tersimpan = PekerjaanTersimpan::select(DB::raw(1))->where('nim', $auth->mahasiswa->nim)->where('id_lowongan', $id)->first() ? true : false;

        $kuotaPenuh = $lowongan->kuota_terisi / $lowongan->kuota == 1;
        $eligible = $isMahasiswa && !$kuotaPenuh;
        return view('program_magang.detail_lowongan', compact('lowongan', 'urlBack','eligible', 'tersimpan'));
    }

    public function show(Request $request, $id)
    {
        $data['detail'] = Industri::where('id_industri', $id)->first();
        $data['lowongan'] = LowonganMagang::where('lowongan_magang.id_industri', $id)
        ->where('statusaprove', LowonganMagangStatusEnum::APPROVED)
        ->orderByRaw("
            CASE 
                WHEN startdate <= ? AND enddate >= ? THEN 1 
                ELSE 2 
            END", [now()->format('Y-m-d'), now()->format('Y-m-d')])
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->orderBy('lowongan_magang.created_at', 'desc');

        if ($request->name) {
            $data['lowongan'] = $data['lowongan']->where('bidang_pekerjaan_industri.namabidangpekerjaan', 'like', '%' .$request->name. '%');
        }


        $data['lowongan'] = $data['lowongan']->paginate(5)->toJson();
        $data['pagination'] = json_decode($data['lowongan'], true);
        $data['lowongan'] = $data['pagination']['data'];

        if ($request->page) {
            return Response::success([
                'pagination' => view('perusahaan/components/pagination', $data)->render(),
                'view' => view('perusahaan/components/card_lowongan', $data)->render(),
            ]);
        }

        $data['urlBack'] = route('daftar_perusahaan');
        if ($request->url_back) {
            $data['urlBack'] = $request->url_back;
        }

        return view('perusahaan.detail_perusahaan', $data);
    }

    public function filter()
    {
        $industries = Industri::where('statusapprove', 1);
        if(request()->name != null){
            $industries = $industries->where('namaindustri', 'like', '%'.request()->name.'%');
        }
        $data['industries'] = $industries->get();
        $data['page_per'] = $this->page_per;
        return view('perusahaan.list_perusahaan', $data)->render();
    }

}
