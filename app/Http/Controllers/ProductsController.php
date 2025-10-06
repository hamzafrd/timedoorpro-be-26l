<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $products = Product::all();
        return $this->responseJson("Ok", 200, $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'stock' => 'required|integer|min:0',
            ],
            [
                'name.required' => 'name must be filled',
                'name.string' => 'name must be filled by array ',
                'name.max' => 'max 50 chars',
                'price.required' => 'price must be filled',
                'stock.required' => 'stock must be filled',
                'stock.integer' => 'stock must be filled by integer',
                'stock.min' => 'stock must be positive',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode(', ', $errors);
            return response()->json(['message' => $errorMessages], 201);
        }

        $validated = $validator->validated();

        product::create($request->all());
        return response()->json(['message' => 'produk berhasil disimpan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id): JsonResponse
    {

        $product = Product::findOrFail($id);

        if ($product) {
            return $this->responseJson("Ok", 200, $product);
        } else {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:50',
                'price' => 'required|numeric',
                'stock' => 'required|integer|min:0',
            ],
            [
                'name.required' => 'name must be filled',
                'name.string' => 'name must be filled by array ',
                'name.max' => 'max 50 chars',
                'price.required' => 'price must be filled',
                'price.numeric' => 'price must be a number',
                'stock.required' => 'stock must be filled',
                'stock.integer' => 'stock must be filled by integer',
                'stock.min' => 'stock must be positive',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessages = implode(', ', $errors);
            return $this->responseJson($errorMessages, 400);
        }

        $validated = $validator->validated();

        product::create($request->all());
        return response()->json(['message' => 'produk berhasil disimpan'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse

    {
        try {
            //code...
            $product = Product::findOrFail($id);
        } catch (Throwable $th) {
            //throw $th;
            return $this->responseJson('produk tidak ditemukan', 404);
        }


        $product->delete();
        return $this->responseJson('produk berhasil dihapus', 200, null);
    }

}
