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
    <!-- Modal -->
    <div class="modal fade" id="quotation-request" tabindex="-1" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{!! route('update.product.images', [ 'id' => $product['ID_Product'] ]) !!}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input id="images" name="images[]" style="visibility:hidden !important; height: 0px !important; padding: 0px !important;" type="file" accept="image/*" multiple>
                    <input type="hidden" id="delete-images" name="delete-images" images="">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabe">Imágenes</h5>
                        <button id="cancel-images" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($product['Images'] as $image)
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <button type="button" class="btn btn-danger delete-image" image="{{ $image['Name'] }}">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                        </svg>
                                    </button>
                                    <img class="d-block img-fluid product-image" src="{{ asset('img/products/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                                </div>
                            @endforeach

                            <div class="col-lg-4 col-sm-6 col-12">
                                <button id="images-button" type="button" class="btn btn-light add-image">
                                    <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-cloud-arrow-up-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 1 0V6.707l1.146 1.147a.5.5 0 0 0 .708-.708z"/>
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="save-images" type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->

    <form method="POST" action="{{ route('request.quote') }}">
    @csrf
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
                <strong>Código del país: </strong><input type="text" class="form-control" id="country" name="country" value="MX">

                <div id="map" class="map" country-code="MX"></div>
            </div>
        </div>
        <!-- /.card -->
    </form>
@endpush

@push('javascripts')
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>
    <script type="text/javascript">
        var first = true;

        $("#images-button").click(function() {
            $("#images").click();
        });

        $(".delete-image").click(function() {
            if (first) {
                $("#delete-images").attr("images", $(this).attr("image"));
                first = false;
            } else {
                $("#delete-images").attr("images", $("#delete-images").attr("images") + ";" + $(this).attr("image"));
            }

            $(this).parent().hide(500);
        });

        $("#save-images").click(function() {
            $( "div[style='display: none;']" ).remove();
        });

        $("#cancel-images").click(function() {
            $( "div[style='display: none;']" ).show(500);
        });

        $(document).ready(function() {
            $("#save-images").click(function(e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var insertImages = $("#images").val();
                var deleteImages = $("#delete-images").val();

                $.ajax({
                    url: "{!! route('update.product.images', [ 'id' => $product['ID_Product'] ]) !!}",
                    type:'POST',
                    data: { 
                        _token: _token,
                        insertImages: insertImages,
                        deleteImages: deleteImages
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        function paintMap() {
            var code = $(this).val();
            var data = {
                [code]: "#1A2F40"
            };

            $('#map').empty();

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
        }

        $("#country").on("input", paintMap());

        $(document).ready(function() {
            paintMap();
        });
    </script>
@endpush