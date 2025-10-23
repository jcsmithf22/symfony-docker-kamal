<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class ProductController extends AbstractController
{
    // #[Route("/product", name: "app_product")]
    // public function index(): Response
    // {
    //     return $this->render("product/index.html.twig", [
    //         "controller_name" => "ProductController",
    //     ]);
    // }

    #[Route("/product", name: "create_product")]
    public function createProduct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ): Response {
        $product = new Product();
        $product->setName("Keyboard");
        $product->setPrice(1999);
        $product->setDescription("Ergonomic and stylish!");

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($product); // Doesn't query yet
        $entityManager->flush(); // This persists

        return new Response("Saved new product with id " . $product->getId());
    }

    #[Route("/product/new", name: "new_product")]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            $this->redirectToRoute("product_show", [
                "id" => $product->getId(),
            ]);
        }

        return $this->render("product/new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route("/product/{id}", name: "product_show")]
    public function show(
        ?Product $product,
        // ProductRepository $productRepository,
        int $id,
    ): Response {
        // $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException("No product found for id $id");
        }

        return $this->render("product/show.html.twig", ["product" => $product]);
    }
}
