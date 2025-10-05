<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\MhsMagang;
use Illuminate\Http\Request;


class InputNilaiAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('kelola_mahasiswa.kelola_mahasiswa_akademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function input(Request $request)
    {
        try {
            foreach ($request->komponen as $d) {
                MhsMagang::create([
                    'id_jenismagang' => $request->id_jenismagang,
                    'aspek_penilaian' =>$d['aspek_penilaian'],
                    'deskripsi_penilaian' => $d['deskripsi_penilaian'],
                    'scored_by' => $d['scored_by'],
                    'nilai_max' => $d['nilai_max'],
                    'status' => true,

                ]);
                
                
            if( $d['scored_by'] == 1){
                $table = '#table-akademik';
            } else{
                $table = '#table-lapangan';   
            }
            }
        

            return response()->json([
                'error' => false,
                'message' => 'Komponen Nilai successfully Add!',
                'modal' => '#modal-komponen-nilai',
                'table' => $table
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        
    }


    
    public function show(Request $request)
    {
       
    }


    
    public function edit($id)
    {

    }

   
    public function update(Request $request, $id)
    {
        
    }
    

  
    public function status($id)
    {
        
    }
    
}