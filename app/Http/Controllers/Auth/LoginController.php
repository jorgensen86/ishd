<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    /**
     * Change credential email to username
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Check if user is active at login
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt( 
            array_merge($this->credentials($request), ['active' => 1]), $request->filled('remember')
        );
    }

    protected function authenticated()
    {
        if ((auth()->user()->administrator)) {
            return redirect()->route('dashboard');
        } elseif (!auth()->user()->administrator) {
            return redirect()->route('home');
        }
    }

    /**
     * change view for login form
     */
    public function showLoginForm()
    {
        return view('layouts.admin.common.login', ['class' => 'loginPage']);
    }
    
}