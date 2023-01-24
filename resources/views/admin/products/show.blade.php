@extends('layouts.admin')

@section('content')
    <h1>Show Product</h1>
    <div><strong>Nome:</strong> {{ $product->name }}</div>


    <div><strong>Descrizione:</strong> {{ $product->description }}</div>
    <div><strong>Prezzo:</strong> {{ $product->price }}</div>
    {{-- <div><strong>Framework:</strong> {{ $product->image }}</div> --}}
    <div><strong>Rating:</strong> {{ $product->rating }}</div>
    <div><strong>Disponibilità:</strong> {{ $product->available }}</div>
@endsection
