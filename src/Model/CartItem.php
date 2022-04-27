<?php

namespace App\Model;

use App\Entity\Product;

class CartItem
{
    private int $count;
    private Product $product;

    public function __construct(int $count, Product $product)
    {
        $this->count = $count;
        $this->product = $product;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
