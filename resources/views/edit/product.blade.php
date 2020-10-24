@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-product-edit.css') }}" rel="stylesheet">
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
                    <div id="map" class="map" latitude="{{ $product['Latitude'] }}" longitude="{{ $product['Longitude'] }}"></div>
                </div>
            </div>
            <!-- /.card -->
        </form>
        
    </div>
    <!-- /.col-lg-8 -->
@endpush

@push('javascripts')
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>
    <script type="text/javascript">
      var map = new ol.Map({
            target: 'map',
            layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([parseFloat($('#map').attr('longitude')), parseFloat($('#map').attr('latitude'))]),
                zoom: 8
            })
        });
    </script>
@endpush