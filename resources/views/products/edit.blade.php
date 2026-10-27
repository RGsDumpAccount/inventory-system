@extends('layouts.app')
@section('title', 'Edit product')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit {{ $product->name }}</h1>
    @include('products._form', ['product' => $product])
@endsection