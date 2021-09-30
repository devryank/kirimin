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
    public $addQty = false;
    public $qty = 0;

    public function mount()
    {
        $this->shopId = request()->segment(2);
    }

    public function render()
    {
        $shop = Shop::findOrFail($this->shopId)->first();
        $products = Product::where('shop_id', $shop->id)->get();
        return view('livewire.general.show', [
            'shop' => $shop,
            'products' => $products,
        ])->extends('layouts.general')->section('content');
    }

    public function createOrder($tagId)
    {
        $this->tagId = $tagId;
        $this->addQty = true;
    }

    public function increaseQty()
    {
        $this->qty += 1;
    }

    public function decreaseQty()
    {
        if ($this->qty !== 0) {
            $this->qty -= 1;
        }
    }

    public function addToCart($productId)
    {
        if ($this->qty > 0) {
            $trxDuplicate = Transaction::where('user_id', Auth::user()->id)
                ->where('product_id', $productId)
                ->where('status', 'waiting')
                ->first();
            if (!empty($trxDuplicate)) {
                $trxDuplicate->update([
                    'qty' => $this->qty,
                ]);
            } else {
                Transaction::create([
                    'id' => date('Ymdhis') . Str::random(4),
                    'product_id' => $productId,
                    'user_id' => Auth::user()->id,
                    'qty' => $this->qty,
                ]);
            }
            $this->reset(['tagId', 'addQty', 'qty']);
        }
    }
}
