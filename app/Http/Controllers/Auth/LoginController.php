<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginInfo;
use Jenssegers\Agent\Agent;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('verify');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $client = new Agent();
        $loginInfo = LoginInfo::create([
            'email' => $request->email,
            'status' => 'success',
            'ip_address' => $request->ip(),
            'device' => $client->device(),
            'platform' => $client->platform(),
            'browser' => $client->browser(),
        ]);

        if (Auth::attempt($credentials)) {
            // echo "role ID: ";
            // echo Auth::user()->roles()->where('id', 3)->exists();
            if(Auth::user()->roles()->where('id', 3)->exists()){
                if($request->ajax()){
                    return response()->json([
                        'redirect' => route('resort.index')
                    ]);
                }else{
                    return redirect()->route('resort.index');
                }
            }
            else{
                if($request->ajax()){
                    return response()->json([
                        'redirect' => route('admin.home')
                    ]);
                }else{
                    return redirect()->route('admin.home');
                }
            }
        }else{
            $loginInfo->update([
                'status' => 'failed'
            ]);
            if($request->ajax()){
                $msg = "User not found, Invalid Email or Password.";
                return response()->json([
                    'error_msg'=> $msg
                ]);
            }
        }
    }
}
