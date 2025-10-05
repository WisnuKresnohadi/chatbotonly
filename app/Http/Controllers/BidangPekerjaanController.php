<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\BidangPekerjaanIndustriRequest;
use App\Http\Requests\BidangPekerjaanMkRequest;
use App\Models\BidangPekerjaanIndustri;
use App\Models\BidangPekerjaanMk;
use App\Models\BidangPekerjaanMkItem;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BidangPekerjaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bidang_pekerjaan.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_fakultas = Fakultas::where('namafakultas', 'Fakultas Ilmu Terapan')->pluck('id_fakultas')->first();
        $prodi = ProgramStudi::where('id_fakultas', $id_fakultas)->get();
        return view('masters.bidang_pekerjaan.index', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BidangPekerjaanIndustriRequest $request)
    {
        try {
            BidangPekerjaanIndustri::create([
                'namabidangpekerjaan' => $request->namabidangpekerjaan,
                'deskripsi' => $request->deskripsi,
                'default' => 1
            ]);

            return Response::success(null, 'Bidang Pekerjaan berhasil ditambahkan');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('default', 1)->get();
        $index = 0;
        $data = [];
        $haveProdi = [];
        $haveProdiIndex = [];

        foreach ($bidangPekerjaanIndustri as $bidangPekerjaan) {
            if (!BidangPekerjaanMk::where('id_bidang_pekerjaan_industri', $bidangPekerjaan->id_bidang_pekerjaan_industri)->exists()) {
                $index++;
                $data[] = [
                    'no' => $index,
                    'bidang' => $bidangPekerjaan->namabidangpekerjaan,
                    'prodi' => '',
                    'matkul' => '',
                    'bobot' => '',
                    'status' => $bidangPekerjaan->status,
                    'id' => $bidangPekerjaan->id_bidang_pekerjaan_industri,
                ];
            }
        }

        $bidangPekerjaanMk = BidangPekerjaanMk::with(['bidangPekerjaanIndustri', 'mkItems.mataKuliah.prodi'])
            ->whereHas('bidangPekerjaanIndustri', function ($query) {
                $query->where('default', 1);
            })
            ->get();

        foreach ($bidangPekerjaanMk as $bidangPekerjaan) {
            $firstProdi = $bidangPekerjaan->mkItems->first();
            $prodi = $firstProdi?->mataKuliah?->prodi->jenjang . ' ' . $bidangPekerjaan->mkItems->first()?->mataKuliah?->prodi->namaprodi;

            if (!in_array($bidangPekerjaan->bidangPekerjaanIndustri->namabidangpekerjaan, $haveProdi)) {
                $haveProdi[] = $bidangPekerjaan->bidangPekerjaanIndustri->namabidangpekerjaan;
                $index++;
                $haveProdiIndex[$bidangPekerjaan->bidangPekerjaanIndustri->namabidangpekerjaan] = $index;
            }

            $matkul = $bidangPekerjaan->mkItems->map(function ($item) {
                return $item->mataKuliah->kode_mk . ' - ' . $item->mataKuliah->namamk . ' - ' . $item->mataKuliah->sks . ' SKS';
            })->join('<br>');

            $data[] = [
                'no' => $haveProdiIndex[$bidangPekerjaan->bidangPekerjaanIndustri->namabidangpekerjaan] ?? $index,
                'bidang' => $bidangPekerjaan->bidangPekerjaanIndustri->namabidangpekerjaan,
                'prodi' => $prodi,
                'matkul' => $matkul,
                'bobot' => $bidangPekerjaan->bobot,
                'status' => $bidangPekerjaan->bidangPekerjaanIndustri->status,
                'id' => $bidangPekerjaan->id_bidang_pekerjaan_industri,
            ];
        }

        return DataTables::of($data)
            ->addColumn('no', fn($row) => $row['no'])
            ->editColumn('status', function ($row) {
                if ($row['status'] == 1) {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-primary'>Active</div></div>";
                } else {
                    return "<div class='text-center'><div class='badge rounded-pill bg-label-danger'>Inactive</div></div>";
                }
            })
            ->addColumn('action', function ($row) {
                $icon = ($row['status']) ? "ti-circle-x" : "ti-circle-check";
                $color = ($row['status']) ? "danger" : "primary";

                $url = route('bidangpekerjaan.status', $row['id']);
                return "
                    <div class='d-flex align-items-center justify-content-center'>
                        <a data-bs-toggle='modal' data-id='{$row['id']}' onclick=edit($(this)) class='mx-1 cursor-pointer text-warning'><i class='tf-icons ti ti-edit' ></i>
                        <a data-bs-toggle='modal' data-id='{$row['id']}' onclick=editMappingMk($(this)) class='mx-1 cursor-pointer text-warning'><i class='tf-icons ti ti-settings'></i>
                        <a data-url='{$url}' data-function='afterUpdateStatus' class='cursor-pointer mx-1 update-status text-{$color}'><i class='tf-icons ti {$icon}'></i></a></div>'
                    </div>
                ";
            })
            ->rawColumns(['action', 'matkul', 'status'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $id)->first();
        if (!$bidangPekerjaanIndustri) return Response::error(null, 'Not Found', 404);

        return Response::success($bidangPekerjaanIndustri, 'Success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BidangPekerjaanIndustriRequest $request, string $id)
    {
        try {
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $id)->first();
            if (!$bidangPekerjaanIndustri) return Response::error(null, 'Bidang Pekerjaan not found!');

            $bidangPekerjaanIndustri->namabidangpekerjaan = $request->namabidangpekerjaan;
            $bidangPekerjaanIndustri->deskripsi = $request->deskripsi;
            $bidangPekerjaanIndustri->update();

            return Response::success(null, 'Bidang Pekerjaan berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function status(string $id)
    {
        try {
            $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_bidang_pekerjaan_industri', $id)->first();
            $bidangPekerjaanIndustri->status = !$bidangPekerjaanIndustri->status;
            $bidangPekerjaanIndustri->save();

            return Response::success(null, 'Status Bidang Pekerjaan berhasil diupdate!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function editMappingMk(string $id)
    {
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::findOrFail($id);

        $bidangPekerjaanIndustri->prodi = ProgramStudi::whereHas('mataKuliah', function ($query) use ($bidangPekerjaanIndustri) {
            $query->whereHas('bidangPekerjaanMkItems', function ($q) use ($bidangPekerjaanIndustri) {
                $q->whereHas('bidangPekerjaanMk', function ($qq) use ($bidangPekerjaanIndustri) {
                    $qq->where('id_bidang_pekerjaan_industri', $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri);
                });
            });
        })
            ->orderBy('namaprodi', 'asc')
            ->get()
            ->map(function ($prodi) use ($bidangPekerjaanIndustri) {
                $prodi->mk_terkait = BidangPekerjaanMkItem::whereHas('mataKuliah', function ($query) use ($prodi) {
                    $query->where('id_prodi', $prodi->id_prodi);
                })
                    ->whereHas('bidangPekerjaanMk', function ($query) use ($bidangPekerjaanIndustri) {
                        $query->where('id_bidang_pekerjaan_industri', $bidangPekerjaanIndustri->id_bidang_pekerjaan_industri);
                    })
                    ->with(['mataKuliah', 'bidangPekerjaanMk'])
                    ->get()
                    ->map(function ($item) use ($bidangPekerjaanIndustri) {
                        return [
                            'id_bidang_pekerjaan_mk' => $item->bidangPekerjaanMk->id_bidang_pekerjaan_mk,
                            'bobot' => $item->bidangPekerjaanMk->bobot,
                            'id_mk' => $item->id_mk,
                        ];
                    });


                $prodi->mk_terkait = $prodi->mk_terkait->groupBy('id_bidang_pekerjaan_mk')->map(function ($group) {
                    return [
                        'id_bidang_pekerjaan_mk' => $group->first()['id_bidang_pekerjaan_mk'],
                        'bobot' => $group->first()['bobot'],
                        'id_mk' => $group->pluck('id_mk')->flatten()->unique()->toArray(),
                    ];
                })->values();

                return $prodi;
            });

        return response()->json([
            'bidangPekerjaanIndustri' => $bidangPekerjaanIndustri
        ]);
    }

    public function updateMappingMk(BidangPekerjaanMkRequest $request, string $id_bidang_pekerjaan_industri)
    {
        DB::transaction(function () use ($request, $id_bidang_pekerjaan_industri) {
            $dataProdi = $request->input('prodi', []);

            $existingBidangPekerjaanMK = BidangPekerjaanMK::with('mkItems')
                ->where('id_bidang_pekerjaan_industri', $id_bidang_pekerjaan_industri)
                ->get();

            $requestedMKData = collect($dataProdi)
                ->flatMap(function ($prodi) {
                    return collect($prodi['matakuliah'])->map(function ($mk) use ($prodi) {
                        return [
                            'id_prodi' => $prodi['id_prodi'],
                            'bobot' => $mk['bobot'],
                            'id_mk' => $mk['id_mk'],
                            'id_bidang_pekerjaan_mk' => $mk['id_bidang_pekerjaan_mk'] ?? null,
                        ];
                    });
                });

            $existingMKItems = $existingBidangPekerjaanMK->flatMap->mkItems;
            $existingMKIds = $existingMKItems->pluck('id_mk')->all();

            $requestedMKIds = $requestedMKData->flatMap(function ($mkData) {
                return $mkData['id_mk'];
            })->unique()->all();

            $mkToDelete = array_diff($existingMKIds, $requestedMKIds);
            if (!empty($mkToDelete)) {
                BidangPekerjaanMkItem::whereIn('id_mk', $mkToDelete)
                    ->whereIn('id_bidang_pekerjaan_mk', $existingBidangPekerjaanMK->pluck('id_bidang_pekerjaan_mk'))
                    ->delete();
            }

            foreach ($requestedMKData as $mkData) {
                if ($mkData['id_bidang_pekerjaan_mk']) {
                    $bidangPekerjaanMK = BidangPekerjaanMK::find($mkData['id_bidang_pekerjaan_mk']);
                    if ($bidangPekerjaanMK) {
                        $bidangPekerjaanMK->update(['bobot' => $mkData['bobot']]);

                        $existingItems = $bidangPekerjaanMK->mkItems->pluck('id_mk')->all();
                        $itemsToAdd = array_diff($mkData['id_mk'], $existingItems);
                        $itemsToRemove = array_diff($existingItems, $mkData['id_mk']);

                        if (!empty($itemsToRemove)) {
                            BidangPekerjaanMkItem::where('id_bidang_pekerjaan_mk', $bidangPekerjaanMK->id_bidang_pekerjaan_mk)
                                ->whereIn('id_mk', $itemsToRemove)
                                ->delete();
                        }

                        foreach ($itemsToAdd as $id_mk) {
                            BidangPekerjaanMkItem::create([
                                'id_bidang_pekerjaan_mk' => $bidangPekerjaanMK->id_bidang_pekerjaan_mk,
                                'id_mk' => $id_mk,
                            ]);
                        }
                    }
                } else {
                    $newBidangPekerjaanMK = BidangPekerjaanMK::create([
                        'bobot' => $mkData['bobot'],
                        'id_bidang_pekerjaan_industri' => $id_bidang_pekerjaan_industri,
                        'id_prodi' => $mkData['id_prodi']
                    ]);

                    foreach ($mkData['id_mk'] as $id_mk) {
                        BidangPekerjaanMkItem::create([
                            'id_bidang_pekerjaan_mk' => $newBidangPekerjaanMK->id_bidang_pekerjaan_mk,
                            'id_mk' => $id_mk,
                        ]);
                    }
                }
            }

            $bidangPekerjaanMkIdsWithItems = BidangPekerjaanMkItem::pluck('id_bidang_pekerjaan_mk');
            $emptyBidangPekerjaanMK = $existingBidangPekerjaanMK->whereNotIn('id_bidang_pekerjaan_mk', $bidangPekerjaanMkIdsWithItems);

            if ($emptyBidangPekerjaanMK->isNotEmpty()) {
                BidangPekerjaanMK::whereIn('id_bidang_pekerjaan_mk', $emptyBidangPekerjaanMK->pluck('id_bidang_pekerjaan_mk'))->delete();
            }
        });

        return Response::success(null, "Mapping data MK berhasil!");
    }
}
