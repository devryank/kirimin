<?php

namespace App\Http\Livewire\Product;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Update extends Component
{
    use WithFileUploads;

    public $productId;
    public $name;
    public $stock;
    public $defaultPhoto;
    public $photo;

    protected $listeners = [
        'productEdit' => 'productEditHandler',
    ];

    public function productEditHandler($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->defaultPhoto = $product->photo;
    }

    public function render()
    {
        return view('livewire.product.update', [
            'roles' => Role::all(),
        ]);
    }

    public function closeUpdateProductHandler()
    {
        $this->emit('closeUpdateProduct');
    }

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'stock' => ['required', 'in:ready,empty'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
        ]);

        if (request()->user()->hasPermissionTo('update products')) {
            if (empty($this->photo)) { // not change image
                $imageName = $this->defaultPhoto;
            } else { // change image 
                $imageName = date('mdYHis') . date('mdYHis') . $this->photo->getClientOriginalName();
                $this->photo->storeAs('/public', $imageName);
                @unlink('storage/' . $this->defaultPhoto);
            }
            $product = Product::findOrFail($this->productId);
            $product->update([
                'shop_id' => Shop::where('user_id', Auth::user()->id)->first()->id,
                'name' => $this->name,
                'stock' => $this->stock,
                'photo' => $imageName,
            ]);
            $this->emit('productStored');
        } else {
            $this->emit('productProhibited', 'update');
        }
    }
}
