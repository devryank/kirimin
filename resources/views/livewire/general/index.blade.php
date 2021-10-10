@push('css')
<style>
    #pagination nav p {
        margin-right: 20px;
    }
</style>
@endpush
<div>
    <section class="mx-4 py-3">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                Cari toko di lingkungan:
                <select class="w-32" wire:model="selectAddress">
                    <option value="rt">RT</option>
                    <option value="rw">RW</option>
                    <option value="kelurahan">Kelurahan</option>
                </select>
            </div>
            @if (empty($shops))
            <div class="col-span-12">
                Toko tidak ditemukan
            </div>
            @endif
            @foreach ($shops as $shop)
            <a href="{{ route('general.show', $shop->id) }}"
                class="col-span-3 max-w-sm rounded overflow-hidden shadow-lg">
                <img class="w-full" src="{{ asset('storage/toko/' . $shop->photo) }}" alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $shop->name }}</div>
                    <p class="leading-none text-sm">
                        {{ $shop->address->jalan . ' ' . $shop->address->rt . '/' . $shop->address->rw . ', ' . $shop->address->kelurahan . ', ' . $shop->address->kecamatan }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="grid grid-cols-12 gap-4 my-8">
            <div class="col-span-12 mx-auto" id="pagination">
                {{$shops->links()}}
            </div>
        </div>
    </section>
</div>