<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Models\JenisMagang;
use App\Models\BerkasMagang;
use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use App\Models\DocumentSyarat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\JenisMagangRequest;

class JenisMagangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jenis_magang.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.jenis_magang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->section == 'get_data_before') {
            $jenismagang = JenisMagang::with([
                'berkas_magang' => function ($q) {
                    $q->select('id_berkas_magang', 'nama_berkas', 'status_upload', 'template', 'id_jenismagang');
                }, 'dokumen_persyaratan' => function ($q) {
                    $q->select('id_document', 'namadocument', 'id_jenismagang');
                }
            ]
            )->where('id_jenismagang', $request->id)->first();
            if (!$jenismagang) return Response::error(null, 'Jenis Magang not found!');

            $data['durasimagang'] = $jenismagang->durasimagang;
            $data['id_year_akademik'] = TahunAkademik::active()->first()->id_year_akademik;
            $data['desc'] = $jenismagang->desc;
            $data['detail_berkas_magang'] = view('masters/jenis_magang/step/detail_berkas_magang', compact('jenismagang'))->render();
            $data['detail_dokumen_persyaratan'] = view('masters/jenis_magang/step/detail_dokumen_persyaratan', compact('jenismagang'))->render();

            return Response::success($data, 'Success');
        }

        $tahunAjaran = TahunAkademik::orderBy('tahun', 'desc')->orderByRaw("CASE WHEN semester = 'Ganjil' THEN 2 WHEN semester = 'Genap' THEN 1 ELSE 0 END")->get();
        $tahunAjaranActiveIndex = $tahunAjaran->search(fn ($item, $key) => $item->status == 1);
        $tahunAjaranBefore = $tahunAjaran[$tahunAjaranActiveIndex + 1];
        
        $jenisMagangBefore = JenisMagang::where('id_year_akademik', $tahunAjaranBefore->id_year_akademik)->where('status', 1)->get();
        $berkas = BerkasMagang::all();
        $urlBack = route('jenismagang');
        return view('masters.jenis_magang.modal', compact('berkas', 'jenisMagangBefore', 'urlBack'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisMagangRequest $request)
    {
        try {
            $dataStep = Crypt::decryptString($request->data_step);
            if (in_array($dataStep, ['1', '2'])) {
                return Response::success([
                    'ignore_alert' => true,
                    'data_step' => (int) ($dataStep + 1),
                ], 'Valid data!');
            }

            if (collect($request->berkas)->where('statusupload', 1)->count() == 0) {
                return Response::error(null, 'Harus ada berkas yang wajib!');
            }

            DB::beginTransaction();
            $kategori = JenisMagang::create([
                'namajenis' => $request->namajenis,
                'durasimagang' => $request->durasimagang,
                'id_year_akademik' => $request->id_year_akademik,
                'desc' => $request->desc,
                'status' => true,
            ]);

            $fileLoaded = collect($request->berkas)->pluck('id_berkas_magang')->toArray();
            if (count($fileLoaded) > 0) $berkasMagang = BerkasMagang::whereIn('id_berkas_magang', collect($request->berkas)->pluck('id_berkas_magang')->toArray())->get();

            foreach ($request->dokumen_persyaratan as $key => $value) {
                DocumentSyarat::create([
                    'namadocument' => $value['namadocument'],
                    'id_jenismagang' => $kategori->id_jenismagang,
                ]);
            }

            foreach ($request->berkas as $key => $value) {
                $file = null;
                if (count($fileLoaded) > 0) {
                    if (count($berkasMagang) > 0) {
                        $berkasMagangPicked = $berkasMagang->where('id_berkas_magang', $value['id_berkas_magang'])->first();
                        if ($berkasMagangPicked == null) return Response::error(null, 'Berkas Magang not found!');
    
                        $file = $berkasMagangPicked->template;
                    }
                }

                if (isset($value['template']) && $value['template'] != null && is_file($value['template']) == true) {
                    $file = Storage::put('template_berkas_magang', $value['template']);
                }

                BerkasMagang::create([
                    'id_jenismagang' => $kategori->id_jenismagang,
                    'nama_berkas' => $value['namaberkas'],
                    'template' => $file,
                    'status_upload' => $value['statusupload'],
                    'due_date' => Carbon::parse($value['due_date'])->format('Y-m-d H:i:s'),
                ]);
            }

            DB::commit();

            return Response::success(null, 'Data successfully Created!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $berkas = JenisMagang::with('berkas_magang')
        ->select('jenis_magang.*', 'tahun_akademik.tahun', 'tahun_akademik.semester')
        ->leftJoin('tahun_akademik', 'tahun_akademik.id_year_akademik', 'jenis_magang.id_year_akademik')
        ->orderBy('tahun_akademik.tahun', 'desc')
        ->orderByRaw("CASE WHEN tahun_akademik.semester = 'Ganjil' THEN 2 WHEN tahun_akademik.semester = 'Genap' THEN 1 ELSE 0 END");

        return DataTables::of($berkas->get())
            ->addIndexColumn()
            ->editColumn('status', function ($jenismagang) {
                if ($jenismagang->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->editColumn('namajenis', fn($x) => '<span class="text-nowrap">' . $x->namajenis . '</span>')
            ->editColumn('tahun', fn($x) => '<span class="text-nowrap">' . $x->tahun . '&ensp;-&ensp;' . $x->semester . '</span>')
            ->editColumn('durasimagang', fn($x) => '<span class="text-nowrap">' . $x->durasimagang . '</span>')
            ->editColumn('desc', function($x) {  
                $fullDesc = nl2br(e($x->desc)); // Full description  
                if (empty($x->desc)) {
                    return '<span class="text-muted">No description available</span>';
                }
                if (strlen($x->desc) > 100) {
                    $shortDesc = nl2br(e(substr($x->desc, 0, 100))) . '...';  
                    return '  
                        <div class="description" style="width:300px; overflow:hidden;">  
                            <span class="short-desc">' . $shortDesc . '</span>  
                            <span class="more-content" style="display: none;">' . $fullDesc . '</span>  
                            <button class="btn btn-link read-more-btn p-0">Read More</button>  
                        </div>  
                    ';  
                }else {  
                    // If the description is 100 characters or less, show it without the button  
                    return '<span>' . $fullDesc . '</span>';  
                }  
            })  
            ->addColumn('dokumen_persyaratan', function ($row) {
                $result = '<div clas"d-flex flex-column align-items-start">';
                $result .= '<a class="btn btn-outline-primary btn-sm text-primary" onclick="viewBerkas($(this))" data-section="dokumen_persyaratan" data-id="'.$row->id_jenismagang.'">Lihat Selengkapnya</a>';
                $result .= '</div>';
                return $result;
            })
            ->addColumn('berkas_magang', function ($row) {
                $result = '<div clas"d-flex flex-column align-items-start">';
                $result .= '<a class="btn btn-outline-primary btn-sm text-primary" onclick="viewBerkas($(this))" data-section="berkas_magang" data-id="'.$row->id_jenismagang.'">Lihat Selengkapnya</a>';
                $result .= '</div>';
                return $result;
            })
            ->addColumn('action', function ($jenismagang) {
                $icon = ($jenismagang->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($jenismagang->status) ? "danger" : "success";

                $url = route('jenismagang.status', $jenismagang->id_jenismagang);
                $btn = "<div class='d-flex justify-content-center'><a href='jenis-magang/edit/{$jenismagang->id_jenismagang}' class='btn-icon text-warning'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' class='update-status btn-icon text-{$color}' data-function='afterUpdateStatus'><i class='tf-icons ti {$icon}'></i></a></div>";

                return $btn;
            })
            ->rawColumns(['namajenis', 'tahun', 'durasimagang', 'desc', 'status', 'action', 'berkas_magang', 'dokumen_persyaratan'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $jenismagang = JenisMagang::where('id_jenismagang', $id)->first();
        $tahun = TahunAkademik::all();
        $urlBack = route('jenismagang');

        return view('masters.jenis_magang.modal', compact('jenismagang', 'tahun', 'urlBack'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisMagangRequest $request, $id)
    {
        try {
            $jenismagang = JenisMagang::with('berkas_magang')->where('id_jenismagang', $id)->first();
            if (!$jenismagang) return Response::error(null, 'Jenis Magang not found!', 404);

            $dataStep = Crypt::decryptString($request->data_step);

            if (in_array($dataStep, ['1', '2'])) {
                return Response::success([
                    'ignore_alert' => true,
                    'data_step' => (int) ($dataStep + 1),
                ], 'Valid data!');
            }

            if (collect($request->berkas)->where('statusupload', 1)->count() == 0) {
                return Response::error(null, 'Harus ada berkas yang wajib!');
            }

            DB::beginTransaction();

            $jenismagang->namajenis = $request->namajenis;
            $jenismagang->durasimagang = $request->durasimagang;
            $jenismagang->id_year_akademik = $request->id_year_akademik;
            $jenismagang->desc = $request->desc;
            $jenismagang->save();

            $jenismagang->dokumen_persyaratan()->whereNotIn('id_document', collect($request->dokumen_persyaratan)->pluck('id_document')->toArray())->delete();
            foreach ($request->dokumen_persyaratan as $key => $value) {
                DocumentSyarat::updateOrCreate([
                    'id_document' => $value['id_document'],
                    'id_jenismagang' => $jenismagang->id_jenismagang,
                ], [
                    'namadocument' => $value['namadocument'],
                ]);
            }

            $berkasToDelete = $jenismagang->berkas_magang()->whereNotIn('id_berkas_magang', collect($request->berkas)->pluck('id_berkas_magang')->toArray())->get();
            foreach ($berkasToDelete as $key => $value) {
                if ($value->template) {
                    Storage::delete($value->template);
                    $value->delete();
                }
            }

            foreach ($request->berkas as $key => $l) {
                if (isset($l['id_berkas_magang']) && $l['id_berkas_magang'] != null) {
                    $berkas_magang = $jenismagang->berkas_magang->where('id_berkas_magang', $l['id_berkas_magang'])->first();
                    $file = $berkas_magang->template;
                    if (isset($l['template']) && $l['template'] != null) {
                        if ($berkas_magang->template) {
                            Storage::delete($berkas_magang->template);
                        }
                        $file = Storage::put('template_berkas_magang', $l['template']);
                    }

                    $berkas_magang->update([
                        'nama_berkas' => $l['namaberkas'],
                        'template' => $file,
                        'status_upload' => $l['statusupload'],
                        'due_date' => Carbon::parse($l['due_date'])->format('Y-m-d H:i:s')
                    ]);
                } else {
                    $file = null;
                    if ($l['template'] != null) {
                        $file = Storage::put('template_berkas_magang', $l['template']);
                    }
                    BerkasMagang::create([
                        'id_jenismagang' => $jenismagang->id_jenismagang,
                        'nama_berkas' => $l['namaberkas'],
                        'template' => $file,
                        'status_upload' => $l['statusupload'],
                        'due_date' => Carbon::parse($l['due_date'])->format('Y-m-d H:i:s')
                    ]);
                }
            }

            DB::commit();
            return Response::success(null, 'Data successfully Updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $jenismagang = JenisMagang::where('id_jenismagang', $id)->first();
            if (!$jenismagang) return Response::error(null, 'Jenis Magang not found!');

            $jenismagang->status = !$jenismagang->status;
            $jenismagang->save();

            return Response::success(null, 'Status successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function getDataBerkas(Request $request) {
        $request->validate([
            'data_id' => 'required|exists:jenis_magang,id_jenismagang',
            'data_section' => 'required|in:dokumen_persyaratan,berkas_magang',
        ]);

        if ($request->data_section == 'dokumen_persyaratan') {
            $dokumenSyarat = DocumentSyarat::where('id_jenismagang', $request->data_id)->get();
            $data['title'] = 'Dokumen Persyaratan';
            $data['view'] = view('masters/jenis_magang/components/list_berkas', compact('dokumenSyarat'))->render();
        } else if ($request->data_section == 'berkas_magang') {
            $berkasMagang = BerkasMagang::where('id_jenismagang', $request->data_id)->get();
            $data['title'] = 'Berkas Magang';
            $data['view'] = view('masters/jenis_magang/components/list_berkas', compact('berkasMagang'))->render();
        } else {
            return Response::error(null, 'Data not found!');
        }

        return Response::success($data, 'Success');
    }

    public function updateStatusDokumentPersyaratan($id) {
        try {
            $dokument = DocumentSyarat::where('id_document', $id)->first();
            if (!$dokument) return Response::error(null, 'Document not found!');
            $dokument->status = !$dokument->status;
            $dokument->save();

            $dokumenSyarat = DocumentSyarat::where('id_jenismagang', $dokument->id_jenismagang)->get();
            return Response::success(
                view('masters/jenis_magang/components/list_berkas', compact('dokumenSyarat'))->render()
            , 'Status successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateStatusBerkasMagang($id) {
        try {
            $berkasMagang = BerkasMagang::where('id_berkas_magang', $id)->first();
            if (!$berkasMagang) return Response::error(null, 'Document not found!');
            $berkasMagang->status_upload = !$berkasMagang->status_upload;
            $berkasMagang->save();

            $berkasMagang = BerkasMagang::where('id_jenismagang', $berkasMagang->id_jenismagang)->get();
            return Response::success(
                view('masters/jenis_magang/components/list_berkas', compact('berkasMagang'))->render()
            , 'Status successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
