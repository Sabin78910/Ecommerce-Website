<?php

namespace App\Http\Controllers;

use App\Mail\QueryReceived;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create record (status defaults to 'unread')
        $query = ContactQuery::create($data);

        // Send acknowledgement email
        Mail::to($query->email)
            ->send(new QueryReceived($query));

        return back()->with(
            'success',
            'Your query has been received! A confirmation email has been sent.'
        );
    }
}
