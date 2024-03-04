<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function saveContactUs(Request $request)
    {
        ContactUs::query()->create([
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'message' => $request->get('message'),
            'phone'   => $request->get('phone'),
            'subject' => $request->get('subject'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us. We will get back to you soon.',
        ]);
    }
}
