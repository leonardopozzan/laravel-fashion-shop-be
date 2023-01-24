@extends('layouts.admin')
@section('content')

    <h1>Create Products</h1>
    <section class="container my-5">
        <div class="row bg-white">
            <div class="col-12">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="">
                    @csrf
                    <div class="mb-3">
                        {{-- Nome Prodotto --}}
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Immagine Prodotto --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Immagine</label>
                        <input type="file" name="image" id="image" class="form-control  @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Descrizione Prodotto --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    {{-- Prezzo Prodotto --}}
                    <div class="mb-3">
                        <label for="price">Prezzo</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control  @error('price') is-invalid @enderror" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Rating Prodotto --}}
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <input type="number" step="0.1" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating">
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Disponibilità Prodotto --}}
                    <div class="mb-3">
                        <label for="available" class="form-label">Disponibilità</label>
                        <input type="radio" name="available" value="1" checked>
                        <span class="text-capitalize">si</span>
                        <input type="radio" name="available" value="0" >
                        <span class="text-capitalize">no</span>
                        @error('available')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Tipo Prodotto (es. Eyeliner, Blush...) --}}
                    <div class="mb-3">
                        <label for="type_id" class="form-label text-capitalize">Seleziona tipo</label>
                        <select name="type_id" id="type_id" class="form-control @error('type_id') is-invalid @enderror text-capitalize" required>
                            <option value="">Seleziona tipo</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ $type->id == old('type_id') ? 'selected' : '' }} class="text-capitalize">
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Categoria Prodotto (es. Powder, Liquid....) --}}
                    <div class="mb-3">
                        <label for="brand_id" class="form-label text-capitalize">Seleziona categoria</label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror text-capitalize" required>
                            <option value="">Seleziona categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }} class="text-capitalize">
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Brand Prodotto --}}
                    <div class="mb-3">
                        <label for="brand_id" class="form-label text-capitalize">Seleziona Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror text-capitalize" required>
                            <option value="">Seleziona Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == old('brand_id') ? 'selected' : '' }} class="text-capitalize">
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                    <label for="tags">Tags</label> <br>
                        @foreach ($tags as $tag)
                            @if (old("tags"))
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{in_array( $tag->id, old("tags", []) ) ? 'checked' : ''}}>
                                <span class="text-capitalize">{{ $tag->name }}</span>
                            @else
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }} " {{ old('tags', $product->tags) ? (old('tags', $product->tags)->contains($tag->id) ? 'checked' : '') : '' }}>
                                <span class="text-capitalize">{{ $tag->name }}</span>
                            @endif
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success" onclick="console.log('submit')">Submit</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </form>
            </div>
        </div>
    </section>
@endsection
