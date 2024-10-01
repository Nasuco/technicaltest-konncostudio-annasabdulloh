<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1 class="text-3xl font-bold mb-4 text-center">Available Products</h1>
                        <p class="text-gray-600 text-center mb-6">Explore our collection and find what you need.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="transform transition duration-500 hover:scale-105">
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover"> 
                                        <div class="p-4">
                                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h2>
                                            <p class="text-gray-600 mb-2">Price: <span class="font-bold text-indigo-600">{{ number_format($product->price, 2) }}</span></p>
                                            <p class="text-gray-600 mb-4">Stock: <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $product->stock }}</span></p>

                                            @if($product->stock > 0)
                                                <form action="{{ route('customer.add_to_cart', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-full">
                                                        Add to Cart
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled class="bg-gray-400 text-white font-bold py-2 px-4 rounded-full cursor-not-allowed">
                                                    Out of Stock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>