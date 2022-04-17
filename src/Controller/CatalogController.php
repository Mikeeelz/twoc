<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private BrandRepository $brandRepository;
    private ProductRepository $productRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        ProductRepository $productRepository,
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
    }

    #[Route("/category/{id}")]
    public function category(int $id): Response
    {
        $category = $this->categoryRepository->find($id);

        if ($category === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('category.html.twig', [
            'category' => $category,
            'categories' => $this->categoryRepository->findAll(),
            'brands' => $this->brandRepository->findAll(),
            'products' => $this->productRepository->findBy(['category' => $category]),
        ]);
    }

    #[Route("/brand/{id}")]
    public function brand(int $id): Response
    {
        $brand = $this->brandRepository->find($id);

        if ($brand === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('brand.html.twig', [
            'brand' => $brand,
            'categories' => $this->categoryRepository->findAll(),
            'brands' => $this->brandRepository->findAll(),
            'products' => $this->productRepository->findBy(['brand' => $brand]),
        ]);
    }
}
