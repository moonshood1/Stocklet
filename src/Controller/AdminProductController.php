<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Pagination\PaginationService;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductController extends AbstractController
{
    /**
     * @Route("/admin/products/{page<\d+>?1}", name="admin_products_index")
     */
    public function index(ProductRepository $repo, $page, PaginationService $pagination,Breadcrumbs $breadcrumbs)
    {
        $pagination->setEntityClass(Product::class)
                   ->setLimit(5)
                   ->setPage($page);
                   
        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Produits","admin_products_index");

        return $this->render('admin/product/index.html.twig', [
            'pagination' => $pagination,
            'online'=> $repo->findOneBy(array('productAvailable'=> 1))
        ]);
    }

    /**
     * Formulaire de création des produits
     * 
     * @Route("admin/products/new", name="admin_products_create")
     *
     * @param Product $product
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager,Breadcrumbs $breadcrumbs) 
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute("admin_products_index");
        }

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Produits","admin_products_index")
                    ->addRouteItem("Création","admin_products_create"); 

        return $this->render('admin/product/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * Formulaire d'edition des produits
     *
     * @Route("admin/products/{id}/edit", name="admin_products_edit")
     * 
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product,Request $request,EntityManagerInterface $manager,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute("admin_products_index");
        } 

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Produits","admin_products_index")
                    ->addRouteItem("Modification","admin_products_edit",['id'=> $product->getId()]);        
        
        return $this->render('admin/product/edit.html.twig',[
            'product'=>$product,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Permet de supprimer un produit
     * 
     * @Route("admin/products/{id}/delete", name="admin_products_delete")
     *
     * @param Product $product
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Product $product,EntityManagerInterface $manager)
    {
        if (count($product->getOrders()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer ce produit car il a deja été commandé"
            );
        } else {
            $manager->remove($product);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_products_index');
    }

    /**
     * Permet de changer la disponibilité du produit
     * 
     * @Route("admin/products/{id}/switch", name="admin_products_switch")
     *
     */
    public function switchAvailability(ProductRepository $repo,Product $product,$id,EntityManagerInterface $manager)
    {
         // recuperation du produit dispo et set de dispo a false

            $dispo = $repo->findOneBy(array('productAvailable'=> 1));
            $dispo->setProductAvailable(false);

        // recuperation de l'id du produit à disponibiliser
            $product->getId();

        // Mise a 1 de la disponibilité

            $product->setProductAvailable(true);

            $manager->persist($dispo);
            $manager->persist($product);

            $manager->flush();

        return $this->redirectToRoute('admin_products_index');
    }
    
    /**
     * Fonction d'affichage d'un seul produit
     * 
     * @Route("/admin/products/details/{id}", name="admin_products_show")
     * 
     * @param Product $product
     * @return void
     */
    public function show(Product $product,Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Produits","admin_products_index")
                    ->addRouteItem("Détail","admin_products_show",['id'=> $product->getId()]);

        return $this->render("admin/product/show.html.twig", [
            'product' => $product
        ]);
    }
}
