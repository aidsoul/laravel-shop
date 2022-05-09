<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show(Request $request){
    $product = Product::getOneProduct($request->product);

    $comments = ProductComment::where('product_id','=', $product->id)
    ->where('status','=',1)->paginate(3);

    //Если нет такого комментария
    if(!$product){
        abort(404);
    }
    $data = ['product'=> $product,'comments'=>$comments];

    if(auth()->user()){
        return view('catalog.comment',array_merge($data,['user_status'=>'1']));
    }else{
        return view('catalog.comment', $data);
    }
    }

    public function create(Request $request){

        $this->validate($request,[
            'comment'=> ['required','string','max:500']
        ]);
        if(auth()->user()){
            $product = new Product; 
            $product = Product::getOneProduct($request->slug);
            $user = auth()->user()->id;
            $slug = $product->id;
            $comment = ProductComment::where('user_id','=',$user)->where('product_id','=',$slug)->first();
            if(!$comment){
                ProductComment::create([
                    'text' => $request['comment'],
                    'user_id'=> $user,
                    'product_id'=> $slug,
                ]);
                return redirect()
                ->route('catalog.product.comment',['product'=> $request->slug])
                ->with('success','Ваш комментарий ожидает модерации');
            }else{
                return redirect()
                ->route('catalog.product.comment',['product'=> $request->slug])
                ->with('warning','Вы уже оставили коментарий!');
            }
            
        }else{
            abort(404);
        }

    }

}
