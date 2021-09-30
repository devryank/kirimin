<div>
    @foreach ($items as $key => $item)
    Toko: {{$item->product->shop->name}}
    <p>ID: {{$item->id}}</p>
    <p>Nama Barang: {{ $item->product->name }}</p>
    <p>Jumlah: {{ $item->qty }}</p>
    <img src="{{ asset('storage/' . $item->product->photo) }}" alt="">
    @if ($addQty AND $key == $tagId)
    <div class="flex flex-row mx-auto h-10 w-2/4 rounded-lg relative">
        <button wire:click="decreaseQty"
            class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
            <span class="m-auto">-</span>
        </button>
        <input type="hidden" class="md:p-2 p-1 text-xs md:text-base border-gray-400 focus:outline-none text-center"
            readonly name="custom-input-quantity" />
        <div class="bg-white w-24 text-xs md:text-base flex items-center justify-center cursor-default">
            <span>{{ $qty }}</span>
        </div>

        <button wire:click="increaseQty"
            class="font-semibold rounded-full border bg-gray-300 hover:bg-gray-400 text-gray-700 border-gray-400 h-full w-16 flex focus:outline-none cursor-pointer">
            <span class="m-auto">+</span>
        </button>

        <button wire:click="addToCart({{$item->product_id}})" class="px-3 py-2 bg-green-500 text-white"
            {{ $qty < 1 ? 'disabled' : '' }}>Order</button>
    </div>
    @else
    <button wire:click="createOrder({{$key}})" class="px-3 py-2 bg-green-500 text-white">Ubah</button>
    @endif
    @endforeach
</div>