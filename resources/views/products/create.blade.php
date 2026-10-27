@extends('layouts.app')
@section('title', 'Add product')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add product</h1>
    @include('products._form')
@endsection