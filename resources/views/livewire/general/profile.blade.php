@push('css')
<style>
    #pagination nav p {
        margin-right: 20px;
    }
</style>
@endpush

<div>
    <div class="flex justify-center">
        <button class="bg-green-300 hover:bg-green-400 h-12 w-12 rounded-full p-3 mr-5" wire:click="profile">
            <i class="fas fa-user text-white"></i>
        </button>
        <button class="bg-green-300 hover:bg-green-400 h-12 w-12 rounded-full p-3" wire:click="historyTrx">
            <i class="fas fa-shopping-cart text-white"></i>
        </button>
    </div>


    @if ($profile)
    <div class="flex justify-center mt-10">
        <div class="w-1/2 border border-gray-300 rounded-lg p-4">
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

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3">
                    <img src="{{ asset('storage/profile/' . $user->profile_photo_path) }}"
                        class="h-32 w-32 rounded-full object-cover">
                </div>
                <div class="col-start-5 col-span-8">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-3 flex items-center">
                            Nama
                        </div>
                        <div class="col-span-9">
                            : {{$user->name}}
                        </div>
                        <div class="col-span-3 flex items-center">
                            Email
                        </div>
                        <div class="col-span-9">
                            : {{$user->email}}
                        </div>
                        <div class="col-span-3 flex items-center">
                            No HP
                        </div>
                        <div class="col-span-9">
                            : {{$user->phone}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-10">
                <button class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white" wire:click="openUpdateProfile">Ubah
                    Profile</button>
            </div>
        </div>
    </div>
    @endif

    @if ($updateProfile)
    <div class="flex justify-center mt-10">
        <div class="w-1/2 border border-gray-300 rounded-lg p-4">
            <form wire:submit.prevent="updateProfile" method="POST">
                @csrf
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-3">
                        @if (empty($photo))
                        <img src="{{ asset('storage/profile/' . $defaultPhoto) }}"
                            class="h-32 w-32 object-cover rounded-full mb-3">
                        @elseif($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-full mb-3">
                        <div wire:loading wire:target="photo">
                            Sedang mengupload ...
                        </div>
                        @endif
                        <input type="file" wire:model="photo" style="width: 100px;">
                        @error('photo')
                        <small class="text-red-500">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-start-5 col-span-8">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-3 flex items-center">
                                Nama
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="name">
                                <br>
                                @error('name')
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-span-3 flex items-center">
                                Email
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="email">
                                <br>
                                @error('email')
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-span-3 flex items-center">
                                No HP
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="phone">
                                <br>
                                @error('phone')
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <hr>
                                <h3 class="text-md text-gray-600 my-2">Ubah Password (kosongkan jika tidak ingin diubah)
                                </h3>
                            </div>
                            <div class="col-span-3 items-center">
                                Password
                            </div>
                            <div class="col-span-9">
                                <input type="password" wire:model="password">
                                <br>
                                @error('password')
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-span-3 items-center">
                                Password Baru
                            </div>
                            <div class="col-span-9">
                                <input type="password" wire:model="password_confirmation">
                                <br>
                                @error('password')
                                <small class="text-red-500">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-10">
                    <button class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white mr-2"
                        type="submit">Simpan</button>
                    <button class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white" wire:click="cancel">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if ($historyTrx)
    <div class="flex justify-center mt-10">
        <div class="w-1/2 border border-gray-300 rounded-lg p-4">
            <div class="grid grid-cols-12 gap-4">
                @foreach ($trxs as $trx)
                <div class="col-span-2">
                    <a href="{{ route('general.show', $trx->product->shop->id) }}">
                        <img src="{{ asset('storage/' . $trx->product->photo) }}" alt="" class="w-full">
                    </a>
                </div>
                <div class="col-span-10">
                    <div class="flex">
                        <div class="flex-1">
                            <a href="{{ route('general.show', $trx->product->shop->id) }}">
                                <h3 class="text-lg font-bold">{{ $trx->product->shop->name }}</h3>
                            </a>
                        </div>
                        <div class="flex-1 text-right">
                            @if ($trx->status == 'cart')
                            <span class="px-2 py-1 bg-gray-400 text-white text-sm rounded-full">Di Keranjang</span>
                            @elseif($trx->status == 'process')
                            <span class="px-2 py-1 bg-blue-400 text-white text-sm rounded-full">Menunggu
                                Pembayaran</span>
                            @elseif($trx->status == 'waiting')
                            <span class="px-2 py-1 bg-purple-400 text-white text-sm rounded-full">Menunggu
                                Verifikasi</span>
                            @elseif($trx->status == 'delivery')
                            <span class="px-2 py-1 bg-indigo-400 text-white text-sm rounded-full">Dalam
                                Pengiriman</span>
                            @elseif($trx->status == 'success')
                            <span class="px-2 py-1 bg-green-400 text-white text-sm rounded-full">Selesai</span>
                            @elseif($trx->status == 'failed')
                            <span class="px-2 py-1 bg-red-400 text-white text-sm rounded-full">Gagal</span>
                            @endif
                        </div>
                    </div>
                    <hr class="my-2">
                    <p>{{ $trx->product->name }} {{ $trx->qty !== 0 ? ' - ' . $trx->qty . ' ' .
                        $trx->product->unit->name : '' }}</p>
                    <p>{{ $trx->custom_price == 0 ?
                        "Rp" . number_format($trx->product->price * $trx->qty,0,',','.') :
                        "Rp" . number_format($trx->custom_price,0,',','.') }}
                    </p>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-12 gap-4 my-8">
                <div class="col-span-12 mx-auto" id="pagination">
                    {{$trxs->links()}}
                </div>
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