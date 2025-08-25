@extends('homepage')
@section('title', 'Carts')
@section('content')

    <!-- ============== SECTION ============== -->
    <section class="padding-y bg-light">
        <div class="container">


            <div class="row">
                <main class="col-xl-8 col-lg-8">
                    <!-- ============== COMPONENT CHECKOUT =============== -->
                    <article class="card">
                        <div class="content-body">
                            <h5 class="card-title"> Checkout </h5>
                            <form action="{{ route('homepage.checkout.order') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Nama lengkap -->
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap"
                                            required>
                                    </div> <!-- col end.// -->

                                    <!-- Nomor Telepon -->
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" value="62" class="form-control"
                                            placeholder="Nomor WhatsApp" required>
                                    </div> <!-- col end.// -->

                                    <!-- Email -->
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="example@gmail.com" required>
                                    </div> <!-- col end.// -->

                                    <!-- Alamat Pengiriman -->
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Pengiriman</label>
                                        <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
                                    </div> <!-- col end.// -->

                                    <!-- Catatan -->
                                    <div class="mb-3">
                                        <label class="form-label">Catatan (opsional)</label>
                                        <textarea name="notes" class="form-control" rows="2"></textarea>
                                    </div> <!-- col end.// -->

                                    <div class="float-end">
                                        <a href="{{ route('homepage.carts') }}" class="btn btn-light">Batal dan kembali</a>
                                        <button type="submit" class="btn btn-success">Buat Pesanan</button>
                                    </div>
                                </div> <!-- row.// -->
                            </form>
                        </div>
                    </article> <!-- card end.// -->

                    <!-- ============== COMPONENT CHECKOUT .// =============== -->

                </main> <!-- col.// -->
                <aside class="col-xl-4 col-lg-4">
                    <!-- ============== COMPONENT SUMMARY =============== -->
                    <article class="ms-lg-4 mt-4 mt-lg-0" style="max-width: 320px">
                        <h6 class="card-title">Summary</h6>
                        @php
                            $totalPrice = 0;
                            foreach ($carts as $item) {
                                $totalPrice += $item->product->price * $item->quantity;
                            }
                        @endphp
                        <dl class="dlist-align">
                            <dt>Harga </dt>
                            <dd class="text-end"> {{ number_format($totalPrice, '0', ',', '.') }}</dd>
                        </dl>
                        <dl class="dlist-align">
                            <dt>Shipping cost</dt>
                            <dd class="text-end"> + Rp.20,000 </dd>
                        </dl>
                        <hr>
                        <dl class="dlist-align">
                            <dt> Total: </dt>
                            <dd class="text-end"> <strong
                                    class="text-dark">Rp.{{ number_format($totalPrice + 20000, '0', ',', '.') }}</strong>
                            </dd>
                        </dl>

                        <hr>
                        <h6 class="mb-4">Item</h6>

                        @foreach ($carts as $item)
                            <figure class="itemside align-items-center mb-4">
                                <div class="aside">
                                    <b class="badge bg-secondary rounded-pill">{{ $item->quantity }}x</b>
                                    <img src="{{ $item->product->getThumbnail() }}" class="img-sm rounded border">
                                </div>
                                <figcaption class="info">
                                    <a href="#" class="title">{{ $item->product->name }}</a>
                                    <div class="price text-muted">Total:
                                        Rp.{{ number_format($item->product->price * $item->quantity, '0', ',', '.') }}
                                    </div> <!-- price .// -->
                                </figcaption>
                            </figure>
                        @endforeach
                    </article>
                    <!-- ============== COMPONENT SUMMARY .// =============== -->
                </aside> <!-- col.// -->
            </div> <!-- row.// -->

            <br><br>

        </div> <!-- container .//  -->
    </section>

@endsection
