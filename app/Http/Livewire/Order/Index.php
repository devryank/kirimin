<?php

namespace App\Http\Livewire\Order;

use App\Models\Shop;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $indexTransaction = true;
    public $showTransaction = false;
    public $emptyStock = false;

    public $trxId;
    public $userId;
    public $items;
    public $total;
    protected $address;
    public $paginate = 10;

    protected $listeners = [
        'refreshTransaction' => '$refresh',
        'transactionStored' => 'transactionStoredHandler',
        'transactionUpdate' => 'transactionUpdateHandler',
        'closeTransaction' => 'closeTransactionHandler',
        'closeStock' => 'closeStockHandler',
        'successEmptyStock' => 'successEmptyStockHandler',
        'transactionProhibited' => 'transactionProhibitedHandler',
        'transactionDestroyed' => 'transactionDestroyedHandler',
    ];


    public function mount()
    {
    }

    public function render()
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $transactions = Transaction::where('shop_id', $shop->id)->where('status', 'waiting')->groupBy('user_id')->orderBy('created_at', 'asc')->paginate($this->paginate);

        return view('livewire.order.index', [
            'transactions' => $transactions,
            'items' => $this->items,
            'total' => $this->total,
            'address' => $this->address
        ]);
    }

    public function closeTransactionHandler()
    {
        $this->indexTransaction = false;
        $this->showTransaction = false;
        $this->emptyStock = false;
    }

    public function showTransaction($id, $trxId)
    {
        $this->closeTransactionHandler();
        $this->trxId = $trxId;
        $this->userId = $id;
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $this->items = Transaction::where('user_id', $this->userId)->where('status', 'waiting')->where('shop_id', $shop->id)->get();
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total += $item->qty == 0 ? $item->custom_price : $item->qty * $item->product->price;
        }
        $this->showTransaction = true;

        $user = User::findOrFail($this->userId);
        $this->address = json_decode($user->address);
    }

    public function transactionStoredHandler()
    {
        $this->closeTransactionHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil dibuat');
    }

    public function emptyStock($id)
    {
        $this->closeTransactionHandler();
        $this->emptyStock = true;
        $this->showTransaction = true;
        $this->emit('emptyStockTrx', $id, $this->trxId);
    }

    public function closeStockHandler()
    {
        $this->closeTransactionHandler();
        $this->showTransaction = true;
    }

    public function successEmptyStockHandler($name)
    {
        $this->closeTransactionHandler();
        $this->indexTransaction = true;
        session()->flash('color', 'green');
        session()->flash('message', 'Berhasil menghapus ' . $name . ' dari transaksi ini');
    }

    public function transactionUpdateHandler()
    {
        $this->closeTransactionHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk berhasil diubah');
    }

    public function transactionProhibitedHandler($action)
    {
        $this->closeTransactionHandler();
        session()->flash('color', 'red');
        session()->flash('message', 'Kamu tidak diizinkan untuk ' . $action . ' produk');
    }

    public function deleteTransaction($id)
    {
        if (Auth::user()->hasRole('super-admin') or request()->user()->hasPermissionTo('delete transactions')) {
            $this->closeTransactionHandler();
            $this->deleteTransaction = true;
            $this->emit('deleteTransaction', $id); // Transaction/Delete.php
        } else {
            $this->emit('transactionProhibited', 'delete');
        }
    }

    public function transactionDestroyedHandler($name)
    {
        $this->closeTransactionHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Produk ' . $name . ' berhasil dihapus');
    }

    public function sendOrder()
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        foreach ($this->items as $key => $item) {
            Transaction::where('user_id', $this->userId)->where('status', 'waiting')->where('shop_id', $shop->id)->update(['status' => 'delivery']);
        }
        $this->closeTransactionHandler();
        $this->reset(['indexTransaction']);
        session()->flash('color', 'green');
        session()->flash('message', 'Berhasil konfirmasi pemesanan. Barang dalam perjalanan');
    }
}
