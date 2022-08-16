<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @author aidsoul <work-aidsoul@outlook.com>
 */
class CommentController extends Controller
{

    public function index(){
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $comments = ProductComment::where('status','=',0)->paginate(5);
            return view('admin.product.comment',compact('comments'));
    }

    public function edit(Request $request){
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $comment = ProductComment::where('id','=',$request->id)->first();

        return view('admin.product.commentedit',compact('comment'));

        // return redirect()->route('admin.product.comment')
        // ->with('success',$request->id);
    }

    public function update(Request $request){
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $this->validate($request,[
            'comment'=> ['required','string','max:500']
        ]);
        $status = empty($request['status'])?0:1;
        
        ProductComment::where('id',$request->id)->update([
            'text'=> $request->comment,
            'status' => $status
        ]);

        return redirect()->route('admin.product.comment',['comment'=>$request])
            ->with('success','Комментарий обновлён!');
    }

    public function delete(Request $request){
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $comment = ProductComment::where('id','=',$request->id);
        $comment->delete();
        return redirect()->route('admin.product.comment')
        ->with('success','Комментарий был удалён');
    }

    public function showCount(){
        if(!Gate::any(['admin','operator'])){
            return abort(404);
        }
        $count = ProductComment::where('status','=',0)->count();

        return  json_encode(['count'=>$count]);
    }
}
