<div>
    <h2 class="text-xl mx-6 mt-3 mb-6">Keranjang Kamu</h2>
    <div class="grid grid-cols-12 gap-4 mx-3">
        <div class="col-span-12 md:col-span-8">
            @foreach ($items as $key => $item)
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-2">
                    <img src="{{ asset('storage/' . $item->product->photo) }}" alt="">
                </div>
                <div class="col-span-5">
                    <h3 class="text-lg">{{$item->product->shop->name}}</h3>
                    <br>
                    <p class="text-sm md:text-base"><span class="text-gray-500">Nama Barang:</span>
                        {{ $item->product->name }}</p>
                    <p class="text-sm md:text-base"><span class="text-gray-500">Jumlah:</span>
                        {{ $item->qty == 0 ? "Rp" . number_format($item->custom_price,0,',','.') : $item->qty . ' ' .
                        $item->product->unit->name }}
                    </p>
                    <p class="text-sm md:text-base"><span class="text-gray-500">Harga:</span>
                        {{ $item->qty == 0 ? "Rp" . number_format($item->custom_price,0,',','.') : "Rp" .
                        number_format($item->qty * $item->product->price,0,',','.') }}
                    </p>
                </div>
                <div class="col-span-5 flex items-center">
                    @if ($addUnitQty AND $key == $tagId)
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-8 flex">
                            <button wire:click="decreaseQty"
                                class="mt-1 font-semibold rounded-full border bg-green-500 hover:bg-green-600 text-white h-8 w-16 sm:w-10 md:w-8 focus:outline-none cursor-pointer">
                                <span class="m-auto">-</span>
                            </button>
                            <input type="hidden"
                                class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center"
                                readonly name="custom-input-quantity" />
                            <div
                                class="bg-white w-16 text-xs md:text-base flex items-center justify-center cursor-default">
                                <span class="text-sm">{{ $unitQty }} {{ $item->product->unit->name }}</span>
                            </div>
                            <button wire:click="increaseQty"
                                class="mt-1 font-semibold rounded-full border bg-green-500 hover:bg-green-600 text-white h-8 w-16 sm:w-10 md:w-8 focus:outline-none cursor-pointer">
                                <span class="m-auto">+</span>
                            </button>
                        </div>
                        <div class="col-span-12">
                            <button wire:click="cancel"
                                class="ml-2 px-3 py-2 bg-red-500 text-white text-xs md:text-md">Batal</button>
                            <button wire:click="addToCart({{$item->product->id}})"
                                class="ml-2 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md" {{
                                $unitQty < 1 ? 'disabled' : '' }}>Pesan</button>
                        </div>
                    </div>

                    @elseif ($addSingleQty AND $key == $tagId)
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-8 md:col-span-6 lg:col-span-5 flex">
                            <input type="number" class="w-full mr-2" wire:model="singleQty" placeholder="Contoh: 5000">
                        </div>
                        <div class="col-span-12 flex">
                            <button wire:click="addToCart({{$item->product->id}})"
                                class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md" {{
                                $singleQty < 1 ? 'disabled' : '' }}>Pesan</button>
                            <button wire:click="cancel"
                                class="ml-2 px-3 py-2 bg-red-500 text-white text-xs md:text-md">Batal</button>
                        </div>
                    </div>
                    @else
                    <div class="md:flex">
                        <button wire:click="createOrderUnit({{$key}})"
                            class="mr-2 mb-2 md:mb-0 px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md"
                            style="white-space: nowrap">
                            Beli per {{ $item->product->unit->name }}
                        </button>
                        @if ($item->product->custom_price)
                        <button wire:click="createOrderSingle({{$key}})"
                            class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs md:text-md"
                            style="white-space: nowrap">
                            Beli Eceran
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-span-12 my-2">
                <hr>
            </div>
            @endforeach
        </div>
        <div class="col-span-12 md:col-span-4">
            <div class="grid grid-cols-12">
                <div class="col-span-6 text-sm md:text-base">
                    @foreach($carts as $key => $cart)
                    <label>
                        <input type="radio" name="shop" id="shop" wire:model="selectShop"
                            value="{{ array_keys($cart)[0] }}"> {{ array_keys($cart)[0] }}
                    </label>
                    <br>
                    @endforeach
                </div>
                <div class="col-span-6 text-sm md:text-base">
                    @foreach($carts as $key => $cart)
                    {{ "Rp " . number_format(array_values($cart)[0],0,',','.') }}
                    <br>
                    @endforeach
                </div>
                <div class="col-span-12 mt-5">
                    <button
                        class="w-full px-3 py-2 bg-green-500 {{ empty($selectShop) ? '' : 'hover:bg-green-600' }} disabled:opacity-60 text-white"
                        wire:click="process" {{ empty($selectShop) ? 'disabled' : '' }}>Proses</button>
                </div>
            </div>
        </div>
    </div>
</div>