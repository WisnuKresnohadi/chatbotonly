<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use App\Models\DokumenPendaftaranMagang;
use Illuminate\Support\Facades\Validator;
use App\Enums\PendaftaranMagangStatusEnum;

class ApprovalMahasiswaKaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $view = $this->getViewDesign();
        return view('approval_mahasiswa/index', compact('view'));
    }

    /**
     * Get data for datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request) {
        // Validate the request
        $request->validate(['section' => 'required|in:approval,sudah_approval']);

        // Get the authenticated user's dosen
        $dosen = auth()->user()->dosen;

        // Mengirim query ke database untuk mendapatkan data
        $data = Mahasiswa::select(
            'mahasiswa.nim', 'mahasiswa.namamhs', 'pendaftaran_magang.tanggaldaftar', 'industri.namaindustri',
            'lowongan_magang.intern_position', 'mahasiswa.nohpmhs', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'mahasiswa.kode_dosen','bidang_pekerjaan_industri.namabidangpekerjaan'
        )
        ->join('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('mahasiswa.id_prodi', $dosen->id_prodi);

        // Filter data berdasarkan parameter tiap bagian/section
        if ($request->section == 'approval') $data = $data->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL);

        $array_status = [];
        if ($request->section == 'sudah_approval') {
            $array_status = array_diff(PendaftaranMagangStatusEnum::getConstants(), ['pending', 'approved_by_doswal', 'rejected_by_doswal']);
            $data = $data->whereIn('pendaftaran_magang.current_step', $array_status);
        }

        // Mengembalikan data dalam format tabel
        return datatables()->of($data->get())
        ->addIndexColumn()
        ->editColumn('namamhs', function ($data) {
            // Format the 'namamhs' column
            $result = '<div class="text-unwrap">';
            $result .= '<span class="fw-bolder text-unwrap">' .$data->namamhs. '</span><br>';
            $result .= '<span>' .$data->nim. '</span><br>';
            $result .= '<small>' .$data->email. '</small>';
            $result .= '</div>';

            return $result;
        })
        ->editColumn('tanggaldaftar', fn ($data) => '<div class="text-center">' . Carbon::parse($data->tanggaldaftar)->format('d M Y') . '</div>')
        ->editColumn('intern_position', function ($data) {
            return $data->namabidangpekerjaan;
        })
        ->editColumn('current_step', function ($data) use ($array_status) {
            // Format the 'current_step' column
            $result = '<div class="text-center">';

            $getStatusLabel = PendaftaranMagangStatusEnum::getWithLabel($data->current_step);
            $result .= '<span class="badge bg-label-' .$getStatusLabel['color']. '">' .$getStatusLabel['title']. '</span>';

            $result .= '</div>';
            return $result;
        })
        ->addColumn('action', function ($data) {
            // Format the 'action' column
            $result = '<div class="d-flex justify-content-center">';
            $result .= "<a href='".route('approval_mahasiswa_kaprodi.detail', $data->id_pendaftaran)."' class='mx-1 text-primary cursor-pointer'><i class='ti ti-file-invoice'></i></a>";
            if ($data->current_step == PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL) {
                $result .= "<a onclick='approved($(this))' class='mx-1 text-success cursor-pointer' data-status='approved' data-id='$data->id_pendaftaran'><i class='ti ti-file-check'></i></a>";
                $result .= "<a onclick='rejected($(this))' class='mx-1 text-danger cursor-pointer' data-status='rejected' data-id='$data->id_pendaftaran'><i class='ti ti-file-x'></i></a>";
            }
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['namamhs', 'tanggaldaftar', 'current_step', 'action'])
        ->make(true);
    }

    public function detail($id) {
        $data['data'] = Mahasiswa::with('education', 'experience', 'sertifikat')->select(
            'mahasiswa.*', 'pendaftaran_magang.tanggaldaftar', 'industri.namaindustri',
            'lowongan_magang.intern_position', 'lowongan_magang.lokasi', 'lowongan_magang.durasimagang', 'lowongan_magang.id_jenismagang', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'universitas.namauniv', 'fakultas.namafakultas',
            'pendaftaran_magang.reason_aplicant'
        )
        ->join('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->where('pendaftaran_magang.id_pendaftaran', $id)->first();

        $data['dokumen_persyaratan'] = DokumenPendaftaranMagang::join('document_syarat', 'document_syarat.id_document', '=', 'dokumen_pendaftaran_magang.id_document')
            ->where('id_pendaftaran', $id)->get();

        $data['urlBack'] = route('approval_mahasiswa_kaprodi');

        return view('approval_mahasiswa/detail', $data);
    }

    public function approval(Request $request, $id) {
        try {
            $validate = Validator::make($request->all(), [
                'status' => 'required|in:approved,rejected',
                'reason' => 'required_if:status,rejected'
            ], ['reason.required_if' => 'Alasan harus diisi.']);

            if ($validate->fails()) {
                if ($validate->errors()->has('status')) {
                    return Response::error(null, 'Invalid.');
                } else {
                    return Response::errorValidate($validate->errors(), 'Invalid.');
                }
            };

            $dosen = auth()->user()->dosen;

            $pendaftaranMahasiswa = PendaftaranMagang::where('id_pendaftaran', $id)
            ->whereHas('mahasiswa', function ($q) use ($dosen) {
                $q->where('id_prodi', $dosen->id_prodi);
            })->first();

            if (!$pendaftaranMahasiswa) return Response::error(null, 'Pendaftaran mahasiswa tidak ditemukan.');

            $message = 'Pendaftaran mahasiswa approved.';
            if ($request->status == 'approved') $pendaftaranMahasiswa->current_step = PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI;
            else {
                $pendaftaranMahasiswa->current_step = PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI;
                $pendaftaranMahasiswa->reason_reject = $request->reason;
                $message = 'Pendaftaran mahasiswa rejected.';
            }
            $pendaftaranMahasiswa->saveHistoryApproval()->save();

            return Response::success(null, $message);
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function approvals(Request $request) {
        try {

            $validate = Validator::make($request->all(), [
                'id_pendaftaran' => 'required|array|exists:pendaftaran_magang,id_pendaftaran',
            ],
            [
                'id_pendaftaran.array' => 'Data tidak valid',
                'id_pendaftaran.required' => 'Data tidak valid',
            ]);

            if ($validate->fails()) {
                if ($validate->errors()->has('status')) {
                    return Response::error(null, 'Invalid.');
                } else {
                    return Response::errorValidate($validate->errors(), 'Invalid.');
                }
            };

            DB::beginTransaction();

            $dosen = auth()->user()->dosen;

            $pendaftaranMahasiswas = PendaftaranMagang::whereIn('id_pendaftaran', $request->id_pendaftaran)
            ->whereHas('mahasiswa', function ($q) use ($dosen) {
                $q->where('id_prodi', $dosen->id_prodi);
            })->get();

            foreach($pendaftaranMahasiswas as $idPendaftar) {
                $idPendaftar->current_step = PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI;
                $idPendaftar->saveHistoryApproval()->save();
            }

            $message = 'Pendaftaran mahasiswa approved.';

            DB::commit();
            return Response::success(null, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    private function getViewDesign() {
        $title = 'Approval Mahasiswa';
        $urlGetData = route('approval_mahasiswa_kaprodi.get_data');
        $urlApproval = route('approval_mahasiswa_kaprodi.approval', ['id' => ':id']);
        $urlApprovals = route('approval_mahasiswa_kaprodi.approvals');

        $sudah_approval = [
            '<th>NO</th>',
            '<th>NAMA</th>',
            '<th style="text-align:center;">TANGGAL DAFTAR</th>',
            '<th>PERUSAHAAN</th>',
            '<th>POSISI MAGANG</th>',
            '<th>NO. TELEPON</th>',
            '<th style="text-align:center;">STATUS APPROVAL</th>',
            '<th style="text-align:center;">AKSI</th>',
        ];

        $approval = [
            '<th></th>',
            ...$sudah_approval
        ];

        $columns = "
            { data: 'DT_RowIndex' },
            { data: 'namamhs', name: 'namamhs' },
            { data: 'tanggaldaftar', name: 'tanggaldaftar' },
            { data: 'namaindustri', name: 'namaindustri' },
            { data: 'intern_position', name: 'intern_position' },
            { data: 'nohpmhs', name: 'nohpmhs' },
            { data: 'current_step', name: 'current_step' },
            { data: 'action', name: 'action' },
        ";

        $columnsSudahApproval= "[
            $columns
        ]";

        $columnsApproval = "[
            {data: null},
            $columns
        ]";

        $columnDefs = "
        {
            targets: 0,
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
                console.log(data);
                return `<input type='checkbox' class='dt-checkboxes form-check-input' value='` + data.id_pendaftaran + `'>`;
            },
            checkboxes: {
                selectRow: false,
                selectAllRender: `<input type='checkbox' class='form-check-input'>`
            }
        },";

        return compact(
            'title',
            'urlGetData',
            'urlApproval',
            'urlApprovals',
            'columnDefs',
            'approval',
            'sudah_approval',
            'columnsApproval',
            'columnsSudahApproval'
        );
    }

}
