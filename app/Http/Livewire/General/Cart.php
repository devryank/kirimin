<?php

namespace App\Http\Livewire\General;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $tagId = false;
    public $addQty = false;
    public $qty = 0;

    public function render()
    {
        $items = Transaction::where('user_id', Auth::user()->id)->get();
        return view('livewire.general.cart', [
            'items' => $items,
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
