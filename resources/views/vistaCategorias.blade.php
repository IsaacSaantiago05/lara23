<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --danger: #dc2626;
            --danger-hover: #b91c1c;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --error-bg: #fef2f2;
            --error-text: #991b1b;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 1000px;
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
            margin: 0 0 16px;
            font-size: 24px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 14px;
            align-items: center;
        }

        .message {
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .message.success {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid #a7f3d0;
        }

        .message.error {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #fecaca;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background: var(--primary);
        }

        .btn:hover { background: var(--primary-hover); }
        .btn-danger { background: var(--danger); }
        .btn-danger:hover { background: var(--danger-hover); }
        .btn-secondary { background: #4b5563; }
        .btn-secondary:hover { background: #374151; }

        input[type="number"] {
            padding: 8px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            min-width: 180px;
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
        }

        th, td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            font-size: 14px;
            vertical-align: top;
        }

        th {
            background: #f9fafb;
            color: var(--muted);
            font-weight: 600;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .muted {
            color: var(--muted);
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Categorias</h1>

            @if (session('success'))
                <p class="message success">{{ session('success') }}</p>
            @endif

            @if (session('error'))
                <p class="message error">{{ session('error') }}</p>
            @endif

            <div class="row">
                <a class="btn" href="{{ route('Categorias.create') }}">Crear Nueva Categoria</a>
            </div>

            <form class="row" action="{{ route('Categorias.buscar') }}" method="GET">
                <label for="id">Consultar categoria por ID:</label>
                <input id="id" type="number" name="id" min="1" required>
                <button class="btn btn-secondary" type="submit">Buscar</button>
            </form>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                    @foreach ($category as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->description }}</td>
                <td>
                    <div class="actions">
                        <form action="{{ route('Categorias.show', $cat->id) }}" method="GET">
                            <button class="btn btn-secondary" type="submit">Ver</button>
                        </form>
                        <form action="{{ route('Categorias.edit', $cat->id) }}" method="GET">
                            <button class="btn" type="submit">Editar</button>
                        </form>
                        <form action="{{ route('Categorias.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar esta categoria? Esta accion no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
                    @endforeach
                </table>
            </div>
            <p class="muted">Total de categorias: {{ count($category) }}</p>
        </div>
    </div>
</body>
</html>