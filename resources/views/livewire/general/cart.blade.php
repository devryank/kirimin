<div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-8">
            @foreach ($items as $key => $item)
            <h3 class="text-xl">{{$item->product->shop->name}}</h3>
            <p>ID: {{$item->id}}</p>
            <p>Nama Barang: {{ $item->product->name }}</p>
            <p>Jumlah:
                {{ $item->qty == 0 ? "Rp" . number_format($item->custom_price,0,',','.') : $item->qty . ' ' . $item->product->unit->name }}
            </p>
            <img src="{{ asset('storage/' . $item->product->photo) }}" alt="">
            @if ($addUnitQty AND $key == $tagId)
            <div class="flex flex-row mx-auto h-10 w-40 rounded-lg relative">
                <button wire:click="decreaseQty"
                    class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                    <span class="m-auto">-</span>
                </button>
                <input type="hidden"
                    class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center" readonly
                    name="custom-input-quantity" />
                <div class="bg-white w-24 text-xs md:text-base flex items-center justify-center cursor-default">
                    <span>{{ $unitQty }} {{ $item->product->unit->name }}</span>
                </div>

                <button wire:click="increaseQty"
                    class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                    <span class="m-auto">+</span>
                </button>

                <button wire:click="addToCart({{$item->product->id}})" class="px-3 py-2 bg-green-500 text-white"
                    {{ $unitQty < 1 ? 'disabled' : '' }}>Pesan</button>
            </div>

            @elseif ($addSingleQty AND $key == $tagId)
            <div class="flex flex-row mx-auto h-10 w-52 rounded-lg relative">
                <input type="number" class="w-full mr-2" wire:model="singleQty" placeholder="Contoh: 5000">
                <button wire:click="addToCart({{$item->product->id}})" class="px-3 py-2 bg-green-500 text-white"
                    {{ $singleQty < 1 ? 'disabled' : '' }}>Pesan</button>
            </div>
            @else
            <button wire:click="createOrderUnit({{$key}})" class="px-3 py-2 bg-green-500 text-white">Ubah
                Satuan</button>
            @if ($item->product->custom_price)
            <button wire:click="createOrderSingle({{$key}})" class="px-3 py-2 bg-green-500 text-white">Ubah
                Eceran</button>
            @endif
            @endif
            @endforeach
        </div>
        <div class="col-span-4">
            @foreach($carts as $key => $cart)
                <input type="radio" name="shop" wire:model="selectShop"> {{ $key }}
            @endforeach
        </div>
    </div>
</div>