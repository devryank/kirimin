<div>
    <div wire:loading class="dark:text-white">
        Please wait ...
    </div>
    @if ($createProduct)
    @livewire('product.create')
    @endif
    @if ($editProduct)
    @livewire('product.update')
    @endif
    @if ($deleteProduct)
    @livewire('product.delete')
    @endif
    <h1 class="text-3xl text-black dark:text-white pb-6">Produk</h1>

    @if (session()->has('message'))
    {{-- alert --}}
    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-{{session('color')}}-500 alert">
        <span class="text-xl inline-block mr-5 align-middle">
            @if (session('color') == 'red')
            <i class="fas fa-info-circle"></i>
            @else
            <i class="fas fa-check"></i>
            @endif
        </span>
        <span class="inline-block align-middle mr-8">
            {{session('message')}}
        </span>
        <button
            class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
            onclick="closeAlert(event)">
            <span>×</span>

        </button>
    </div>
    @endif

    <div class="w-full">

        <div class="px-5 py-5 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="hidden sm:hidden md:block">
                <div class="grid grid-cols-6">
                    @if(Auth::user()->hasPermissionTo('create products'))
                    <div>
                        <button wire:click="createProduct"
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
                    @if(Auth::user()->hasPermissionTo('create products'))
                    <div>
                        <button wire:click="createProduct"
                            class="px-4 py-2 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded">Add</button>
                    </div>
                    @endif
                    <div class="col-start-3 text-right">
                        <div class="grid grid-cols-2">
                            <div>
                                <select wire:model="paginate" class="py-2 bg-gray-200">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <div>
                                <input wire:model="search" type="text" class="py-2 bg-gray-200" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-auto mt-5">
                <table class="min-w-full bg-white dark:bg-gray-800"
                    style="width:100%; padding-top: 1em; padding-bottom: 1em;">
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

                                    @if ((Auth::user()->hasPermissionTo('update products') AND Auth::user()->id ==
                                    $product->shop->user_id)
                                    OR Auth::user()->hasRole('super-admin'))
                                    <button wire:click="editProduct({{$product->id}})"
                                        class="px-3 py-2 text-white font-light tracking-wider bg-yellow-700 rounded">Ubah</button>
                                    @endif

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
    </div>

    @push('js')
    <script>
        function closeAlert(event){
          let element = event.target;
          while(element.nodeName !== "BUTTON"){
            element = element.parentNode;
          }
          element.parentNode.parentNode.removeChild(element.parentNode);
        }

    </script>
    @endpush
</div>