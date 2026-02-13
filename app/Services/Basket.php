<?php

namespace App\Services;

class Basket
{
    public function all()
    {
        return session()->get('basket', []);
    }

    public function add($product, $quantity)
    {
        $basket = $this->all();

        if (array_key_exists($product->sku, $basket)) {
            if ($product->stock >= $quantity) {
                $product->decrement('stock', $quantity);
                $basket[$product->sku]['quantity'] += $quantity;
                $basket[$product->sku]['total'] = $this->productTotal($product->price, $basket[$product->sku]['quantity']);
            } else {
                throw new \Exception('Insufficient stock');
            }
        } else {
            if ($product->stock >= $quantity) {
                $product->decrement('stock', $quantity);
                $total = $this->productTotal($product->price, $quantity);
                $basket[$product->sku] = [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $total,
                ];
            } else {
                throw new \Exception('Insufficient stock');
            }
        }

        session()->put('basket', $basket);
    }

    public function update($product, $quantity)
    {
        $basket = $this->all();

        if (array_key_exists($product->sku, $basket)) {
            $currentQty = $basket[$product->sku]['quantity'];
            $diff = $quantity - $currentQty;

            if ($diff > 0) {
                // Determine if we need more stock
                if ($product->stock >= $diff) {
                    $product->decrement('stock', $diff);
                } else {
                    throw new \Exception('Insufficient stock');
                }
            } elseif ($diff < 0) {
                // Returning stock
                $product->increment('stock', abs($diff));
            }

            $basket[$product->sku]['quantity'] = $quantity;
            $basket[$product->sku]['total'] = $this->productTotal($product->price, $quantity);
            session()->put('basket', $basket);
        }
    }

    public function remove($product)
    {
        $basket = $this->all();

        if (array_key_exists($product->sku, $basket)) {
            $qty = $basket[$product->sku]['quantity'];
            $product->increment('stock', $qty);
            unset($basket[$product->sku]);
            session()->put('basket', $basket);
        }
    }

    public function clearBasket()
    {
        $basket = $this->all();
        foreach ($basket as $item) {
            $product = \App\Models\Product::find($item['id']);
            if ($product) {
                $product->increment('stock', $item['quantity']);
            }
        }
        session()->forget('basket');
    }

    public function total()
    {
        // total value of the basket
        $total = 0;
        foreach ($this->all() as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function productTotal($price, $quantity)
    {
        // total value of individual product
        return $price * $quantity;
    }
}
