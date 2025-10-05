<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\JenisMagang;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PekerjaanTersimpan;
use Illuminate\Support\Facades\DB;
use App\Enums\PendaftaranMagangStatusEnum;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if ($request->component) {
            return self::getComponent($request->component);
        }

        $jenisMagang = JenisMagang::whereExists(function ($q) {
            $q->select(DB::raw(1))->from('tahun_akademik')->where('status', 1)->whereColumn('jenis_magang.id_year_akademik', 'id_year_akademik');
        })->get();

        $lowonganMagangCounts = LowonganMagang::join('industri', 'industri.id_industri','lowongan_magang.id_industri')
        ->where('lowongan_magang.status', 1)
        ->select('bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
            DB::raw('COUNT(DISTINCT industri.id_industri) as total_industri'),
            DB::raw('COUNT(lowongan_magang.id_lowongan) as total_lowongan'),
            'lowongan_magang.kuota')
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->groupBy('bidang_pekerjaan_industri.namabidangpekerjaan','lowongan_magang.kuota')
        ->orderBy('lowongan_magang.kuota', 'desc')->get();

        //dd($lowonganMagangCounts);

        $kota = DB::table('reg_regencies')->get();

        return view('landingpage.landingpage', compact('jenisMagang', 'kota','lowonganMagangCounts'));
    }


    public function detailLowongan($id) {
        $lowongan = LowonganMagang::select(
            'id_lowongan', 'intern_position', 'industri.namaindustri', 'industri.image', 'industri.description as deskripsi_industri',
            'pelaksanaan', 'durasimagang', 'lokasi', 'nominal_salary', 'created_at', 'jenjang', 'kuota',
            'gender', 'statusaprove', 'keterampilan', 'deskripsi', 'requirements', 'benefitmagang',
            'tahapan_seleksi', 'enddate', 'lowongan_magang.status'
        )
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->where('id_lowongan', $id)
        ->where('lowongan_magang.status', 1)
        ->first();
        if (!$lowongan) abort(404);
        $lowongan = $lowongan->dataTambahan('program_studi');

        $urlBack = route('dashboard');

        $auth = auth()->user();
        $isMahasiswa = ($auth && $auth->hasRole('Mahasiswa')) ?? false ;

        $tersimpan = false;
        if ($isMahasiswa) $tersimpan = PekerjaanTersimpan::select(DB::raw(1))->where('nim', $auth->mahasiswa->nim)->where('id_lowongan', $id)->first() ? true : false;

        $kuotaPenuh = $lowongan->kuota_terisi / $lowongan->kuota == 1;
        $eligible = $isMahasiswa && !$kuotaPenuh;

        return view('program_magang.detail_lowongan', compact('lowongan', 'urlBack', 'eligible', 'tersimpan'));
    }


    // any private function

    private static function getComponent($type)
    {
        if ($type == 'container-lowongan-magang') {
            $lowongan = LowonganMagang::select(
                'lowongan_magang.id_lowongan', 'industri.namaindustri', 'industri.image',
                'lowongan_magang.created_at', 'lokasi', 'lowongan_magang.nominal_salary', 'lowongan_magang.durasimagang', 'gender', 'lowongan_magang.statusaprove',
                'lowongan_magang.startdate', 'lowongan_magang.enddate', 'bidang_pekerjaan_industri.namabidangpekerjaan as intern_position',
            )
            ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
            ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
            ->leftJoin('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'lowongan_magang.id_jenismagang')
            ;

            $lowonganTerbaru = $lowongan
            ->where('jenis_magang.namajenis','Magang Fakultas')
            ->where('lowongan_magang.statusaprove', 'diterima')
            ->where('lowongan_magang.status', 1)
            ->whereDate('lowongan_magang.startdate', '<=', Carbon::now())
            ->whereDate('lowongan_magang.enddate', '>=', Carbon::now())
            ->withCount('pendaftaran')
            ->limit(6)->orderBy('created_at', 'desc')->get()->transform(function ( $item, $key) {
                $item->created_at = Carbon::parse($item->created_at)->diffForHumans(Carbon::now());
                $item->durasimagang = implode(' dan ', json_decode($item->durasimagang));
                $item->lokasi = implode(', ', json_decode($item->lokasi));
                $item->image = ($item->image) ? url('storage/' . $item->image) : asset('app-assets/img/avatars/building.png');
                return $item;
            });
            $lowonganPopuler = $lowonganTerbaru->sortByDesc('pendaftaran_count');
            return view('landingpage/components/lowongan', compact('lowonganTerbaru','lowonganPopuler'))->render();
        } else if ('container-mitra') {
            $mitra = Industri::where('statusapprove', 1)->limit(6)->get()->transform(function ( $item, $key) {

                $item->image = ($item->image) ? url('storage/' . $item->image) : asset('app-assets/img/avatars/building.png');

                return $item;
            });

            $urlBack = route('dashboard');
            return view('landingpage/components/mitra', compact('mitra', 'urlBack'))->render();
        }

    }
}
