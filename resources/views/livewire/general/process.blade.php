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

            @endforeach
        </div>
        <div class="col-span-4">
            <div class="grid grid-cols-12">
                <div class="col-span-6">
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
            <div class="grid grid-cols-12">

                <div class="col-span-6">
                    Total:
                </div>
                <div class="col-span-6">
                    @foreach($carts as $key => $cart)
                    {{ "Rp " . number_format(array_values($cart)[0],0,',','.') }}
                    <br>
                    @endforeach
                </div>
                <div class="col-span-12">
                    <button class="w-full px-3 py-2 bg-green-500 text-white" wire:click="buyNow">Beli Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>