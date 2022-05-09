<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductComment;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke() {
        // $comment = ProductComment::where('status','=',0)->count();

        // return view('admin.index',['comment'=>$comment]);
        return view('admin.index');
    }
}
