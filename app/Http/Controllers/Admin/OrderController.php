<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Help\Validator as V;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller {


    /**
     * Просмотр списка заказов
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(!Gate::any(['admin','operator','driver'])){
            return abort(404);
        }
        $orders = Order::orderBy('status', 'asc')->paginate(5);
        if(auth()->user()->admin == 4){
            $orders = Order::where('status','=',1)
            ->orwhere('status','=',2)
            ->orwhere('status','=',3)
            ->paginate(5);
        }
        $statuses = Order::STATUSES;
        return view('admin.order.index',compact('orders', 'statuses'));
    }


    /**
     * Просмотр отдельного заказа
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order) {
        if(!Gate::any(['admin','operator','driver'])){
            return abort(404);
        }
        $statuses = Order::STATUSES;
        return view('admin.order.show', compact('order', 'statuses'));
    }

    /**
     * Форма редактирования заказа
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order) {
        $statuses = Order::STATUSES;
        return view('admin.order.edit', compact('order', 'statuses'));
    }

    /**
     * Обновляет заказ покупателя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order) {
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:30', V::userName()],
            'last_name' => ['required', 'string', 'max:30',V::userName()],
            'middle_name' => ['required', 'string', 'max:30',V::userName()],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required','max:18'], 
            'address' => ['required', 'string', 'max:255'], 
            'comment' => ['max:500']
        ]
        );
        $order->update($request->all());
        return redirect()
            ->route('admin.order.show', ['order' => $order->id])
            ->with('success', 'Заказ был успешно обновлен');
    }

    public function countNewOrder(){
        if(!Gate::any(['admin','operator','driver'])){
            return abort(404);
        }
        $count = Order::where('status','=',0)->count();
        if(auth()->user()->admin == 4){
        $count = Order::where('status','=',1)
        ->orwhere('status','=',2)
        ->orwhere('status','=',3)->count();
        }

        return json_encode(['count'=>$count]);
    }
}
