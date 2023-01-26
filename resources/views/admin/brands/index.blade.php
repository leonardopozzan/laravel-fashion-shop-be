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
                    <input type="text" class="form-control @if(count($errors->store_errors)) is-invalid @endif" name="name" id="name" required maxlength="45">
                    @if(count($errors->store_errors))
                        <div class="invalid-feedback">{{$errors->store_errors->first('name')}}</div>
                    @endif
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Invia</button>
                    <button type="reset" class="btn btn-danger text-white" id="btn-reset">Reset</button>
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
                    @foreach ($brands as $key => $brand)
                        <tr>
                            <th scope="row">{{$brand->id}}</th>
                            {{-- <td>{{$brand->name}}</td> --}}
                            <td>
                                <form action="{{route('admin.brands.update', $brand->slug)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input class="border-0 bg-transparent text-capitalize @if(count($errors->update_errors)) is-invalid @endif" type="text" name="name" value="{{$brand->name}}">
                                    @if(count($errors->update_errors))
                                        @if(session()->get('brand_id') == $brand->id)
                                            <div class="invalid-feedback">{{$errors->update_errors->first('name')}}</div>
                                        @endif
                                    @endif
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