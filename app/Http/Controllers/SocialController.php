<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\SocialService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Request {

    public function index(){
        return Socialite::driver('vkontakte')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('vkontakte')->user();

        $socialUser = new SocialService();
        if($u = $socialUser->saveDataUser($user)){
            Auth::login($u);
            $route = 'user.index';
            $message = 'Вы успешно вошли в личный кабинет';
            if ($u->admin) {
                $route = 'admin.index';
                $message = 'Вы успешно вошли в панель управления';
            }
            return redirect()->route($route)
                ->with('success', $message);
        }else{
            return back(400);
        }
        
    }
}
