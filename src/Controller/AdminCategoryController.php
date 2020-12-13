<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/{page<\d+>?1} ", name="admin_category_index")
     */
    public function index(CategoryRepository $repo, $page, PaginationService $pagination,Breadcrumbs $breadcrumbs)
    {
        $pagination->setEntityClass(Category::class)
                   ->setPage($page);
           
        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Categories","admin_category_index") ;

        return $this->render('admin/category/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Creation d'une nouvelle catégorie
     * 
     * @Route("/admin/category/new", name="admin_category_new")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function create(Request $request, EntityManagerInterface $manager,Breadcrumbs $breadcrumbs)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute("admin_category_index");
        }

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Categories","admin_category_index")
                    ->addRouteItem("Création","admin_category_new");

        return $this->render('admin/category/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Formulaire d'edition d'une catégorie
     * 
     * @Route("admin/category/{id}/edit", name="admin_category_edit")
     *
     * @param Category $category
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function edit(Category $category,Request $request,EntityManagerInterface $manager , Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute("admin_category_index");
        } 

        $breadcrumbs->prependRouteItem("Dashboard","admin_home")
                    ->addRouteItem("Categories","admin_category_index")
                    ->addRouteItem("Modification","admin_category_edit",['id'=> $category->getId()]);
        
        return $this->render('admin/category/edit.html.twig',[
            'category'=>$category,
            'form'=>$form->createView()
        ]);
    }
    /**
     * Suppression d'une catégorie
     * 
     * @Route("admin/category/{id}/delete", name="admin_category_delete")
     *
     * @param Category $category
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Category $category,EntityManagerInterface $manager)
    {
        if (count($category->getProducts()) > 0) {
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer cette catégorie car elle a des produits"
            );
        } else {
            $manager->remove($category);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_category_index');
    }        
}
