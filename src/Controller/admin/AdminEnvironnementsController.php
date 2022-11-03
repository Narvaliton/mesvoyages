<?php

namespace App\Controller\admin;

use App\Entity\Environnement;
use App\Repository\EnvironnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of adminEnvironnementsController
 *
 * @author maxco
 */
class AdminEnvironnementsController extends AbstractController{
    
    private $repository;
    
    /**
     * Constructeur de l'attribut repository
     * @param EnvironnementRepository $repository
     */
    public function __construct(EnvironnementRepository $repository){
        $this->repository = $repository;
    }
    
    /**
     * @Route("/admin/environnements", name="admin.environnements")
     * @return Response
     */
    public function index(): Response{
        $environnements = $this->repository->findAll('nom');
        return $this->render("admin/admin.environnements.html.twig", [
           'environnements' => $environnements
       ]); 
    }
    
    /**
     * @Route("/admin/environnements/suppr/{id}", name="admin.environnements.suppr")
     * @param Environnement $environnement
     * @return Response
     */
    public function suppr(Environnement $environnement): Response{
        $this->repository->remove($environnement, true);
        return $this->redirectToRoute('admin.environnements');
    }
    
    /**
     * @Route("/admin/environnements/ajout", name="admin.environnements.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $nomEnvironnement = $request->get("nom");
        if($nomEnvironnement != ""){
             $environnement = new Environnement();
            $environnement->setNom($nomEnvironnement);
            $this->repository->add($environnement, true);
        }
        return $this->redirectToRoute('admin.environnements');
    }
    
}
