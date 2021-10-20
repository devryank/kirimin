<div>
    <div class="h-96">
        <img src="{{ asset('storage/toko/' . $shop->photo) }}" class="w-full h-full object-cover">
    </div>
    <h1 class="m-4 text-2xl font-bold">{{ $shop->name }}</h1>

    <div class="grid grid-cols-12 gap-4 mx-auto">
        <div class="col-span-12 lg:col-start-4 lg:col-span-6">
            <div class="px-2">
                @if ($products->count() == 0)
                <h3 class="text-xl font-bold text-center my-5">Tidak ada produk yang tersedia</h3>
                @endif
                @foreach ($products as $key => $product)
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-3 lg:col-span-2">
                        <img src="{{ asset('storage/' . $product->photo) }}" class="w-full">
                    </div>
                    <div class="col-span-4 lg:col-span-6 flex items-center">
                        {{$product->name}}
                        <br>
                        {{ "Rp" . number_format($product->price,0,',','.') }}
                    </div>
                    <div class="col-span-4 lg:col-span-4 md:flex md:items-center md:justify-center">
                        @if ($addUnitQty AND $key == $tagId)
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-8 flex">
                                <button wire:click="decreaseQty"
                                    class="mt-1 font-semibold rounded-full border bg-green-500 hover:bg-green-600 text-white h-8 w-16 focus:outline-none cursor-pointer">
                                    <span class="m-auto">-</span>
                                </button>
                                <input type="hidden"
                                    class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center"
                                    readonly name="custom-input-quantity" />
                                <div
                                    class="bg-white w-24 text-xs md:text-base flex items-center justify-center cursor-default">
                                    <span class="text-sm">{{ $unitQty }} {{ $product->unit->name }}</span>
                                </div>
                                <button wire:click="increaseQty"
                                    class="mt-1 font-semibold rounded-full border bg-green-500 hover:bg-green-600 text-white h-8 w-16 focus:outline-none cursor-pointer">
                                    <span class="m-auto">+</span>
                                </button>
                            </div>
                            <div class="col-span-12">
                                <button wire:click="cancel"
                                    class="ml-2 px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs md:text-md">Batal</button>
                                <button wire:click="addToCart({{$product->id}})"
                                    class="ml-2 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md"
                                    {{ $unitQty < 1 ? 'disabled' : '' }}>Pesan</button>
                            </div>
                        </div>

                        @elseif ($addSingleQty AND $key == $tagId)
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-8 flex">
                                <input type="number" class="w-full mr-2" wire:model="singleQty"
                                    placeholder="Contoh: 5000">
                            </div>
                            <div class="col-span-12 flex">
                                <button wire:click="addToCart({{$product->id}})"
                                    class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md" {{
                                    $singleQty < 1 ? 'disabled' : '' }}>Pesan</button>
                                <button wire:click="cancel"
                                    class="ml-2 px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs md:text-md">Batal</button>
                            </div>
                        </div>
                        @else
                        <div class="md:flex">
                            <button wire:click="createOrderUnit({{$key}})"
                                class="flex-1 mr-2 mb-2 md:mb-0 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md"
                                style="white-space: nowrap">
                                Beli per {{ $product->unit->name }}
                            </button>
                            @if ($product->custom_price)
                            <button wire:click="createOrderSingle({{$key}})"
                                class="flex-1 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md"
                                style="white-space: nowrap">
                                Beli Eceran
                            </button>
                            @endif
                        </div>
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