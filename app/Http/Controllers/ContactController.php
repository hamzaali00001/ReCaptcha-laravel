<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Rules\Captcha;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();

        return view('contact', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'message' => 'required|string|min:10|max:2000',
            'g-recaptcha-response' => new Captcha()
        ]);

        Contact::create([
            'email' => $validatedData['email'],
            'message' => $validatedData['message']
        ]);

        return redirect()->back()->with('message', 'Contact us query submitted successfully');
    }
}
