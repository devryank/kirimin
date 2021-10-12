<?php

namespace App\Http\Livewire\Delivery;

use Livewire\Component;
use App\Models\Transaction;

class Success extends Component
{
    public $deliveryId;
    public $name;

    protected $listeners = [
        'successDelivery' => 'successDeliveryHandler',
    ];

    public function render()
    {
        return view('livewire.delivery.success', [
            'name' => $this->name,
        ]);
    }

    public function successDeliveryHandler($id)
    {
        $delivery = Transaction::findOrFail($id);
        $this->deliveryId = $delivery->id;
        $this->name = $delivery->product->name;
    }

    public function CheckDelivery()
    {
        $delivery = Transaction::find($this->deliveryId);
        $name = $delivery->product->name;
        Transaction::where('id', $this->deliveryId)->update(['status' => 'success']);
        $this->emit('deliverySuccess', $name);
    }
}
