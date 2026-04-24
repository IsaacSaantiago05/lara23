<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tenis</title>
    <style>
        :root { --bg:#f5f7fb; --card:#fff; --text:#1f2937; --muted:#6b7280; --line:#e5e7eb; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background:var(--bg); color:var(--text); }
        .container { max-width:900px; margin:24px auto; padding:0 16px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:10px; padding:18px; }
        h1 { margin:0 0 14px; font-size:24px; }
        .grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:12px; }
        .field { display:flex; flex-direction:column; gap:6px; }
        .full { grid-column:1 / -1; }
        label { font-size:13px; color:var(--muted); }
        input, textarea, select { border:1px solid var(--line); border-radius:8px; padding:9px 10px; font-size:14px; width:100%; }
        textarea { min-height:90px; resize:vertical; }
        .actions { margin-top:14px; display:flex; gap:8px; flex-wrap:wrap; }
        .btn { display:inline-block; border:1px solid var(--line); border-radius:8px; padding:8px 12px; background:#fff; text-decoration:none; color:var(--text); cursor:pointer; }
        .btn.primary { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
        .errors { margin-bottom:12px; padding:10px 12px; border-radius:8px; border:1px solid #fecaca; background:#fef2f2; color:#991b1b; font-size:14px; }
        @media (max-width: 700px) { .grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Editar Tenis #{{ $product['id'] }}</h1>

            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('Tenis.update', $product['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid">
                    <div class="field">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $product['nombre'] ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label>Tipo</label>
                        <input type="text" name="tipo" value="{{ old('tipo', $product['tipo'] ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label>Genero</label>
                        <input type="text" name="genero" value="{{ old('genero', $product['genero'] ?? '') }}" required>
                    </div>
                    <div class="field">
                        <label>Precio</label>
                        <input type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $product['precio'] ?? 0) }}" required>
                    </div>
                    <div class="field">
                        <label>Descuento (0 a 1)</label>
                        <input type="number" step="0.01" min="0" max="1" name="descuento" value="{{ old('descuento', $product['descuento'] ?? 0) }}" required>
                    </div>
                    <div class="field">
                        <label>Stock</label>
                        <input type="number" min="0" name="stock" value="{{ old('stock', $product['stock'] ?? 0) }}" required>
                    </div>
                    <div class="field">
                        <label>Valoracion (0 a 5)</label>
                        <input type="number" step="0.1" min="0" max="5" name="valoracion" value="{{ old('valoracion', $product['valoracion'] ?? 4.5) }}" required>
                    </div>
                    <div class="field">
                        <label>Envio gratis</label>
                        <select name="envio_gratis">
                            <option value="1" {{ old('envio_gratis', !empty($product['envio']['gratis']) ? '1' : '0') == '1' ? 'selected' : '' }}>Si</option>
                            <option value="0" {{ old('envio_gratis', !empty($product['envio']['gratis']) ? '1' : '0') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Tiempo envio (dias)</label>
                        <input type="number" min="1" name="envio_tiempo" value="{{ old('envio_tiempo', $product['envio']['tiempo_estimado_dias'] ?? 3) }}" required>
                    </div>
                    <div class="field">
                        <label>Material exterior</label>
                        <input type="text" name="material_exterior" value="{{ old('material_exterior', $product['material']['exterior'] ?? '') }}">
                    </div>
                    <div class="field">
                        <label>Material suela</label>
                        <input type="text" name="material_suela" value="{{ old('material_suela', $product['material']['suela'] ?? '') }}">
                    </div>
                    <div class="field full">
                        <label>Descripcion</label>
                        <textarea name="descripcion" required>{{ old('descripcion', $product['descripcion'] ?? '') }}</textarea>
                    </div>
                    <div class="field full">
                        <label>Colores disponibles (separados por coma)</label>
                        <input type="text" name="colores_disponibles" value="{{ old('colores_disponibles', isset($product['colores_disponibles']) ? implode(', ', $product['colores_disponibles']) : '') }}">
                    </div>
                    <div class="field full">
                        <label>Tallas disponibles (separadas por coma)</label>
                        <input type="text" name="tallas_disponibles" value="{{ old('tallas_disponibles', isset($product['tallas_disponibles']) ? implode(', ', $product['tallas_disponibles']) : '') }}">
                    </div>
                    <div class="field full">
                        <label>Caracteristicas (separadas por coma)</label>
                        <input type="text" name="caracteristicas" value="{{ old('caracteristicas', isset($product['caracteristicas']) ? implode(', ', $product['caracteristicas']) : '') }}">
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn primary">Actualizar</button>
                    <a href="{{ route('Tenis') }}" class="btn">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
