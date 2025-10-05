<?php

namespace App\Http\Controllers;

use App\Libraries\ExperienceExtractor;
use App\Libraries\SertificateExtractor;
use App\Models\Experience;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;

class ExperienceController extends Controller
{
    protected $sertifextractor;
    protected $extractor;

    public function __construct(SertificateExtractor $sertifextractor, ExperienceExtractor $extractor) {
        $this->sertifextractor = $sertifextractor;
        $this->extractor =  $extractor;
    }
    public function uploadCV(Request $request){
        // Validasi file upload
        $validator = Validator::make($request->all(), [
            'cv_file' => 'required|mimes:pdf|max:2048',
        ], [
            'cv_file.required' => 'File PDF wajib diunggah. Silakan pilih file sebelum melanjutkan.',
            'cv_file.mimes' => 'File harus dalam format PDF. Format file lain tidak diizinkan.',
            'cv_file.max' => 'Ukuran file PDF tidak boleh lebih dari 2MB. Silakan unggah file yang lebih kecil.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('showModal', true);
        }

        // Jika validasi berhasil, simpan file
        $file = $request->file('cv_file');
        $fileName = time() . '-' . $file->getClientOriginalName();
        // dd($fileName);
        $file->move(public_path('uploads'), $fileName);

        session(['uploaded_cv' => $fileName]);
        // Setelah upload berhasil, tampilkan modal validasi
        return back()->with('showValidationModal', true);
    }

    public function validateCV(Request $request) {
        // Ambil nama file dari sesi
        $fileName = session('uploaded_cv');
        if (!$fileName) {
            return back()->withErrors(['cv_file' => 'File CV tidak ditemukan. Silakan unggah ulang.']);
        }
        $filePath = public_path('uploads/' . $fileName);
        if (!file_exists($filePath)) {
            return back()->withErrors(['cv_file' => 'File CV tidak ditemukan di server.']);
        }

        $this->extractCV($request);
        return redirect()->route('profile')->with('success', 'File CV berhasil dikirim ke sistem rekomendasi pekerjaan.');

        // try {
        //     $client = new Client();
        //     $response = $client->request('POST', 'http://127.0.0.1:5000/predict-job-category', [
        //         'multipart' => [
        //             [
        //                 'name'     => 'file',
        //                 'contents' => fopen($filePath, 'r'),
        //                 'filename' => $fileName
        //             ]
        //         ]
        //     ]);

        //     // Periksa respons dari API
        //     if ($response->getStatusCode() === 200) {
        //         $responseData = json_decode($response->getBody(), true);

        //         // Ambil hasil rekomendasi pekerjaan dari respons API
        //         $jobCategory = $responseData['predicted_category'] ?? 'Tidak ada rekomendasi';

        //         // Simpan ke kolom headliner di database
        //         $mahasiswa = auth()->user()->mahasiswa; // Ambil data mahasiswa yang sedang login
        //         $mahasiswa->headliner = $jobCategory;
        //         $mahasiswa->save();

        //         // Lakukan ektsraksi cv
        //         $this->extractCV($request);
        //         return redirect()->route('profile')->with('success', 'File CV berhasil dikirim ke sistem rekomendasi pekerjaan.');
        //     } else {
        //         return back()->withErrors(['api_error' => 'Gagal mengirim file ke sistem rekomendasi. Silakan coba lagi.']);
        //     }
        // } catch (Exception $e) {
        //     return back()->withErrors(['api_error' => 'Terjadi kesalahan saat menghubungi sistem rekomendasi: ' . $e->getMessage()]);
        // }
    }

    public function extractCV (Request $request){
        // Ambil nama file dari sesi
        $fileName = session('uploaded_cv');
        // dd($fileName);
        if (!$fileName) {
            return back()->withErrors(['cv_file' => 'File CV tidak ditemukan. Silakan unggah ulang.']);
        }
        $filePath = public_path('uploads/' . $fileName);
        // Inisialisasi array untuk menampung error
        $errors = [];
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();
            // dd($text);

            // menggunakan library experienceextractor untuk menampung method ektraksi.
            $extractor = new ExperienceExtractor();
            // dd($extractor);
            // Eksekusi extractWorkExperience.
            $extractor->extractWorkExperience($text, $errors);
            // Eksekusi extractProjects
            $extractor->extractProjects($text, $errors);
            // Eksekusi extractCompetitions.
            $extractor->extractCompetition($text, $errors);
            // menggunakan library sertifikat extractor untuk menampung method ektraksi.
            $sertifectractor = new SertificateExtractor;
            // Eksekusi extractSertifikasi
            $sertifectractor->extractSertifikat($text, $errors);
            // Jika ada error, tampilkan di view
            if (!empty($errors)) {
                return redirect()->back()
                ->withErrors($errors);
            }
            // Jika berhasil
            // Hapus file dari sesi setelah berhasil dikirim
            session()->forget('uploaded_cv');
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'PDF parsing failed: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
