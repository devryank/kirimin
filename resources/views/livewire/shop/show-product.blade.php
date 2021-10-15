<div class="px-5 py-5 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="hidden sm:hidden md:block">
        <div class="grid grid-cols-6">
            @if(Auth::user()->hasPermissionTo('create shops'))
            <div>
                <button wire:click="createShop"
                    class="px-4 py-2 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded">Tambah</button>
            </div>
            @endif
            <div class="col-start-3 col-span-4 text-right">
                <select wire:model="paginate" class="px-5 py-2 bg-gray-200">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input wire:model="search" type="text" class="px-3 py-2 bg-gray-200" placeholder="Search">
            </div>
        </div>
    </div>
    <div class="sm:block md:hidden">
        <div class="grid grid-cols-4">
            <div class="col-start-3 text-right">
                <div class="grid grid-cols-2">
                    <div>
                        <select wire:model="paginateProduct" class="py-2 bg-gray-200">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                    <div>
                        <input wire:model="searchProduct" type="text" class="py-2 bg-gray-200" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-auto mt-5">
        <table class="min-w-full bg-white dark:bg-gray-800" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead class="bg-gray-800 text-white dark:bg-gray-900">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Stok</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Foto</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-white">
                @foreach ($products as $product)
                <tr>
                    <td class="w-1/3 text-left py-3 px-4">{{$product->name}}</td>
                    <td class="w-1/3 text-left py-3 px-4">
                        @if ($product->stock == 'ready')
                        Tersedia
                        @else
                        Tidak tersedia
                        @endif
                    </td>
                    <td class="w-1/3 text-left py-3 px-4"><img src="{{ asset('storage/' . $product->photo) }}"
                            class="w-full"></td>
                    <td class="w-1/3 text-left py-3 px-4">
                        <div class="flex space-x-2">
                            @if ((Auth::user()->hasPermissionTo('delete products') AND Auth::user()->id ==
                            $product->shop->user_id)
                            OR Auth::user()->hasRole('super-admin'))
                            <button wire:click="deleteProduct({{$product->id}})"
                                class="px-3 py-2 text-white font-light tracking-wider bg-red-700 rounded"
                                onclick="scrollUp()">
                                Hapus
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$products->links()}}
</div>