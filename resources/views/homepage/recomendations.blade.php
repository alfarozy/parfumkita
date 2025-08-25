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
                        <div class="card mb-5">
                            <div class="card-header">
                                Berdasarkan Preferensi Anda
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li>Nama: <strong>{{ request('name') }}</strong></li>
                                    <li>Jenis Kelamin:
                                        <strong>{{ request('gender') === 'male' ? 'Laki-laki' : 'Perempuan' }}</strong>
                                    </li>
                                    <li>Umur: <strong>{{ request('age') }}</strong> Tahun</li>
                                    <li>Waktu Penggunaan:
                                        <strong>{{ request('usage_time') === 'morning' ? 'Pagi' : 'Sore' }}</strong>
                                    </li>
                                    <li>Situasi:
                                        <strong>{{ request('situation') === 'outdoor' ? 'Luar Ruangan' : 'Dalam Ruangan' }}</strong>
                                    </li>
                                    <li>Daya Tahan Aroma:
                                        <strong>{{ request('longevity') === 'indoor' ? 'Dalam Ruangan' : 'Luar Ruangan' }}</strong>
                                    </li>
                                    <li>Jenis Aroma Luar Ruangan:
                                        <strong>{{ request('outdoor_aroma') === 'citrus' ? 'Citrus' : 'Floral' }}</strong>
                                    </li>
                                    <li>Jenis Aroma Dalam Ruangan:
                                        <strong>{{ request('indoor_aroma') === 'warm' ? 'Hangat' : 'Cool' }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
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

    <!-- Kuisioner Modal -->
    <div class="modal fade" id="kuisionerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('homepage.products.recomendations') }}" method="GET">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Kuisioner Parfum</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">1. Siapa nama kamu?</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">2. Jenis kelamin kamu apa?</label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="male">Pria</option>
                                        <option value="female">Wanita</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">3. Umur kamu berapa?</label>
                                    <input type="number" name="age" class="form-control" placeholder="15" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">4. Biasanya kamu pakai parfum kapan?</label>
                                    <select name="usage_time" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="morning">Pagi / Siang hari</option>
                                        <option value="night">Malam hari</option>
                                        <option value="allday">Sepanjang hari</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">5. Kamu biasa pakai parfum di situasi…</label>
                                    <select name="situation" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="indoor">Dalam ruangan</option>
                                        <option value="outdoor">Luar ruangan</option>
                                        <option value="mix">Campuran keduanya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">6. Kamu lebih suka parfum yang wanginya…</label>
                                    <select name="longevity" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="indoor">Tahan lama seharian</option>
                                        <option value="outdoor">Ringan tapi sering disemprot ulang</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">7. Kalau di luar ruangan, kamu lebih suka aroma yang…</label>
                                    <select name="outdoor_aroma" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="citrus">Segar & ringan</option>
                                        <option value="woody">Wangi alami</option>
                                        <option value="floral">Manis lembut</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">8. Kalau di dalam ruangan, kamu lebih suka aroma
                                        yang…</label>
                                    <select name="indoor_aroma" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="soft">Soft & calming</option>
                                        <option value="warm">Hangat & elegan</option>
                                        <option value="playful">Manis & playful</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Lanjutkan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    @if (
        !request('type') &&
            !request('name') &&
            !request('gender') &&
            !request('age') &&
            !request('usage_time') &&
            !request('situation') &&
            !request('longevity') &&
            !request('outdoor_aroma') &&
            !request('indoor_aroma'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var kuisionerModal = new bootstrap.Modal(document.getElementById('kuisionerModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                kuisionerModal.show();
            });
        </script>
    @endif

@endsection
