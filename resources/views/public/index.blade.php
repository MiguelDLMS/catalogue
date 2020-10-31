@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet">
@endpush

@push('content')
    <div class="row my-4">
        @forelse ( $products as $product )
            <x-ProductCard :productID="$product['ID_Product']" :productName="$product['Name']" :productDescription="$product['Description']" :imageName="$product['Images'][0]['Name']" />
        @empty
            <div class="col">
                <div class="col">
                    <div class="row my-2">
                        <img class="col-2 img-fluid mx-auto" src="{{ asset('images/magnifying-glass-1976105_640.png') }}" alt="">
                        <h2 class="text-center">No hemos podido encontrar productos en la base de datos.</h2>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <!-- /.row -->

    <row class="row my-4 justify-content-center">
        {{ $products->links() }}
    </row>
    <!-- /.row -->
@endpush