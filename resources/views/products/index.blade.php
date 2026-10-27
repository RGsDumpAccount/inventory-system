@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Products</h1>
    <a href="{{ route('products.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">+ Add product</a>
</div>

<div class="flex gap-2 mb-4 overflow-x-auto">
    <a href="{{ route('inventory') }}"
       class="px-3 py-1 rounded-full text-sm whitespace-nowrap {{ request('category') ? 'bg-white' : 'bg-indigo-600 text-white' }}">All</a>
    @foreach ($categories as $c)
        <a href="{{ route('inventory', ['category' => $c->id]) }}"
           class="px-3 py-1 rounded-full text-sm whitespace-nowrap {{ request('category') == $c->id ? 'bg-indigo-600 text-white' : 'bg-white' }}">{{ $c->name }}</a>
    @endforeach
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse ($products as $p)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
            @if ($p->image_url)
                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="h-32 w-full object-cover">
            @else
                <div class="h-32 bg-slate-200 flex items-center justify-center text-3xl">📦</div>
            @endif

            <div class="p-3 flex-1">
                <p class="text-xs text-slate-500">{{ $p->category->name }}</p>
                <h2 class="font-semibold">{{ $p->name }}</h2>
                <p class="text-sm mt-1 {{ $p->is_low ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                    {{ $p->stock_label }} @if ($p->is_low) ⚠ low @endif
                </p>
                <p class="text-sm text-slate-600">
                    ₱{{ number_format($p->price_per_pack, 2) }} / {{ $p->units_per_pack > 1 ? 'pack' : 'pc' }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Worth ₱{{ number_format($p->expected_by_pack, 2) }}</p>
            </div>

            <div class="flex border-t text-sm">
                <a href="{{ route('products.edit', $p) }}" class="flex-1 text-center py-2 hover:bg-slate-50">Edit</a>
                <form method="POST" action="{{ route('products.destroy', $p) }}" class="flex-1 border-l"
                      onsubmit="return confirm('Delete {{ $p->name }}?')">
                    @csrf @method('DELETE')
                    <button class="w-full py-2 text-red-600 hover:bg-red-50">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-500 col-span-full">No products yet. Add your first one.</p>
    @endforelse
</div>
@endsection