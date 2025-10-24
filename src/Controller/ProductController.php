<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class ProductController extends AbstractController
{
    #[Route("/", name: "products")]
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('search');
        $products = $productRepository->findByNameSearch($searchTerm);

        return $this->render("product/index.html.twig", [
            "controller_name" => "ProductController",
            "products" => $products,
            "searchTerm" => $searchTerm,
        ]);
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

            return $this->redirectToRoute("product_show", [
                "id" => $product->getId(),
            ]);
        }

        return $this->render("product/new.html.twig", [
            "form" => $form,
        ]);
    }

    #[Route("/product/{id}/edit", name: "edit_product")]
    public function edit(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute("product_show", [
                "id" => $product->getId(),
            ]);
        }

        return $this->render("product/edit.html.twig", [
            "product" => $product,
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

    #[Route("/product/{id}/delete", name: "delete_product", methods: ["POST"])]
    public function delete(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager,
    ): Response {
        if (
            $this->isCsrfTokenValid(
                "delete" . $product->getId(),
                $request->request->get("_token"),
            )
        ) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute("products");
    }
}
