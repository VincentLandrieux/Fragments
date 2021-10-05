<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    public function create(Request $request, SluggerInterface $slugger): Response
    {
        // create new product
        $product = new Product();

        // create form product
        $form = $this->createForm(ProductType::class, $product);

        // if form post recieved
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // image file
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('products_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $product->setImgUrl($newFilename);
            }

            // save product
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

    public function edit(Int $id, Request $request, SluggerInterface $slugger): Response
    {
        // get product by id
        $product = $this->repository->find($id);

        // create form product
        $form = $this->createForm(ProductType::class, $product);

        // if form post recieved
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set image file
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('products_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $product->setImgUrl($newFilename);
            } else {
                // reset image
                if ($product->getImgUrl() && $request->get('img_change')) {
                    $product->setImgUrl(null);
                }
            }


            // save product
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
