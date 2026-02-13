<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\Basket;

class ProductController extends Controller
{
    protected $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function index()
    {
        $products = Product::all();

        return view('pages.home', [
            'products' => $products,
            'basket' => $this->basket->all(),
        ]);
    }

    public function add(ProductRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        try {
            $this->basket->add($product, $request->quantity);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Product added to basket',
            'basket' => $this->basket->all(),
            'total' => $this->basket->total(),
        ]);
    }

    public function update(ProductRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        try {
            $this->basket->update($product, $request->quantity);
        } catch (\Exception $e) {
             return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Product quantity updated',
            'basket' => $this->basket->all(),
            'total' => $this->basket->total(),
        ]);
    }

    public function delete(ProductRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $this->basket->remove($product);

        return response()->json([
            'message' => 'Product removed from basket',
            'basket' => $this->basket->all(),
            'total' => $this->basket->total(),
        ]);
    }

    public function clearBasket()
    {
        $this->basket->clearBasket();

        return response()->json([
            'message' => 'Basket cleared',
        ]);
    }
}
