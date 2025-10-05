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

class ApprovalMahasiswaController extends Controller
{
    public function __construct() {
        $this->middleware('permission:approval_mhs_doswal.view', ['only' => ['index', 'getData', 'detail']]);
        $this->middleware('permission:approval_mhs_doswal.approval', ['only' => ['approval', 'approvals']]);
    }

    public function index() {
        $view = $this->getViewDesign();
        return view('approval_mahasiswa/index', compact('view'));
    }

    public function getData(Request $request) {
        $request->validate(['section' => 'required|in:approval,sudah_approval']);

        $dosen = auth()->user()->dosen;

        $data = Mahasiswa::select(
            'mahasiswa.nim', 'mahasiswa.namamhs', 'pendaftaran_magang.tanggaldaftar', 'industri.namaindustri',
            'lowongan_magang.intern_position', 'mahasiswa.nohpmhs', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'mahasiswa.kode_dosen', 'bidang_pekerjaan_industri.namabidangpekerjaan'
        )
        ->join('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->leftJoin('bidang_pekerjaan_industri', 'lowongan_magang.intern_position', '=', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri')
        ->where('mahasiswa.kode_dosen', $dosen->kode_dosen);

        if ($request->section == 'approval') $data = $data->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::PENDING);

        if ($request->section == 'sudah_approval') {
            $array_status = array_diff(PendaftaranMagangStatusEnum::getConstants(), ['pending']);
            $data = $data->whereIn('pendaftaran_magang.current_step', $array_status);
        }

        return datatables()->of($data->get())
        ->addIndexColumn()
        ->editColumn('namamhs', function ($data) {
            $result = '<div class="text-nowrap">';
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
        ->editColumn('current_step', function ($data) {
            $result = '<div class="text-center">';

            $getStatusLabel = PendaftaranMagangStatusEnum::getWithLabel($data->current_step);
            $result .= '<span class="badge bg-label-' .$getStatusLabel['color']. '">' .$getStatusLabel['title']. '</span>';

            $result .= '</div>';
            return $result;
        })
        ->addColumn('action', function ($data) {
            $result = '<div class="d-flex justify-content-center">';
            $result .= "<a href='".route('approval_mahasiswa_doswal.detail', $data->id_pendaftaran)."' class='mx-1 text-primary cursor-pointer' data-bs-toggle='tooltip' title='View Details'><i class='ti ti-file-invoice'></i></a>";
            if ($data->current_step == PendaftaranMagangStatusEnum::PENDING) {
                $result .= "<a onclick='approved($(this))' class='mx-1 text-success cursor-pointer' data-status='approved' data-id='$data->id_pendaftaran' data-bs-toggle='tooltip' title='approved'><i class='ti ti-file-check'></i></a>";
                $result .= "<a onclick='rejected($(this))' class='mx-1 text-danger cursor-pointer' data-status='rejected' data-id='$data->id_pendaftaran' data-bs-toggle='tooltip' title='rejected'><i class='ti ti-file-x'></i></a>";
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
            'lowongan_magang.intern_position', 'lowongan_magang.lokasi', 'lowongan_magang.durasimagang', 'lowongan_magang.id_jenismagang', 'jenis_magang.namajenis', 'users.email', 'pendaftaran_magang.current_step',
            'pendaftaran_magang.id_pendaftaran', 'universitas.namauniv', 'fakultas.namafakultas',
            'pendaftaran_magang.reason_aplicant'
        )
        ->join('pendaftaran_magang', 'mahasiswa.nim', '=', 'pendaftaran_magang.nim')
        ->join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->join('jenis_magang', 'jenis_magang.id_jenismagang', '=', 'lowongan_magang.id_jenismagang')
        ->join('industri', 'industri.id_industri', '=', 'lowongan_magang.id_industri')
        ->join('users', 'mahasiswa.id_user', '=', 'users.id')
        ->join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->where('pendaftaran_magang.id_pendaftaran', $id)->first();

        $data['dokumen_persyaratan'] = DokumenPendaftaranMagang::join('document_syarat', 'document_syarat.id_document', '=', 'dokumen_pendaftaran_magang.id_document')
            ->where('id_pendaftaran', $id)->get();

        $data['urlBack'] = route('approval_mahasiswa_doswal');

        return view('approval_mahasiswa/detail', $data);
    }

    public function approval(Request $request, $id) {
        try {
            $validate = Validator::make($request->all(), [
                'status' => 'required|in:approved,rejected',
                // 'reason' => 'required_if:status,rejected',
                'reason' => 'nullable',
            ], ['reason.required_if' => 'Alasan harus diisi.']);

            if ($validate->fails()) {
                if ($validate->errors()->has('status')) {
                    return Response::error(null, 'Invalid.');
                } else {
                    return Response::errorValidate($validate->errors(), 'Invalid.');
                }
            };

            $pendaftaranMahasiswa = PendaftaranMagang::where('id_pendaftaran', $id)->first();
            if (!$pendaftaranMahasiswa) return Response::error(null, 'Pendaftaran mahasiswa tidak ditemukan.');

            $message = 'Pendaftaran mahasiswa approved.';
            if ($request->status == 'approved') $pendaftaranMahasiswa->current_step = PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL;
            else {
                $pendaftaranMahasiswa->current_step = PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL;
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
            $pendaftaranMahasiswas = PendaftaranMagang::whereIn('id_pendaftaran', $request->id_pendaftaran)->get();
            foreach($pendaftaranMahasiswas as $pendaftaran) {
                $pendaftaran->current_step = PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL;
                $pendaftaran->saveHistoryApproval()->save();
            }
            DB::commit();
            $message = 'Pendaftaran mahasiswa approved.';

            return Response::success(null, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    private function getViewDesign() {
        $title = 'Approval Mahasiswa';
        $urlGetData = route('approval_mahasiswa_doswal.get_data');
        $urlApproval = route('approval_mahasiswa_doswal.approval', ['id' => ':id']);
        $urlApprovals = route('approval_mahasiswa_doswal.approvals');

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
