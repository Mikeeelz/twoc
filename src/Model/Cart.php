<?php

namespace App\Model;

class Cart
{
    /** @var CartItem[] */
    private array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(CartItem $item): void
    {
        foreach ($this->items as $currentItem) {
            if ($currentItem->getProduct()->getId() === $item->getProduct()->getId()) {
                $this->increment($item->getProduct()->getId());
                return;
            }
        }

        $this->items[] = $item;
    }

    public function increment(int $productId): void
    {
        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $productId) {
                $item->setCount($item->getCount() + 1);
            }
        }
    }

    public function decrement(int $productId): void
    {
        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() === $productId) {
                if ($item->getCount() <= 1) {
                    $this->deleteProduct($productId);
                    return;
                }

                $item->setCount($item->getCount() - 1);
            }
        }
    }

    public function deleteProduct(int $productId): void
    {
        $result = [];

        foreach ($this->items as $item) {
            if ($item->getProduct()->getId() !== $productId) {
                $result[] = $item;
            }
        }

        $this->items = $result;
    }

    public function format(): array
    {
        $result = [];

        foreach ($this->items as $item) {
            $result[$item->getProduct()->getId()] = $item->getCount();
        }

        return $result;
    }

    public function getCount(): int
    {
        $result = 0;
        foreach ($this->items as $item) {
            $result += $item->getCount();
        }

        return $result;
    }

    public function getPrice(): int
    {
        $result = 0;
        foreach ($this->items as $item) {
            $result += $item->getProduct()->getPrice() * $item->getCount();
        }

        return $result;
    }
}
