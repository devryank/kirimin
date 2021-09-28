@extends('layouts.general')

@section('content')
<section>
    <div class="h-96">
        <img src="{{ asset('storage/toko/' . $shop->photo) }}" class="w-full h-full object-cover">
    </div>
    <h1 class="m-4 text-2xl font-bold">{{ $shop->name }}</h1>

    <div class="grid grid-cols-12 gap-4 m-4">
        <div class="col-span-8 h-56">
            <h2 class="text-xl font-bold">
                Produk
            </h2>
            <div class="product border border-black rounded-lg">
                @foreach ($products as $product)
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-2">
                        <img src="{{ 'storage/' . $product->photo }}" class="w-full">
                    </div>
                    <div class="col-span-8">
                        {{$product->name}}
                    </div>
                    <div class="col-span-2">

                    </div>
                    <div class="col-span-12">
                        <hr>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection