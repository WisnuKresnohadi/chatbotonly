<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sertif;
use App\Helpers\Response;
use App\Models\Education;
use App\Models\Mahasiswa;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\SosmedTambahan;
use Illuminate\Support\Carbon;
use App\Models\BahasaMahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DokumenRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\InformasiKeahlianReq;
use App\Http\Requests\InformasiTambahanReq;
use App\Http\Requests\InformasiPendidikanReq;
use App\Http\Requests\InformasiPengalamanReq;

class ProfileMahasiswaController extends Controller
{
    public function __construct() {

    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->getFullDataProfile();
        $data['jobCategory'] = $data['mahasiswa']->headliner ?? 'Belum ada rekomendasi';
        return view('profile.informasi_pribadi', $data);
    }

    public function getDataProfile(Request $request) {
        $user = auth()->user();

        switch ($request->section) {
            case 'modalEditInformasi':
                $data = self::getDataProfileDetail($user);
                $data->profile_picture = ($data->profile_picture != null) ? asset('storage/' . $data->profile_picture) : asset('app-assets/img/avatars/user.png');
                break;
            case 'modalEditInformasiTambahan':
                $data = self::getDataInfoTambahan($user->mahasiswa);
                break;
            case 'modalTambahPendidikan':
                $data = self::getDataPendidikan($user->mahasiswa->nim, $request->data_id);
                break;
            case 'modalTambahKeahlian':
                $data = Mahasiswa::select('skills')->where('nim', $user->mahasiswa->nim)->first();
                $data = json_decode($data);
                break;
            case 'modalTambahDokumen':
                $data = self::getDataDokumen($user->mahasiswa->nim, $request->data_id);
                break;
            case 'modalTambahPengalaman':
            case 'modalTambahProyek':
            case 'modalTambahKompetisi':
                $data = self::getDataExperience($user->mahasiswa->nim, $request->data_id);
                break;



            default:
                return Response::error(null, 'Not Found');
        }

        if (!$data) return Response::error(null, 'Not Found');
        return Response::success($data, 'Success get detail profile.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if($request->citizenships != null){
            $domisili = [
                'attr' => 'required',
                'message' => 'Silahkan lengkapi domisili.'
            ];
        }else{
            $domisili = [
                'attr' => 'nullable',
                'message' => ''
            ];
        }

        $request->validate([
            'tgl_lahir' => 'required|before:today',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'headliner' => 'required',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
            'deskripsi_diri' => 'required',
            'kota_id' => $domisili['attr'],
            'kodepos' => $domisili['attr'],
            'alamatmhs' => 'required|string|max:255',
            'tesbahasa' => 'required|numeric|integer',
            'tak' => 'required|numeric|integer',
        ], [
            'tgl_lahir.required' => 'Tanggal lahir wajib di isi.',
            'tgl_lahir.before' => 'Tidak boleh melebihi tanggal hari ini.',
            'gender.required' =>  'Pilih jenis kelamin terlebih dahulu.',
            'gender.in' => 'Jenis kelamin tidak valid',
            'headliner.required' => 'Headliner wajib diisi.',
            'image.mimes' => 'File harus berupa JPG, PNG atau JPEG.',
            'image.max' => 'File tidak boleh lebih dari 2 MB.',
            'deskripsi_diri.required' => 'Deskripsi wajib diisi.',
            'kota_id.required' => $domisili['message'],
            'kodepos.required' => $domisili['message'],
            'alamatmhs.required' => 'Alamat wajib diisi.',
            'tesbahasa.required' => 'Eprt wajib diisi.',
            'tak.required' => 'Tak wajib diisi.',
            'tesbahasa.numeric' => 'Eprt harus berupa angka.',
            'tak.numeric' => 'Tak harus berupa angka.',
            'tesbahasa.integer' => 'Eprt harus berupa bilangan bulat.',
            'tak.integer' => 'Tak harus berupa bilangan bulat.',
        ]);

        try {
            $user = auth()->user();

            $mahasiswa = Mahasiswa::where('id_user', $user->id)->first();
            if (!$mahasiswa) return Response::error(null, 'Mahasiswa not found', 404);

            $profile_picture = $mahasiswa->profile_picture ?? null;
            if ($request->hasFile('image')) {
                if ($profile_picture != null &&  Storage::has($profile_picture)) {
                    Storage::delete($profile_picture);
                }
                $profile_picture = Storage::put('profile_picture_mahasiswa', $request->file('image'));
            }

            $mahasiswa->tgl_lahir = $request->tgl_lahir;
            $mahasiswa->headliner = $request->headliner;
            $mahasiswa->deskripsi_diri = $request->deskripsi_diri;
            $mahasiswa->gender = $request->gender;
            $mahasiswa->kota_id = $request->kota_id;
            $mahasiswa->kodepos = $request->kodepos;
            $mahasiswa->alamatmhs = $request->alamatmhs;
            $mahasiswa->tesbahasa = $request->tesbahasa;
            $mahasiswa->tipetesbahasa = "EPRT";
            $mahasiswa->tak = $request->tak;

            $mahasiswa->profile_picture = $profile_picture;

            if ($request->remove_image == 1) {
                if (isset($mahasiswa->profile_picture)) {
                    Storage::delete($mahasiswa->profile_picture);
                }
                $mahasiswa->profile_picture = null;
            }

            $mahasiswa->save();

            $mahasiswa = $mahasiswa->load('univ', 'fakultas', 'prodi');

            return Response::success([
                'view' => view('profile/components/informasi_pribadi_detail', compact('mahasiswa'))->render()
            ], 'Informasi pribadi successfully updated.');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateInfoTambahan(InformasiTambahanReq $request) {
        try {
            DB::beginTransaction();
            $mahasiswa = auth()->user()->mahasiswa;

            $mahasiswa->lokasi_yg_diharapkan = $request->lokasi_yg_diharapkan;
            $mahasiswa->bahasamhs()->delete();
            foreach ($request->bahasa as $key => $value) {
                BahasaMahasiswa::create([
                    'nim' => $mahasiswa->nim,
                    'bahasa' => $value,
                ]);
            }

            $mahasiswa->sosmedmhs()->delete();
            foreach ($request->sosmedmhs_ as $key => $value) {
                SosmedTambahan::create([
                    'nim' => $mahasiswa->nim,
                    'namaSosmed' => $value['namaSosmed'],
                    'urlSosmed' => $value['urlSosmed'],
                ]);
            }
            $mahasiswa->save();

            $sosmed = $mahasiswa->sosmedmhs;
            $bahasa = $mahasiswa->bahasamhs;
            DB::commit();
            return Response::success([
                'view' => view('profile/components/detail_info_tambahan', compact('mahasiswa', 'sosmed', 'bahasa'))->render()
            ], 'Data Successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updatePendidikan(InformasiPendidikanReq $request) {
        try{
            $mahasiswa = auth()->user()->mahasiswa;
            $pendidikan = Education::where('nim', $mahasiswa->nim)->where('id_education', $request->data_id)->first();

            $data = [
                'name_intitutions' => $request->name_intitutions,
                'tingkat' => $request->tingkat,
                'startdate'=> Carbon::createFromFormat('F Y', $request->startdate)->format('Y-m') . '-01',
                'enddate' => Carbon::createFromFormat('F Y', $request->enddate)->format('Y-m') . '-01',
                'nilai' => $request->nilai,
            ];

            if ($pendidikan) {
                $pendidikan->update($data);
            } else {
                $data['nim'] = $mahasiswa->nim;
                Education::create($data);
            }

            $pendidikan = $mahasiswa->education;
            return Response::success([
                'view' => view('profile/components/timeline_pendidikan', compact('pendidikan'))->render()
            ], 'Data Successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function deletePendidikan($id) {
        try {
            $mahasiswa = auth()->user()->mahasiswa;
            $education = Education::where('nim', $mahasiswa->nim)->where('id_education', $id)->first();
            if (!$education) return Response::error(null, 'Education not found', 404);
            $education->delete();

            $pendidikan = $mahasiswa->education;
            return Response::success([
                'view' => view('profile/components/timeline_pendidikan', compact('pendidikan'))->render()
            ], 'Data Successfully Deleted!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateKeahlian(InformasiKeahlianReq $request) {
        try{
            $mahasiswa = auth()->user()->mahasiswa;
            $mahasiswa->skills = json_encode($request->skills);
            $mahasiswa->save();

            $skills = $request->skills;
            return Response::success([
                'view' => view('profile/components/badge_skills', compact('skills'))->render()
            ], 'Data Successfully Updated!');
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateExperience(InformasiPengalamanReq $request) {
        try {
            $mahasiswa = auth()->user()->mahasiswa;
            $experience = Experience::where('nim', $mahasiswa->nim)->where('id_experience', $request->data_id)->first();

            $data = [
                'posisi' => $request->posisi,
                'jenis' => $request->jenis,
                'name_intitutions' => $request->name_intitutions,
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'prestasi' => $request->prestasi,
                'startdate'=> Carbon::createFromFormat('F Y', $request->startdate)->format('Y-m') . '-01',
                'enddate' => Carbon::createFromFormat('F Y', $request->enddate)->format('Y-m') . '-01',
                'deskripsi' => $request->deskripsi,
            ];

            if ($experience) {
                $experience->update($data);
            } else {
                $data['nim'] = $mahasiswa->nim;
                Experience::create($data);
            }

            $view = 'profile/components/timeline_pengalaman';
            $experienceType = 'profesional';

            if ($data['kategori'] === 'project') {
                $view = 'profile/components/timeline_pengalaman_proyek';
                $experienceType = 'project';
            } elseif ($data['kategori'] === 'competition') {
                $view = 'profile/components/timeline_kompetisi';
                $experienceType = 'competition';
            }

            $$experienceType = $mahasiswa->{$experienceType};

            return Response::success([
                'view' => view($view, compact("$experienceType"))->render()
            ], 'Data Successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function deleteExperience($id) {
        try {
            $mahasiswa = auth()->user()->mahasiswa;
            $experience = Experience::where('nim', $mahasiswa->nim)->where('id_experience', $id)->first();
            if (!$experience) return Response::error(null, 'Experience not found', 404);

            $view = 'profile/components/timeline_pengalaman';
            $experienceType = 'profesional';

            if ($experience['kategori'] === 'project') {
                $view = 'profile/components/timeline_pengalaman_proyek';
                $experienceType = 'project';
            } elseif ($experience['kategori'] === 'competition') {
                $view = 'profile/components/timeline_kompetisi';
                $experienceType = 'competition';
            }

            $experience->delete();

            $$experienceType = $mahasiswa->{$experienceType};

            return Response::success([
                'view' => view($view, compact("$experienceType"))->render()
            ], 'Data Successfully Deleted!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function updateDokumenPendukung(DokumenRequest $request) {
        try {
            $mahasiswa = auth()->user()->mahasiswa;
            $sertifikat = Sertif::where('nim', $mahasiswa->nim)->where('id_sertif', $request->data_id)->first();

            $file = null;
            if ($request->hasFile('file_sertif')) {
                $file = Storage::put('sertifikat', $request->file('file_sertif'));
            }

            $data = [
                'nama_sertif' => $request->nama_sertif,
                'penerbit' => $request->penerbit,
                'startdate'=> Carbon::createFromFormat('F Y', $request->startdate)->format('Y-m') . '-01',
                'enddate' => ($request->enddate) ? (Carbon::createFromFormat('F Y', $request->enddate)->format('Y-m') . '-01') : null,
                'file_sertif' => $file,
                'link_sertif' => $request->link_sertif,
                'deskripsi' => $request->deskripsi
            ];

            if ($sertifikat) {
                if ($file != null) Storage::delete($sertifikat->file_sertif);
                else $data['file_sertif'] = $sertifikat->file_sertif;

                $sertifikat->update($data);
            } else {
                $data['nim'] = $mahasiswa->nim;
                Sertif::create($data);
            }

            $dokumenPendukung = $mahasiswa->sertifikat;
            return Response::success([
                'view' => view('profile/components/card_dokumen_pendukung', compact('dokumenPendukung'))->render()
            ], 'Data Successfully Updated!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function deleteDokumen($id) {
        try {
            $mahasiswa = auth()->user()->mahasiswa;
            $sertifikat = Sertif::where('nim', $mahasiswa->nim)->where('id_sertif', $id)->first();
            if (!$sertifikat) return Response::error(null, 'Sertifikat not found', 404);
            Storage::delete($sertifikat->file_sertif);
            $sertifikat->delete();

            $dokumenPendukung = $mahasiswa->sertifikat;
            return Response::success([
                'view' => view('profile/components/card_dokumen_pendukung', compact('dokumenPendukung'))->render()
            ], 'Data Successfully Deleted!');
        } catch (\Exception $e) {
            return Response::errorCatch($e);
        }
    }

    private static function getDataProfileDetail($user) {

        $mahasiswa = Mahasiswa::join('universitas', 'universitas.id_univ', '=', 'mahasiswa.id_univ')
        ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
        ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
        ->leftJoin('reg_regencies', 'reg_regencies.id', '=', 'mahasiswa.kota_id')
        ->leftJoin('reg_provinces', 'reg_provinces.id', '=', 'reg_regencies.province_id')
        ->leftJoin('reg_countries', 'reg_countries.id', '=', 'reg_provinces.country_id')
        ->select('mahasiswa.*', 'universitas.namauniv', 'fakultas.namafakultas', 'program_studi.namaprodi', 'reg_regencies.id as cities', 'reg_provinces.id as provinces', 'reg_countries.id as countries')
        ->where('id_user', $user->id)->first();

        return $mahasiswa;
    }

    private static function getDataInfoTambahan($mahasiswa) {
        $mahasiswa->bahasa = json_encode($mahasiswa->bahasamhs->pluck('bahasa')->toArray());
        $mahasiswa->sosmedmhs_ = json_encode($mahasiswa->sosmedmhs->select('namaSosmed', 'urlSosmed')->toArray());
        unset($mahasiswa->bahasamhs);
        unset($mahasiswa->sosmedmhs);
        return $mahasiswa;
    }

    private static function getDataPendidikan($nim, $id) {
        $education = Education::where('nim', $nim)->where('id_education', $id)->first();
        $education->startdate = Carbon::parse($education->startdate)->format('F Y');
        $education->enddate = Carbon::parse($education->enddate)->format('F Y');
        return $education;
    }

    private static function getDataExperience($nim, $id) {
        $experience = Experience::where('nim', $nim)->where('id_experience', $id)->first();
        $experience->startdate = Carbon::parse($experience->startdate)->format('F Y');
        $experience->enddate = Carbon::parse($experience->enddate)->format('F Y');
        return $experience;
    }

    private static function getDataDokumen($nim, $id) {
        $sertifikat = Sertif::where('nim', $nim)->where('id_sertif', $id)->first();
        $sertifikat->startdate = Carbon::parse($sertifikat->startdate)->format('F Y');
        $sertifikat->enddate = Carbon::parse($sertifikat->enddate)->format('F Y');
        return $sertifikat;
    }

    // fungsi untuk menampilkan cv pada halaman unduh-profile/{nim}
    public static function showCV(){
        $user = auth()->user();
        $nim = $user->mahasiswa->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        $dataProfile = self::getDataProfileDetail($mahasiswa);
        $dataInfoTambahan = self::getDataInfoTambahan($mahasiswa);

        $pendidikan = Education::where('nim', $nim)->orderBy('startdate', 'asc')->get();
        $experience = Experience::where('nim', $nim)->orderBy('startdate', 'asc')->get();
        $dokumenPendukung = Sertif::where('nim', $nim)->orderBy('startdate', 'asc')->get();

        // // Check apakah seluruh data yang dibutuhkan pada halaman profil mahasiswa telah diisi
        // $isDataComplete = !empty($dataProfile) && !empty($dataInfoTambahan) && $pendidikan->isNotEmpty() && $experience->isNotEmpty() && $dokumenPendukung->isNotEmpty();

        $data = [
            'dataProfile' => $dataProfile,
            'dataInfoTambahan' => $dataInfoTambahan,
            'pendidikan' => $pendidikan,
            'experience' => $experience,
            'dokumenPendukung' => $dokumenPendukung,
            'nim' => $nim,
            // 'isDataComplete' => $isDataComplete
        ];

        return view('mahasiswa.cv', $data);
    }

    public static function getFullDataProfile($id = null){
        if($id){
            $mahasiswa = Mahasiswa::where('id_user', $id)->first();
        }else{
            $user = auth()->user();
            $mahasiswa = $user->mahasiswa->load('univ', 'fakultas', 'prodi', 'dosen_wali');
        }
        $data['mahasiswa'] = $mahasiswa;
        $data['skills'] = json_decode($mahasiswa->skills, true) ?? [];
        $data['pendidikan'] = Education::where('nim', $mahasiswa->nim)->orderBy('startdate', 'desc')->get();
        $data['profesional'] = Experience::where('nim', $mahasiswa->nim)
            ->where('kategori', 'profesional')
            ->orderBy('startdate', 'desc')
            ->get();
        $data['project'] = Experience::where('nim', $mahasiswa->nim)
            ->where('kategori', 'project')
            ->orderBy('startdate', 'desc')
            ->get();
        $data['competition'] = Experience::where('nim', $mahasiswa->nim)
            ->where('kategori', 'competition')
            ->orderBy('startdate', 'desc')
            ->get();

        $data['sosmed'] = SosmedTambahan::where('nim', $mahasiswa->nim)->orderBy('namaSosmed', 'asc')->get();
        $data['bahasa'] = BahasaMahasiswa::where('nim', $mahasiswa->nim)->orderBy('bahasa', 'asc')->get();
        $data['dokumenPendukung'] = Sertif::where('nim', $mahasiswa->nim)->orderBy('startdate', 'desc')->get();
        $data['percentageData'] = self::countPercentage($data);

        return $data;
    }

    public static function countPercentage($data){
        $totalData = 0;
        $totalEmptyData = 0;
        $excludedColumns = ['tipetesbahasa', 'created_at', 'updated_at'];
        foreach($data as $key => $value){
            if($key == 'mahasiswa'){
                foreach($value->toArray() as $k => $v){
                    if(!in_array($k, $excludedColumns)) {
                        if($v == null || $v == ''){
                            $totalEmptyData++;
                            $clue[] = $k;
                        }
                        $totalData++;
                    }
                }
            }else{
               if(is_array($value)){
                    if(count($value) == 0){
                        $totalEmptyData++;
                        $clue[] = $key;
                    }
                    $totalData++;
                }elseif(is_object($value)){
                    if($value->isEmpty()){
                        $totalEmptyData++;
                        $clue[] = $key;
                    }
                    $totalData++;
                }else{
                    if($value == null || $value == ''){
                        $totalEmptyData++;
                        $clue[] = $key;
                    }
                    $totalData++;
                }
            }
        }

        $data = new \stdClass();
        $data->percentage = floor(($totalData - $totalEmptyData) / $totalData * 100);
        $data->totalData = $totalData;
        $data->totalEmptyData = $totalEmptyData;
        $data->clue = implode(', ', $clue ?? []);
        return $data;
    }

    public function getPercentage(){
        $percentageData = $this->getFullDataProfile()['percentageData'];

        return Response::success(['view' => view('profile/components/percentage', compact('percentageData'))->render()], 'Success get percentage data.');

    }
}
