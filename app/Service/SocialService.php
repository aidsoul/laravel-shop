<?php 
namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialService 
{
    
    public function saveDataUser($user){
        $email = $user->getEmail();
        $name  = explode(' ',$user->getName());
        $firstName = $name[0];
        $lastName = $name[1];
        $password = Hash::make('asfg54dsf%#25');
        $u = User::firstOrCreate(
            ['email'=>$email],
            ['first_name'=>$firstName,
            'last_name'=>$lastName,
            'middle_name'=>'',
            'password'=>$password
        ]);
        if($u){
            return $u->fill(['first_name'=>$name]);
        }
    }
}
