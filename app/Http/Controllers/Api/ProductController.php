<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|string|max:225',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price'
        ]);
        if (!$request->user()->tokenCan('product.create')) {
            return Response::json([
                'code' => 0,
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        }

        $product = Product::create($request->all());
        return Response::json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        // return $product->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'store_id' => 'sometimes|required|string|max:225',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'sometimes|nullable|numeric|min:0',
            'compare_price' => 'sometimes|nullable|numeric|gt:price'
        ]);
        if (!$request->user()->tokenCan('product.update')) {
            return Response::json([
                'code' => 0,
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        }

        $product->update($request->all());
        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var \App\Models\User $user */

        Product::destroy($id);
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('product.delete')) {
            return Response::json([
                'code' => 0,
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        }
        return Response::json([
            'message' => 'Product Deleted Successfully'
        ], 200);
    }
}
