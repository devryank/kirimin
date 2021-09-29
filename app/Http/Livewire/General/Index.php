<?php

namespace App\Http\Livewire\General;

use App\Models\Shop;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $qty = 0;
    public function mount()
    {
        if (!Auth::user()) {
            return view('livewire.general.noauth')
                ->extends('layouts.general')
                ->section('content');
        }
    }

    public function render()
    {
        $shops = Shop::all();
        return view('livewire.general.index', [
            'shops' => $shops
        ])->extends('layouts.general')->section('content');
    }

    public function createOrder()
    {
        // $this->addQty = true;
        $this->qty = $this->qty + 1;
    }
}
