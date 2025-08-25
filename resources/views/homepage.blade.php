<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Type some info">
    <meta name="author" content="Type name">

    <title>Parfum Kita - @yield('title') </title>

    <!-- Bootstrap css -->
    <link href="/frontoffice/css/bootstrap.css?v=2.0" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="/frontoffice/images/logo.png" type="image/x-icon">
    <!-- Custom css -->
    <link href="/frontoffice/css/ui.css?v=2.0" rel="stylesheet" type="text/css" />
    <link href="/frontoffice/css/responsive.css?v=2.0" rel="stylesheet" type="text/css" />

    <!-- Font awesome 5 -->
    <link href="/frontoffice/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">

    <style>
        .image-thumbnail {
            object-fit: cover;
            height: 250px;
            object-position: center;
        }
    </style>
</head>

<body>

    <header class="section-header">
        <section class="header-main">
            <div class="container">
                <div class="row gy-3 align-items-center">
                    <div class="col-lg-2 col-sm-4 col-4">
                        <a href="/" class="navbar-brand">
                            <img class="logo" height="180" src="/frontoffice/images/logo.png">
                        </a> <!-- brand end.// -->
                    </div>
                    <div class="order-lg-last col-lg-5 col-sm-8 col-8">
                        <div class="float-end">

                            @if (auth()->check())
                                <a href="{{ route('dashboard') }}" class="btn btn-light">
                                    <i class="fa fa-user"></i> <span class="ms-1 d-none d-sm-inline-block">Dashboard
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light">
                                    <i class="fa fa-user"></i> <span class="ms-1 d-none d-sm-inline-block">Sign in
                                    </span>
                                </a>
                            @endif
                            @if (auth()->guest())
                                <a href="{{ route('login') }}" class="btn btn-light">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                            @else
                                <a href="{{ route('homepage.carts') }}" class="btn btn-light">
                                    <i class="fa fa-shopping-cart"></i> <span
                                        class="ms-1 badge bg-danger">{{ \App\Models\Cart::where('user_id', auth()->user()->id)->count() }}</span>
                                </a>
                            @endif
                        </div>
                    </div> <!-- col end.// -->
                    <div class="col-lg-5 col-md-12 col-12">
                        <form action="{{ route('homepage.products') }}" class="">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" style="width:55%"
                                    placeholder="Search" value="{{ request('search') }}">

                                <button class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div> <!-- input-group end.// -->
                        </form>
                    </div> <!-- col end.// -->

                </div> <!-- row end.// -->
            </div> <!-- container end.// -->
        </section> <!-- header-main end.// -->

        <nav class="navbar navbar-light bg-white border-top navbar-expand-lg">
            <div class="container">
                <button class="navbar-toggler border" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar_main">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar_main">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link ps-0" href="{{ route('homepage.products', ['type' => 'all']) }}"> Semua
                                Produk </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('homepage.products', ['type' => 'male']) }}"> Parfum Pria
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('homepage.products', ['type' => 'female']) }}"> Parfum
                                Wanita </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('homepage.products', ['type' => 'best']) }}"> Best
                                Seller
                            </a>
                        </li>
                    </ul>
                </div> <!-- collapse end.// -->

            </div> <!-- container end.// -->
        </nav> <!-- navbar end.// -->
    </header> <!-- section-header end.// -->

    @yield('content')
    <footer class="section-footer bg-gray-light">
        <div class="container">
            <section class="footer-main padding-y">
                <div class="row">
                    <aside class="col-12 col-sm-12 col-lg-3">
                        <article class="me-lg-4">
                            <img src="/frontoffice/images/logo.png" class="logo-footer">
                            <p class="mt-3"> © 2025 Parfum Kita. <br> All rights reserved. </p>
                        </article>
                    </aside>
                    <aside class="col-6 col-sm-4 col-lg-2">
                        <h6 class="title">Store</h6>
                        <ul class="list-menu mb-4">
                            <li> <a href="#">About us</a></li>
                            <li> <a href="#">Find store</a></li>
                            <li> <a href="#">Categories</a></li>
                            <li> <a href="#">Blogs</a></li>
                        </ul>
                    </aside>
                    <aside class="col-6 col-sm-4 col-lg-2">
                        <h6 class="title">Information</h6>
                        <ul class="list-menu mb-4">
                            <li> <a href="#">Help center</a></li>
                            <li> <a href="#">Money refund</a></li>
                            <li> <a href="#">Shipping info</a></li>
                            <li> <a href="#">Refunds</a></li>
                        </ul>
                    </aside>
                    <aside class="col-6 col-sm-4  col-lg-2">
                        <h6 class="title">Support</h6>
                        <ul class="list-menu mb-4">
                            <li> <a href="#"> Help center </a></li>
                            <li> <a href="#"> Documents </a></li>
                            <li> <a href="#"> Account restore </a></li>
                            <li> <a href="#"> My Orders </a></li>
                        </ul>
                    </aside>

                </div> <!-- row.// -->
            </section> <!-- footer-top.// -->
        </div> <!-- container end.// -->
    </footer>


    <!-- Bootstrap js -->
    <script src="/frontoffice/js/bootstrap.bundle.min.js"></script>

    <!-- Custom js -->
    <script src="/frontoffice/js/script.js?v=2.0"></script>

</body>

</html>
