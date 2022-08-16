<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UserAmount;
use App\Models\Order;


class UserController extends Controller {
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        // получаем общее количество потраченных денег пользователя
        $order = Order::getAllWhereUser(
            auth()
            ->user()
            ->id);
        $get = UserAmount::set();
        $get->getAll($order);

        $amount = $get->getAmount();
        $discount = $get->getDiscount();
        $orderCount = $order->count();

        $rout = auth()->user()->admin > 0 && auth()->user()->admin <= 4?true:false;

        return view('user.index',compact('amount','discount','rout','orderCount'));
    }
}

