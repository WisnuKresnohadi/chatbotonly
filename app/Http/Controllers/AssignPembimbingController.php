<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LowonganMagang;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\MhsMagang;
use App\Models\PegawaiIndustri;

class AssignPembimbingController extends Controller
{
    
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['pegawai'] = $this->getPegawaiIndustri(function ($query) {
            return $query->whereHas('user', function ($q) {
                $q->whereHas('roles', function ($q2) {
                    $q2->where('name', 'Pembimbing Lapangan');
                });
            });
        })->my_pegawai_industri;
        
        $data['prodi'] = ProgramStudi::all();
        return view('company.assign_pembimbing.index', $data);
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request)
    {
        $request->validate([
            'type' => 'required|in:assigned,unassigned',
        ]);
        
        $this->getPendaftarMagang(function ($query) use ($request) {

            $query = $query->leftJoin('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran');
            $query = $query->leftJoin('pegawai_industri', 'mhs_magang.id_peg_industri', '=', 'pegawai_industri.id_peg_industri');

            if($request->type == 'assigned') {
                $query = $query->whereNotNull('mhs_magang.id_peg_industri');
            } else {
                $query = $query->whereNull('mhs_magang.id_peg_industri');
            }

            if($request->posisi){
                $query->where('lowongan_magang.intern_position', 'like', '%' . $request->posisi . '%');
            }

            if($request->id_prodi){
                $query->where('mahasiswa.id_prodi', $request->id_prodi);
            }

            if($request->tahun_akademik){
                $query->where('lowongan_magang.id_year_akademik', $request->tahun_akademik);
            }

            $query = $query->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN);

            $query = $query->select(
                'pendaftaran_magang.*',
                'mhs_magang.id_peg_industri',
                'mhs_magang.id_mhsmagang',
                'mhs_magang.startdate_magang',
                'mhs_magang.enddate_magang',
                'pegawai_industri.namapeg',
                'pegawai_industri.nohppeg',
                'pegawai_industri.id_peg_industri',
                'pendaftaran_magang.file_document_mitra',
                'program_studi.namaprodi',
                'program_studi.id_prodi',
                'mahasiswa.namamhs',
                'mahasiswa.nim',
                'lowongan_magang.intern_position',
            );

            return $query;
        });
       
        return DataTables::of($this->my_pendaftar_magang)
            ->addIndexColumn()
            ->addColumn('tanggal_magang', function ($row) {
                $result = '<div class="text-start">';

                $result .= '<span class="text-muted text-nowrap">Tanggal Mulai:</span><br>';
                $result .= '<span>' . (($row->startdate_magang) ? Carbon::parse($row->startdate_magang)->format('d F Y') : '-') . '</span><br>';
                $result .= '<span class="text-muted text-nowrap">Tanggal Berakhir:</span><br>';
                $result .= '<span>' . (($row->enddate_magang) ? Carbon::parse($row->enddate_magang)->format('d F Y') : '-') . '</span>';

                $result .= '</div>';
                return  $result;
            })
            ->editColumn('namamhs', function ($data) {
                $result = '<div class="text-nowrap">';
                $result .= '<span class="fw-bolder text-unwrap">' .$data->namamhs. '</span><br>';
                $result .= '<span>' .$data->nim. '</span><br>';
                $result .= '</div>';

                return $result;
            })
            ->addColumn('pembimbing_lapangan', function ($data) {
                if(!$data->id_peg_industri) return '<div class="text-nowrap">-</div>';
                $result = '<div class="text-nowrap">';
                $result .= '<span>' .$data->namapeg . '</span><br>';
                $result .= '<span class="fw-bolder text-unwrap">' .$data->nohppeg . '</span><br>';
                $result .= '</div>';

                return $result;
            })
            ->addColumn('bukti_penerimaan', function ($data) {
                if(!$data->file_document_mitra) return '<div class="text-nowrap">-</div>';
                $result = '<div class="text-nowrap">';
                $result .= '<a href="' . url($data->file_document_mitra) . '" target="_blank" class="text-primary">Bukti Penerimaan</a>';
                $result .= '</div>';

                return $result;
            })
            ->rawColumns(['namamhs', 'tanggal_magang', 'pembimbing_lapangan', 'bukti_penerimaan'])
            ->make(true);
    }

    public function assignPemLapangan(Request $request) {

        $request->validate([
            'id_mhsmagang' => 'required|array|exists:mhs_magang,id_mhsmagang',
            'id_peg_industri' => 'required|exists:pegawai_industri,id_peg_industri'
        ], [
            'id_peg_industri.required' => 'Pilih pembimbing lapangan',
            'id_mhsmagang.array' => 'Data tidak valid',
            'id_peg_industri.exists' => 'Pembimbing tidak ditemukan',
            'id_mhsmagang.exists' => 'Data tidak ditemukan',
            'id_mhsmagang.required' => 'Data tidak valid'
        ]);

        try {
            DB::beginTransaction();

            MhsMagang::whereIn('id_mhsmagang', $request->id_mhsmagang)->update([
                'id_peg_industri' => $request->id_peg_industri
            ]);

            DB::commit();
            return Response::success(null, 'Berhasil assign pembimbing lapangan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }
   
    private function getPegawaiIndustri($additional = null){
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;
        $this->my_pegawai_industri = PegawaiIndustri::where('id_industri', $pegawaiIndustri->id_industri);
        if ($additional) $this->my_pegawai_industri = $additional($this->my_pegawai_industri);
        
        $this->my_pegawai_industri = $this->my_pegawai_industri->get();

        return $this;
    }


    private function getPendaftarMagang($additional = null){
        $user = auth()->user();
        $pegawaiIndustri = $user->pegawai_industri;

        $this->my_pendaftar_magang = PendaftaranMagang::join('mahasiswa', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->leftJoin('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->leftJoin('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('lowongan_magang.id_industri', $pegawaiIndustri->id_industri);

        if ($additional) $this->my_pendaftar_magang = $additional($this->my_pendaftar_magang);
        $this->my_pendaftar_magang = $this->my_pendaftar_magang->get();
        
        return $this;
    }
}
