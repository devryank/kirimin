<div>
    <div wire:loading class="dark:text-white">
        Please wait ...
    </div>
    @if ($createShop)
    @livewire('shop.create')
    @endif
    @if ($editShop)
    @livewire('shop.update')
    @endif
    @if ($deleteShop)
    @livewire('shop.delete')
    @endif
    @if ($deleteProduct)
    @livewire('shop.delete-product')
    @endif
    <h1 class="text-3xl text-black dark:text-white pb-6">Toko</h1>

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
        @if (!$showProduct)
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
                    @if(Auth::user()->hasPermissionTo('create shops'))
                    <div>
                        <button wire:click="createShop"
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
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Toko</th>
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Pemilik</th>
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Alamat</th>
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-white">
                        @foreach ($shops as $shop)
                        <tr>
                            <td class="w-1/3 text-left py-3 px-4">{{$shop->name}}</td>
                            <td class="w-1/3 text-left py-3 px-4">{{$shop->user->name}}</td>
                            <td class="w-1/3 text-left py-3 px-4">
                                {{
                                $shop->address->jalan . ' ' .
                                $shop->address->rt . '/' .
                                $shop->address->rw . ' no.' .
                                $shop->address->no . ' ' .
                                $shop->address->kelurahan . ', ' .
                                $shop->address->kecamatan . ', ' .
                                $shop->address->kota . ', ' .
                                $shop->address->provinsi . ', ' .
                                $shop->address->kodepos
                                }}
                            </td>
                            <td class="w-1/3 text-left py-3 px-4">
                                <div class="flex space-x-2">

                                    @if ((Auth::user()->hasPermissionTo('update shops') AND Auth::user()->id ==
                                    $shop->id)
                                    OR Auth::user()->hasPermissionTo('update shops'))
                                    <button wire:click="editShop('{{$shop->id}}')"
                                        class="px-3 py-2 text-white font-light tracking-wider bg-yellow-700 rounded">Ubah</button>

                                    @endif

                                    @if (Auth::user()->hasRole('super-admin'))
                                    <button wire:click="showProduct('{{$shop->id}}')"
                                        class="px-3 py-2 text-white font-light tracking-wider bg-blue-700 rounded"
                                        onclick="scrollUp()">
                                        Produk
                                    </button>
                                    @endif

                                    @if ((Auth::user()->hasPermissionTo('delete shops') AND Auth::user()->id ==
                                    $shop->user_id)
                                    OR Auth::user()->hasRole('super-admin'))
                                    <button wire:click="deleteShop('{{$shop->id}}')"
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
            {{$shops->links()}}
        </div>
        @endif

        @if ($showProduct)
        @livewire('shop.show-product')
        @endif
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