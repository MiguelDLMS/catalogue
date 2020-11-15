@extends('public.base')

@push('title')
    Acorla
@endpush

@push('stylesheets')
    <link href="{{ asset('css/shop-product-edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/map.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-jvectormap-2.0.5.css') }}">
@endpush

@push('content')
    <div id="error-modal" class="modal fade" tabindex="-4" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabe">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    No ha sido posible realizar la acción solicitada
                </div>
            </div>
        </div>
    </div>

    <div id="success-modal" class="modal fade" tabindex="-3" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabe">Acción realizada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Se ha actualizado exitosamente
                </div>
            </div>
        </div>
    </div>

    <div id="delete-product-modal" class="modal fade" tabindex="-2" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabe">Eliminar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    ¿Desea eliminar este producto permanentemente?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button id="delete-product" type="button" class="btn btn-danger">
                        <div id="delete-spinner" style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="sr-only">Deleting...</span>
                        </div>
                        <div id="delete-text">
                            Eliminar producto
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="images-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="images-form" action="{!! route('update.product.images', [ 'id' => $product['ID_Product'] ]) !!}" method="post" enctype="multipart/form-data">
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
                        <div id="image-previews" class="row">
                            @foreach ($product['Images'] as $image)
                                <div class="col-lg-4 col-sm-6 col-12 mb-3 image-preview">
                                    <button type="button" class="btn btn-danger delete-image" image="{{ $image['Name'] }}">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                        </svg>
                                    </button>
                                    <img class="d-block img-fluid product-image" src="{{ asset('products/images/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                                </div>
                            @endforeach

                            <div id="add-image-btn" class="col-lg-4 col-sm-6 col-12">
                                <button id="images-button" type="button" class="btn btn-light add-image">
                                    <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-cloud-arrow-up-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 1 0V6.707l1.146 1.147a.5.5 0 0 0 .708-.708z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="save-images" type="submit" class="btn btn-primary">
                            <div id="save-images-spinner" style="width: 1em; height: 1em;display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="sr-only">Saving...</span>
                            </div>
                            <div id="save-images-text">
                                Guardar
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->

    <form id="product-form" action="{!! route('update.product', [ 'id' => $product['ID_Product'] ]) !!}" method="post" enctype="multipart/form-data">
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
                                <img class="d-block img-fluid product-image" src="{{ asset('products/images/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
                            </div>
                        @else
                            <div class="carousel-item">
                                <img class="d-block img-fluid product-image" src="{{ asset('products/images/'. $image['Name']) }}" alt="{{ $image['Name'] }}">
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

            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#images-modal">Seleccionar imágenes</button>

            <div class="card-body">
                <h3 class="card-title">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product['Name'] }}">
                </h3>
                <p class="card-text">
                    <input type="text" class="form-control" id="description" name="description" value="{{ $product['Description'] }}">
                </p>
            </div>
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <button type="button" class="btn btn-danger float-left" data-toggle="modal" data-target="#delete-product-modal">Eliminar producto</button>
                    </div>
                    <div class="col-md-6 col-12 my-auto">
                        <div class="custom-control custom-switch float-right">
                            <input id="visible" name="visible" type="checkbox" class="custom-control-input" @if($product['Visible']) checked @endif>
                            <label class="custom-control-label" for="visible">Mostrar este producto al público</label>
                        </div>
                    </div>
                </div>
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
                <strong>Código del país: </strong><input type="text" class="form-control" id="country" name="country" maxlength="2" value="{{ $product['Country_Code'] }}">

                <div id="map" class="map" country-code="{{ $product['Country_Code'] }}"></div>
            </div>
        </div>
        <!-- /.card -->

        <button id="save-changes" type="submit" class="float btn btn-primary" data-toggle="tooltip" data-placement="left" title="Guardar">
            <div id="saving-spinner" style="display: none;">
                <span class="spinner-border spinner-border-sm" style="width: 1em; height: 1em;" role="status" aria-hidden="true"></span>
                <span class="sr-only">Saving...</span>
            </div>
            <div id="save-icon">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cloud-upload-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
                </svg>
            </div>
        </button>

        @if ( count($product['Categories']) )
            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Categorías
                </div>
                
                <div class="card-body">
                    @foreach ( $product['Categories'] as $category )
                        <a href="{{ url('category/'.$category['Name']) }}"><u>{{ $category['Name'] }}</u></a>
                    @endforeach
                </div>
            </div>
            <!-- /.card -->
        @endif
    </form>
