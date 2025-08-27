@extends('layouts.backoffice')
@section('title', 'Invoice Order #' . $order->order_number)

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice @yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.orders.index') }}">Orders</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Detail Invoice</h3>
                            </div>
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="25%">Order Number</th>
                                        <td><b>{{ $order->order_number }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pemesan</th>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon</th>
                                        <td>{{ $order->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pengiriman</th>
                                        <td>{{ $order->shipping_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Harga</th>
                                        <td><b>Rp{{ number_format($order->total_price, 0, ',', '.') }}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif ($order->status == 'confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif ($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            @if ($order->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($order->payment_status == 'waiting_confirmation')
                                                <span class="badge bg-info">Menunggu Konfirmasi</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <td>{{ $order->payment_method ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ $order->notes ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</td>
                                    </tr>
                                </table>

                                <h4 class="mt-4">Daftar Produk</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                                </td>
                                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Instruksi pembayaran --}}
                                @if ($order->status == 'pending' && $order->payment_status != 'waiting_confirmation')
                                    <div class="alert alert-info mt-4">
                                        <h5>Instruksi Pembayaran</h5>
                                        <p>Transfer ke <b>BRI</b> 5481 0103 1262 537 a.n Agung</p>

                                        <p>Total yang harus dibayar:
                                            <b>Rp{{ number_format($order->total_price, 0, ',', '.') }}</b>
                                        </p>

                                        <p>Setelah transfer, upload bukti pembayaran di bawah.</p>
                                    </div>

                                    <form action="{{ route('user.orders.uploadPaymentProof', $order->id) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-3">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                            <input type="file"
                                                class="form-control @error('payment_proof') is-invalid @enderror"
                                                name="payment_proof" required>
                                            @error('payment_proof')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-upload"></i> Upload
                                        </button>
                                    </form>
                                @endif

                                @if ($order->payment_status == 'waiting_confirmation')
                                    @if (auth()->user()->role == 'admin')
                                        {{-- Jika ada bukti pembayaran --}}
                                        @if ($order->payment_proof)
                                            <div class="mt-4">
                                                <h5>Bukti Pembayaran</h5>
                                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                                        alt="Bukti Pembayaran" class="img-fluid img-thumbnail"
                                                        style="max-width: 400px;">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="alert alert-warning mt-4">
                                            Bukti pembayaran sudah dikirim user.
                                            Silakan konfirmasi pembayaran.
                                        </div>

                                        <form action="{{ route('admin.orders.confirmPayment', $order->id) }}"
                                            method="POST" class="mt-3">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="approve" class="btn btn-success">
                                                <i class="fa fa-check"></i> Setujui Pembayaran
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-danger">
                                                <i class="fa fa-times"></i> Tolak Pembayaran
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-secondary mt-4">
                                            Bukti pembayaran sudah dikirim. Menunggu konfirmasi admin.
                                            <p>Jika ada kendala atau ingin konfirmasi lebih cepat, silakan hubungi admin di:
                                                <br>
                                                <a href="https://wa.me/6282286456213" target="_blank">+6282286456213</a>
                                            </p>
                                        </div>
                                    @endif
                                @elseif($order->payment_status == 'paid')
                                    {{-- Tombol Pengembalian Produk --}}
                                    <div class="alert alert-success mt-4">
                                        ✅ Pembayaran sudah diterima. Terima kasih!
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
