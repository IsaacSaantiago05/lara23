<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;

class ctrlCategorias extends Controller
{
    public function Categorias(){
        try {
            $category = Category::all();
        } catch (QueryException $e) {
            session()->now('error', 'La tabla categories aun no existe en Railway. Ejecuta las migraciones y vuelve a desplegar.');
            $category = collect();
        }

        Return view('vistaCategorias')->with(compact('category')); // 2. enviarlas a la vista
    }

    public function create(){
        return view('vistaCreateCategoria');
    }

    public function buscarId(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $category = Category::find($data['id']);

        if (!$category) {
            return redirect()->route('Categorias')->with('error', 'No se encontró la categoría con ID '.$data['id'].'.');
        }

        return redirect()->route('Categorias.show', $category->id);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = new Category($data);
        $category->id = $this->nextAvailableId();
        $category->save();

        return redirect()->route('Categorias')->with('success', 'Categoria creada exitosamente.');
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

    public function show(Category $category){
        return view('vistaShowCategoria')->with(compact('category'));
    }

    public function edit(Category $category){
        return view('vistaEditCategoria')->with(compact('category'));
    }

    public function update(Request $request, Category $category){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('Categorias')->with('success', 'Categoria actualizada exitosamente.');
    }

    public function destroy(Category $category){
        if (Product::where('id_category', $category->id)->exists()) {
            return redirect()->route('Categorias')->with('error', 'No se puede eliminar la categoria porque tiene productos asociados.');
        }

        try {
            $category->delete();
        } catch (QueryException $e) {
            return redirect()->route('Categorias')->with('error', 'No se puede eliminar la categoria porque tiene productos relacionados.');
        }

        return redirect()->route('Categorias')->with('success', 'Categoria eliminada exitosamente.');
    }
}
