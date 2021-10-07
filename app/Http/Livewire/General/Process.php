<?php

namespace App\Http\Livewire\General;

use App\Models\Method;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Process extends Component
{
    public $method;

    public function render()
    {
        $items = Transaction::where('user_id', Auth::user()->id)->where('status', 'process')->get();
        $carts = [];
        foreach ($items as $key => $item) {
            if (!empty($carts)) {
                $found = false;
                for ($i = 0; $i < $key; $i++) {
                    if (isset($carts[$i][$item->product->shop->name])) {
                        if (array_keys($carts[$i])[0] == $item->product->shop->name) {
                            $carts[$i][$item->product->shop->name] += $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty;
                            $found = true;
                            break;
                        }
                    }
                    // check if its last loop and cannot find same shop 
                    if ($i == $key - 1 and !$found) {
                        $carts[] = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
                    }
                }
            } else {
                $carts[] = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
            }
        }
        // dd($carts);
        foreach ($carts as $key => $cart) {
            // var_dump(array_keys($cart)[0]);
        }
        // die;
        return view('livewire.general.process', [
            'items' => $items,
            'carts' => $carts,
            'methods' => Method::all(),
        ])->extends('layouts.general')->section('content');
    }
}
