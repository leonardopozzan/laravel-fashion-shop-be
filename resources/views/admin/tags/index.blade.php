@extends('layouts.admin')

@section('content')
    <section class="container mt-5">
        @if (session()->has('message'))
            <div class="alert alert-success mb-3 mt-3 w-75 m-auto">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="{{ route('admin.tags.store') }}" method="POST" class="mb-5 pb-3">
            @csrf
            <h1 class="fs-2 mb-3">Aggiungi un Tag</h1>
            <div class="w-50">
                <label for="name">Nome</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required maxlength="45" minlength="3">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary" id="btn-submit">Invia</button>
                <button type="reset" class="btn btn-danger text-white" id="btn-reset">Resetta</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th class="" scope="col">Name</th>
                    <th class="" scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <th class="pt-4" scope="row">{{ $tag->id }}</th>
                        <td class="pt-4">
                            <form class="m-0" action="{{ route('admin.tags.update', $tag->slug) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent text-capitalize" type="text" name="name" value="{{ $tag->name }}" required maxlength="45" minlength="3">
                            </form>
                        </td>
                        <td class="pt-4">
                            <form class="m-0" action="{{ route('admin.tags.destroy', $tag->slug) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button btn btn-danger text-white" data-item-title="{{ $tag->name }}"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $tags->links('vendor.pagination.bootstrap-5') }}
        </div>
        @include('partials.admin.modal')
    </section>
</div>
@endsection