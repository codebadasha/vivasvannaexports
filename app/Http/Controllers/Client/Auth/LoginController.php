<?php

namespace App\Http\Controllers\Client\Auth;

use Auth;
use App\Models\ClientCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/client';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'gstn' => 'required|string|size:15', // GSTN is 15 characters
            'password' => 'required|string|min:6',
        ], [
            'gstn.required' => 'GST number is required',
            'gstn.size'     => 'GST number must be exactly 15 characters',
            'password.required' => 'Password is required',
        ]);

        try {
            $gstn = $request->gstn;
            $password = $request->password;

            // ✅ Check user by GSTN
            $user = ClientCompany::where('gstn', $gstn)->first();

            if (!$user) {
                Log::warning("Login failed: GSTN not found", ['gstn' => $gstn]);
                return back()->withErrors([
                    'username' => 'This GST number is not registered in our records.'
                ]);
            }

            // ✅ Verify password
            if (!Hash::check($password, $user->password)) {
                Log::warning("Login failed: Invalid password", ['gstn' => $gstn]);
                return back()->withErrors([
                    'password' => 'Invalid credentials. Please try again.'
                ]);
            }

            // ✅ Login
            Auth::guard('client')->login($user);

            Log::info("Login successful", ['gstn' => $gstn, 'id' => $user->id]);

            return redirect()->route('client.dashboard')
                ->with('success', 'Welcome back!');
        } catch (\Exception $e) {
            // ✅ Exception logging
            Log::error("Login error", ['error' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);

            return back()->withErrors([
                'general' => 'Something went wrong while processing your login. Please try again later.'
            ]);
        }
    }

    public function logout(Request $request)
    {

        $this->performLogout($request);

        $message = isset($request->access) ? 'Your access is restricted, please contact admin' : 'You are logged out';

        return redirect()->route('client.login')->with('message', $message);
    }

    //defining guard for admins
    protected function guard()
    {
        return Auth::guard('client');
    }
}
