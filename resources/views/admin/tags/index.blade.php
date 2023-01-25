@extends('layouts.admin')

@section('content')
    <section id="table-list">
        <div class="table-container">
            @if (session()->has('message'))
                <div class="alert alert-success mb-3 mt-3 w-75 m-auto text-capitalize">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="{{ route('admin.tags.store') }}" method="POST" class="mb-5 pb-5">
                @csrf
                <h1 class="fs-2 mb-3">Aggiungi un Tag</h1>
                <div class="w-50">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control @if(count($errors->store_errors)) is-invalid @endif" name="name" id="name" required maxlength="45">
                        @if(count($errors->store_errors))
                            <div class="invalid-feedback">{{$errors->store_errors->first('name')}}</div>
                        @endif
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Invia</button>
                    <button type="reset" class="btn btn-danger text-white" id="btn-reset">Resetta</button>
                </div>
            </form>
            <table class="mb-2">
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
                            <th scope="row">{{ $tag->id }}</th>
                            <td>
                                <form class="m-0" action="{{ route('admin.tags.update', $tag->slug) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input class="border-0 bg-transparent @if(count($errors->update_errors)) is-invalid @endif" type="text" name="name" value="{{$tag->name}}">
                                        @if(count($errors->update_errors))
                                            @if(session()->get('tag_id') == $tag->id)
                                                <div class="invalid-feedback">{{$errors->update_errors->first('name')}}</div>
                                            @endif
                                        @endif
                                </form>
                            </td>
                            <td>
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
            {{ $tags->links('vendor.pagination.bootstrap-5') }}
            @include('partials.admin.modal')
        </div>
    </section>
</div>
@endsection