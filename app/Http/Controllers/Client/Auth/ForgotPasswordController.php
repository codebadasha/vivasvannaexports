<?php

namespace App\Http\Controllers\Client\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\ClientCompany;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

   public function showLinkRequestForm()
    {
        return view('client.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'gstn' => 'required'
        ]);

        // Find client by GSTN
        $client = ClientCompany::where('gstn', $request->gstn)->first();

        if (!$client) {
            return back()->withErrors(['gstn' => 'GSTN not found']);
        }

        // Send reset link using email
        $response = Password::broker('client')->sendResetLink([
            'email' => $client->email
        ]);

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent to registered email')
            : back()->withErrors(['email' => 'Unable to send reset link']);
    }

    public function broker()
    {
        return Password::broker('clients');
    }
}
