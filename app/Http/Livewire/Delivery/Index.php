<?php

namespace App\Http\Livewire\Delivery;

use App\Models\Shop;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $indexDelivery = true;
    public $showDelivery = false;
    public $failDelivery = false;
    public $checkDelivery = false;

    public $userId;
    public $items;
    public $total;
    public $paginate = 10;

    protected $listeners = [
        'refreshDelivery' => '$refresh',
        'transactionStored' => 'transactionStoredHandler',
        'transactionUpdate' => 'transactionUpdateHandler',
        'closeDelivery' => 'closeDeliveryHandler',
        'transactionProhibited' => 'transactionProhibitedHandler',
        'deliveryDestroyed' => 'deliveryDestroyedHandler',
        'deliverySuccess' => 'deliverySuccessHandler',
    ];


    public function mount()
    {
    }

    public function render()
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $transactions = Transaction::where('shop_id', $shop->id)->where('status', 'delivery')->groupBy('user_id')->orderBy('created_at', 'asc')->paginate($this->paginate);

        return view('livewire.delivery.index', [
            'transactions' => $transactions,
            'items' => $this->items,
            'total' => $this->total,
        ]);
    }

    public function closeDeliveryHandler()
    {
        $this->checkDelivery = false;
        $this->failDelivery = false;
        $this->showDelivery = false;
        $this->indexDelivery = true;
    }

    public function showDelivery($id)
    {
        $this->userId = $id;
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $this->items = Transaction::where('user_id', $this->userId)->where('status', 'delivery')->where('shop_id', $shop->id)->get();
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total += $item->qty == 0 ? $item->custom_price : $item->qty * $item->product->price;
        }
        $this->indexDelivery = false;
        $this->showDelivery = true;
    }

    public function transactionStoredHandler()
    {
        $this->closeDeliveryHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil dibuat');
    }

    public function editDelivery($id)
    {
        $this->closeDeliveryHandler();
        $this->editDelivery = true;
        $this->emit('transactionEdit', $id);
    }

    public function transactionUpdateHandler()
    {
        $this->closeDeliveryHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil diubah');
    }

    public function transactionProhibitedHandler($action)
    {
        $this->closeDeliveryHandler();
        session()->flash('color', 'red');
        session()->flash('message', 'Kamu tidak diizinkan untuk ' . $action . ' produk');
    }

    public function successDelivery($id)
    {
        $this->checkDelivery = true;
        $this->emit('successDelivery', $id); // Delivery/Failed.php
    }

    public function deliverySuccessHandler($name)
    {
        $this->checkDelivery = false;
        $this->failDelivery = false;
        $this->showDelivery = false;
        $this->indexDelivery = true;
        session()->flash('color', 'green');
        session()->flash('message', 'Produk ' . $name . ' berhasil diceklis');
    }

    public function failedDelivery($id)
    {
        $this->failDelivery = true;
        $this->emit('failedDelivery', $id); // Delivery/Failed.php
    }

    public function deliveryDestroyedHandler($name)
    {
        $this->failDelivery = false;
        $this->showDelivery = false;
        $this->indexDelivery = true;
        session()->flash('color', 'green');
        session()->flash('message', 'Produk ' . $name . ' berhasil digagalkan');
    }

    public function checkAll()
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        foreach ($this->items as $key => $item) {
            Transaction::where('user_id', $this->userId)->where('status', 'delivery')->where('shop_id', $shop->id)->update(['status' => 'success']);
        }
        $this->closeDeliveryHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Berhasil ceklis semua pesanan');
    }
}
