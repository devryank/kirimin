<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowProduct extends Component
{
    public $shopId;
    public $name;
    public $search;
    public $paginate = 10;

    protected $listeners = [
        'productList' => 'productListHandler',
    ];

    public function productListHandler($id)
    {
        $shop = Shop::findOrFail($id);
        $this->shopId = $shop->id;
    }

    public function render()
    {
        $shop = Shop::where('user_id', $this->shopId)->first();
        dd($this->shopId);
        $products = $this->search === NULL     ?
            Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->paginate($this->paginate) :
            Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);

        return view('livewire.product.show-product', [
            'products' => $products,
        ]);
    }

    public function destroyShop()
    {
        if (request()->user()->hasRole('super-admin') or request()->user()->hasPermissionTo('delete shops')) {
            $shop = Shop::find($this->shopId);
            $name = $shop['name'];
            @unlink('storage/toko/' . $shop['photo']);
            $shop->delete();
            $this->emit('shopDestroyed', $name);
        } else {
            $this->emit('userProhibited', 'delete');
        }
    }
}
