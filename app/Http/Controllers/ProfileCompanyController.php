<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Industri;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileCompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:profile_perusahaan.view', ['only' => ['index']]);
        $this->middleware('permission:profile_perusahaan.update', ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $penanggungJawab = $user->pegawai_industri;
        $industri = $penanggungJawab->industri;

        return view('company.summary_profile.index', compact('industri', 'penanggungJawab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $industri = Industri::where('id_industri', $id)->first();
        $industri->image = ($industri->image != null) ? asset('storage/' . $industri->image) : asset('app-assets/img/avatars/building.png');
        return $industri;
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'remove_image' => 'nullable|in:1',
            'namaindustri' => 'required',
            'alamatindustri' => 'required',
            'description' => 'required',
            'notelpon' => 'required',
            'email' => 'required|email|unique:industri,email,' . $id . ',id_industri',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ], [
            'namaindustri.required' => 'Nama Industri wajib diisi.',
            'alamatindustri.required' => 'Alamat Industri wajib diisi.',
            'description.required' => 'Deskripsi Industri wajib diisi.',
            'notelpon.required' => 'No telp Industri wajib diisi.',
            'email.required' => 'Email Industri wajib diisi.',
            'email.email' => 'Email Industri tidak valid.',
            'email.unique' => 'Email Industri sudah digunakan.',
            'image.file' => 'File harus berupa gambar.',
            'image.mimes' => 'File harus berupa jpg, png atau jpeg.',
        ]);

        try {
            $industri = Industri::where('id_industri', $id)->first();
            
            $industri->namaindustri = $request->namaindustri;
            $industri->alamatindustri = $request->alamatindustri;
            $industri->description = $request->description;
            $industri->notelpon = $request->notelpon;
            $industri->email = $request->email;

            $file = $industri->image ?? null;
            if ($request->hasFile('image')) {
                if ($file != null && Storage::has($file)) {
                    Storage::delete($file);
                }
                $file = Storage::put('photo_industri', $request->image);
            }
            $industri->image = $file;

            if ($request->remove_image == 1) {
                if (isset($industri->image)) {
                    Storage::delete($industri->image);
                }
                $industri->image = null;
            }
            
            $industri->save();
            $penanggungJawab = $industri->penanggungJawab;

            return Response::success([
                'view' => view('company/summary_profile/components/card_detail', compact('industri', 'penanggungJawab'))->render(),
                'image' => ($industri->image != null) ? url('storage/' . $industri->image) : null
            ], 'Data Successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }
}