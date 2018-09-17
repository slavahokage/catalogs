<?php
declare(strict_types=1);

namespace App\Controller;


use App\Entity\Categories;
use App\Entity\Customer;
use App\Entity\Products;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categories::class)->findAll();

        return $this->render('index/maintitle.html.twig', array('categories' => $categories));
    }

    /**
     * @Route("/contacts", name="contacts")
     *
     */
    public function contacts(Request $request): Response
    {
        $newCustomer = new Customer();
        $form = $this->createForm(CustomerType::class, $newCustomer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newCustomer);
                $entityManager->flush();
                return $this->render(
                    'customer/customer.html.twig',
                    array('form' => $form->createView(), 'success' => 'Successfully add!')
                );
            } catch (\Exception $e) {
                return $this->render(
                    'customer/customer.html.twig',
                    array('form' => $form->createView(), 'error' => 'Something went wrong!')
                );
            }
        }

        return $this->render('customer/customer.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{category_slug}", name="category")
     *
     */
    public function category(Request $request, $category_slug): Response
    {
        $product = $this->getDoctrine()->getRepository(Products::class)->findOneBy(array('name' => $category_slug));
        if ($product != null) {
            return $this->render('product/product.html.twig', array('product' => $product));
        } else {
            $category = $this->getDoctrine()->getRepository(Categories::class)->findOneBy(array('name' => $category_slug));
            if ($category != null) {
                $products = $category->getProducts();
                return $this->render('category/category.html.twig', array('products' => $products));
            } else {
                $categories = $this->getDoctrine()->getRepository(Categories::class)->findAll();
                return $this->redirectToRoute('index', array('categories' => $categories));
            }
        }
    }
}