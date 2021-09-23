<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Delete extends Component
{
    public $shopId;
    public $name;

    protected $listeners = [
        'deleteShop' => 'deleteShopHandler',
    ];

    public function render()
    {
        return view('livewire.shop.delete', [
            'name' => $this->name,
        ]);
    }

    public function deleteShopHandler($id)
    {
        $shop = Shop::findOrFail($id);
        $this->shopId = $shop->id;
        $this->name = $shop->name;
    }

    public function destroyShop()
    {
        if (request()->user()->hasRole('super-admin') or request()->user()->hasPermissionTo('delete shops')) {
            $shop = Shop::find($this->shopId);
            $name = $shop['name'];
            $shop->delete();
            $this->emit('shopDestroyed', $name);
        } else {
            $this->emit('userProhibited', 'delete');
        }
    }
}
