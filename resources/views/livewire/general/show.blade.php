<div>
    <div class="h-96">
        <img src="{{ asset('storage/toko/' . $shop->photo) }}" class="w-full h-full object-cover">
    </div>
    <h1 class="m-4 text-2xl font-bold">{{ $shop->name }}</h1>

    <div class="grid grid-cols-12 gap-4 m-4">
        <div class="col-span-8 h-56">
            <h2 class="text-xl font-bold">
                Produk
            </h2>
            <div class="product border border-black rounded-lg">
                @foreach ($products as $key => $product)
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-2">
                        <img src="{{ asset('storage/' . $product->photo) }}" class="w-full">
                    </div>
                    <div class="col-span-6">
                        {{$product->name}}
                    </div>
                    <div class="col-span-4">
                        @if ($addUnitQty AND $key == $tagId)
                        <div class="flex flex-row mx-auto h-10 w-40 rounded-lg relative">
                            <button wire:click="decreaseQty"
                                class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                                <span class="m-auto">-</span>
                            </button>
                            <input type="hidden"
                                class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center"
                                readonly name="custom-input-quantity" />
                            <div
                                class="bg-white w-24 text-xs md:text-base flex items-center justify-center cursor-default">
                                <span>{{ $unitQty }} {{ $product->unit->name }}</span>
                            </div>

                            <button wire:click="increaseQty"
                                class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                                <span class="m-auto">+</span>
                            </button>

                            <button wire:click="addToCart({{$product->id}})" class="px-3 py-2 bg-green-500 text-white"
                                {{ $unitQty < 1 ? 'disabled' : '' }}>Pesan</button>
                        </div>

                        @elseif ($addSingleQty AND $key == $tagId)
                        <div class="flex flex-row mx-auto h-10 w-52 rounded-lg relative">
                            <input type="number" class="w-full mr-2" wire:model="singleQty" placeholder="Contoh: 5000">
                            <button wire:click="addToCart({{$product->id}})" class="px-3 py-2 bg-green-500 text-white"
                                {{ $singleQty < 1 ? 'disabled' : '' }}>Pesan</button>
                        </div>
                        @else
                        <button wire:click="createOrderUnit({{$key}})" class="px-3 py-2 bg-green-500 text-white">
                            Beli Satuan
                        </button>
                        @if ($product->custom_price)
                        <button wire:click="createOrderSingle({{$key}})" class="px-3 py-2 bg-green-500 text-white">
                            Beli Eceran
                        </button>
                        @endif
                        @endif
                    </div>
                    <div class="col-span-12">
                        <hr>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
    </div>
</div>