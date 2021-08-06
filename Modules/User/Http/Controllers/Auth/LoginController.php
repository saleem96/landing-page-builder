<?php

namespace Modules\User\Http\Controllers\Auth;

use Modules\User\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    private $providers = [
        'facebook',
        'twitter',
        'linkedin',
        'google',
        'github',
        'gitlab',
        'bitbucket',
    ];

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
    protected $redirectTo = 'dashboard';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('themes::' . config('app.SITE_LANDING') . '.auth.login');
    }

    /**
     * Redirect the user to the authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return redirect()->route('login');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return redirect()->route('login');
        }

        try {

            $social = Socialite::driver($provider)->user();

            $user = User::firstOrCreate(
                [
                    'email' => $social->getEmail(),
                ],
                [
                    'name'          => $social->getName(),
                    'password'      => Hash::make(Str::random(40)),
                    
                ]
            );

            Auth::login($user);

            // return redirect()->route('landingpages.index')->withErrors('add payment method and make a payment of 1 usd to activate his account');
            return redirect()->route('landingpages.index');
        } catch (\Exception $e) {

            return redirect()->route('login')->with('error', $e->getMessage());
          
        }
    }

}
