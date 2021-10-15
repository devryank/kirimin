<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $showProduct = false;
    public $showShop = false;
    public $createShop = false;
    public $editShop = false;
    public $deleteShop = false;
    public $deleteProduct = false;
    public $search;
    public $paginate = 10;

    public $shopId;
    public $searchProduct;
    public $paginateProduct = 10;

    protected $listeners = [
        'refreshShop' => '$refresh',
        'shopStored' => 'shopStoredHandler',
        'shopUpdated' => 'shopUpdatedHandler',
        'closeShop' => 'closeShopHandler',
        'userProhibited' => 'userProhibitedHandler',
        'shopDestroyed' => 'shopDestroyedHandler',
        'productDestroyed' => 'productDestroyedHandler',
    ];

    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        if (!$this->showProduct) {
            if (Auth::user()->hasRole('super-admin')) {
                $shops = $this->search === NULL     ?
                    Shop::orderBy('id', 'asc')->paginate($this->paginate) :
                    Shop::orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);
            } else if (Auth::user()->hasRole('seller')) {
                $shops = $this->search === NULL     ?
                    Shop::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->paginate($this->paginate) :
                    Shop::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);
            }
            return view('livewire.shop.index', [
                'shops' => $shops,
            ]);
        }
        if ($this->showProduct) {
            $shop = Shop::where('id', $this->shopId)->first();
            $products = $this->searchProduct === NULL     ?
                Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->paginate($this->paginateProduct) :
                Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->where('name', 'like', '%' . $this->searchProduct . '%')->paginate($this->paginateProduct);

            return view('livewire.shop.show-product', [
                'products' => $products,
            ]);
        }
    }

    public function closeShopHandler()
    {
        $this->showProduct = false;
        $this->showShop = false;
        $this->editShop = false;
        $this->createShop = false;
        $this->deleteShop = false;
        $this->deleteProduct = false;
    }

    public function showShop($shopId)
    {
        $this->closeShopHandler();
        $this->showShop = true;
        $this->emit('showShop', $shopId); // Shop/Show
    }

    public function createShop()
    {
        $already = Shop::where('user_id', Auth::user()->id)->first();
        if (!$already) {
            $this->closeShopHandler();
            $this->createShop = true;
        } else {
            session()->flash('color', 'red');
            session()->flash('message', 'Kamu sudah memiliki warung');
        }
    }

    public function shopStoredHandler()
    {
        $this->closeShopHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Warung berhasil dibuat');
    }

    public function editShop($id)
    {
        $this->closeShopHandler();
        $this->editShop = true;
        $this->emit('shopEdit', $id);
    }

    public function shopUpdatedHandler()
    {
        $this->closeShopHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Warung berhasil diubah');
    }

    public function userProhibitedHandler($action)
    {
        $this->closeShopHandler();
        session()->flash('color', 'red');
        session()->flash('message', 'Kamu tidak diizinkan untuk ' . $action . ' toko');
    }

    public function deleteShop($id)
    {
        $this->closeShopHandler();
        $this->deleteShop = true;
        $this->emit('deleteShop', $id); // Shop/Delete.php
    }

    public function shopDestroyedHandler($name)
    {
        $this->closeShopHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Berhasil menghapus ' . $name);
    }

    public function deleteProduct($id)
    {
        $this->closeShopHandler();
        $this->deleteProduct = true;
        $this->emit('deleteProduct', $id); // Shop/DeleteProduct.php
    }

    public function productDestroyedHandler($name)
    {
        $this->closeShopHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Berhasil menghapus ' . $name);
    }

    public function showProduct($id)
    {
        $this->closeShopHandler();
        $this->shopId = $id;
        $this->showProduct = true;
        // $this->emitTo('ShowProduct', 'showProductList', $id); // Shop/ShowProduct
    }
}
