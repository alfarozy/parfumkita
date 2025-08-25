@extends('homepage')
@section('title', 'Katalog Parfum')
@section('content')

    <!-- ============== SECTION PAGETOP ============== -->
    <section class="bg-primary py-5">
        <div class="container">
            <h2 class="text-white">Katalog Parfum</h2>
            <ol class="breadcrumb ondark mb-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </div> <!-- container //  -->
    </section>
    <!-- ============== SECTION PAGETOP END// ============== -->

    <!-- ============== SECTION CONTENT ============== -->
    <section class="padding-y">
        <div class="container">
            <div class="row">
                <!-- ===== SIDEBAR FILTER ===== -->
                <aside class="col-lg-3">
                    <button class="btn btn-outline-secondary mb-3 w-100 d-lg-none" data-bs-toggle="collapse"
                        data-bs-target="#aside_filter">Tampilkan Filter</button>

                    <div id="aside_filter" class="collapse card d-lg-block mb-5">

                        <!-- Filter Harga -->
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_price">
                                    <i class="icon-control fa fa-chevron-down"></i> Harga
                                </a>
                            </header>
                            <div class="collapse show" id="collapse_price">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="min" class="form-label">Min</label>
                                            <input class="form-control" id="min" placeholder="Rp 0" type="number">
                                        </div>
                                        <div class="col-6">
                                            <label for="max" class="form-label">Max</label>
                                            <input class="form-control" id="max" placeholder="Rp 1.000.000"
                                                type="number">
                                        </div>
                                    </div>
                                    <button class="btn btn-light w-100" type="button">Terapkan</button>
                                </div>
                            </div>
                        </article>

                        <!-- Filter Aroma -->
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" class="title" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_fragrance">
                                    <i class="icon-control fa fa-chevron-down"></i> Jenis Aroma
                                </a>
                            </header>
                            <div class="collapse show" id="collapse_fragrance">
                                <div class="card-body">
                                    <ul class="list-menu">
                                        <li><a href="#">Floral</a></li>
                                        <li><a href="#">Citrus</a></li>
                                        <li><a href="#">Woody</a></li>
                                        <li><a href="#">Oriental</a></li>
                                        <li><a href="#">Aquatic</a></li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                </aside>

                <!-- ===== PRODUK LIST ===== -->
                <main class="col-lg-9">
                    <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                        <strong class="d-block py-2">{{ $products->count() }} Produk ditemukan</strong>
                        <div class="ms-auto">
                            <select class="form-select d-inline-block w-auto">
                                <option value="0">Urutkan: Terbaru</option>
                                <option value="1">Harga Terendah</option>
                                <option value="2">Harga Tertinggi</option>
                            </select>
                        </div>
                    </header>

                    <div class="row">
                        @if ($products->count() == 0)
                            <div class="col-12 text-center">
                                <h2 class="text-muted">Belum ada produk yang tersedia</h2>

                            </div>
                        @else
                            @foreach ($products as $product)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <figure class="card card-product-grid">
                                        <a href="{{ route('homepage.products.detail', $product->slug) }}">
                                            <img class="col-12 image-thumbnail" src="{{ $product->getThumbnail() }}">
                                        </a>
                                        <figcaption class="info-wrap border-top">
                                            <div class="price-wrap">
                                                <strong
                                                    class="price">Rp.{{ number_format($product->price, 0, ',', '.') }}</strong>
                                            </div>
                                            <p class="title mb-2">{{ $product->name }}</p>
                                            <a href="{{ route('homepage.products.detail', $product->slug) }}"
                                                class="btn btn-primary col-12">Detail</a>
                                        </figcaption>
                                    </figure>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <hr>

                    <!-- Pagination -->
                    <footer class="d-flex mt-4">
                        {{ $products->links() }}
                    </footer>
                </main>
            </div>
        </div>
    </section>
    <!-- ============== SECTION CONTENT END// ============== -->

@endsection
