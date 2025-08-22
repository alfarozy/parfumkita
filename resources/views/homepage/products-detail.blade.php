@extends('homepage')
@section('title', $product['name'])
@section('content')

    <section class="bg-primary padding-y-sm">
        <div class="container">

            <ol class="breadcrumb ondark mb-0">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item"><a href="#">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->category->name }}</li>
            </ol>

        </div> <!-- container //  -->
    </section>
    <!-- ============== SECTION PAGETOP END// ============== -->

    <!-- ============== SECTION CONTENT ============== -->
    <section class="padding-y">
        <div class="container">

            <div class="row">
                <aside class="col-lg-6">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap img-thumbnail">
                            <a data-fslightbox="mygalley" data-type="image" href="{{ $product->getThumbnail() }}">
                                <img height="560" src="{{ $product->getThumbnail() }}">
                            </a>
                        </div> <!-- img-big-wrap.// -->

                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <article class="ps-lg-3">
                        <h4 class="title text-dark">{{ str()->title($product->name) }}</h4>
                        <div class="rating-wrap my-3">
                            <span class="label-rating text-muted">
                                {{ $product->stock }} Stok
                            </span>
                            <i class="dot"></i>
                            @if ($product->stock > 5)
                                <span class="label-rating text-success">Tersedia</span>
                            @elseif($product->stock > 0 && $product->stock <= 5)
                                <span class="label-rating text-warning">Hampir Habis</span>
                            @else
                                <span class="label-rating text-danger">Stok Habis</span>
                            @endif
                        </div> <!-- rating-wrap.// -->

                        <div class="mb-3">
                            <var class="price h5">Rp.{{ number_format($product->price, '0', ',', '.') }}</var>
                        </div>

                        <dl class="row">
                            <dt class="col-4">Kategori</dt>
                            <dd class="col-8">{{ $product->category->name }}</dd>

                            <dt class="col-4">Jenis Aroma</dt>
                            <dd class="col-8">{{ $product->fragrance_family }}</dd>

                            <dt class="col-4">Volume (ml)</dt>
                            <dd class="col-8">{{ $product->volume_ml }}</dd>

                            <dt class="col-4">Jenis Kelamin</dt>
                            <dd class="col-8">
                                @if ($product->gender_target == 'male')
                                    Pria
                                @elseif ($product->gender_target == 'female')
                                    Wanita
                                @else
                                    Unisex
                                @endif
                            </dd>

                            <dt class="col-4">Waktu Penggunaan</dt>
                            <dd class="col-8">
                                @if ($product->usage_time == 'morning')
                                    Pagi
                                @elseif ($product->usage_time == 'night')
                                    Malam
                                @else
                                    Sepanjang Hari
                                @endif
                            </dd>

                            <dt class="col-4">Situasi</dt>
                            <dd class="col-8">{{ $product->situation }}</dd>

                            <dt class="col-4">Daya Tahan</dt>
                            <dd class="col-8">
                                @if ($product->longevity == 'long_last')
                                    Tahan Lama (Seharian)
                                @elseif ($product->longevity == 'light_frequent')
                                    Ringan (Sering Semprot Ulang)
                                @endif
                            </dd>
                        </dl>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-4 col-6 mb-3">
                                <label class="form-label d-block">Jumlah</label>
                                <div class="input-group input-spinner">
                                    <button class="btn btn-icon btn-light btn-qty-minus" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#999"
                                            viewBox="0 0 24 24">
                                            <path d="M19 13H5v-2h14v2z"></path>
                                        </svg>
                                    </button>
                                    <input class="form-control text-center qty-input" type="number" name="quantity"
                                        value="1" min="1" max="{{ $product->stock }}">
                                    <button class="btn btn-icon btn-light btn-qty-plus" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#999"
                                            viewBox="0 0 24 24">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                        </svg>
                                    </button>
                                </div> <!-- input-group.// -->
                                <small class="text-muted">Stok tersedia: {{ $product->stock }}</small>
                            </div>
                        </div>


                        <a href="#" class="btn  btn-warning"> Beli sekarang </a>
                        <a href="#" class="btn  btn-primary"> <i class="me-1 fa fa-shopping-basket"></i>
                            Tambahkan keranjang </a>

                    </article> <!-- product-info-aside .// -->
                </main> <!-- col.// -->
            </div> <!-- row.// -->

        </div> <!-- container .//  -->
    </section>
    <!-- ============== SECTION CONTENT END// ============== -->

    <!-- ============== SECTION  ============== -->
    <section class="padding-y bg-light border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- =================== COMPONENT SPECS ====================== -->
                    <div class="card">
                        <header class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a href="#" data-bs-target="#tab_specs" data-bs-toggle="tab"
                                        class="nav-link active">Deskripsi</a>
                                </li>
                            </ul>
                        </header>
                        <div class="tab-content">
                            <article id="tab_specs" class="tab-pane show active card-body">
                                <p> {!! $product->description !!} </p>
                            </article> <!-- tab-content.// -->
                        </div>
                    </div>
                    <!-- =================== COMPONENT SPECS .// ================== -->
                </div> <!-- col.// -->
                <aside class="col-lg-4">
                    <!-- =================== COMPONENT ADDINGS ====================== -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Produk Terkait</h5>

                            @foreach ($relatedProducts as $item)
                                <article class="itemside mb-3">
                                    <a href="#" class="aside">
                                        <img src="{{ $item->getThumbnail() }}" width="96" height="96"
                                            class="img-md img-thumbnail">
                                    </a>
                                    <div class="info">
                                        <a href="#" class="title mb-1"> {{ $item->name }}</a>
                                        <strong class="price">
                                            Rp.{{ number_format($item->price, '0', ',', '.') }}</strong>
                                        <!-- price.// -->
                                    </div>
                                </article>
                            @endforeach
                        </div> <!-- card-body .// -->
                    </div> <!-- card .// -->
                    <!-- =================== COMPONENT ADDINGS .// ================== -->
                </aside> <!-- col.// -->
            </div>

            <br><br>

        </div><!-- container // -->
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const minusBtn = document.querySelector(".btn-qty-minus");
            const plusBtn = document.querySelector(".btn-qty-plus");
            const qtyInput = document.querySelector(".qty-input");
            const maxStock = parseInt(qtyInput.getAttribute("max"));

            minusBtn.addEventListener("click", function() {
                let value = parseInt(qtyInput.value) || 1;
                if (value > 1) {
                    qtyInput.value = value - 1;
                }
            });

            plusBtn.addEventListener("click", function() {
                let value = parseInt(qtyInput.value) || 1;
                if (value < maxStock) {
                    qtyInput.value = value + 1;
                }
            });

            // Biar ga bisa input sembarangan
            qtyInput.addEventListener("input", function() {
                let value = parseInt(qtyInput.value) || 1;
                if (value < 1) value = 1;
                if (value > maxStock) value = maxStock;
                qtyInput.value = value;
            });
        });
    </script>

@endsection
