<?php

namespace App\Controller;

use App\Entity\Prodact;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProdactController extends AbstractController
{
    /**
     * @Route("/prodact", name="prodact")
     */
    public function index(): Response
{
    $repo = $this->getDoctrine()->getRepository(Prodact::class);
    $products= $repo->findAll();
#$products=["article1","article2","article2"];
return $this->render('prodact/index.html.twig', ['products' => $products]);
}
/**
     * @Route("/prodact/add", name="add")
     */
public function add(): Response
{
    $manager = $this->getDoctrine()->getManager();
    
        $product = new Prodact();
        $product->setlib("lib2")
        ->setprix(500)
        ->setdes("test description de l'article ")
        ->setimg("http://placehold.it/350*150");
        $manager->persist($product);
        $manager->flush();
return new Response("ajout validé".$product->getId());
}
/**
     * @Route("/prodact/detail/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Prodact::class);
        $products= $repo->find($id);
        return $this->render('prodact/detail.html.twig', ['products' => $products]);
    }
    /**
     * @Route("/prodact/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Prodact::class);
        $products= $repo->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($products);
        $manager->flush();
        #return $this->render('prodact/index.html.twig', ['products' => $products]);
        return new Response("supp validé");
    }
    /**
     * @Route("/prodact/add2", name="add2")
     */

    public function new(Request $request): Response
    {
        $task = new Prodact();
        // ...

        $form = $this->createForm(ProductType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($task);
             $entityManager->flush();
        
            return $this->redirectToRoute('prodact');
        }

        return $this->renderForm('prodact\new.html.twig', [
            'formpro' => $form,
        ]);
    }
    
}
