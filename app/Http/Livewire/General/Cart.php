<?php

namespace App\Http\Livewire\General;

use Livewire\Component;

class Cart extends Component
{
    public function render()
    {

        return view('livewire.general.cart')
            ->extends('layouts.general')->section('content');
    }
}
