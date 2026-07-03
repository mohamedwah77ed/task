# Architecture Notes

This project is a small Laravel REST API for inventory products.

## Main Structure

The API routes are in `routes/api.php`. The product routes are handled by `ProductController`.

I used a repository class for product database logic:

- `ProductRepositoryInterface`
- `ProductRepository`

The controller depends on the interface, and the real repository is bound in `AppServiceProvider`. This keeps the controller smaller and makes it easier to change the product storage logic later.

## Product Model

Products have:

- UUID primary key
- unique SKU
- price
- stock quantity
- low stock threshold
- status
- soft deletes

UUIDs were used because they are safer to expose in APIs than auto increment IDs.

## Validation

Request validation is done in Form Request classes:

- `ProductRequest`
- `UpdateStockRequest`

This keeps validation outside the controller. It also makes the controller methods easier to read.

## API Response

Product responses use `ProductResource`. This gives one response format for product data instead of returning the model directly.

## Cache

The product list is cached for 10 minutes using Laravel Cache. Redis is used as the cache store in Docker.

I used `predis` as the Redis client because it works through Composer and does not require the PHP Redis extension on the local machine.

## Stock Update

Stock update has a separate endpoint:

```text
POST /api/products/{id}/stock
```

This is clearer than updating the full product when only stock changes. It also checks that stock does not go below zero.

When stock becomes less than or equal to the low stock threshold, a `LowStockAlert` event is dispatched.

## Things I Would Improve Later

- Add authentication for API users.
- Add tests for product CRUD and stock update.
- Clear product list cache after create, update, or delete.
- Add filtering by product status.

