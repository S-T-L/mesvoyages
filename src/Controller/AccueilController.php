<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author estel
 */
class AccueilController extends AbstractController{
    
    private $repository;
    
      /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }
    
    #[Route('/', name : 'accueil')]
    public function index(): Response {
        $visites = $this->repository->lastVisite(2);
        return $this->render("pages/accueil.html.twig", [
            'visites' => $visites]);
        
    }
    
   
}
