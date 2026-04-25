<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('q')) {
            $keyword = '%' . $request->string('q') . '%';
            $query->where(function ($builder) use ($keyword) {
                $builder->where('name', 'like', $keyword)
                    ->orWhere('category', 'like', $keyword);
            });
        }

        return response()->json($query->orderBy('id')->paginate(12));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }
}
