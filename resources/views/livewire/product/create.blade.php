<div>
    <div class="flex-flex-wrap">
        <div class="w-full my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center dark:text-white">
                Tambah Produk
            </p>
            <div class="leading-loose">
                <form wire:submit.prevent="store" method="post" class="p-5 bg-white dark:bg-gray-800 rounded shadow-xl">
                    @csrf
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="name">Nama</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('name') border-2 border-red-300 @enderror"
                                id="name" type="text" required="" aria-label="Name" wire:model="name">
                            @error('name')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="stock">Stok</label>
                            <select id="stock" wire:model="stock"
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('stock') border-2 border-red-300 @enderror">
                                <option>-- Pilih Stok --</option>
                                <option value="ready">Tersedia</option>
                                <option value="empty">Habis</option>
                            </select>
                            @error('stock')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="unitId">Satuan</label>
                            <select id="unitId" wire:model="unitId"
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('unitId') border-2 border-red-300 @enderror">
                                <option>-- Pilih Satuan --</option>
                                @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @error('unitId')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-span-6 dark:text-white">
                            <label class="block text-sm text-gray-600 dark:text-white" for="customPrice">Pembeli boleh
                                membeli
                                eceran?</label>
                            <input type="radio" wire:model="customPrice" value="1"> Ya
                            <br>
                            <input type="radio" wire:model="customPrice" value="0"> Tidak
                            @error('customPrice')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="photo">Foto Produk</label>
                            <input type="file"
                                class="w-full px-5 py-1 text-gray-700 rounded @error('stock') border-2 border-red-300 @enderror"
                                id="photo" wire:model="photo">
                            @error('photo')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-span-6">
                            @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full">
                            @else
                            <img src="{{ asset('storage/placeholder.png') }}" class="w-full">
                            <div wire:loading wire:target="photo">
                                Sedang mengupload ...
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        <button
                            class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded"
                            type="submit">Tambah</button>
                        <button wire:click.prevent="$emit('closeProduct')"
                            class="px-4 py-1 text-white font-light tracking-wider bg-red-700 rounded">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>