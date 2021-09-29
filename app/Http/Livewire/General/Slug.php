<?php

namespace App\Http\Livewire\General;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;

class Slug extends Component
{
    public $shop_id;
    public $addQty = false;

    public function mount()
    {
        $this->shop_id = request()->segment(2);
    }

    public function render()
    {
        $shop = Shop::findOrFail($this->shop_id)->first();
        $products = Product::where('shop_id', $shop->id)->get();
        return view('livewire.general.slug', [
            'shop' => $shop,
            'products' => $products,
        ])->extends('layouts.general')->section('content');
    }

    public function createOrder()
    {
        $this->addQty = true;
    }
}
