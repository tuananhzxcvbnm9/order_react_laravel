# Laravel + MySQL + JWT backend cho frontend đặt hàng

Repo này cung cấp phần **backend API** theo đúng flow frontend: `Home → Listing → Detail → Cart → Checkout → Success`.

## 1) Cấu trúc

- `backend/`: mã nguồn Laravel API (controller, model, migration, route).
- `frontend/src/api.js`: helper gọi API.
- `frontend/src/useShopApi.js`: hook kết nối frontend component với backend.

## 2) API endpoints

### Auth (JWT)
- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/auth/me` (Bearer token)
- `POST /api/auth/logout` (Bearer token)
- `POST /api/auth/refresh` (Bearer token)

### Product
- `GET /api/products?q=&category=&page=`
- `GET /api/products/{id}`

### Order
- `POST /api/orders` (Bearer token)
- `GET /api/orders` (Bearer token)
- `GET /api/orders/{id}` (Bearer token)

## 3) Hướng dẫn tích hợp vào project Laravel thật

1. Tạo Laravel project:
   ```bash
   composer create-project laravel/laravel shop-api
   ```
2. Cài JWT package:
   ```bash
   composer require tymon/jwt-auth
   php artisan vendor:publish --provider="Tymon\\JWTAuth\\Providers\\LaravelServiceProvider"
   php artisan jwt:secret
   ```
3. Copy các file trong `backend/` vào đúng vị trí tương ứng trong Laravel project.
4. Cấu hình `.env` cho MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=shop_db
   DB_USERNAME=root
   DB_PASSWORD=secret
   JWT_SECRET=... # từ php artisan jwt:secret
   ```
5. Chạy migrate + seed:
   ```bash
   php artisan migrate
   php artisan db:seed --class=ProductSeeder
   ```
6. Chạy server:
   ```bash
   php artisan serve
   ```

## 4) Kết nối frontend

- Set biến môi trường Vite:
  ```env
  VITE_API_URL=http://127.0.0.1:8000/api
  ```
- Dùng `productApi.list()` để load danh sách sản phẩm cho màn Listing.
- Dùng `orderApi.create()` khi click nút `Đặt hàng`.

## 5) JSON mẫu tạo đơn hàng

```json
{
  "receiver_name": "Tuấn Anh",
  "phone": "0988888888",
  "address": "12 Duy Tân, Cầu Giấy, Hà Nội",
  "items": [
    { "product_id": 1, "qty": 2 },
    { "product_id": 4, "qty": 1 }
  ]
}
```
