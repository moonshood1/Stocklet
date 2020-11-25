<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Form\PromoType;
use App\Repository\PromoRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPromoController extends AbstractController
{
    /**
     * @Route("/admin/promo/{page<\d+>?1}", name="admin_promo_index")
     */
    public function index(PaginationService $pagination,$page)
    {
        $pagination->setEntityClass(Promo::class)->setLimit(5);

        return $this->render('admin/promo/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    /**
     * Fonction de creation d'un code promo
     * @Route("/admin/promo/create", name="admin_promo_create")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function create(EntityManagerInterface $manager,Request $request)
    {
        $promo = new Promo();
        $form = $this->createForm(PromoType::class,$promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($promo);
            $manager->flush();

            return $this->redirectToRoute("admin_promo_index");
        }

        return $this->render('admin/promo/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction d'edition d'un code promo
     * @Route("/admin/promo/{id}/edit", name="admin_promo_edit")
     * @param Promo $promo
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Promo $promo,EntityManagerInterface $manager,Request $request)
    {
        $form = $this->createForm(PromoType::class,$promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($promo);
            $manager->flush();

            return $this->redirectToRoute("admin_promo_index");
        }

        return $this->render('admin/promo/edit.html.twig',[
            'promo' => $promo,
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de suppression d'un code promo
     * @Route("/admin/promo/{id}/delete", name="admin_promo_delete")
     * @param Promo $promo
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Promo $promo,EntityManagerInterface $manager)
    {
        if (count($promo->getOrders() > 0)) {
            $this->addFlash(
                'warning',
                'vous ne pouvez pas supprimer ce code promo car il est lié a une commande'
            );
        }   else {
                $manager->remove($promo);
                $manager->flush();
            }
            return $this->redirectToRoute("admin_promo_index");
    }

    /**
     * Fonction de changement de status de la promo
     * @Route("/admin/promo/{id}/switch", name="admin_promo_switch")
     * @param Promo $promo
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function disable(Promo $promo,EntityManagerInterface $manager)
    {  
        $status = $promo->getIsActive();
        if ($status == true) {
            $promo->setIsActive(false);
        } else {
            $promo->setIsActive(true);
        }
        return $this->redirectToRoute("admin_promo_index");
    }
}
