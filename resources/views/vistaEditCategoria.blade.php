<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <style>
        :root { --bg:#f5f7fb; --card:#fff; --text:#1f2937; --line:#e5e7eb; --primary:#2563eb; --primary-hover:#1d4ed8; --secondary:#4b5563; --secondary-hover:#374151; --error-bg:#fef2f2; --error-text:#991b1b; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background:var(--bg); color:var(--text); }
        .container { max-width:820px; margin:24px auto; padding:0 16px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:10px; padding:18px; }
        h1 { margin:0 0 14px; font-size:24px; }
        .form-group { margin-bottom:12px; }
        label { display:block; margin-bottom:6px; font-size:14px; }
        input, textarea { width:100%; padding:9px 10px; border:1px solid var(--line); border-radius:8px; font-size:14px; }
        textarea { resize:vertical; min-height:100px; }
        .actions { display:flex; gap:10px; margin-top:14px; }
        .btn { border:none; border-radius:8px; padding:8px 12px; font-size:14px; cursor:pointer; text-decoration:none; color:#fff; background:var(--primary); }
        .btn:hover { background:var(--primary-hover); }
        .btn-secondary { background:var(--secondary); }
        .btn-secondary:hover { background:var(--secondary-hover); }
        .errors { background:var(--error-bg); color:var(--error-text); border:1px solid #fecaca; border-radius:8px; padding:10px 14px; margin-bottom:12px; }
        .errors ul { margin:0; padding-left:18px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Editar Categoria #{{ $category->id }}</h1>

            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('Categorias.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}">
                </div>

                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">Actualizar</button>
                    <a class="btn btn-secondary" href="{{ route('Categorias') }}">Volver al listado</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
