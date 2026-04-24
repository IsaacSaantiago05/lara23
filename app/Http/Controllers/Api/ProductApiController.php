<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json(Product::orderBy('id')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'descriptionLong' => 'required|string',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
        ]);

        $product = new Product($data);
        $product->id = $this->nextAvailableId();
        $product->save();

        return response()->json([
            'message' => 'Producto creado exitosamente.',
            'data' => $product,
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'descriptionLong' => 'required|string',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
        ]);

        $product->update($data);

        return response()->json([
            'message' => 'Producto actualizado exitosamente.',
            'data' => $product,
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente.',
        ]);
    }

    private function nextAvailableId(): int
    {
        $ids = Product::orderBy('id')->pluck('id');
        $nextId = 1;

        foreach ($ids as $id) {
            if ((int) $id === $nextId) {
                $nextId++;
                continue;
            }

            if ((int) $id > $nextId) {
                break;
            }
        }

        return $nextId;
    }
}
