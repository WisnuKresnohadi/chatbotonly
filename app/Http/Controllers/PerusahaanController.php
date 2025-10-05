<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\BidangPekerjaanMkRequest;
use App\Models\BidangPekerjaanIndustri;
use App\Models\BidangPekerjaanMk;
use App\Models\BidangPekerjaanMkItem;
use App\Models\Fakultas;
use App\Models\Industri;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PerusahaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:perusahaan.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('masters.perusahaan.index');
    }

    public function show()
    {
        $data = Industri::leftJoin('bidang_pekerjaan_industri', 'industri.id_industri', '=', 'bidang_pekerjaan_industri.id_industri')
            ->leftJoin('bidang_pekerjaan_mk', 'bidang_pekerjaan_industri.id_bidang_pekerjaan_industri', '=', 'bidang_pekerjaan_mk.id_bidang_pekerjaan_industri')
            ->select(
                'industri.namaindustri',
                'industri.id_industri',
                DB::raw('COUNT(DISTINCT bidang_pekerjaan_industri.id_bidang_pekerjaan_industri) as jumlah_bidang_pekerjaan'),
                DB::raw('SUM(CASE WHEN bidang_pekerjaan_industri.id_bidang_pekerjaan_industri IS NOT NULL AND bidang_pekerjaan_mk.id_bidang_pekerjaan_industri IS NULL THEN 1 ELSE 0 END) as unmapped_bidang_count')
            )
            ->groupBy('industri.id_industri', 'industri.namaindustri')
            ->get();


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('namaperusahaan', function ($row) {
                // $url = route('perusahaan.bidangpekerjaanperusahaan', ['id' => $row->id_industri]);
                $result = '
                        <div class="description" style="width:250px; overflow:hidden;">  
                            <span class="short-desc">' . $row->namaindustri . '</span>                                                          
                        </div>'
                        ;
                return $result;
            })
            ->addColumn('jumlah_bidang_pekerjaan', function ($row) {
                return "{$row->jumlah_bidang_pekerjaan} Bidang Pekerjaan";
            })
            ->addColumn('informasi', function ($row) {
                if ($row->unmapped_bidang_count > 0) {
                    return "<span style='color: #4EA971;'>+{$row->unmapped_bidang_count} Bidang Pekerjaan Baru</span>";
                } else {
                    return "Belum ada Bidang Pekerjaan Baru";
                }
            })
            ->addColumn('action', function ($row) {
                $url = route('perusahaan.bidangpekerjaanperusahaan', ['id' => $row->id_industri]);
                return '<a href="' . $url . '" class="text-primary"><i class="ti ti-file-invoice" data-bs-toggle="tooltip" title="Detail"></i></a>';
            })
            ->rawColumns(['namaperusahaan', 'jumlah_bidang_pekerjaan', 'informasi', 'action'])
            ->make(true);
    }

    public function bidangPekerjaanPerusahaan(string $id)
    {
        $id_fakultas = Fakultas::where('namafakultas', 'Fakultas Ilmu Terapan')->pluck('id_fakultas')->first();
        $prodi = ProgramStudi::where('id_fakultas', $id_fakultas)->get();
        $nama_perusahaan = Industri::where('id_industri', $id)->select('namaindustri')->first()->namaindustri;
        return view('masters.perusahaan.bidang_pekerjaan', compact('id', "prodi", "nama_perusahaan"));
    }

    public function showDetailBidangPekerjaanPerusahaan(string $id)
    {
        $bidangPekerjaanIndustri = BidangPekerjaanIndustri::where('id_industri', $id)->get();

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
                    'id' => $bidangPekerjaan->id_bidang_pekerjaan_industri,
                ];
            }
        }

        $bidangPekerjaanMk = BidangPekerjaanMk::with(['bidangPekerjaanIndustri', 'mkItems.mataKuliah.prodi'])
            ->whereHas('bidangPekerjaanIndustri', function ($query) use ($id) {
                $query->where('id_industri', $id);
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
                'id' => $bidangPekerjaan->id_bidang_pekerjaan_industri,
            ];
        }

        return DataTables::of($data)
            ->addColumn('no', fn($row) => $row['no'])
            ->addColumn('action', fn($row) => "<a data-bs-toggle='modal' data-id='{$row['id']}' onclick=edit($(this)) class='mx-1 cursor-pointer text-warning'><i class='tf-icons ti ti-settings'></i>")
            ->rawColumns(['action', 'matkul'])
            ->make(true);
    }


    public function edit(string $id)
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

    public function update(BidangPekerjaanMkRequest $request, string $id_bidang_pekerjaan_industri)
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
