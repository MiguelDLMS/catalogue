@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-product.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/css/ol.css" type="text/css">
@endpush

@push('content')
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
                            <img class="d-block img-fluid product-image" src="{{ asset('storage/img/products/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                        </div>
                    @else
                        <div class="carousel-item">
                            <img class="d-block img-fluid product-image" src="{{ asset('storage/img/products/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
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
        <div class="card-body">
            <h3 class="card-title">{{ $product['Name'] }}</h3>
            <p class="card-text">{{ $product['Description'] }}</p>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#quotation-request">Cotizar</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="quotation-request" tabindex="-1" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{ route('request.quote') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabe">Solicitar cotización</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre(s):</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="last-name" class="col-form-label">Apellido(s):</label>
                                <input type="text" class="form-control" id="last-name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-form-label">Especificaciones de la cotización:</label>
                                <textarea class="form-control" id="message"></textarea>
                            </div>

                            <input type="hidden" id="product-name" name="product-name" value="{{ $product['Name'] }}">
                            <input type="hidden" id="product-url" name="product-url" value="http://catalogue.acorla.com/product/{{ $product['ID_Product'] }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Modal -->
    </div>
    <!-- /.card -->

    <div class="card card-outline-secondary my-4">
        <div class="card-header">
            Información técnica
        </div>
        
        <div class="card-body">
            {{ $product['Technical_Specifications'] }}
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

    <div class="row my-4">
        <div class="col">
            <h3>Productos sugeridos</h3>
        </div>
    </div>

    <div class="row my-4">
        @forelse ( $suggestedProducts as $product )
            <x-ProductCard :productID="$product['ID_Product']" :productName="$product['Name']" :productDescription="$product['Description']" :imageName="$product['Images'][0]['Name']" />
        @empty
            <div class="col">
                <div class="col">
                    <div class="row my-2">
                        <img class="col-2 img-fluid mx-auto" src="{{ asset('img/magnifying-glass-1976105_640.png') }}" alt="">
                        <h2 class="text-center">No hemos encontrado productos similares.</h2>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <!-- /.row -->
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
    <script type="text/javascript">
        $('#quotation-request').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modal = $(this);
        });
    </script>
@endpush