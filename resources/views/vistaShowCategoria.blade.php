<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Categoria</title>
    <style>
        :root { --bg:#f5f7fb; --card:#fff; --text:#1f2937; --muted:#6b7280; --line:#e5e7eb; --primary:#2563eb; --primary-hover:#1d4ed8; --secondary:#4b5563; --secondary-hover:#374151; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background:var(--bg); color:var(--text); }
        .container { max-width:820px; margin:24px auto; padding:0 16px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:10px; padding:18px; }
        h1 { margin:0 0 14px; font-size:24px; }
        .grid { display:grid; grid-template-columns:170px 1fr; gap:8px 14px; font-size:14px; }
        .grid strong { color:var(--muted); }
        .actions { display:flex; gap:10px; margin-top:16px; }
        .btn { border:none; border-radius:8px; padding:8px 12px; font-size:14px; cursor:pointer; text-decoration:none; color:#fff; background:var(--primary); display:inline-block; }
        .btn:hover { background:var(--primary-hover); }
        .btn-secondary { background:var(--secondary); }
        .btn-secondary:hover { background:var(--secondary-hover); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Detalle de la Categoria</h1>

            <div class="grid">
                <strong>ID</strong><span>{{ $category->id }}</span>
                <strong>Nombre</strong><span>{{ $category->name }}</span>
                <strong>Descripcion</strong><span>{{ $category->description }}</span>
            </div>

            <div class="actions">
                <a class="btn" href="{{ route('Categorias.edit', $category->id) }}">Editar</a>
                <a class="btn btn-secondary" href="{{ route('Categorias') }}">Volver al listado</a>
            </div>
        </div>
    </div>
</body>
</html>
