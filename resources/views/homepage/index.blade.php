@extends('homepage')
@section('title', 'Parfum ')
@section('content')

    <!-- ================ SECTION INTRO ================ -->
    <section class="section-intro bg-primary padding-y-lg">
        <div class="container">

            <article class="my-5 text-white">
                <h1 class="display-4 text-white"> Temukan Wangi yang <br> Menceritakan Dirimu </h1>
                <p class="lead text-white">
                    Parfum bukan sekadar aroma, tapi identitas.
                    Dari koleksi eksklusif hingga best seller, semua diracik untuk mendekatkan yang jauh
                    dan melekatkan yang dekat, dalam satu semprotan.
                </p>
                <a href="{{ route('homepage.products') }}" class="btn btn-warning"> Belanja Sekarang </a>
                <a href="{{ route('homepage.products.recomendations') }}" class="btn btn-light"> Rekomendasi Terbaik </a>
            </article>


        </div> <!-- container end.// -->
    </section>
    <!-- ================ SECTION INTRO END.// ================ -->

    <!-- ================ SECTION PRODUCTS ================ -->
    <section class="padding-y">
        <div class="container">

            <header class="section-heading">
                <h3 class="section-title">Terbaru</h3>
            </header>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <figure class="card card-product-grid">

                            <img class="image-thumbnail" src="{{ $product->getThumbnail() }}">
                            <figcaption class="info-wrap border-top">
                                <div class="price-wrap">
                                    <span class="price">Rp.{{ number_format($product->price, '0', ',', '.') }}</span>
                                </div> <!-- price-wrap.// -->
                                <p class="title mb-2">{{ $product->name }}</p>

                                <a href="{{ route('homepage.products.detail', $product->slug) }}"
                                    class="btn btn-light col-12">Detail</a>
                            </figcaption>
                        </figure>
                    </div> <!-- col end.// -->
                @endforeach
            </div>

        </div> <!-- container end.// -->
    </section>
    <!-- ================ SECTION FEATURE ================ -->
    <section class="bg-light padding-y">
        <div class="container">

            <header class="section-heading mt-2 mb-5">
                <h3 class="section-title">Kenapa memilih Parfum Kita?</h3>
            </header>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-money-bill"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Harga Terjangkau</h6>
                            <p>Koleksi parfum premium dengan harga bersahabat tanpa mengorbankan kualitas.</p>
                        </figcaption>
                    </figure>
                </div><!-- col // -->

                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-star"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Kualitas Terbaik</h6>
                            <p>Setiap aroma dipilih dengan teliti untuk menghadirkan wangi yang tahan lama.</p>
                        </figcaption>
                    </figure>
                </div><!-- col // -->

                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-plane"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Pengiriman Cepat</h6>
                            <p>Pesananmu dikirim dengan aman dan cepat ke seluruh Indonesia.</p>
                        </figcaption>
                    </figure>
                </div> <!-- col // -->

                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-users"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Kepuasan Pelanggan</h6>
                            <p>Kami berkomitmen memberikan pelayanan terbaik agar setiap pelanggan merasa istimewa.</p>
                        </figcaption>
                    </figure>
                </div><!-- col // -->

                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-thumbs-up"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Ribuan Pelanggan Puas</h6>
                            <p>Bergabunglah dengan komunitas pelanggan kami yang sudah jatuh cinta dengan Parfum Kita.</p>
                        </figcaption>
                    </figure>
                </div><!-- col // -->

                <div class="col-lg-4 col-md-6">
                    <figure class="itemside align-items-center mb-4">
                        <div class="aside">
                            <span class="rounded-circle shadow-sm text-primary icon-lg bg-white">
                                <i class="fa fa-box"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Banyak Pilihan</h6>
                            <p>Dari aroma segar hingga elegan, tersedia koleksi parfum untuk setiap momen spesialmu.</p>
                        </figcaption>
                    </figure>
                </div> <!-- col // -->
            </div>
        </div> <!-- container end.// -->
    </section>
    <!-- ================ SECTION FEATURE END.// ================ -->

@endsection
