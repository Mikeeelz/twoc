<?php

namespace App\Service;

use App\Model\Cart;
use App\Model\CartItem;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private ProductRepository $productRepository;
    private SessionInterface $session;

    public function __construct(
        ProductRepository $productRepository,
        RequestStack $requestStack,
    ) {
        $this->productRepository = $productRepository;
        $this->session = $requestStack->getSession();
    }

    public function getCart(): Cart
    {
        $result = new Cart();

        if (!$this->session->has('cart')) {
            return $result;
        }

        foreach ($this->session->get('cart') as $productId => $count) {
            $product = $this->productRepository->find($productId);
            $item = new CartItem($count, $product);
            $result->addItem($item);
        }

        return $result;
    }

    public function saveCart(Cart $cart): void
    {
        $this->session->set('cart', $cart->format());
    }

    public function addProduct(int $productId): void
    {
        $product = $this->productRepository->find($productId);

        $cart = $this->getCart();
        $cart->addItem(new CartItem(1, $product));
        $this->saveCart($cart);
    }

    public function deleteProduct(int $productId): void
    {
        $cart = $this->getCart();
        $cart->deleteProduct($productId);
        $this->saveCart($cart);
    }

    public function incrementProduct(int $productId): void
    {
        $cart = $this->getCart();
        $cart->increment($productId);
        $this->saveCart($cart);
    }

    public function decrementProduct(int $productId): void
    {
        $cart = $this->getCart();
        $cart->decrement($productId);
        $this->saveCart($cart);
    }
}
