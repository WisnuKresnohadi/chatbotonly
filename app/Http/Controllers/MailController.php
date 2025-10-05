<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    
    public function index(){
return 'assadssf';
	// $details = [
    // 'title' => 'Halo ini aku mita, aku lagi coba test kirim email',
    // 'body' => 'This is for testing email using smtp'
    // ];

    $user = 'Mita Mutiara';
    // $pathToFile = url('https://ibb.co/K72zq75');
   
    Mail::to('mitamutiara476@gmail.com')->send(new \App\Mail\EmailJadwalSeleksi($user));
   
    dd("Email sudah terkirim.");

	}
}