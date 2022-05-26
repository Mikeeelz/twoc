<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
    ) {

    }

    #[Route('/cart')]
    public function index(Request $request): Response
    {
        return $this->render('cart.html.twig', [
            'cart' => $this->cartService->getCart(),
            'errorRegister' => $request->query->has('error-register'),
        ]);
    }

    #[Route('/cart/add/{id}')]
    public function add(int $id): Response
    {
        $this->cartService->addProduct($id);

        return new JsonResponse([
           'sum' => $this->cartService->getCart()->getCount(),
        ]);
    }

    #[Route('/cart/increase/{id}')]
    public function increase(int $id): Response
    {
        $this->cartService->incrementProduct($id);

        return new RedirectResponse('/cart');
    }

    #[Route('/cart/reduce/{id}')]
    public function reduce(int $id): Response
    {
        $this->cartService->decrementProduct($id);

        return new RedirectResponse('/cart');
    }

    #[Route('/cart/remove/{id}')]
    public function remove(int $id): Response
    {
        $this->cartService->deleteProduct($id);

        return new RedirectResponse('/cart');
    }
}
