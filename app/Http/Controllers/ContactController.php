<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mail::to('usertalentern@gmail.com')->send(new ContactMail($request));

        // $user = 'Lulu PutrI Aprilia';
        // Mail::to('luluputriaprilia@gmail.com')->send(new ContactMail($user));

        // dd("Email sudah terkirim.");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'institutions' => 'required',
            'note' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagepath = $request->file('file')->store('image','public');
        $imagepath = url('/') . '/storage/' . $imagepath;
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'institutions' => $request->input('institutions'),
            'note' => $request->input('note'),
            'file' => $imagepath,
        ];
        // return $imagepath;

        // Mail::send('emails.support', $data, function($message) use ($data)
        // {
        //   $message->from($data['email']);
        //   $message->to('smartrahat@gmail.com','Mohammed');
        //   $message->subject($data['subject']);
        // });

        Mail::to('lkmfit@gmail.com')->send(new ContactMail($data));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
