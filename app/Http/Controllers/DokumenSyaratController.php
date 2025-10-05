<?php

namespace App\Http\Controllers;

use Exception;
use App\Helpers\Response;
use App\Models\JenisMagang;
use Illuminate\Http\Request;
use App\Models\DocumentSyarat;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DokumenSyaratRequest;

class DokumenSyaratController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dokumen_syarat.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis = JenisMagang::all();
        return view('masters.dokumen_persyaratan.index', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenSyaratRequest $request)
    {
        try {
            DocumentSyarat::create([
                'namadocument' => $request->namadoc,
                'id_jenismagang' => $request->namajenis,
                'status' => true,
            ]);

            return Response::success(null, 'Document successfully Add!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $doc = DocumentSyarat::with('jenis')->orderBy('id_jenismagang', 'asc')->get();

        return DataTables::of($doc)
            ->addIndexColumn()
            ->editColumn('jenis_magang', function ($row) {
                return $row->jenis->namajenis." (".$row->jenis->durasimagang.")";
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-success'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row->status) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row->status) ? "danger" : "primary";

                $url = route('doc-syarat.status', $row->id_document);
                $btn = "<div class='d-flex justify-content-center'></div><a data-bs-toggle='modal' data-id='{$row->id_document}' onclick=edit($(this)) class='cursor-pointer mx-1 text-warning'><i class='tf-icons ti ti-edit' ></i>
                <a data-url='{$url}' class='cursor-pointer mx-1 update-status text-{$color}' data-function='afterUpdateStatus'><i class='tf-icons ti {$icon}'></i></a>";

                return $btn;
            })
            ->rawColumns(['action', 'status'])

            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doc = DocumentSyarat::where('id_document', $id)->first();
        return $doc;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DokumenSyaratRequest $request, string $id)
    {
        try {
            $doc = DocumentSyarat::where('id_document', $id)->first();
            if (!$doc) return Response::error(null, 'Not Found.', 404);

            $doc->id_jenismagang = $request->namajenis;
            $doc->namadocument = $request->namadoc;
            $doc->save();

            return Response::success(null, 'Document successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(string $id)
    {
        try {
            $doc = DocumentSyarat::where('id_document', $id)->first();
            $doc->status = ($doc->status) ? false : true;
            $doc->save();

            return Response::success(null, 'Status Document successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}
