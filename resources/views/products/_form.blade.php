@php
    $p = $product ?? null;
    $input = 'w-full border border-slate-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400';
    $label = 'block text-sm font-semibold mb-1';
@endphp

<form method="POST" enctype="multipart/form-data"
      action="{{ $p ? route('products.update', $p) : route('products.store') }}"
      class="bg-white rounded-xl shadow-sm p-5 space-y-4 max-w-xl">
    @csrf
    @if ($p) @method('PUT') @endif

    <div>
        <label class="{{ $label }}">Category</label>
        <select name="category_id" class="{{ $input }}" required>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $p->category_id ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="{{ $label }}">Name</label>
        <input type="text" name="name" value="{{ old('name', $p->name ?? '') }}" class="{{ $input }}" required>
    </div>

    <div>
        <label class="{{ $label }}">Photo</label>
    
        <div class="flex items-center gap-4">
            {{-- Preview: shows the saved photo, then swaps to the newly chosen one --}}
            <img id="photoPreview"
                 src="{{ $p && $p->image_url ? $p->image_url : '' }}"
                 class="h-24 w-24 rounded-lg object-cover border border-slate-200 {{ $p && $p->image_url ? '' : 'hidden' }}"
                 alt="">
    
            <div>
                <label for="image"
                       class="inline-flex items-center gap-2 cursor-pointer bg-indigo-50 text-indigo-700 border border-indigo-200 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition">
                    📷 {{ $p && $p->image_url ? 'Change photo' : 'Choose photo' }}
                </label>
                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                <p id="photoName" class="text-xs text-slate-500 mt-2">No file chosen</p>
            </div>
        </div>
    </div>

    <div>
        <label class="{{ $label }}">Units per pack</label>
        <input type="number" name="units_per_pack" min="1" value="{{ old('units_per_pack', $p->units_per_pack ?? 1) }}" class="{{ $input }}" required>
        <p class="text-xs text-slate-500 mt-1">20 sticks for a cigarette pack. Use 1 for softdrinks and biscuits.</p>
    </div>

    @unless ($p)
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="{{ $label }}">Starting packs</label>
                <input type="number" name="stock_packs" min="0" value="{{ old('stock_packs', 0) }}" class="{{ $input }}">
            </div>
            <div>
                <label class="{{ $label }}">Extra loose sticks</label>
                <input type="number" name="stock_loose" min="0" value="{{ old('stock_loose', 0) }}" class="{{ $input }}">
            </div>
        </div>
    @endunless

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="{{ $label }}">Cost per pack (₱)</label>
            <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price', $p->cost_price ?? '') }}" class="{{ $input }}" required>
        </div>
        <div>
            <label class="{{ $label }}">Sell per pack (₱)</label>
            <input type="number" step="0.01" min="0" name="price_per_pack" value="{{ old('price_per_pack', $p->price_per_pack ?? '') }}" class="{{ $input }}" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="{{ $label }}">Sell per stick (₱)</label>
            <input type="number" step="0.01" min="0" name="price_per_stick" value="{{ old('price_per_stick', $p->price_per_stick ?? '') }}" class="{{ $input }}">
            <p class="text-xs text-slate-500 mt-1">Cigarettes only</p>
        </div>
        <div>
            <label class="{{ $label }}">Low-stock alert (packs)</label>
            <input type="number" min="0" name="reorder_level" value="{{ old('reorder_level', $p->reorder_level ?? 0) }}" class="{{ $input }}" required>
        </div>
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700">Save</button>
        <a href="{{ route('inventory') }}" class="px-5 py-2 rounded-lg border border-slate-300">Cancel</a>
    </div>
</form>

<script>
    document.getElementById('image').addEventListener('change', function () {
        const file = this.files[0];
        const preview = document.getElementById('photoPreview');
        document.getElementById('photoName').textContent = file ? file.name : 'No file chosen';

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>