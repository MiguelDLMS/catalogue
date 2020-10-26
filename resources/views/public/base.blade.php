<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@stack('title')</title>
        @stack('stylesheets')

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                    <a class="navbar-brand" href="https://www.acorla.com">
                        <img src="{{ asset('img/acorla-logo-white.png') }}" alt="Logo">
                    </a>
                </div>
                <button class="navbar-toggler" data-toggle="collapse" type="button" id="sidebarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="mx-auto order-0">
                    <a class="navbar-brand mx-auto" href="{{ url('/') }}">
                        <h2>Catálogo Latam</h2>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <form method="POST" action="{{ route('search.product') }}">
                                @csrf
                                <div class="input-group is-invalid">
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Buscar" required>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <x-CategoryMenu/>

        <div class="row">
            <div class="container main">
                <!-- Content -->
                @stack('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">contacto@acorla.com</p>
            </div>
            
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Acorla 2020</p>
            </div>
            <!-- /.container -->
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });

                $('#dismiss, .overlay').on('click', function () {
                    // hide sidebar
                    $('#sidebar').removeClass('active');
                    // hide overlay
                    $('.overlay').removeClass('active');
                });

                $('#sidebarCollapse').on('click', function () {
                    // open sidebar
                    $('#sidebar').addClass('active');
                    // fade in the overlay
                    $('.overlay').addClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            });
        </script>
        @stack('javascripts')
    </body>
</html>
