<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ctrlTenis extends Controller
{
    public function json(): JsonResponse
    {
        return response()->json($this->readCatalog());
    }

    public function vista(): View
    {
        $catalog = $this->readCatalog();
        $products = $catalog['productos'] ?? [];

        return view('vistaTenis', compact('catalog', 'products'));
    }

    public function create(): View
    {
        return view('vistaCreateTenis');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateTenis($request);
        $catalog = $this->readCatalog();
        $products = $catalog['productos'] ?? [];

        $products[] = $this->mapPayloadToProduct($data, $this->nextAvailableId($products));
        $catalog['productos'] = $products;
        $catalog['ultima_actualizacion'] = now()->toDateString();

        $this->writeCatalog($catalog);

        return redirect()->route('Tenis')->with('success', 'Tenis agregado correctamente.');
    }

    public function edit(int $id): View
    {
        $catalog = $this->readCatalog();
        $index = $this->findProductIndexById($catalog['productos'] ?? [], $id);

        if ($index === null) {
            abort(404, 'No se encontro el tenis solicitado.');
        }

        $product = $catalog['productos'][$index];

        return view('vistaEditTenis', compact('product'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $this->validateTenis($request);
        $catalog = $this->readCatalog();
        $products = $catalog['productos'] ?? [];
        $index = $this->findProductIndexById($products, $id);

        if ($index === null) {
            abort(404, 'No se encontro el tenis solicitado.');
        }

        $products[$index] = $this->mapPayloadToProduct($data, $id);
        $catalog['productos'] = array_values($products);
        $catalog['ultima_actualizacion'] = now()->toDateString();

        $this->writeCatalog($catalog);

        return redirect()->route('Tenis')->with('success', 'Tenis actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $catalog = $this->readCatalog();
        $products = $catalog['productos'] ?? [];
        $index = $this->findProductIndexById($products, $id);

        if ($index === null) {
            abort(404, 'No se encontro el tenis solicitado.');
        }

        unset($products[$index]);
        $catalog['productos'] = array_values($products);
        $catalog['ultima_actualizacion'] = now()->toDateString();

        $this->writeCatalog($catalog);

        return redirect()->route('Tenis')->with('success', 'Tenis eliminado correctamente.');
    }

    private function validateTenis(Request $request): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'genero' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'descuento' => 'required|numeric|min:0|max:1',
            'stock' => 'required|integer|min:0',
            'valoracion' => 'required|numeric|min:0|max:5',
            'colores_disponibles' => 'nullable|string',
            'tallas_disponibles' => 'nullable|string',
            'caracteristicas' => 'nullable|string',
            'material_exterior' => 'nullable|string|max:255',
            'material_suela' => 'nullable|string|max:255',
            'envio_gratis' => 'nullable|boolean',
            'envio_tiempo' => 'required|integer|min:1',
        ]);
    }

    private function mapPayloadToProduct(array $data, int $id): array
    {
        $colores = $this->splitCsv($data['colores_disponibles'] ?? '');
        $tallas = array_map('intval', $this->splitCsv($data['tallas_disponibles'] ?? ''));
        $caracteristicas = $this->splitCsv($data['caracteristicas'] ?? '');

        return [
            'id' => $id,
            'nombre' => $data['nombre'],
            'tipo' => $data['tipo'],
            'genero' => $data['genero'],
            'descripcion' => $data['descripcion'],
            'colores_disponibles' => $colores,
            'precio' => (float) $data['precio'],
            'descuento' => (float) $data['descuento'],
            'stock' => (int) $data['stock'],
            'tallas_disponibles' => $tallas,
            'material' => [
                'exterior' => $data['material_exterior'] ?? '',
                'suela' => $data['material_suela'] ?? '',
            ],
            'caracteristicas' => $caracteristicas,
            'envio' => [
                'gratis' => (bool) ($data['envio_gratis'] ?? false),
                'tiempo_estimado_dias' => (int) $data['envio_tiempo'],
            ],
            'valoracion' => (float) $data['valoracion'],
        ];
    }

    private function splitCsv(string $value): array
    {
        $parts = array_map('trim', explode(',', $value));

        return array_values(array_filter($parts, static fn ($item) => $item !== ''));
    }

    private function nextAvailableId(array $products): int
    {
        $ids = array_map(static fn ($p) => (int) ($p['id'] ?? 0), $products);
        sort($ids);

        $nextId = 1;
        foreach ($ids as $id) {
            if ($id === $nextId) {
                $nextId++;
                continue;
            }

            if ($id > $nextId) {
                break;
            }
        }

        return $nextId;
    }

    private function findProductIndexById(array $products, int $id): ?int
    {
        foreach ($products as $index => $product) {
            if ((int) ($product['id'] ?? 0) === $id) {
                return $index;
            }
        }

        return null;
    }

    private function writeCatalog(array $catalog): void
    {
        $path = base_path('tenis_nike.json');
        $encoded = json_encode($catalog, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            abort(500, 'No se pudo convertir el catalogo de tenis a JSON.');
        }

        $written = file_put_contents($path, $encoded . PHP_EOL);

        if ($written === false) {
            abort(500, 'No se pudo guardar tenis_nike.json.');
        }
    }

    private function readCatalog(): array
    {
        $path = base_path('tenis_nike.json');

        if (!is_file($path)) {
            abort(404, 'No se encontro el archivo tenis_nike.json.');
        }

        $content = file_get_contents($path);

        if ($content === false) {
            abort(500, 'No se pudo leer tenis_nike.json.');
        }

        $data = json_decode($content, true);

        if (!is_array($data)) {
            abort(500, 'El contenido de tenis_nike.json no es valido.');
        }

        if (!isset($data['productos']) || !is_array($data['productos'])) {
            abort(500, 'El catalogo de tenis no tiene la estructura esperada.');
        }

        return $data;
    }
}
