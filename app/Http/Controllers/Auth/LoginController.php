<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

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

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login', [
            'meta' => [
                'title' => 'tests',
                'foo' => 'bar'
            ]
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        var_dump($this->checkCaptcha($input['token']));
        die();
        if ($this->checkCaptcha($input['token'])->success == 'false') {
            return Redirect()->route('login')
                ->with('error', 'You are not human.');
        }

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            // return redirectWithoutInertia('admin.dashboard');
            return Redirect()->route('admin.dashboard');
        } else {
            return Redirect()->route('login')
                ->with('error', 'Username or password is wrong.');
        }
    }

    private function checkCaptcha($token)
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6Lc_exkcAAAAAH4dTGANMTEYyg7k_hYpjC8JHRY_',
            'response' => $token,
        ]);
        return $response;
    }

    public function logout()
    {
        //logout user
        Auth::logout();
        // redirect to homepage
        return Redirect()->route('login');
    }
}
