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
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3">
                    <img src="{{ asset('storage/profile/' . $user->profile_photo_path) }}"
                        class="h-full w-full rounded-full">
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
                        @if ($photo !== 'profile.png')
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full rounded-full mb-3">
                        @else
                        <img src="{{ asset('storage/profile/' . $photo) }}" class="rounded-full mb-3">
                        <div wire:loading wire:target="photo">
                            Sedang mengupload ...
                        </div>
                        @endif
                        <input type="file" wire:model="photo" style="width: 100px;">
                    </div>
                    <div class="col-start-5 col-span-8">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-3 flex items-center">
                                Nama
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="name">
                            </div>
                            <div class="col-span-3 flex items-center">
                                Email
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="email">
                            </div>
                            <div class="col-span-3 flex items-center">
                                No HP
                            </div>
                            <div class="col-span-9">
                                : <input type="text" wire:model="phone">
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

    @endif
</div>