@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet">
@endpush

@push('content')
    <div class="col-lg-8">
        <div class="row my-4">
            <h3>{{ $category }}</h3>
        </div>

        <div class="row">
            @forelse ( $products as $product )
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="{{ url('/product/'.$product['ID_Product']) }}"><img class="card-img-top" src="{{ asset('img/products/'.$product['Images'][0]['Name']) }}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ url('/product/'.$product['ID_Product']) }}">{{ $product['Name'] }}</a>
                            </h4>
                            <p class="card-text">{{ $product['Description'] }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ url('/product/'.$product['ID_Product']) }}" class="btn btn-success float-right">Ver</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="col">
                        <div class="row my-2">
                            <img class="col-2 img-fluid mx-auto" src="{{ asset('img/magnifying-glass-1976105_640.png') }}" alt="">
                            <h2 class="text-center">No hemos podido encontrar productos en la base de datos.</h2>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- /.row -->

    </div>
    <!-- /.col-lg-9 -->
@endpush