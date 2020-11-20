<?php

namespace App\Services\Pagination;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

// Classe spéciale pour toutes les pages qui implemente la paginaton
class PaginationService 
{
    /**
     * Nom de l'entité sur laquelle on pagine
     *
     * @var string
     */
    private $entityClass;


    /**
     * le nombre des enregistrements à recuperer
     *
     * @var integer
     */
    private $limit = 5;


    /**
     * Page sur laquelle on se trouve actuellement
     *
     * @var integer
     */
    private $currentPage = 1;


    private $manager;

    /**
     * Variable de la route sur laquelle on se trouve
     *
     * @var string
     */
    private $route;

    public function __construct(EntityManagerInterface $manager,Environment $twig,RequestStack $request)
    {
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
    }


    // Fonction d'affichage du template de la pagination
    public function display()
    {
        $this->twig->display('admin/partials/pagination.html.twig',[
            'page'=> $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    // Fonction de recuperation de toutes les pages pour l'entité
    public function getPages()
    {
        // Le total des enregistrements de la table
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        // Arrondir le resultat de la divison
        $pages = ceil($total/$this->limit);

        // Retourner le resultat
        return $pages;
    }

    // Fonction de recuperation des données issues des pages
    public function getData()
    {
        // Calculer l'offset

        $offset = $this->currentPage * $this->limit - $this->limit;

        // demander au repo de trouver les elements

        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],['id'=> 'DESC'],$this->limit, $offset);

        // envoyer les elements trouvés

        return $data;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;
        return $this;
    }

    public function getPage()
    {
        return $this->currentPage;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }
}
