@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Produk</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
            </div>
        
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
            </div>
        
            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
            </div>
        
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
        
    </div>
@endsection
