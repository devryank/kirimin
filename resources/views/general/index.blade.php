@extends('layouts.general')

@section('content')
<section class="ml-4 py-3">
    <div class="grid grid-cols-12 gap-4">
        @foreach ($shops as $shop)
        <a href="{{ route('general.show', $shop->id) }}" class="col-span-3 max-w-sm rounded overflow-hidden shadow-lg">
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
</section>
@endsection