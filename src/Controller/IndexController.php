<?php

namespace App\Controller;

use App\Repository\BannerRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private BannerRepository $bannerRepository;
    private BrandRepository $brandRepository;
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;

    public function __construct(
        BannerRepository $bannerRepository,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
    )
    {
        $this->bannerRepository = $bannerRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    #[Route("/")]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'banners' => $this->bannerRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'brands' => $this->brandRepository->findAll(),
            'products' => $this->productRepository->findAll(),
        ]);
    }
}
