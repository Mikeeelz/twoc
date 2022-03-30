<?php

namespace App\Controller;

use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private BannerRepository $bannerRepository;

    public function __construct(
        BannerRepository $bannerRepository,
    )
    {
        $this->bannerRepository = $bannerRepository;
    }

    #[Route("/")]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'banners' => $this->bannerRepository->findAll(),
            'categories' => [],
            'brands' => [],
            'products' => [],
        ]);
    }
}
