<?php

namespace App\Http\Livewire\Order;

use App\Models\Product;
use App\Models\Transaction;
use Livewire\Component;

class EmptyStock extends Component
{
    public $productId;
    public $name;
    public $trxId;

    protected $listeners = [
        'emptyStockTrx' => 'emptyStockTrxHandler',
    ];

    public function render()
    {
        return view('livewire.order.empty-stock', [
            'name' => $this->name,
        ]);
    }

    public function emptyStockTrxHandler($id, $trxId)
    {
        $this->trxId = $trxId;
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
    }

    public function removeFromDelivery()
    {
        $product = Product::find($this->productId);
        $name = $product->name;
        Transaction::where('id', $this->trxId)->update(['status' => 'empty']);
        $this->emit('successEmptyStock', $name);
    }
}
