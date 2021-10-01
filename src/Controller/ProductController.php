<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAllAvailable();

        return $this->json($products, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
