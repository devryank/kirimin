<div>
    <div class="grid grid-cols-12 gap-4 mx-3">
        <div class="col-span-12 md:col-span-8">
            @foreach ($items as $key => $item)
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-2">
                    <img src="{{ asset('storage/' . $item->product->photo) }}" alt="">
                </div>
                <div class="col-span-5">
                    <p class="text-sm md:text-base"><span class="text-gray-500">Nama Barang:</span>
                        {{ $item->product->name }}</p>
                    <p class="text-sm md:text-base"><span class="text-gray-500">Jumlah:</span>
                        {{ $item->qty == 0 ? "Rp" . number_format($item->custom_price,0,',','.') : $item->qty . ' ' . $item->product->unit->name }}
                    </p>
                    <p class="text-sm md:text-base"><span class="text-gray-500">Harga:</span>
                        {{ $item->qty == 0 ? "Rp" . number_format($item->custom_price,0,',','.') : "Rp" . number_format($item->qty * $item->product->price,0,',','.') }}
                    </p>
                </div>
            </div>

            <div class="col-span-12 my-2">
                <hr>
            </div>
            @endforeach
        </div>
        <div class="col-span-4">
            <div class="grid grid-cols-12">
                <div class="col-span-6 flex items-center">
                    Metode Pembayaran:
                </div>
                <div class="col-span-6">
                    <select class="w-full" wire:model="method">
                        <option>--Pilih--</option>
                        @foreach ($methods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-12 my-5">
                <div class="col-span-6">
                    Total:
                </div>
                <div class="col-span-6">
                    @foreach($carts as $key => $cart)
                    {{ "Rp " . number_format(array_values($cart)[0],0,',','.') }}
                    <br>
                    @endforeach
                </div>
                <div class="col-span-12 my-5">
                    <div class="flex">
                        <div class="flex-1 mr-1">
                            <button class="w-full px-3 py-2 bg-red-500 hover:bg-red-600 text-white"
                                wire:click="cancel">Batal</button>
                        </div>
                        <div class="flex-1">
                            <button class="w-full px-3 py-2 bg-green-500 hover:bg-green-600 text-white"
                                wire:click="buyNow">Beli
                                Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>