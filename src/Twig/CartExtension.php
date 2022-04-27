<?php

namespace App\Twig;

use App\Service\CartService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{
    public function __construct(
        private CartService $cartService,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCartCount', [$this, 'getCartCount']),
        ];
    }

    public function getCartCount(): int
    {
        return $this->cartService->getCart()->getCount();
    }
}
