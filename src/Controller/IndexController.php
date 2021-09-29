<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{

    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAllAvailable();

        return $this->render('pages/index.html.twig', [
            'products' => $products
        ]);
    }
}
