<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Help\Validator as V;
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
     * Сразу после входа выполняем редирект и устанавливаем flash-сообщение
     */
    protected function authenticated(Request $request, $user) {
        $this->validate($request,[
            'email' => ['required', 'string', 'max:30', V::userName()],
        ]
        );
        $route = 'user.index';
        $message = 'Вы успешно вошли в личный кабинет';
        return redirect()->route($route)
            ->with('success',  $message);
    }

    /**
     * Сразу после выхода выполняем редирект и устанавливаем flash-сообщение
     */
    protected function loggedOut(Request $request) {
            return redirect()->route('user.login')
            ->with('success', 'Вы успешно вышли из личного кабинета');
    }
}
