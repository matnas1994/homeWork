<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page') ?? 15;
        return ProductResource::collection(Product::with('warehouses')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ProductResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreProduct $request)
    {
        $validatedData = $request->validated();
        $product = Product::create($validatedData);

        foreach ($validatedData['warehouses'] as $warehouse) {
            $product->warehouses()->attach($warehouse['id'], ['stock_level' => $warehouse['stock_level']]);
        }

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        $product->with('warehouses')->get();
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return ProductResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $validatedData = $request->validated();

        $product->fill($validatedData);

        if (isset($validatedData['warehouses'])) {
            foreach ($validatedData['warehouses'] as $warehouse) {
                if ($warehouse['stock_level'] === 0) {
                    $product->warehouses()->detach($warehouse['id']);
                } else {
                    $product->warehouses()->sync([$warehouse['id'] => ['stock_level' => $warehouse['stock_level']]], false);
                }
            }
        }

        $product->save();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
