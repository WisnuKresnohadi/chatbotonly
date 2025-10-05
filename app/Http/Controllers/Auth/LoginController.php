<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('superadmin')) {
            return redirect()->route('dashboard.superadmin');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('profile_company.index');
        } else {
            // if (!$user->hasVerifiedEmail()) {
            //     return redirect()->route('verification.notice')->with('warning', 'Please verify your email first.');
            // }
            return view('landingpage.landingpage');
        }
    }

    public function loginIgracias()
    {
        try {
            $username = env("USERNAME_IGRACIAS");
            $password = env("PASSWORD_IGRACIAS");
            $loginUrl = env('BASE_URL_IGRACIAS') . '/' . env("PATHNAME_LOGIN_IGRACIAS");
            $authTokenKey = env('AUTH_TOKEN_KEY_IGRACIAS', 'auth_token_igracias');

            logIgracias('info', 'Attempting to log in to iGracias API');

            $response = Http::post($loginUrl, [
                'username' => $username,
                'password' => $password,
            ]);

            logIgracias('info', 'Username: ' . $username);
            logIgracias('info', 'Password: ' . $password);            

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['token'])) {
                    $token = $responseData['token'];
                    $expired = $responseData['expired'];
                    Cache::put($authTokenKey, encrypt($token), $expired);
                    return $token;
                } else {
                    $errorMessage = "Kredensial Anda tidak valid atau token telah kedaluwarsa. Silakan hubungi administrator jika masalah ini terus berlanjut.";
                    logIgracias('error', 'Login failed: ' . $errorMessage);
                    throw new Exception($errorMessage);
                }
            } else {
                $errorMessage = "Kredensial Anda tidak valid atau token telah kedaluwarsa. Silakan hubungi administrator jika masalah ini terus berlanjut.";
                logIgracias('error', 'Login failed with status: ' . $response->status() . ' - ' . $errorMessage);
                throw new Exception($errorMessage);
            }
        } catch (ConnectionException $e) {
            // Tidak bisa konek sama sekali (offline, DNS, timeout)
            logIgracias('error', 'Connection error during login: ' . $e->getMessage());
            logIgracias('info', '');
            throw new Exception("Tidak dapat terhubung ke server Igracias. Periksa koneksi Anda atau coba beberapa saat lagi.");
        } catch (RequestException $e) {
            logIgracias('error', 'Request error during login: ' . $e->getMessage());
            logIgracias('info', '');
            throw new Exception("Permintaan ke server Igracias gagal: " . $e->getMessage());
        } catch (Exception $e) {
            logIgracias('error', 'Authentication error: ' . $e->getMessage());
            logIgracias('info', '');
            throw new Exception("Autentikasi gagal: " . $e->getMessage());
        }
    }
}
