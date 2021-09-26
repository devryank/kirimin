<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $showShop = false;
    public $createShop = false;
    public $editShop = false;
    public $deleteShop = false;
    public $search;
    public $paginate = 10;

    protected $listeners = [
        'refreshShop' => '$refresh',
        'shopStored' => 'shopStoredHandler',
        'shopUpdated' => 'shopUpdatedHandler',
        'closeShop' => 'closeShopHandler',
        'userProhibited' => 'userProhibitedHandler',
        'shopDestroyed' => 'shopDestroyedHandler',
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
        $shops = $this->search === NULL     ?
            Shop::orderBy('id', 'asc')->paginate($this->paginate) :
            Shop::orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);

        return view('livewire.shop.index', [
            'shops' => $shops,
        ]);
    }

    public function closeShopHandler()
    {
        $this->showShop = false;
        $this->editShop = false;
        $this->createShop = false;
        $this->deleteShop = false;
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
}
