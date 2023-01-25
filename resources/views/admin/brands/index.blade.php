@extends('layouts.admin')

@section('content')

    <div id="table-list">
        
        <div class="table-container">
            @if(session()->has('message'))
            <div class="alert alert-success mb-3 mt-3 w-75 m-auto">
                {{ session()->get('message') }}
            </div>
            @endif
            <form action="{{ route('admin.brands.store') }}" method="POST" class="mb-5 pb-5">
                @csrf
                <h1 class="fs-2 mb-3">Aggiungi un Brand</h1>
                <div class="w-50">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required maxlength="45">
                    @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Invia</button>
                    <button type="reset" class="btn btn-danger" id="btn-reset">Resetta</button>
                </div>
            </form>
            <table class="mb-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        {{-- <th scope="col">Edit</th> --}}
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <th scope="row">{{$brand->id}}</th>
                            {{-- <td>{{$brand->name}}</td> --}}
                            <td>
                                <form action="{{route('admin.brands.update', $brand->slug)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input class="border-0 bg-transparent @error('name') is-invalid @enderror" type="text" name="name" value="{{$brand->name}}">
                                    @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </form>
                            </td>
                            {{-- <td><a class="link-secondary" href="{{route('admin.brands.index', $brand->slug)}}" title="Edit brand"><i class="fa-solid fa-pen"></i></a></td> --}}
                            <td>
                                <form action="{{route('admin.brands.destroy', $brand->slug)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button btn btn-danger ms-3" data-item-title="{{$brand->name}}"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $brands->links('vendor.pagination.bootstrap-5') }}
            @include('partials.admin.modal')
        </div>
    </div>
@endsection