@extends('layouts.app')
@section('title', 'Add biscuit')

@section('content')
@php
    $input = 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400';
    $label = 'block text-sm font-semibold mb-1';
    $hint  = 'text-xs text-slate-500 mt-1';
@endphp

<h1 class="text-2xl font-bold mb-1">Add biscuit</h1>
<p class="text-sm text-slate-500 mb-4">Sold by a single pack of biscuit</p>

<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
      class="bg-white rounded-xl shadow-sm p-5 space-y-4 max-w-xl">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category->id }}">
    <input type="hidden" name="units_per_pack" value="1">

    @include('products._photo')

    <div>
        <label class="{{ $label }}">Brand Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Bingo Chocolate Flavor" class="{{ $input }}" required>
    </div>

    <div>
        <label class="{{ $label }}">Biscuit in stock</label>
        <input type="number" name="stock_packs" min="0" value="{{ old('stock_packs', 0) }}" class="{{ $input }}">
        <p class="{{ $hint }}">Count the biscuits in a pack.</p>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="{{ $label }}">Cost per biscuit (₱)</label>
            <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price') }}" class="{{ $input }}" required>
        </div>
        <div>
            <label class="{{ $label }}">Sell per biscuit (₱)</label>
            <input type="number" step="0.01" min="0" name="price_per_pack" value="{{ old('price_per_pack') }}" class="{{ $input }}" required>
        </div>
    </div>

    <div>
        <label class="{{ $label }}">Low-stock alert (biscuits)</label>
        <input type="number" min="0" name="reorder_level" value="{{ old('reorder_level', 20) }}" class="{{ $input }}" required>
        <p class="{{ $hint }}">Warn me at this many biscuits.</p>
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700">Save</button>
        <a href="{{ route('inventory') }}" class="px-5 py-2 rounded-lg border border-slate-300">Cancel</a>
    </div>
</form>
@endsection