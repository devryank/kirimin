<?php

namespace App\Http\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;

class DeleteProduct extends Component
{
    public $productId;
    public $name;

    protected $listeners = [
        'deleteProduct' => 'deleteProductHandler',
    ];

    public function render()
    {
        return view('livewire.shop.delete-product', [
            'name' => $this->name,
        ]);
    }

    public function deleteProductHandler($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
    }

    public function destroyProduct()
    {
        $product = Product::find($this->productId);
        if (request()->user()->hasRole('super-admin') or (request()->user()->hasPermissionTo('delete products') and Auth::user()->id == $product->shop->user_id)) {
            $name = $product->name;
            @unlink('storage/' . $product->photo);
            $product->delete();
            $this->emit('productDestroyed', $name);
        } else {
            $this->emit('userProhibited', 'delete');
        }
    }
}
