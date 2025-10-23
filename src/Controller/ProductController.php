<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        // $product->setPrice(1999);
        $product->setDescription("Ergonomic and stylish!");

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($product); // Doesn't query yet
        $entityManager->flush(); // This persists

        return new Response("Saved new product with id" . $product->getId());
    }
}
