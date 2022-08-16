<?php
namespace App\Http\Help;
/**
 * @author aidsoul <work-aidsoul@outlook.com>
 */
class Validator{

    
    public static function stripTag(){
        return "regex:/<[sS]cript>/u";
    }

    public static function userName(){
        return 'regex:/[А-Яа-я]{2,}/u';       
    }

    // public static function phone(){
    //     return 'regex:/^((\3|7|5)+([0-9]){10})$/';
    // }
    public static function phone(){
        return 'regex:/f/';
    }
}
