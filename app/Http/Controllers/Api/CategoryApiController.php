<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoryApiController extends Controller
{
    public function index()
    {
        return response()->json(Category::orderBy('id')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = new Category($data);
        $category->id = $this->nextAvailableId();
        $category->save();

        return response()->json([
            'message' => 'Categoria creada exitosamente.',
            'data' => $category,
        ], 201);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json([
            'message' => 'Categoria actualizada exitosamente.',
            'data' => $category,
        ]);
    }

    public function destroy(Category $category)
    {
        if (Product::where('id_category', $category->id)->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la categoria porque tiene productos asociados.',
            ], 409);
        }

        try {
            $category->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'No se puede eliminar la categoria porque tiene productos relacionados.',
            ], 409);
        }

        return response()->json([
            'message' => 'Categoria eliminada exitosamente.',
        ]);
    }

    private function nextAvailableId(): int
    {
        $ids = Category::orderBy('id')->pluck('id');
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
