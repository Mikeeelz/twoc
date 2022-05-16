<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private CartService $cartService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        CartService $cartService,
        EntityManagerInterface $entityManager,
    ) {
        $this->cartService = $cartService;
        $this->entityManager = $entityManager;
    }

    #[Route('/order/create')]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $cart = $this->cartService->getCart();

        $order = new Order($user);
        $this->entityManager->persist($order);

        $order->setAddress($request->request->get('address'));

        foreach ($cart->getItems() as $cartItem) {
            $orderItem = new OrderItem($order, $cartItem->getProduct());
            $orderItem->setPrice($cartItem->getProduct()->getPrice());
            $orderItem->setCount($cartItem->getCount());

            $this->entityManager->persist($orderItem);

            $order->addItem($orderItem);
        }

        $this->entityManager->flush();

        return new RedirectResponse('/');
    }
}