@endpush

@push('javascripts')
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-jvectormap-world-mill.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()

            var first = true;

            $("#images-button").click(function() {
                $("#images").click();
            });

            function imagesPreview(input, placeToInsertImagePreview) {

                if (input.files) {
                    Object.keys(input.files).forEach(function(k){
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            var $template = $('.image-preview').first().clone();

                            $template.find(".delete-image").attr("image", input.files[k].name);
                            $template.find(".product-image").attr("alt", input.files[k].name);
                            $template.find(".product-image").attr("src", event.target.result);
                            
                            $template.insertBefore(placeToInsertImagePreview + " div:last");
                        }

                        reader.readAsDataURL(input.files[k]);
                    });
                }

            };

            $('#images').on('change', function() {
                imagesPreview(this, '#image-previews');
            });

            $("#image-previews").on('click', 'div button.delete-image', function() {
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

            $("#images-form").submit(function(e) {
                e.preventDefault();
                $('#save-images-text').hide();
                $('#save-images-spinner').show();

                var formData = new FormData();

                formData.append("_token", "{{ csrf_token() }}");
                $.each($("#images")[0].files, function(i, file) {
                    formData.append('insertImages[]', file);
                });
                formData.append('deleteImages', $('#delete-images').attr("images"));

                $.ajax({
                    url: "{!! route('update.product.images', [ 'id' => $product['ID_Product'] ]) !!}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(result) {
                        console.log("Success: " + result);
                        
                        $('#save-images-text').show();
                        $('#save-images-spinner').hide();
                        $('#images-modal').modal('hide');
                        $('#success-modal').modal('show');
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Error: ");
                        console.log(data);

                        $('#save-images-text').show();
                        $('#save-images-spinner').hide();
                        $('#images-modal').modal('hide');
                        $('#error-modal').modal('show');
                        location.reload();
                    }
                });
            });

            $("#delete-product").click(function(e) {
                $('#delete-text').hide();
                $('#delete-spinner').show();

                var formData = new FormData();

                formData.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: "{!! route('delete.product', [ 'id' => $product['ID_Product'] ]) !!}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(result) {
                        console.log("Success: " + result);
                        
                        $(location).attr('href', 'http://catalogue.acorla.com');
                    },
                    error: function(data) {
                        console.log("Error: ");
                        console.log(data);
                        
                        $('#delete-text').show();
                        $('#delete-spinner').hide();
                        $('#error-modal').modal('show');
                    }
                });
            });

            $("#product-form").submit(function(e) {
                e.preventDefault();
                $('#save-icon').hide();
                $('#saving-spinner').show();

                var formData = new FormData();

                formData.append("_token", "{{ csrf_token() }}");
                formData.append('name', $('#name').val());
                formData.append('description', $('#description').val());
                formData.append('specifications', $('#specifications').val());
                formData.append('country', $('#country').val());
                formData.append('visible', $('#visible').is( ':checked' ) ? 1: 0);

                $.ajax({
                    url: "{!! route('update.product', [ 'id' => $product['ID_Product'] ]) !!}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(result) {
                        console.log("Success: " + result);
                        
                        $('#save-icon').show();
                        $('#saving-spinner').hide();
                        $('#success-modal').modal('show');
                    },
                    error: function(data) {
                        console.log("Error: " + data);

                        $('#save-icon').show();
                        $('#saving-spinner').hide();
                        $('#error-modal').modal('show');
                    }
                });
            });
        });
    </script>
@endpush