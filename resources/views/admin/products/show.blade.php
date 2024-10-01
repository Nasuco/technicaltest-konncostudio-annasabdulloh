@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Detail Produk</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $product->name }}</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <strong>Nama Produk:</strong>
                <p>{{ $product->name }}</p>
            </div>

            <div class="mb-3">
                <strong>Harga:</strong>
                <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            <div class="mb-3">
                <strong>Stok:</strong>
                <p>{{ $product->stock }} unit</p>
            </div>

            <div class="mb-3">
                <strong>Status:</strong>
                <p>
                    @if($product->status == 1)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                    @endif
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Produk</a>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary mt-3">Edit Produk</a>
        </div>
    </div>
</div>
@endsection
