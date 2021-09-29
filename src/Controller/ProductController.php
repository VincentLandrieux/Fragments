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
        // Create new product
        // $product = new Product();
        // $product->setTitle('Produit 2')
        //     ->setPrice(99.99)
        //     ->setAvailable(true);

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($product);
        // $em->flush();

        $products = $repository->findAllAvailable();
        dump($products);

        return new Response('Products');
    }
}
