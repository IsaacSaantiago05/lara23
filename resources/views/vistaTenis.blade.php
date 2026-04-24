<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Tenis</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 1200px;
            margin: 24px auto;
            padding: 0 16px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 18px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 24px;
        }

        p {
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--line);
            text-decoration: none;
            color: var(--text);
            background: #fff;
            font-size: 13px;
            cursor: pointer;
        }

        .btn.primary {
            background: #1d4ed8;
            color: #fff;
            border-color: #1d4ed8;
        }

        .btn.danger {
            background: #dc2626;
            color: #fff;
            border-color: #dc2626;
        }

        .msg {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .inline {
            display: inline;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            font-size: 14px;
        }

        th, td {
            padding: 9px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #f9fafb;
            color: var(--muted);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>{{ $catalog['marca'] ?? 'Nike' }} - Catalogo de Tenis</h1>
            <p>Total de productos: {{ count($products) }} | Moneda: {{ $catalog['moneda'] ?? 'USD' }} | Actualizado: {{ $catalog['ultima_actualizacion'] ?? 'N/A' }}</p>

            @if (session('success'))
                <div class="msg">{{ session('success') }}</div>
            @endif

            <div class="actions">
                <a href="{{ route('Tenis.create') }}" class="btn primary">Agregar tenis</a>
                <a href="{{ route('Tenis.json') }}" class="btn">Ver JSON</a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Genero</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Precio Final</th>
                            <th>Stock</th>
                            <th>Valoracion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $shoe)
                            @php
                                $price = (float) ($shoe['precio'] ?? 0);
                                $discount = (float) ($shoe['descuento'] ?? 0);
                                $finalPrice = $price * (1 - $discount);
                            @endphp
                            <tr>
                                <td>{{ $shoe['id'] ?? '' }}</td>
                                <td>{{ $shoe['nombre'] ?? '' }}</td>
                                <td>{{ $shoe['tipo'] ?? '' }}</td>
                                <td>{{ $shoe['genero'] ?? '' }}</td>
                                <td>{{ number_format($price, 2) }}</td>
                                <td>{{ number_format($discount * 100, 0) }}%</td>
                                <td>{{ number_format($finalPrice, 2) }}</td>
                                <td>{{ $shoe['stock'] ?? '' }}</td>
                                <td>{{ $shoe['valoracion'] ?? '' }}</td>
                                <td>
                                    <a href="{{ route('Tenis.edit', $shoe['id']) }}" class="btn">Editar</a>
                                    <form action="{{ route('Tenis.destroy', $shoe['id']) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este tenis?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
