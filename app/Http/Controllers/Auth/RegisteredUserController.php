<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Industri;
use App\Helpers\Response;
use App\Jobs\SendMailJob;
use App\Mail\VerifyEmail;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PegawaiIndustri;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\WriteAndReadCounterBadgeJob;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $validate = ['roleregister' => 'required|in:dosen,user,mitra'];

            if ($request->roleregister == 'dosen') {
                $validate['nip'] = 'required|numeric|exists:dosen,nip';
            } else if ($request->roleregister == 'user') {
                $validate['nim'] = 'required|numeric|exists:mahasiswa,nim';
            } else if ($request->roleregister == 'mitra') {
                $validate['namaindustri'] = 'required';
                $validate['name'] = 'required';
                $validate['email'] = ['required','email','unique:users,email',function ($attribute, $value, $fail) {
                    $pegawaiIndustri = PegawaiIndustri::where('emailpeg', $value)->first();
                    if ($pegawaiIndustri) {
                        $industri = Industri::where('id_industri', $pegawaiIndustri->id_industri)->where('statusapprove', '!=', 2)->first();
                        if ($industri) {
                            $fail('Email sudah terdaftar');
                        }
                    }
                }];
                $validate['notelpon'] = 'required';
                $validate['kategori_industri'] = 'required|in:Internal,Eksternal';
                $validate['statuskerjasama'] = 'required|in:Iya,Tidak';
            }

            $validator = Validator::make($request->all(), $validate, [
                'roleregister.required' => 'Pilih role terlebih dahulu',
                'roleregister.in' => 'Role tidak valid',
                'name.required' => 'Nama harus diisi',
                'email.required' => 'Email harus diisi',
                'email.unique' => 'Email sudah terdaftar',
                'notelpon.required' => 'No. Telepon harus diisi',
                'statuskerjasama.required' => 'Status Kerjasama harus dipilih.',
                'statuskerjasama.in' => 'Status Kerjasama tidak valid.',
                'kategori_industri.required' => 'Kategori Industri harus dipilih.',
                'kategori_industri.in' => 'Kategori Industri tidak valid.',
                'namaindustri.required' => 'Nama harus diisi',
                'nim.required' => 'NIM harus di isi',
                'nim.numeric' => 'NIM harus angka',
                'nim.exists' => 'NIM tidak ditemukan, hubungi LKM untuk info lebih lanjut',
                'nip.required' => 'NIP harus di isi',
                'nip.numeric' => 'NIP harus angka',
                'nip.exists' => 'NIP tidak ditemukan, hubungi LKM untuk info lebih lanjut',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            if ($request->roleregister == 'dosen') {
                $dosen = Dosen::where('nip', $request->nip)->first();
                if (!$dosen) return Response::error(null, 'Not Found.');

                $code = Str::random(60);
                $passwordResetToken = DB::table('password_reset_tokens')->where('email', $dosen->emaildosen)->first();
                if ($passwordResetToken) {
                    DB::table('password_reset_tokens')->where('email', $dosen->emaildosen)->delete();
                }

                DB::table('password_reset_tokens')->insert([
                    'email' => $dosen->emaildosen,
                    'token' => $code,
                    'created_at' => now(),
                ]);

                $user = User::where('email', $dosen->emaildosen)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $dosen->namadosen,
                        'username' => $dosen->namadosen,
                        'email' => $dosen->emaildosen,
                        'password' => Hash::make(Str::random(12)),
                    ])->assignRole('Dosen');

                    $dosen->id_user = $user->id;
                    $dosen->save();
                }

                $data['url'] = route('register.set-password', ['token' => $code]);
                $data['name'] = $dosen->namadosen;
                $data['message'] = 'Aktivasi akun anda berhasil! Silakan atur password anda';

                dispatch(new SendMailJob($dosen->emaildosen, new VerifyEmail($data)));

                $email = $dosen->emaildosen;

            } else if ($request->roleregister == 'user') {
                $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();
                if (!$mahasiswa) return Response::error(null, 'Not Found.');

                $code = Str::random(60);
                $passwordResetToken = DB::table('password_reset_tokens')->where('email', $mahasiswa->emailmhs)->first();
                if ($passwordResetToken) {
                    DB::table('password_reset_tokens')->where('email', $mahasiswa->emailmhs)->delete();
                }

                DB::table('password_reset_tokens')->insert([
                    'email' => $mahasiswa->emailmhs,
                    'token' => $code,
                    'created_at' => now(),
                ]);

                $user = User::where('email', $mahasiswa->emailmhs)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $mahasiswa->namamhs,
                        'username' => $mahasiswa->namamhs,
                        'email' => $mahasiswa->emailmhs,
                        'password' => Hash::make(Str::random(12)),
                    ])->assignRole('Mahasiswa');

                    $mahasiswa->id_user = $user->id;
                    $mahasiswa->save();
                }

                $data['url'] = route('register.set-password', ['token' => $code]);
                $data['name'] = $mahasiswa->namamhs;
                $data['message'] = 'Aktivasi akun anda berhasil! Silakan atur password anda';

                dispatch(new SendMailJob($mahasiswa->emailmhs, new VerifyEmail($data)));

                $email = $mahasiswa->emailmhs;

            } else if ($request->roleregister == 'mitra') {
                $industri = Industri::create([
                    'namaindustri' => $request->namaindustri,
                    'status' => 1,
                    'statusapprove' => 0,
                    'kategori_industri' => $request->kategori_industri,
                    'statuskerjasama' => $request->statuskerjasama
                ]);

                $pegawaiIndustri = PegawaiIndustri::create([
                    'id_industri' => $industri->id_industri,
                    'namapeg' => $request->name,
                    'nohppeg' => $request->notelpon,
                    'emailpeg' => strtolower($request->email),
                    'jabatan' => 'Administrator',
                    'statuspeg' => true
                ]);

                new WriteAndReadCounterBadgeJob('kelola_mitra_count', 'increment', function () {
                    return Industri::where('statusapprove', 0)->count();
                });

                $industri->update(['penanggung_jawab' => $pegawaiIndustri->id_peg_industri]);

                $email = strtolower($request->email);
            } else {
                abort(404);
            }

            DB::commit();
            return redirect()->route('register.successed', [
                'role' => $request->roleregister,
                'email' => Crypt::encryptString($email),
            ]);
        } catch (Exception $e) {
            return Response::errorCatch($e);
        }
    }

    public function newPassword($token) {
        $email = DB::table('password_reset_tokens')->where('token', $token)->first()->email ?? null;
        if (!$email) return abort(403);

        return view('auth.verifikasi_akun', compact('token' , 'email'));
    }

    public function storeNewPassword(Request $request) {
        $validate = [
            'token' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => ['required'],
        ];

        $validator = Validator::make($request->all(), $validate, [
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password harus minimal 8 karakter',
            'password.letters' => 'Setidaknya ada satu huruf',
            'password.mixed' => 'Setidaknya ada satu huruf kapital dan huruf kecil',
            'password.numbers' => 'Setidaknya ada satu angka',
            'password.symbols' => 'Setidaknya ada satu simbol atau karakter',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $passwordResetToken = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$passwordResetToken) {
            return redirect()->back()->withInput()->withErrors(['token' => 'Token tidak valid, silahkan melakukan registrasi ulang!']);
        }

        $user = User::where('email', $passwordResetToken->email)->first();
        if (!$user) return Response::error(null, 'Not Found.');
        $user->password = Hash::make($request->password);
        $user->save();
        DB::table('password_reset_tokens')->where('email', $passwordResetToken->email)->delete();
        DB::commit();

        return redirect(url('login'));
    }

}
