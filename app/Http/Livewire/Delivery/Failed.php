<?php

namespace App\Http\Livewire\Delivery;

use Livewire\Component;
use App\Models\Transaction;

class Failed extends Component
{
    public $deliveryId;
    public $name;

    protected $listeners = [
        'failedDelivery' => 'failedDeliveryHandler',
    ];

    public function render()
    {
        return view('livewire.delivery.failed', [
            'name' => $this->name,
        ]);
    }

    public function failedDeliveryHandler($id)
    {
        $delivery = Transaction::findOrFail($id);
        $this->deliveryId = $delivery->id;
        $this->name = $delivery->product->name;
    }

    public function destroyDelivery()
    {
        $delivery = Transaction::find($this->deliveryId);
        $name = $delivery->product->name;
        Transaction::where('id', $this->deliveryId)->update(['status' => 'failed']);
        $this->emit('deliveryDestroyed', $name);
    }
}
