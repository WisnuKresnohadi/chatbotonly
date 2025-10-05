<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Industri;
use App\Models\Mahasiswa;
use App\Models\MhsMagang;
use App\Models\MhsMandiri;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\lowongan_magang;
use App\Models\PengajuanMandiri;
use App\Models\PendaftaranMagang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\KonfirmasiMagangRequest;

class KonfirmasiMagangController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nim = Auth::user()->nim;

        $pendaftar = PendaftaranMagang::with('lowongan_magang')->orderBy('tanggaldaftar', "asc")->get();

        $pendaftar->transform(function ($pendaftar) {
            // ----------------------------------------------------------------------------
            $now = Carbon::now();
            // if ($now->greaterThan($pendaftar->lowongan_magang->date_confirm_closing)) {
            //     if ($pendaftar->where('konfirmasi_status', 3)) {
            //         $pendaftar->konfirmasi_status = 2;
            //         $pendaftar->current_step = 'ditolak';
            //     } elseif ($pendaftar->where('konfirmasi_status', 2)) {
            //         $pendaftar->current_step = 'ditolak';
            //     } elseif (empty($pendaftar->bukti_doc)) {
            //         $pendaftar->konfirmasi_status = 2;
            //         $pendaftar->current_step = 'ditolak';
            //     }
            // }
            // $pendaftar->save();

            // ----------------------------------------------------------------------------

            $industri = Industri::where('id_industri', $pendaftar->lowongan_magang->id_industri)->first();
            $picture = $industri?->image ? url('assets/images/' . $industri->image) : '\assets\images\no-pictures';
            $pendaftar->img = $picture . '.png';

            // note: 1 = diterima, 2 = ditolak, 3 = penawaran.
            return self::makeStyleStatus($pendaftar);
        });

        if ($request->ajax()) {
            $pendaftar = $pendaftar->whereIn('current_step', ['screening', 'tahap1', 'tahap2', 'tahap3', 'penawaran', 'diterima', 'ditolak']);
            if ($request->filter && $request->filter != null && $request->filter != '' && $request->filter != 'all') {
                $pendaftar = $pendaftar->where('current_step', $request->filter);
            } elseif ($request->filter == 'all') {
                $pendaftar = $pendaftar;
            }

            return view('kegiatan_saya/lamaran_saya/components/proses_seleksi', compact('pendaftar'))->render();
        }

        $urlGetCard = url('kegiatan-saya/lamaran-saya');

        // Mandiri
        $mandiri = PengajuanMandiri::where("nim", $nim)->get();
        $mahasiswa = Mahasiswa::all();
        $file = MhsMandiri::with('PengajuanMandiri')->get();
        $file = MhsMagang::with('PengajuanMandiri')->get();

        $nim1 = Mahasiswa::find($nim);
        // $nim = $nim->nim;
        $mandiri_nim = $mandiri->pluck('nim')->toArray();


        return view('kegiatan_saya.lamaran_saya.index',  compact('urlGetCard', 'pendaftar', 'mandiri', 'mahasiswa', 'file', 'nim', 'mandiri_nim', 'nim1'));
    }

    private static function makeStyleStatus($pendaftar)
    {
        if ($pendaftar->current_step == "screening") {
            $pendaftar->step = 'Screening';
            $pendaftar->color = 'warning';
        } elseif ($pendaftar->current_step == "tahap1") {
            $pendaftar->step = 'Tahap 1';
            $pendaftar->color = 'primary';
        } elseif ($pendaftar->current_step == "tahap2") {
            $pendaftar->step = 'Tahap 2';
            $pendaftar->color = 'primary';
        } elseif ($pendaftar->current_step == "tahap3") {
            $pendaftar->step = 'Tahap 3';
            $pendaftar->color = 'primary';
        } elseif ($pendaftar->konfirmasi_status == 1) {
            $pendaftar->step = 'Diterima';
            $pendaftar->color = 'success';
        } elseif ($pendaftar->konfirmasi_status == 2) {
            $pendaftar->step = 'Ditolak';
            $pendaftar->color = 'danger';
        } elseif ($pendaftar->konfirmasi_status == 3) {
            $pendaftar->step = 'Penawaran';
            $pendaftar->color = 'info';
        }

        return $pendaftar;
    }

    public function store($request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();
        return $mandiri;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();
            // dd($mandiri);
            $mandiri->nim = $request->nim;
            $mandiri->nama_industri = $request->nama_industri;
            $mandiri->posisi_magang = $request->posisi_magang;
            $mandiri->startdate = Carbon::parse($request->startdate)->format('Y-m-d');
            $mandiri->enddate = Carbon::parse($request->enddate)->format('Y-m-d');
            if (!empty($request->bukti_doc)) {
                $mandiri->bukti_doc = $request->bukti_doc->store('post');
            }
            $mandiri->status_terima = 1;
            $mandiri->save();

            return response()->json([
                'error' => false,
                'message' => 'Data successfully Updated!',
                'modal' => '#modalDiterima',
                'status_terima' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateDitolak(Request $request, string $id)
    {
        try {

            $mandiri = PengajuanMandiri::where('id_pengajuan', $id)->first();
            if (!empty($request->bukti_doc)) {
                $mandiri->bukti_doc = $request->bukti_doc->store('post');
            }
            $mandiri->status_terima = 2;
            $mandiri->save();

            MhsMagang::create([
                'id_pengajuan' => $id,
                'status' => false
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Data successfully Updated!',
                'modal' => '#modalDitolak',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status($id)
    {
    }

    public function porto($file)
    {
        $path = storage_path($file);

        return response()->file($path);
    }

    public function detail($id)
    {
        $nim = Auth::user()->nim;
        $now = Carbon::now();

        $pelamar = PendaftaranMagang::where('nim', $nim)->with('lowongan_magang')->get();
        $pendaftar = $pelamar->where('id_lowongan', $id)->first();

        $industri = Industri::where('id_industri', $pendaftar->lowongan_magang->id_industri)->first();
        $picture = $industri?->image ? url('assets/images/' . $industri->image) : '\assets\images\no-pictures';
        $img = $picture . '.png';

        $color1 = 'secondary';
        $color2 = 'secondary';
        $color3 = 'secondary';
        $color4 = 'secondary';

        if ($pendaftar->current_step == "screening") {
            $step = 'Screening';
            $color = 'warning';
            $color1 = 'success';
        } elseif ($pendaftar->current_step == "tahap1") {
            $step = 'Tahap 1';
            $color = 'primary';
            $color2 = 'success';
        } elseif ($pendaftar->current_step == "tahap2") {
            $step = 'Tahap 2';
            $color = 'primary';
            $color2 = 'success';
        } elseif ($pendaftar->current_step == "tahap3") {
            $step = 'Tahap 3';
            $color = 'primary';
            $color2 = 'success';
        } elseif ($pendaftar->konfirmasi_status == 1) {
            $step = 'Diterima';
            $color = 'success';
            $color4 = 'success';
        } elseif ($pendaftar->konfirmasi_status == 2) {
            $step = 'Ditolak';
            $color = 'danger';
            $color4 = 'success';
        } elseif ($pendaftar->konfirmasi_status == 3) {
            $step = 'Penawaran';
            $color = 'info';
            $color3 = 'success';
        }
        // note: 1 = diterima, 2 = ditolak, 3 = penawaran.

        // $pendaftar->transform(function ($item) {



        //     return $item;
        // });

        return view('kegiatan_saya.lamaran_saya.status_lamaran', compact('pendaftar', 'img', 'step', 'color', 'now', 'color1', 'color2', 'color3', 'color4'));
    }

    public function ambil(Request $request, $nim)
    {
        try {
            $pelamar = PendaftaranMagang::where('nim', $nim)->get();

            $diterima =  $pelamar->where('konfirmasi_status', 1)->all();
            $lowongan = $pelamar->where('id_lowongan', $request->lowongan)->first();

            $count = count($diterima) ?? 0;

            if ($count == 0) {
                $lowongan->konfirmasi_status = 1;
                $lowongan->save();
            }

            return response()->json([
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function tolak(Request $request, $nim)
    {
        try {
            $pelamar = PendaftaranMagang::where('nim', $nim)->get();

            $lowongan = $pelamar->where('id_lowongan', $request->lowongan)->first();

            $lowongan->konfirmasi_status = 2;
            $lowongan->save();

            return response()->json([
                'error' => false
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function editMulai(string $id)
    {
        $pelamar = PendaftaranMagang::where('id_pendaftaran', $id)->first();
        return $pelamar;
    }

    public function mulai(KonfirmasiMagangRequest $request, $id)
    {
        try {

            $pendaftar = PendaftaranMagang::where('id_pendaftaran', $id)->with('lowongan_magang')->first();

            if (!empty($request->bukti_doc)) {
                $pendaftar->bukti_doc = $request->bukti_doc->store('post');
            }
            $pendaftar->konfirmasi_status = 1;
            $pendaftar->current_step = 'diterima';
            $pendaftar->save();

            MhsMagang::create([
                'id_pendaftaran' => $id,
                'startdate_magang' => $request->mulai,
                'enddate_magang' => $request->akhir
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Data berhasil dibuat!',
                'url' => url('kegiatan-saya/lamaran-saya'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
