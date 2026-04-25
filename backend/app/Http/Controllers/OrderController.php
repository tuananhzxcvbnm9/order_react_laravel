<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::query()
            ->where('user_id', auth('api')->id())
            ->with('items.product')
            ->latest('id')
            ->paginate(10);

        return response()->json($orders);
    }

    public function show(Order $order): JsonResponse
    {
        abort_if($order->user_id !== auth('api')->id(), 403);

        return response()->json($order->load('items.product'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'receiver_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        $productIds = collect($data['items'])->pluck('product_id')->all();
        $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

        $result = DB::transaction(function () use ($data, $products) {
            $subtotal = 0;
            $items = [];

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']];
                $linePrice = $product->price;
                $subtotal += $linePrice * $item['qty'];

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $linePrice,
                    'qty' => $item['qty'],
                    'line_total' => $linePrice * $item['qty'],
                ];
            }

            $discount = $subtotal > 1000000 ? 120000 : 0;
            $total = $subtotal - $discount;

            $order = Order::query()->create([
                'user_id' => auth('api')->id(),
                'receiver_name' => $data['receiver_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'status' => 'confirmed',
            ]);

            $order->items()->createMany($items);

            return $order->load('items');
        });

        return response()->json($result, 201);
    }
}
