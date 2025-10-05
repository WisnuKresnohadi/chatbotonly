<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use App\Models\Universitas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class IgraciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:igracias.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $view = $this->getViewDesign();

        if ($request->type) {
            switch ($request->type) {
                case 'id_fakultas':
                    $data = Fakultas::select('namafakultas as text', 'id_fakultas as id')->where('id_univ', $request->selected)->get();
                    break;
                case 'id_prodi':
                    $data = ProgramStudi::select(DB::raw("CONCAT(jenjang, ' ', namaprodi) as text"), 'id_prodi as id')
                        ->where('id_fakultas', $request->selected)
                        ->get();
                    break;
                case 'kode_dosen':
                    $data = Dosen::where('id_prodi', $request->selected)->get()->transform(function ($item) {
                        $result = new \stdClass();
                        $result->text = $item->kode_dosen . ' | ' . $item->namadosen;
                        $result->id = $item->kode_dosen;
                        return $result;
                    });
                    break;
                case 'id_mk':
                    $data = MataKuliah::select(DB::raw("CONCAT(kode_mk, ' - ', namamk, ' [', sks, ' SKS]') as text"), 'id_mk as id')
                        ->where('id_prodi', $request->selected)
                        ->get();
                    break;
                case 'kode_dosen_wali':
                    $data = Dosen::where('id_fakultas', $request->selected)->get()->transform(function ($item) {
                        $result = new \stdClass();
                        $result->text = $item->kode_dosen . ' | ' . $item->namadosen;
                        $result->id = $item->kode_dosen;
                        return $result;
                    });
                    break;
                default:
                    # code...
                    break;
            }
            return Response::success($data, 'Success');
        }

        $universitas = Universitas::all();
        return view('masters.igracias.index', compact('universitas', 'view'));
    }

    public function syncAll(Request $request)
    {
        try {
            // Start time tracking
            $userId = auth()->user()->id;
            Cache::put('batch_{$batchId}_isRead', false);

            $configKey = 'igracias.prodi';
            $listProdi = config($configKey, []);
            $listProdi = array_flip($listProdi);
            $batchId = Cache::get("sync_batch_active_id_$userId");
            $batchInfo = Cache::get("batch_{$batchId}_info");
            $isRead = Cache::get('batch_{$batchId}_isRead');

            if ($batchInfo && $batchInfo['progress'] != 100 && $batchInfo['finishedAt'] == null && !$isRead) {
                return Response::error(null, 'Sinkronisasi sedang berlangsung, mohon untuk menunggu sinknronisasi selesai untuk melakukan sinkronisasi baru.');
            }

            $syncAll = ["ProdiSync", "DosenSync", "MhsSync", "MkSync", "NilaiAkhirMhsSync"];

            foreach ($syncAll as $class) {
                $syncClass = "App\\Sync\\{$class}";
                $syncModel = new $syncClass($queryParams = ["limit" => 500]);
                $syncModel->synchronize();
            }

            return Response::success(['icon' => 'info', 'title' => 'info'], 'Siknronisasi Data Akademik dalam proses');
        } catch (Exception $e) {
            // Clean up time tracking on error
            $userId = auth()->user()->id;
            Cache::forget("sync_batch_active_start_time_$userId");

            return Response::errorCatch($e, $e->getMessage());
        }
    }

    public function syncActiveBatch()
    {
        $userId = auth()->user()->id;
        $batchId = Cache::get("sync_batch_active_id_$userId");
        $batchInfo = Cache::get("batch_{$batchId}_info");

        if ($batchInfo && $batchInfo['pendingJobs'] == 0 && $batchInfo['finishedAt'] != null) {
            $this->clearAllCacheSync($batchId);

            $isRead = Cache::get("batch_{$batchId}_isRead", 0);

            if (!$isRead) {
                Cache::put("batch_{$batchId}_isRead", 1);
                $batchInfo['isRead'] = false;
            } else {
                $batchInfo['isRead'] = true;
            }
        }
        return response()->json(['batchId' => $batchId, 'batch' => $batchInfo]);
    }

    private function clearAllCacheSync($batchId)
    {
        // Bus::findBatch($batchId)->delete();
        // Cache::forget("batch_{$batchId}_info");
        // Cache::forget("sync_batch_active_id");
        Cache::forget("batch_{$batchId}_paginate_total");
        Cache::forget("batch_{$batchId}_success");
        Cache::forget("batch_{$batchId}_error");
        Cache::forget("batch_{$batchId}_failed");
        Cache::forget("batch_{$batchId}_progress_batch");
        Cache::forget("batch_{$batchId}_total");
    }

    private function getViewDesign()
    {

        $dosen = [
            '
            <th>No</th>
            <th>Universitas</th>
            <th>NIP</th>
            <th style="text-align: center;">KODE DOSEN</th>
            <th>NAMA DOSEN</th>
            <th>NOMOR TELEPON</th>
            <th>EMAIL</th>
            <th class="text-center">STATUS</th>
            <th>AKSI</th>
            '
        ];

        $mata_kuliah = [
            '
            <th>No</th>
            <th>KODE MATA KULIAH</th>
            <th>NAMA MATA KULIAH</th>
            <th>KURIKULUM</th>
            <th>UNIVERSITAS & FAKULTAS</th>
            <th style="text-align: center;">SKS</th>
            <th class="text-center">STATUS</th>
            <th>AKSI</th>
            '
        ];

        $mahasiswa = [
            '
            <th>NO</th>
            <th>NAMA/NIM</th>
            <th>UNIVERSITAS & FAKULTAS</th>
            <th class="text-center">TUNGGAKAN BPP</th>
            <th class="text-center">IPK</th>
            <th class="text-center">TES BAHASA</th>
            <th class="text-center">TAK</th>
            <th class="text-center">ANGKATAN</th>
            <th>KONTAK</th>
            <th>ALAMAT</th>
            <th class="text-center">STATUS</th>
            <th class="text-center">AKSI</th>
            '
        ];

        $program_studi =  [
            '
            <th>NOMOR</th>
            <th>UNIVERSITAS</th>
            <th>NAMA FAKULTAS</th>
            <th>NAMA PRODI</th>
            <th class="text-center">STATUS</th>
            <th class="text-center">AKSI</th>
            '
        ];

        $columnsDosen = "[
            { data: 'DT_RowIndex' },
            { data: 'id_univ', name: 'id_univ' },
            { data: 'nip', name: 'nip' },
            { data: 'kode_dosen', name: 'kode_dosen' },
            { data: 'namadosen', name: 'namadosen' },
            { data: 'nohpdosen', name: 'nohpdosen' },
            { data: 'emaildosen', name: 'emaildosen' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' }
        ]";

        $columnsMataKuliah = "[
            { data: 'DT_RowIndex' },
            { data: 'kode_mk', name: 'kode_mk' },
            { data: 'namamk', name: 'namamk' },
            { data: 'kurikulum', name: 'kurikulum' },
            { data: 'id_univ', name: 'id_univ' },
            { data: 'sks', name: 'sks' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' }
        ]";

        $columnsMahasiswa = "[
            { data: 'nomor_urut', name: 'nomor_urut', orderable: false, searchable: false},
            { data: 'name', name: 'name' },
            { data: 'univ_fakultas', name: 'univ_fakultas' },
            { data: 'tunggakan_bpp', name: 'tunggakan_bpp' },
            { data: 'ipk', name: 'ipk' },
            { data: 'tesbahasa', name: 'tesbahasa' },
            { data: 'tak', name: 'tak' },
            { data: 'angkatan', name: 'angkatan' },
            { data: 'contact', name: 'contact' },
            { data: 'alamatmhs', name: 'alamatmhs' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]";

        $columnsProdi = '[{
                data: "DT_RowIndex"
            },
            {
                data: "univ.namauniv"
            },
            {
                data: "fakultas.namafakultas"
            },
            {
                data: "namaprodi"
            },
            {
                data: "status"
            },
            {
                data: "action"
            }
        ]';

        return compact(
            'dosen',
            'mahasiswa',
            'mata_kuliah',
            'program_studi',
            'columnsDosen',
            'columnsMataKuliah',
            'columnsMahasiswa',
            'columnsProdi',
        );
    }
}
