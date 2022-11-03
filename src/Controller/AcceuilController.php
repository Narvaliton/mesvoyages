<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of AcceuilController
 *
 * @author Narvaliton
 */
class AcceuilController extends AbstractController{
    
    private $repository;
    
    
    public function __construct(VisiteRepository $repository){
        $this->repository = $repository;
    }
    
    /**
     * @Route("/", name="acceuil")
     * @return Response
     */
    public function index(): Response{
        $visites = $this->repository->findLastResult();
        return $this->render("pages/acceuil.html.twig", [
            'visites' => $visites
        ]);
    }
}
