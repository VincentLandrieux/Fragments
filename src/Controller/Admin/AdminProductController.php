<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminProductController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ProductRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    public function index(): Response
    {
        // get all products
        $products = $this->repository->findAll();

        // serve index page
        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    public function create(Request $request): Response
    {
        // create new product
        $product = new Product();

        // create form product
        $form = $this->createForm(ProductType::class, $product);

        // if form post recieved
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash('success', 'Nouveau produit créé');

            // redirect to index page
            return $this->redirectToRoute('admin.product.index');
        }

        // serve edit page
        return $this->render('admin/product/create.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    public function edit(Int $id, Request $request): Response
    {
        // get product by id
        $product = $this->repository->find($id);

        // create form product
        $form = $this->createForm(ProductType::class, $product);

        // if form post recieved
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Produit modifié');

            // redirect to index page
            return $this->redirectToRoute('admin.product.index');
        }

        // serve edit page
        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    public function delete(Int $id, Request $request): Response
    {
        // get product by id
        $product = $this->repository->find($id);

        // check crsf token
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token'))) {
            // remove product
            $this->em->remove($product);
            $this->em->flush();

            $this->addFlash('success', 'Produit supprimé');
        }

        // redirect to index page
        return $this->redirectToRoute('admin.product.index');
    }
}
