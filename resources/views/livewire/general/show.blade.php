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
                @foreach ($products as $product)
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-2">
                        <img src="{{ 'storage/' . $product->photo }}" class="w-full">
                    </div>
                    <div class="col-span-8">
                        {{$product->name}}
                    </div>
                    <div class="col-span-2">
                        @if ($addQty)
                        <div class="flex flex-row mx-auto h-10 w-2/4 rounded-lg relative">
                            <button
                                class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                                <span class="m-auto">-</span>
                            </button>
                            <input type="hidden"
                                class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center"
                                readonly name="custom-input-quantity" />
                            <div
                                class="bg-white w-24 text-xs md:text-base flex items-center justify-center cursor-default">
                                <span>0</span>
                            </div>

                            <button
                                class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
                                <span class="m-auto">+</span>
                            </button>
                        </div>
                        @else
                        <button wire:click.prevent="createOrder()"
                            class="px-3 py-2 text-white font-light tracking-wider bg-yellow-700 rounded">Ubah</button>
                        {{$qty}}
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