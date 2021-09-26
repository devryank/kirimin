<div>
    <div class="flex-flex-wrap">
        <div class="w-full my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center dark:text-white">
                Ubah Toko
            </p>
            <div class="leading-loose">
                <form wire:submit.prevent="update" method="post"
                    class="p-5 bg-white dark:bg-gray-800 rounded shadow-xl">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-12 gap-4">
                        <div class="md:col-span-4 sm:col-span-12 dark:text-white">
                            <label class="block text-sm text-gray-600 dark:text-white" for="name">Nama Warung</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('name') border-2 border-red-300 @enderror"
                                id="name" type="text" required aria-label="Nama" wire:model="name">
                            @error('name')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="md:col-span-4 sm:col-span-12 dark:text-white">
                            <label class="block text-sm text-gray-600 dark:text-white" for="photo">Foto Toko</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('photo') border-2 border-red-300 @enderror"
                                id="photo" type="file" required aria-label="Nama" wire:model="photo">
                            @error('photo')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="md:col-span-4 sm:col-span-12 dark:text-white">
                            @if ($defaultPhoto AND empty($photo))
                            <img src="{{ asset('storage/toko/' . $defaultPhoto) }}" class="w-full">
                            @elseif($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full">
                            @else
                            <img src="{{ asset('storage/placeholder.png') }}" class="w-full">
                            <div wire:loading wire:target="photo">
                                Sedang mengupload ...
                            </div>
                            @endif
                        </div>

                        <div class="md:col-span-12 sm:col-span-12 dark:text-white">
                            <label class="block text-sm text-gray-600 dark:text-white">Alamat</label>
                            <input id="new" type="radio" required aria-label="Alamat" wire:model="address" value="new">
                            <label for="new">Gunakan alamat baru</label>
                            <br>
                            <input id="user" type="radio" required aria-label="Alamat" wire:model="address"
                                value="user"> <label for="user">Gunakan alamat akun</label>
                        </div>

                        @if ($address == 'new')
                        <div class="md:col-span-4 sm:col-span-12">
                            <label class="block text-sm text-gray-600 dark:text-white" for="jalan">Nama
                                Jalan</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('jalan') border-2 border-red-300 @enderror"
                                id="jalan" type="text" required aria-label="Nama Jalan" wire:model="jalan">
                            @error('jalan')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="rt">RT</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('rt') border-2 border-red-300 @enderror"
                                id="rt" type="number" required wire:model="rt">
                            @error('rt')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="rw">RW</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('rw') border-2 border-red-300 @enderror"
                                id="rw" type="number" required wire:model="rw">
                            @error('rw')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="no">Nomor</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('no') border-2 border-red-300 @enderror"
                                id="no" type="number" required wire:model="no">
                            @error('no')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kodepos">Kode Pos</label>
                            <input
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('kodepos') border-2 border-red-300 @enderror"
                                id="kodepos" type="number" required wire:model="kodepos">
                            @error('kodepos')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="province">Provinsi</label>
                            <select
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('province') border-2 border-red-300 @enderror"
                                name="province" id="province" required wire:model="province">
                                <option>-- Pilih Provinsi --</option>
                                @foreach ($provinces->provinsi as $province)
                                <option value="{{ $province->id }}">{{ $province->nama }}</option>
                                @endforeach
                            </select>
                            @error('province')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="city">Kota/Kabupaten</label>
                            <select
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('city') border-2 border-red-300 @enderror"
                                name="city" id="city" required wire:model="city">
                                @if ($listCity)
                                <option>-- Pilih Kota --</option>
                                @foreach ($listCity as $city)
                                <option value="{{ $city->id }}">{{ $city->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('city')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kecamatan">Kecamatan</label>
                            <select
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('kecamatan') border-2 border-red-300 @enderror"
                                name="kecamatan" id="kecamatan" required wire:model="kecamatan">
                                @if ($listKecamatan)
                                <option>-- Pilih Kota --</option>
                                @foreach ($listKecamatan as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('kecamatan')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kelurahan">Kelurahan</label>
                            <select
                                class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded @error('kelurahan') border-2 border-red-300 @enderror"
                                name="kelurahan" id="kelurahan" required wire:model="kelurahan">
                                @if ($listKelurahan)
                                <option>-- Pilih Kota --</option>
                                @foreach ($listKelurahan as $kelurahan)
                                <option value="{{ $kelurahan->id }}">{{ $kelurahan->nama }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('kelurahan')
                            <small class="text-red-500">{{$message}}</small>
                            @enderror
                        </div>
                        @endif

                        @if ($address == 'user' or empty($address))
                        <div class="md:col-span-4 sm:col-span-12">
                            <label class="block text-sm text-gray-600 dark:text-white" for="jalan">Nama
                                Jalan</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="jalan" type="text"
                                required aria-label="Nama Jalan" wire:model="jalan">
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="rt">RT</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="rt" type="number"
                                required wire:model="rt">
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="rw">RW</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="rw" type="number"
                                required wire:model="rw">
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="no">Nomor</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="no" type="number"
                                required disabled wire:model="no">
                        </div>
                        <div class="md:col-span-2 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kodepos">Kode Pos</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="kodepos" type="number"
                                required disabled wire:model="kodepos">
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="province">Provinsi</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="province" type="text"
                                required disabled wire:model="province">
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="city">Kota/Kabupaten</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="city" type="text"
                                required disabled wire:model="city">
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kecamatan">Kecamatan</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="kecamatan" type="text"
                                required disabled wire:model="kecamatan">
                        </div>
                        <div class="md:col-span-3 sm:col-span-6">
                            <label class="block text-sm text-gray-600 dark:text-white" for="kelurahan">Kelurahan</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="kelurahan" type="text"
                                required disabled wire:model="kelurahan">
                        </div>
                        @endif
                    </div>
                    <div class="mt-6">
                        <button
                            class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded"
                            type="submit">Ubah</button>
                        <button wire:click.prevent="$emit('closeShop')"
                            class="px-4 py-1 text-white font-light tracking-wider bg-red-700 rounded">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>