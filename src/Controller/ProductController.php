<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Product;

class ProductController extends AbstractController {

    /**
     * @Route("/product", name="product")
     */
    public function index() {
        $category = new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // relates this product to the category
        $product->setCategory($category);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->render('product/index.html.twig', [
                    'controller_name' => 'ProductController',
                    'product_id' => $product->getId(),
                    'category_id' => $category->getId()
        ]);
    }

    /**
     * @Route("/product/show/{id}", name="product_show")
     */
    public function show($id) {
        $product = $this->getDoctrine()
                ->getRepository(Product::class)
//                ->find($id); // two queries execute here
                ->findOneByIdJoinedToCategory($id); // incase of join, only one query execute

        $category = $product->getCategory();

        return $this->render('product/show.html.twig', [
                    'category_id' => $category->getId(),
                    'category_name' => $category->getName(),
                    'product_id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'description' => $product->getDescription()
        ]);
    }

}
