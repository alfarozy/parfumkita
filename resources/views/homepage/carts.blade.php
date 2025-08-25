@extends('homepage')
@section('title', 'Carts')
@section('content')

    <!-- ============== SECTION PAGETOP ============== -->
    <section class="bg-primary padding-y-sm">
        <div class="container">
            <ol class="breadcrumb ondark mb-0">
                <li class="breadcrumb-item"> <a href="#">Home</a> </li>
                <li class="breadcrumb-item active"> Keranjang belanja </li>
            </ol>
        </div> <!-- container //  -->
    </section>
    <!-- ============== SECTION PAGETOP END// ============== -->
    <section class="padding-y bg-light">
        <div class="container">

            <div class="row">
                @if (session()->has('success'))
                    <div class="alert bg-success text-center text-white">
                        {!! session()->get('success') !!}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert bg-danger text-center text-white">
                        {!! session()->get('error') !!}
                    </div>
                @endif
                <div class="col-lg-9">

                    <div class="card">
                        <div class="content-body">
                            <h4 class="card-title mb-4">Keranjang belanja</h4>
                            @if ($carts->count() == 0)
                                <div class="text-center">
                                    <h2 class="text-muted">Belum ada produk yang di tambahkan</h2>
                                    <p class="text-muted">Klik tombol dibawah untuk pilih produk</p>
                                    <a href="{{ route('homepage.products') }}" class="btn btn-primary">Pilih Produk</a>
                                </div>
                            @else
                                @foreach ($carts as $item)
                                    <article class="row gy-3 mb-4">
                                        <div class="col-lg-6">
                                            <figure class="itemside me-lg-5">
                                                <div class="aside"><img src="{{ $item->product->getThumbnail() }}"
                                                        class="img-sm img-thumbnail">
                                                </div>
                                                <figcaption class="info">
                                                    <a href="#"
                                                        class="title">{{ str()->title($item->product->name) }}</a>
                                                    <p class="text-muted"> {{ $item->product->category->name }} </p>
                                                    <var
                                                        class="price h6">Rp.{{ number_format($item->product->price, '0', ',', '.') }}</var>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col-lg-2 col-sm-4 col-6">
                                            <div class="price-wrap lh-sm">
                                                <br>
                                                <var class="price h6">{{ $item->quantity }}x</var>
                                            </div> <!-- price-wrap .// -->
                                        </div>
                                        <div class="col-lg col-sm-4">
                                            <div class="float-lg-end">
                                                <form action="{{ route('homepage.carts.destroy', $item->product->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
                                                        Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </article> <!-- row.// -->
                                @endforeach
                            @endif
                        </div> <!-- card-body .// -->


                    </div> <!-- card.// -->

                </div> <!-- col.// -->
                <aside class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $totalPrice = 0;
                                foreach ($carts as $item) {
                                    $totalPrice += $item->product->price * $item->quantity;
                                }
                            @endphp
                            <dl class="dlist-align">
                                <dt>Total price:</dt>
                                <dd class="text-end"> Rp.{{ number_format($totalPrice, '0', ',', '.') }}</dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-end text-dark h5"> Rp.{{ number_format($totalPrice, '0', ',', '.') }}</dd>
                            </dl>

                            <div class="d-grid gap-2 my-3">
                                <a href="{{ route('homepage.checkout') }}" class="btn btn-success w-100"> Checkout
                                </a>
                            </div>
                        </div> <!-- card-body.// -->
                    </div> <!-- card.// -->

                </aside> <!-- col.// -->

            </div> <!-- row.// -->


            <br><br>

        </div> <!-- container .//  -->
    </section>

@endsection
