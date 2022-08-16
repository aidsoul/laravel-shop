<?php
namespace App\Helpers;

class UserAmount {

    private $discount = 0;
    private $amout = 0;
    private $orderCount = 0;

    public function getAmount(){
        return $this->amout;
    }
    public function getDiscount(){
        return $this->discount;
    }
    public function getOrderCount(){
        return $this->orderCount;
    }

    public function getAll($orders){
        $totalPrice = 0;
        $this->orderCount = count($orders);
        foreach($orders as $ord){
            $totalPrice += $ord->amount;
        }

        $this->amout = $totalPrice;
        $this->discount = $this->discount();
    }

    public static function set():UserAmount{
        return new static();
    }

    private function discount(){
        $cent = [
            1000 => 1,
            2500 => 5,
            5000 => 10,
            10000 => 13,
            15000 => 15,
            30000 => 20
        ];
        $centPrice = 0;
        foreach($cent as $k=>$itm){
            if($this->amout >= $k){
                $centPrice = $itm;
            }
        }
        return  $centPrice;
    }
    
    public function endPrice($price,$discount = false){
        if(!$discount){
            $discount = $this->discount;
        }
        return $price - ($price *($discount / 100));
    }
}
