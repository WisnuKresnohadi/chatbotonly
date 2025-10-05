<?php

namespace App\Http\Controllers;
use Exception;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Requests\MasterEmailRequest;
use App\Enums\TemplateEmailListProsesEnum;

class MasterEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('company.master_email.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate(['proses' => ['required', 'in:' . implode(',', TemplateEmailListProsesEnum::getConstants())]]);

        $proses = TemplateEmailListProsesEnum::_getWithLabel($request->proses);
        $data['proses_selected'] = '<option value="'.$request->proses.'" selected disabled>'.$proses['title'].'</option>';
        $data['proses'] = $request->proses;
        $data['urlAction'] = route('template_email.store');
        $list_tag = TemplateEmailListProsesEnum::getListTag($request->proses);
        $data['list_tag'] = view('company/master_email/components/list_tag', compact('list_tag'))->render();

        $user = auth()->user();
        $id_industri = $user->pegawai_industri->id_industri;

        $data['existing'] = EmailTemplate::where('proses', $request->proses)->where('id_industri', $id_industri)->first();


        return view('company/master_email/form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterEmailRequest $request)
    {
        try {
            $user = auth()->user();
            $peg_industri = $user->pegawai_industri;

            $email = EmailTemplate::updateOrCreate(
            [
                'proses' => $request->proses,
                'id_industri' => $peg_industri->id_industri
            ], [
                'subject_email' => $request->subject_email,
                'headline_email' => TemplateEmailListProsesEnum::_getWithLabel($request->proses)['title'],
                'content_email' => $request->content_email,
            ]);

            return Response::success(null, 'Berhasil menyimpan template email.');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        $peg_industri = $user->pegawai_industri;

        $listProses = TemplateEmailListProsesEnum::getConstants();

        $email = EmailTemplate::where('id_industri', $peg_industri->id_industri)->get();

        $listProses = collect($listProses)->map(function ($item) use ($email, $peg_industri) {
            if ($email->where('proses', $item)->first()) {
                $email = $email->where('proses', $item)->first();
            } else {
                $email = new EmailTemplate();
                $email->proses = $item;
                $email->id_industri = $peg_industri->id_industri;
            }
            return $email;
        });

        return datatables()->of($listProses)
            ->addIndexColumn()
            ->editColumn('proses', function ($x) {
                return TemplateEmailListProsesEnum::_getWithLabel($x->proses)['title'];
            })
            ->editColumn('subject_email', function ($x) {
                return $x->subject_email ?? '<span class="fst-italic">- Not Yet Set -</span>';
            })
            ->addColumn('aksi', function ($x) {
                $result = '<div class="d-flex justify-content-center">';
                $result .= '<a class="cursor-pointer mx-1 text-warning" href="'.route('template_email.create', ['proses' => $x->proses]).'" data-bs-toggle="tooltip" title="edit"><i class="ti ti-edit"></i></a>';
                $result .= '</div>';
                return $result;
            })
            ->rawColumns(['proses', 'subject_email', 'aksi'])
            ->make(true);
    }
}