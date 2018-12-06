<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/json", name="category_json")
     */
    public function index_json()
    {
      $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        //->findAll()
        ->findAllAssoc()
        ;

      return new Response(json_encode($categories));
    }

    /**
     * @Route("/category/add", name="category_add")
     */
    public function add(Request $request)
    {
      $category = new Category();
      $form = $this->createForm(CategoryType::class, $category);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        $category = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
      }

      return $this->render('form.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
