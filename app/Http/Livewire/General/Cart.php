<?php

namespace App\Http\Livewire\General;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $shopId;
    public $tagId = false;
    public $addUnitQty = false;
    public $addSingleQty = false;
    public $unitQty = 0;
    public $singleQty = 0;

    public function render()
    {
        $items = Transaction::where('user_id', Auth::user()->id)->get();
        $cart = [];
        foreach ($items as $key => $item) {
            if(!empty($cart)) {
                // echo 'ok';
            for ($i = 0; $i < $key - 1; $i++) {
                //   echo array_keys($cart[$i])[0];
                //   echo $item->product->shop->item;
                    //  if(array_keys($cart[$key])[$i] == $item->product->shop->name) {
                        //  echo 'ok';
                        //  $cart[$i] = array($item->product->shop->name => $item->qty == 0 ? array_values($cart[$i]) + $item->custom_price : array_values($cart[$i]) + $item->product->price * $item->qty);
                    //  } else {
                        //  $cart = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
                    //  }
                 
                 }
            } else {
                // $cart[] = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
// dd($cart);
            }
            
        }
        
        $cart = [];
        
        foreach ($items as $key => $item) {
            if(!empty($cart)) {
                for ($i = 0; $i < $key; $i++) {
                    // echo $item->product->shop->name;
                     if(isset($cart[$i][$item->product->shop->name])) {
                         if(array_keys($cart[$i])[0] == $item->product->shop->name) {
                            $cart[$i][$item->product->shop->name] += $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty;
                            // echo 'sama';
                             break;
                         }
                    }else {
                        echo 'beda';
                        $cart[] = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
                    
                       break;
                    }   

                     
                }
                
            } else {
                $cart[] = array($item->product->shop->name => $item->qty == 0 ? $item->custom_price : $item->product->price * $item->qty);
       
            }
        }
        
        dd($cart);
        return view('livewire.general.cart', [
            'items' => $items,
        ])->extends('layouts.general')->section('content');
    }

    public function createOrderUnit($tagId)
    {
        $this->tagId = $tagId;
        $this->addSingleQty = false;
        $this->addUnitQty = true;
    }

    public function createOrderSingle($tagId)
    {
        $this->tagId = $tagId;
        $this->addUnitQty = false;
        $this->addSingleQty = true;
    }

    public function increaseQty()
    {
        $this->unitQty += 1;
    }

    public function decreaseQty()
    {
        if ($this->unitQty !== 0) {
            $this->unitQty -= 1;
        }
    }

    public function addToCart($productId)
    {
        if ($this->unitQty > 0) {
            $trxDuplicate = Transaction::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->where('status', 'waiting')
                ->first();
            if (!empty($trxDuplicate)) { // have a duplicate
                $trxDuplicate->update([
                    'qty' => $this->unitQty,
                    'custom_price' => 0,
                ]);
            } else {
                Transaction::create([
                    'id' => date('Ymdhis') . Str::random(4),
                    'product_id' => $productId,
                    'user_id' => Auth::user()->id,
                    'qty' => $this->unitQty,
                ]);
            }
        }

        if ($this->singleQty > 0) {
            $trxDuplicate = Transaction::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->where('status', 'waiting')
                ->first();
            if (!empty($trxDuplicate)) { // have a duplicate
                $trxDuplicate->update([
                    'qty' => 0,
                    'custom_price' => $this->singleQty
                ]);
            } else {
                Transaction::create([
                    'id' => date('Ymdhis') . Str::random(4),
                    'product_id' => $productId,
                    'user_id' => Auth::user()->id,
                    'custom_price' => $this->singleQty
                ]);
            }
        }
        $this->reset(['tagId', 'addUnitQty', 'addSingleQty', 'unitQty', 'singleQty']);
    }
}
