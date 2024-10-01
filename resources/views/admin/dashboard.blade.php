@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Produk</h5>
                    <p>{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Produk Aktif</h5>
                    <p>{{ $activeProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Produk Nonaktif</h5>
                    <p>{{ $inactiveProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Stok</h5>
                    <p>{{ $totalStock }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                Kelola Produk
            </a>
        </div>
    </div>
</div>
@endsection
