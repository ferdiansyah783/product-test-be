<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Price;
use App\Models\PriceDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('name'); // Nama produk atau kata kunci
        $tier = $request->input('tier'); // Tier yang dipilih
        $productCategory = $request->input('category'); // Kategori produk yang dipilih

        $query = Product::with(['prices.priceDetails']);

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if (!empty($productCategory)) {
            $query->where('product_category', 'like', '%' . $productCategory . '%');
        }

        if (!empty($tier)) {
            $query->whereHas('prices.priceDetails', function ($query) use ($tier) {
                $query->where('tier', 'like', '%' . $tier . '%');
            });
        }

        if (!empty($tier)) {
            $query->has('prices.priceDetails'); // Pastikan produk memiliki detail harga dengan tier yang dipilih
        }

        $products = $query->get();

        return response()->json($products);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'product_category' => 'required|string|in:' . implode(',', Product::CATEGORIES),
            'description' => 'nullable|string|max:255',
        ]);

        $product = Product::create($request->only('name', 'product_category', 'description'));

        // Simpan Price dan PriceDetail
        if ($request->has('prices')) {
            foreach ($request->prices as $priceData) {
                $price = Price::create([
                    'product_id' => $product->id,
                    'unit' => $priceData['unit'],
                ]);

                if (isset($priceData['price_details'])) {
                    foreach ($priceData['price_details'] as $detail) {
                        PriceDetail::create([
                            'price_id' => $price->id,
                            'tier' => $detail['tier'],
                            'price' => $detail['price'],
                        ]);
                    }
                }
            }
        }

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::with(['prices.priceDetails'])->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only('name', 'product_category', 'description'));

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}

