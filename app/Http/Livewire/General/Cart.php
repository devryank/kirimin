<?php

namespace App\Http\Livewire\General;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $shopId;
    public $tagId = false;
    public $addUnitQty = false;
    public $addSingleQty = false;
    public $unitQty = 0;
    public $singleQty = 0;

    public $selectShop;

    public function render()
    {
        $items = Transaction::where('user_id', Auth::user()->id)->where('status', 'cart')->get();
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
        return view('livewire.general.cart', [
            'items' => $items,
            'carts' => $carts,
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

    public function buyNow()
    {
        $transactions = Transaction::where('status', 'cart')->get();
        $checkTrx = Transaction::where('status', 'process')->first();
        $redirect = false;

        foreach ($transactions as $trx) {
            // check selected shop's name is same with transactions shop's name
            if ($trx->product->shop->name == $this->selectShop) {
                // check if there is any transactions with status process
                if (empty($checkTrx)) {
                    Transaction::where('shop_id', $trx->shop_id)->where('status', 'cart')->update(['status' => 'process']);
                    $redirect = true;
                } else {
                    dd('ada transaksi lain');
                }
            }
        }
        if ($redirect) {
            return redirect()->route('general.process');
        }
    }
}
