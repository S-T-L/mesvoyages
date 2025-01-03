<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author estel
 */
class VoyagesController extends AbstractController{
    
    const PAGEVOYAGES = "pages/voyages.html.twig";
    const PAGEVOYAGE = "pages/voyage.html.twig";
    /**
     * 
     * @var VisiteRepository
     */
    private $repository;
    
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }

    
    #[Route('/voyages', name : 'voyages')]
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render(self::PAGEVOYAGES,[
            'visites' => $visites
        ]);
        
    }
    
    #[Route('/voyages/tri/{champ}/{ordre}', name: 'voyages.sort')]
    public function sort($champ, $ordre) : Response {
        $visites = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::PAGEVOYAGES, [
            'visites' => $visites
        ]);
    }
    
    #[Route('/voyage/recherche/{champ}', name : 'voyages.findallequal')]
    public function findAllEqual($champ, Request $request): Response{
        if($this->isCsrfTokenValid('filtre_'.$champ, $request->get('_token'))){
            $valeur = $request->get("recherche");
            $visites = $this->repository->findByEqualValue($champ, $valeur);
            return $this->render(self::PAGEVOYAGES,[
                'visites' => $visites
        ]);
        }
        return $this->redirectToRoute("voyages");
    }
        
    
    #[Route('/voyages/voyage/{id}', name: 'voyages.showone')]
    public function showOne($id): Response{
        $visite = $this->repository->find($id);
        return $this->render(self::PAGEVOYAGE, [
            'visite' => $visite
        ]);
    }
    
    
    
    
}
