<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of AcceuilController
 *
 * @author Narvaliton
 */
class AcceuilController extends AbstractController{
    
    /**
     * @Route("/", name="acceuil")
     * @return Response
     */
    public function index(): Response{
        return $this->render("pages/acceuil.html.twig");
    }
}
