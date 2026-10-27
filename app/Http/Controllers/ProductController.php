<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->category, fn ($q, $c) => $q->where('category_id', $c))
            ->orderBy('name')
            ->get();

        return view('products.index', [
            'products'   => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('products.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            ...$this->rules(),
            'stock_packs' => ['nullable', 'integer', 'min:0'],
            'stock_loose' => ['nullable', 'integer', 'min:0'],
        ]);

        // Starting stock: packs and loose sticks → smallest unit
        $data['stock'] = ((int) ($data['stock_packs'] ?? 0) * $data['units_per_pack'])
                       + (int) ($data['stock_loose'] ?? 0);
        unset($data['stock_packs'], $data['stock_loose']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('inventory')->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('inventory')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('inventory')->with('success', 'Product deleted.');
    }

    private function rules(): array
    {
        return [
            'category_id'     => ['required', 'exists:categories,id'],
            'name'            => ['required', 'string', 'max:255'],
            'image'           => ['nullable', 'image', 'max:4096'],
            'units_per_pack'  => ['required', 'integer', 'min:1'],
            'cost_price'      => ['required', 'numeric', 'min:0'],
            'price_per_pack'  => ['required', 'numeric', 'min:0'],
            'price_per_stick' => ['nullable', 'numeric', 'min:0'],
            'reorder_level'   => ['required', 'integer', 'min:0'],
        ];
    }
}
