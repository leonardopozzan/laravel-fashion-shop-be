@extends('layouts.admin')
@section('content')

    <section class="container my-5">
    <h1 class="mb-4">Edit Product: {{$product->name}}</h1>
        <div class="row bg-white">
            <div class="col-12">
                <form action="{{ route('admin.products.update', $product->slug) }}" method="POST" enctype="multipart/form-data" class="form-crud">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        {{-- Nome Prodotto --}}
                        <label for="name" class="form-label">Name <span>*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $product->name)}}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Prezzo Prodotto --}}
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo <span>*</span></label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control  @error('price') is-invalid @enderror" value="{{old('price', $product->price)}}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Disponibilità Prodotto --}}
                    <div class="mb-3">
                        <label for="available" class="form-label">Disponibilità <span>*</span></label>
                        <input type="radio" name="available" value="1" {{old('available', $product->available) == 1 ? 'checked' : ''}}>
                        <span class="text-capitalize">si</span>
                        <input type="radio" name="available" value="0" {{old('available', $product->available) == 0 ? 'checked' : ''}}>
                        <span class="text-capitalize">no</span>
                        @error('available')
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
                    {{-- Tipo Prodotto (es. Eyeliner, Blush...) --}}
                    <div class="mb-3">
                        <label for="type_id" class="form-label text-capitalize">Seleziona tipo <span>*</span></label>
                        <select name="type_id" id="type_id" class="form-control @error('type_id') is-invalid @enderror text-capitalize" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ $type->id == old('type_id', $product->type_id) ? 'selected' : '' }} class="text-capitalize">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Categoria Prodotto (es. Powder, Liquid....) --}}
                    <div class="mb-3">
                        <label for="brand_id" class="form-label text-capitalize">Seleziona categoria <span>*</span></label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror text-capitalize" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }} class="text-capitalize">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Brand Prodotto --}}
                    <div class="mb-3">
                        <label for="brand_id" class="form-label text-capitalize">Seleziona Brand <span>*</span></label>
                        <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror text-capitalize" required>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == old('brand_id', $product->brand_id) ? 'selected' : '' }} class="text-capitalize">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Tag Prodotto --}}
                    <div class="mb-5 row">
                    <label for="tags" class="form-label">Tags</label> <br>
                        @foreach ($tags as $tag)
                            @if (old("tags"))
                                <div class="d-flex col-xl-2 col-lg-3 col-md-4 col-6">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{in_array( $tag->id, old("tags", []) ) ? 'checked' : ''}}>
                                    <span class="text-capitalize">{{ $tag->name }}</span>
                                </div>
                            @else
                                <div class="d-flex col-xl-2 col-lg-3 col-md-4 col-6">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }} " {{ old('tags', $product->tags) ? (old('tags', $product->tags)->contains($tag->id) ? 'checked' : '') : '' }}>
                                    <span class="text-capitalize">{{ $tag->name }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    {{-- Immagine Prodotto --}}
                    <div class="d-flex mb-5 align-items-center">
                        <div class="media me-4">
                        @if($product->image)
                            <img class="shadow" width="150" src="{{asset('storage/' . $product->image)}}" alt="{{$product->image}}">
                            @else
                            <img class="shadow" width="150" src="https://dummyimage.com/200x200/000/fff" alt="C/O https://placeholder.com/">
                        @endif
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Immagine</label>
                            <input type="file" name="image" id="image" class="form-control  @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Descrizione Prodotto --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="description" name="description">{{old('description', $product->description)}}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>
        </div>
    </section>
@endsection
