<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function submitContactUs(Request $request)
    {
        $validator = Validator::make(
            request()->all(), [
                recaptchaFieldName() => recaptchaRuleName(),
                'name' => 'required|string|max:180|min:3',
                'email' => 'required|email|max:180',
                'message' => 'required|string',
            ]
        );

        // check if validator fails
        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'success' => false,
                'message' => 'Please fill the required fields.',
                'errors' => $errors,
            ], 422);
        }

        ContactUs::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'message' => $request->get('message'),
        ]);

        return response()->json([
            'success' => true,
            'message' => '<strong>Success!</strong> Your message has been sent.',
        ]);
    }
}
