# Guia Completa: Laravel + Base de Datos + Pruebas en Postman

## 1. Crear el proyecto (desde cero)

Si no tienes proyecto aun:

```bash
composer create-project laravel/laravel lara23
cd lara23
```

Si ya tienes este proyecto (clonado), entra directo:

```bash
cd lara23
```

## 2. Requisitos

Instala y verifica:

- PHP 8.2+
- Composer
- Node.js y npm
- XAMPP (MySQL)
- Postman

Comandos de verificacion:

```bash
php -v
composer -V
node -v
npm -v
```

## 3. Configurar base de datos (XAMPP)

1. Abre XAMPP y enciende MySQL.
2. En phpMyAdmin crea una base de datos, por ejemplo: `lara23`.
3. Configura el archivo `.env` del proyecto.

Valores recomendados (ajusta a tu maquina):

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lara23
DB_USERNAME=root
DB_PASSWORD=
```

> Nota: si tu MySQL usa otro puerto (por ejemplo 3307), cambia `DB_PORT`.

## 4. Instalar dependencias del proyecto

```bash
composer install
npm install
```

## 5. Generar clave y preparar tablas

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
```

## 6. Levantar el servidor

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

URL base local:

- `http://127.0.0.1:8000`

## 7. Verificar que la API existe

Rutas API de este proyecto:

- `GET /api/categorias`
- `POST /api/categorias`
- `GET /api/categorias/{id}`
- `PUT /api/categorias/{id}`
- `DELETE /api/categorias/{id}`
- `GET /api/productos`
- `POST /api/productos`
- `GET /api/productos/{id}`
- `PUT /api/productos/{id}`
- `DELETE /api/productos/{id}`

## 8. Configurar Postman

1. Crea una Collection, por ejemplo: `API LARA23`.
2. Crea un Environment con variable:
   - `base_url = http://127.0.0.1:8000`
3. En cada request usa headers:
   - `Accept: application/json`
   - `Content-Type: application/json` (cuando envias body)

## 9. Pruebas en Postman (10 endpoints)

## 9.1 Categorias

### 1) Listar categorias

- Metodo: `GET`
- URL: `{{base_url}}/api/categorias`
- Body: ninguno
- Esperado: `200 OK`

### 2) Crear categoria

- Metodo: `POST`
- URL: `{{base_url}}/api/categorias`
- Body (raw JSON):

```json
{
  "name": "Deportes",
  "description": "Categoria de prueba desde Postman"
}
```

- Esperado: `201 Created`

### 3) Obtener categoria por id

- Metodo: `GET`
- URL: `{{base_url}}/api/categorias/1`
- Body: ninguno
- Esperado: `200 OK` (o `404` si no existe)

### 4) Actualizar categoria

- Metodo: `PUT`
- URL: `{{base_url}}/api/categorias/1`
- Body (raw JSON):

```json
{
  "name": "Deportes Actualizada",
  "description": "Descripcion actualizada"
}
```

- Esperado: `200 OK`

### 5) Eliminar categoria

- Metodo: `DELETE`
- URL: `{{base_url}}/api/categorias/1`
- Body: ninguno
- Esperado: `200 OK` o `409 Conflict` si tiene productos asociados

## 9.2 Productos

### 6) Listar productos

- Metodo: `GET`
- URL: `{{base_url}}/api/productos`
- Body: ninguno
- Esperado: `200 OK`

### 7) Crear producto

- Metodo: `POST`
- URL: `{{base_url}}/api/productos`
- Body (raw JSON):

```json
{
  "name": "Tenis de prueba",
  "description": "Descripcion corta",
  "descriptionLong": "Descripcion larga de prueba",
  "price": 99.99,
  "id_category": 1
}
```

- Esperado: `201 Created`
- Nota: `id_category` debe existir en la tabla categories

### 8) Obtener producto por id

- Metodo: `GET`
- URL: `{{base_url}}/api/productos/1`
- Body: ninguno
- Esperado: `200 OK` (o `404` si no existe)

### 9) Actualizar producto

- Metodo: `PUT`
- URL: `{{base_url}}/api/productos/1`
- Body (raw JSON):

```json
{
  "name": "Tenis actualizado",
  "description": "Descripcion editada",
  "descriptionLong": "Descripcion larga editada",
  "price": 129.99,
  "id_category": 1
}
```

- Esperado: `200 OK`

### 10) Eliminar producto

- Metodo: `DELETE`
- URL: `{{base_url}}/api/productos/1`
- Body: ninguno
- Esperado: `200 OK`

## 10. Evidencia para entrega (capturas)

Para cada endpoint toma captura mostrando:

1. Metodo HTTP
2. URL
3. Body JSON (si aplica)
4. Status code
5. Respuesta JSON

## 11. Errores comunes y solucion rapida

### Error 500 en Postman

- Verifica que el servidor este corriendo (`php artisan serve`).
- Revisa `.env` y datos de DB.
- Ejecuta:

```bash
php artisan optimize:clear
php artisan migrate --force
php artisan db:seed --force
```

### Error 422 Unprocessable Entity

- Falta algun campo requerido.
- Revisa nombres exactos del body JSON.

### Error de categoria al crear producto

- `id_category` no existe.
- Crea primero una categoria y luego el producto.

## 12. Comando de validacion de rutas

```bash
php artisan route:list --path=api
```

Con esto debes tener el proyecto funcionando y las pruebas completas en Postman.
