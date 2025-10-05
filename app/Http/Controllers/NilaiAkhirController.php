<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\ConfigNilaiAkhirReq;
use App\Models\ConfigNilaiAkhir;
use App\Models\ProgramStudi;
use Exception;

class NilaiAkhirController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nilai_akhir.view');
    }

    public function index(){
        $data['prodi'] = ProgramStudi::where('status', 1)->get();
        return view('masters.nilai_akhir.index', $data);
    }


    public function getData() {

        $config = ConfigNilaiAkhir::select('program_studi.namaprodi', 'config_nilai_akhir.id_config_nilai_akhir', 'config_nilai_akhir.nilai_pemb_lap', 'config_nilai_akhir.nilai_pemb_akademik', 'config_nilai_akhir.status')
        ->leftJoin('program_studi', 'config_nilai_akhir.id_prodi', '=', 'program_studi.id_prodi')->get();

        return datatables()->of($config)
        ->addIndexColumn()
        ->addColumn('aksi', function ($x) {
            $result = '<div class="d-flex justify-content-center">';
            $result .= '<a class="mx-1 cursor-pointer text-warning" data-id="'.$x->id_config_nilai_akhir.'" onclick="edit($(this))"><i class="ti ti-edit"></i></a>';
            if (!$x->status) {
                $result .= '<a class="mx-1 cursor-pointer text-danger" onclick="destroy($(this))" data-url="'.route('nilai_akhir.delete', $x->id_config_nilai_akhir).'"><i class="ti ti-trash"></i></a>';
            }
            if ($x->status) {
                $result .= '<a class="mx-1 cursor-pointer text-danger update-status" data-url="'.route('nilai_akhir.change_status', $x->id_config_nilai_akhir).'" data-function="afterChangeStatus"><i class="ti ti-circle-x"></i></a>';
            } else {
                $result .= '<a class="mx-1 cursor-pointer text-primary update-status" data-url="'.route('nilai_akhir.change_status', $x->id_config_nilai_akhir).'" data-function="afterChangeStatus"><i class="ti ti-circle-check"></i></a>';
            }
            $result .= '</div>';

            return $result;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(ConfigNilaiAkhirReq $request) {
        try {
            ConfigNilaiAkhir::create([
                'id_prodi' => $request->id_prodi,
                'nilai_pemb_lap' => $request->nilai_pemb_lap,
                'nilai_pemb_akademik' => $request->nilai_pemb_akademik
            ]);

            return Response::success(null, 'Berhasil menambah data config nilai akhir.');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function edit($id) {
        $config = ConfigNilaiAkhir::where('id_config_nilai_akhir', $id)->first();
        if (!$config) return Response::error(null, 'Config Nilai Not Found!');

        return Response::success($config, 'Success');
    }

    public function update(ConfigNilaiAkhirReq $request, $id) {
        try {
            $config = ConfigNilaiAkhir::where('id_config_nilai_akhir', $id)->first();
            if (!$config) return Response::error(null, 'Config Nilai Not Found!');

            $config->id_prodi = $request->id_prodi;
            $config->nilai_pemb_lap = $request->nilai_pemb_lap;
            $config->nilai_pemb_akademik = $request->nilai_pemb_akademik;
            $config->save();

            return Response::success(null, 'Berhasil memperbarui data config nilai akhir.');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function changeStatus($id) {
        try {
            $config = ConfigNilaiAkhir::where('id_config_nilai_akhir', $id)->first();
            if (!$config) return Response::error(null, 'Config Nilai Not Found!');
            $config->status = !$config->status;
            $config->save();
            
            return Response::success(null, 'Berhasil memperbarui status');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function destroy($id) {
        try {
            $config = ConfigNilaiAkhir::where('id_config_nilai_akhir', $id)->where('status', 0)->first();
            if (!$config) return Response::error(null, 'Config Nilai Not Found!');
            $config->delete();
            
            return Response::success(null, 'Berhasil menghapus data config nilai akhir.');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }    
}