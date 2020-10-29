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

    <!-- Modal -->
    <div id="images-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabe" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="images-form" method="post" enctype="multipart/form-data">
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

    <form id="product-form" method="post" enctype="multipart/form-data">
    @csrf
        <div class="card mt-4">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#images-modal">Seleccionar imágenes</button>

            <div class="card-body">
                <h3 class="card-title">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del producto">
                </h3>
                <p class="card-text">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Descripción del producto">
                </p>
            </div>
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 my-auto">
                        <div class="custom-control custom-switch float-right">
                            <input id="visible" name="visible" type="checkbox" class="custom-control-input">
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
                <input type="text" class="form-control" id="specifications" name="specifications" placeholder="Información técnica">
            </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Región
            </div>
            
            <div class="card-body">
                <strong>Código del país: </strong><input type="text" class="form-control" id="country" name="country" maxlength="2" placeholder="--">

                <div id="map" class="map" country-code=""></div>
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
                $('#images-modal').modal('hide');
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

                $.each($("#images")[0].files, function(i, file) {
                    formData.append('insertImages[]', file);
                });
                formData.append('deleteImages', $('#delete-images').attr("images"));

                $.ajax({
                    url: "{!! route('insert.product') !!}",
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