<?php

namespace App\Http\Livewire\General;

use Livewire\Component;

class Noauth extends Component
{
    public function render()
    {
        return view('livewire.general.noauth')
            ->extends('layouts.general')
            ->section('content');
    }
}
