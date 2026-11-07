@extends('layouts.app')
@section('title', 'Add cigarettes')

@section('content')
@php
    $input = 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400';
    $label = 'block text-sm font-semibold mb-1';
    $hint  = 'text-xs text-slate-500 mt-1';
@endphp

<h1 class="text-2xl font-bold mb-1">🚬 Add cigarettes</h1>
<p class="text-sm text-slate-500 mb-4">Sold by the pack or by the stick.</p>

<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
      class="bg-white rounded-xl shadow-sm p-5 space-y-4 max-w-xl">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category->id }}">

    @include('products._photo')

    <div>
        <label class="{{ $label }}">Brand name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Marlboro Red" class="{{ $input }}" required>
    </div>

    <input type="hidden" name="units_per_pack" value="20">

    <div>
        <label class="{{ $label }}">Packs in stock</label>
    
        <input type="number" id="stockPacks" name="stock_packs" min="0" inputmode="numeric"
               value="{{ old('stock_packs', 0) }}" class="{{ $input }} text-center text-lg font-semibold">
    
        <div class="grid grid-cols-6 gap-2 mt-2">
            @foreach ([-10, -5, -1, 1, 5, 10] as $n)
                <button type="button" data-step="{{ $n }}"
                        class="py-2 rounded-lg border font-semibold text-sm
                               {{ $n < 0
                                   ? 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100 active:bg-red-200'
                                   : 'border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 active:bg-indigo-200' }}">
                    {{ $n > 0 ? '+' . $n : $n }}
                </button>
            @endforeach
        </div>
    
        <p class="{{ $hint }}">Tap the buttons to add or remove packs, or type the number.</p>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="{{ $label }}">Cost per pack (₱)</label>
            <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price') }}" class="{{ $input }}" required>
            <p class="{{ $hint }}">What you pay the supplier.</p>
        </div>
        <div>
            <label class="{{ $label }}">Sell per pack (₱)</label>
            <input type="number" step="0.01" min="0" name="price_per_pack" value="{{ old('price_per_pack') }}" class="{{ $input }}" required>
            <p class="{{ $hint }}">Customer price.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="{{ $label }}">Sell per stick (₱)</label>
            <input type="number" step="0.01" min="0" name="price_per_stick" value="{{ old('price_per_stick') }}" class="{{ $input }}">
            <p class="{{ $hint }}">Leave empty if never sold by stick.</p>
        </div>
        <div>
            <label class="{{ $label }}">Low-stock alert (packs)</label>
            <input type="number" min="0" name="reorder_level" value="{{ old('reorder_level', 2) }}" class="{{ $input }}" required>
            <p class="{{ $hint }}">Warn me at this many packs.</p>
        </div>
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700">Save</button>
        <a href="{{ route('inventory') }}" class="px-5 py-2 rounded-lg border border-slate-300">Cancel</a>
    </div>
</form>
<script>
    const packsInput = document.getElementById('stockPacks');

    document.querySelectorAll('[data-step]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const current = parseInt(packsInput.value) || 0;
            const next = current + parseInt(btn.dataset.step);
            packsInput.value = Math.max(0, next);    // never go below 0
        });
    });
</script>
@endsection