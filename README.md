# Inventory API

Small Laravel API for managing products and stock quantity.

## Requirements

- Docker and Docker Compose
- PHP 8.1+ and Composer, only if running without Docker

## Setup with Docker

1. Clone the project and go inside the folder.

2. Copy the env file if it does not exist:

```bash
cp .env.example .env
```

On Windows you can also just duplicate `.env.example` and rename it to `.env`.

3. Make sure these values exist in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=inventory_db
DB_USERNAME=postgres
DB_PASSWORD=password

CACHE_DRIVER=redis
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_CLIENT=predis
```

4. Build and start the containers:

```bash
docker compose up -d --build
```

5. Install dependencies if needed:

```bash
docker compose exec app composer install
```

6. Generate app key:

```bash
docker compose exec app php artisan key:generate
```

7. Run migrations:

```bash
docker compose exec app php artisan migrate
```

8. Clear config cache:

```bash
docker compose exec app php artisan config:clear
```

The API should now run at:

```text
http://localhost:8000/api
```

## Main Endpoints

### List products

```http
GET /api/products
```

### Create product

```http
POST /api/products
```

Example body:

```json
{
  "sku": "SKU-001",
  "name": "Keyboard",
  "description": "Mechanical keyboard",
  "price": 1200,
  "stock_quantity": 15,
  "low_stock_threshold": 5,
  "status": "active"
}
```

### Show one product

```http
GET /api/products/{id}
```

### Update product

```http
PUT /api/products/{id}
```

Use the same body as create product.

### Delete product

```http
DELETE /api/products/{id}
```

### Update product stock

```http
POST /api/products/{id}/stock
```

Example body:

```json
{
  "type": "increment",
  "quantity": 3
}
```

`type` can be `increment` or `decrement`.

### Low stock products

```http
GET /api/products/low-stock
```

## Postman

There is a Postman collection in:

```text
postman_collection.json
```

Import it in Postman, then use the `base_url` variable. Default value is:

```text
http://localhost:8000/api
```

After creating a product, copy its `id` into the `product_id` collection variable to test show, update, delete, and stock endpoints.

## Notes

- Product IDs are UUIDs.
- Products use soft delete.
- Product list is paginated.
- Redis is used for cache.
- PostgreSQL is used as the database in Docker.

