<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ctrlProductos extends Controller
{
    public function Productos(){
        $product = Product::with('category')->get();              // 1. obtener productos con su categoría
        Return view('vistaProductos')->with(compact('product')); // 2. enviarlos a la vista
    }

    public function create(){
        return view('vistaCreateProducto');
    }

    public function buscarId(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $product = Product::find($data['id']);

        if (!$product) {
            return redirect()->route('Productos')->with('error', 'No se encontró el producto con ID '.$data['id'].'.');
        }

        return redirect()->route('Productos.show', $product->id);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'descriptionLong' => 'required',
            'price' => 'required|numeric',
            'id_category' => 'required|exists:categories,id',
        ]);

        $product = new Product($data);
        $product->id = $this->nextAvailableId();
        $product->save();

        return redirect()->route('Productos')->with('success', 'Producto creado exitosamente.');
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

    public function edit(Product $product){
        return view('vistaEditProducto')->with(compact('product'));
    }

    public function show(Product $product){
        $product->load('category');

        return view('vistaShowProducto')->with(compact('product'));
    }

    public function update(Request $request, Product $product){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'descriptionLong' => 'required|string',
            'price' => 'required|numeric|min:0',
            'id_category' => 'required|exists:categories,id',
        ]);

        $product->update($data);

        return redirect()->route('Productos')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product){
        $product->delete();

        return redirect()->route('Productos')->with('success', 'Producto eliminado exitosamente.');
    }
}
