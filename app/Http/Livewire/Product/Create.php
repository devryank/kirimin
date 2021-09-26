<?php

namespace App\Http\Livewire\Product;

use App\Models\Shop;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $stock;
    public $photo;

    protected $listeners = [
        'closeCreateProduct' => 'closeCreateProductHandler',
    ];

    public function render()
    {
        return view('livewire.product.create', [
            'roles' => Role::all(),
        ]);
    }

    public function closeCreateProductHandler()
    {
        $this->emit('closeCreateProduct');
    }

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'stock' => ['required', 'in:ready,empty'],
            'photo' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
        ]);

        if (request()->user()->hasPermissionTo('create products')) {
            $imageName = date('mdYHis') . date('mdYHis') . $this->photo->getClientOriginalName();
            Product::create([
                'shop_id' => Shop::where('user_id', Auth::user()->id)->first()->id,
                'name' => $this->name,
                'stock' => $this->stock,
                'photo' => $imageName,
            ]);
            $this->photo->storeAs('/public', $imageName);
            $this->emit('productStored');
        } else {
            $this->emit('productProhibited', 'create');
        }
    }
}
