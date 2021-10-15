<?php

namespace App\Http\Livewire\Product;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $createProduct = false;
    public $editProduct = false;
    public $deleteProduct = false;
    public $search;
    public $paginate = 10;

    protected $listeners = [
        'refreshProduct' => '$refresh',
        'productStored' => 'productStoredHandler',
        'productUpdate' => 'productUpdateHandler',
        'closeProduct' => 'closeProductHandler',
        'productProhibited' => 'productProhibitedHandler',
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
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $products = $this->search === NULL     ?
            Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->paginate($this->paginate) :
            Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);

        return view('livewire.product.index', [
            'products' => $products,
        ]);
    }

    public function closeProductHandler()
    {
        $this->editProduct = false;
        $this->createProduct = false;
        $this->deleteProduct = false;
    }

    public function createProduct()
    {
        $this->closeProductHandler();
        $this->createProduct = true;
    }

    public function productStoredHandler()
    {
        $this->closeProductHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil dibuat');
    }

    public function editProduct($id)
    {
        $this->closeProductHandler();
        $this->editProduct = true;
        $this->emit('productEdit', $id);
    }

    public function productUpdateHandler()
    {
        $this->closeProductHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil diubah');
    }

    public function productProhibitedHandler($action)
    {
        $this->closeProductHandler();
        session()->flash('color', 'red');
        session()->flash('message', 'Kamu tidak diizinkan untuk ' . $action . ' produk');
    }

    public function deleteProduct($id)
    {
        if (Auth::user()->hasRole('super-admin') or request()->user()->hasPermissionTo('delete products')) {
            $this->closeProductHandler();
            $this->deleteProduct = true;
            $this->emit('deleteProduct', $id); // Product/Delete.php
        } else {
            $this->emit('productProhibited', 'delete');
        }
    }

    public function productDestroyedHandler($name)
    {
        $this->closeProductHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk ' . $name . ' berhasil dihapus');
    }
}
