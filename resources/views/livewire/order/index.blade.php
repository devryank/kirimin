<div>
    <div wire:loading class="dark:text-white">
        Please wait ...
    </div>
    <h1 class="text-3xl text-black dark:text-white pb-6">Pesanan</h1>

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

    @if ($indexTransaction)
    <div class="w-full">

        <div class="px-5 py-5 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="hidden sm:hidden md:block">
                <div class="grid grid-cols-6">
                    @if(Auth::user()->hasPermissionTo('create transactions'))
                    <div>
                        <button wire:click="createTransaction"
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
                    </div>
                </div>
            </div>
            <div class="sm:block md:hidden">
                <div class="grid grid-cols-4">
                    @if(Auth::user()->hasPermissionTo('create transactions'))
                    <div>
                        <button wire:click="createTransaction"
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
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Pembeli</th>
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Pemesanan</th>
                            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-white">
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td class="w-1/3 text-left py-3 px-4">{{$transaction->user->name}}</td>
                            <td class="w-1/3 text-left py-3 px-4">
                                {{date('H:i:s - d F Y', strtotime($transaction->created_at))}}
                            </td>
                            <td class="w-1/3 text-left py-3 px-4">
                                <div class="flex space-x-2">
                                    @if ((Auth::user()->hasPermissionTo('read transactions'))
                                    OR Auth::user()->hasRole('super-admin'))
                                    <button wire:click="showTransaction({{$transaction->user_id}})"
                                        class="px-3 py-2 text-white font-light tracking-wider bg-blue-700 rounded"
                                        onclick="scrollUp()">
                                        Detail
                                    </button>
                                    @endif
                                    @if ((Auth::user()->hasPermissionTo('delete transactions'))
                                    OR Auth::user()->hasRole('super-admin'))
                                    <button wire:click="deleteTransaction({{$transaction->id}})"
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
            {{$transactions->links()}}
        </div>
    </div>
    @endif

    @if ($showTransaction)
    <div class="w-full">
        <div class="bg-white dark:bg-gray-800 overflow-auto mt-5">
            <table class="min-w-full bg-white dark:bg-gray-800"
                style="width:100%; padding-top: 1em; padding-bottom: 1em;">
                <thead class="bg-gray-800 text-white dark:bg-gray-900">
                    <tr>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Produk</th>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Jumlah</th>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-white">
                    @foreach ($items as $item)
                    <tr>
                        <td class="w-1/3 text-left py-3 px-4">{{$item->product->name}}</td>
                        <td class="w-1/3 text-left py-3 px-4">
                            {{ $item->qty == 0 ? "Rp " . number_format($item->custom_price,0,',','.') : $item->qty . ' '
                            . $item->product->unit->name }}
                        </td>
                        <td class="w-1/3 text-left py-3 px-4">
                            {{ $item->qty == 0 ? "Rp " . number_format($item->custom_price,0,',','.') : "Rp " .
                            number_format($item->qty * $item->product->price,0,',','.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="grid grid-cols-12 gap-4 mt-5">
            <div class="col-span-6">
                <h3 class="text-xl dark:text-white">Total: {{ "Rp " . number_format($total,0,',','.') }}</h3>
            </div>
            <div class="col-span-6 text-right">
                <button class="px-3 py-2 text-white font-light tracking-wider bg-blue-700 rounded"
                    wire:click="sendOrder">
                    Kirim Pesanan
                </button>
            </div>
        </div>
    </div>
    @endif

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