<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public  function  login(){
        return view('auth.login');
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function authenticate(Request $request){

        $login =['user_name'=> $request->user_name , 'password'=>$request->password];
        if(Auth::attempt($login)) {
            $user = Auth::user();
            $user->status = "نشط";
            $user->save();
           // \Illuminate\Support\Facades\Cookie::queue('active_user',60*60*24);

            return redirect()->route('dashboard');
        }
        return redirect()->back()->withInput()->with('error','فشلت عملية تسجيل الدخول.اسم المستخدم أو كلمة السر غير صحيحة!');
    }
    public  function  logout(){
        if (Auth::check()){
            $user = Auth::user();
            $user->status = "غير نشط";
            $user->save();
            Auth::logout();
        }
        return redirect()->route('login');
    }
}
