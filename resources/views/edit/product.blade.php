@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-product-edit.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-jvectormap-2.0.5.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/css/ol.css" type="text/css">
@endpush

@push('content')
    <div class="col-lg-9 col-md-8 col-12">
        <div class="card mt-4">
             <div id="carouselExampleIndicators" class="carousel slide  card-img-top img-fluid" data-ride="carousel">
                <ol class="carousel-indicators">
                    @for ( $i = 0; $i < count($product['Images']); $i++ )
                        @if ($i == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="active"></li>
                        @else
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"></li>
                        @endif
                    @endfor
                </ol>
                <div class="carousel-inner" role="listbox">
                    @foreach ($product['Images'] as $image)
                        @if ($loop->first)
                            <div class="carousel-item active">
                                <img class="d-block img-fluid product-image" src="{{ asset('img/products/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img class="d-block img-fluid product-image" src="{{ asset('img/products/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                            </div>
                        @endif
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#quotation-request">Seleccionar imágenes</button>

            <form method="POST" action="{{ route('request.quote') }}">
                @csrf
                <div class="card-body">
                    <h3 class="card-title">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product['Name'] }}">
                    </h3>
                    <p class="card-text">
                        <input type="text" class="form-control" id="description" name="description" value="{{ $product['Description'] }}">
                    </p>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#quotation-request" disabled>Cotizar</button>
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Información técnica
                </div>
                
                <div class="card-body">
                    <input type="text" class="form-control" id="specifications" name="specifications" value="{{ $product['Technical_Specifications'] }}">
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Región
                </div>
                
                <div class="card-body">
                    <strong>Código del país: </strong><input type="text" class="form-control" id="specifications" name="specifications" value="MX">

                    <div id="map" class="map" country-code="MX"></div>
                </div>
            </div>
            <!-- /.card -->
        </form>
        
    </div>
    <!-- /.col-lg-8 -->
@endpush

@push('javascripts')
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>
    <script type="text/javascript">
        var code = $('#map').attr('country-code');
        var data = {
            [code]: "#1A2F40"
        };

        console.log(data);

        var map = $('#map').vectorMap({
            map: 'world_mill', // el mapa del mundo
            backgroundColor: 'white',
            regionStyle: {
                initial: {
                    fill: "#65BAFF"
                }
            },
            series: {
                regions: [{
                    values: data, // los valores
                    attribute: 'fill',
                    normalizeFunction: 'polynomial' // la formula de normalizacion de datos
                }]
            },
            onRegionTipShow: function(e, el, code){ // al seleccionar una region se muestra el valor que tengan en el array
                el.html(el.html());
            }
        });
    </script>
@endpush