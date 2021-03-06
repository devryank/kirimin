<?php

namespace App\Http\Livewire\General;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public $shopId;
    public $tagId = false;
    public $addUnitQty = false;
    public $addSingleQty = false;
    public $unitQty = 0;
    public $singleQty = 0;

    public function mount()
    {
        $this->shopId = request()->segment(2);
    }

    public function render()
    {
        $shop = Shop::findOrFail($this->shopId);
        $products = Product::where('shop_id', $this->shopId)->where('stock', 'ready')->get();
        return view('livewire.general.show', [
            'shop' => $shop,
            'products' => $products,
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
            // check duplicate item
            $trxDuplicate = Transaction::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->where('status', 'cart')
                ->first();
            if (!empty($trxDuplicate)) { // have a duplicate
                $trxDuplicate->update([
                    'qty' => $this->unitQty,
                    'custom_price' => 0,
                ]);
            } else {
                // check last item if there is in cart
                $lastTrxInCart = Transaction::where('user_id', Auth::user()->id)
                    ->where('status', 'cart')
                    ->first();
                $lastTrxSuccess = Transaction::where('user_id', Auth::user()->id)
                    ->where('status', 'waiting')
                    ->first();
                if ($lastTrxInCart and !$lastTrxSuccess) { // available
                    Transaction::create([
                        'trx_id' => $lastTrxInCart->trx_id,
                        'shop_id' => $this->shopId,
                        'product_id' => $productId,
                        'user_id' => Auth::user()->id,
                        'qty' => $this->unitQty,
                    ]);
                } else { // no item in cart
                    Transaction::create([
                        'trx_id' => date('Ymdhis') . Str::random(4),
                        'shop_id' => $this->shopId,
                        'product_id' => $productId,
                        'user_id' => Auth::user()->id,
                        'qty' => $this->unitQty,
                    ]);
                }
            }
        }

        if ($this->singleQty > 0) {
            $trxDuplicate = Transaction::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->where('status', 'cart')
                ->first();
            if (!empty($trxDuplicate)) { // have a duplicate
                $trxDuplicate->update([
                    'qty' => 0,
                    'custom_price' => $this->singleQty
                ]);
            } else {
                // check last item if there is in cart
                $lastTrxInCart = Transaction::where('user_id', Auth::user()->id)
                    ->where('status', 'cart')
                    ->first();
                $lastTrxSuccess = Transaction::where('user_id', Auth::user()->id)
                    ->where('status', 'waiting')
                    ->first();
                if ($lastTrxInCart and !$lastTrxSuccess) { // available
                    Transaction::create([
                        'trx_id' => $lastTrxInCart->trx_id,
                        'shop_id' => $this->shopId,
                        'product_id' => $productId,
                        'user_id' => Auth::user()->id,
                        'custom_price' => $this->singleQty
                    ]);
                } else { // no item in cart
                    Transaction::create([
                        'trx_id' => date('Ymdhis') . Str::random(4),
                        'shop_id' => $this->shopId,
                        'product_id' => $productId,
                        'user_id' => Auth::user()->id,
                        'custom_price' => $this->singleQty
                    ]);
                }
            }
        }
        $this->reset(['tagId', 'addUnitQty', 'addSingleQty', 'unitQty', 'singleQty']);
    }

    public function cancel()
    {
        $this->reset(['tagId', 'addUnitQty', 'addSingleQty', 'unitQty', 'singleQty']);
    }
}
