<?php

namespace App\Http\Livewire\General;

use App\Models\Shop;
use App\Models\Address;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $paginate = 10;

    public $selectAddress = 'rw';

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
        $userAddress = json_decode(Auth::user()->address);
        if ($this->selectAddress == 'rt') {
            $addresses = Address::where([
                ['rt', '=', $userAddress->rt],
                ['rw', '=', $userAddress->rw],
                ['kelurahan', '=', $userAddress->kelurahan],
            ])->get();
        }
        if ($this->selectAddress == 'rw') {
            $addresses = Address::where([
                ['rw', '=', $userAddress->rw],
                ['kelurahan', '=', $userAddress->kelurahan],
            ])->get();
        }
        if ($this->selectAddress == 'kelurahan') {
            $addresses = Address::where([
                ['kelurahan', '=', $userAddress->kelurahan],
            ])->get();
        }

        $addressId = array();
        foreach ($addresses as $key => $address) {
            $addressId[] = $address->id;
        }

        if (!empty($addressId)) {
            $shops = Shop::whereIn('address_id', $addressId)->paginate($this->paginate);
        } else {
            $shops = [];
        }
        return view('livewire.general.index', [
            'shops' => $shops
        ])->extends('layouts.general')->section('content');
    }
}
