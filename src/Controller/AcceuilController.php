<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of AcceuilController
 *
 * @author Narvaliton
 */
class AcceuilController {
    
    /**
     * @Route("/", name="acceuil")
     * @return Response
     */
    public function index(): Response{
        return new Response('Hello world');
    }
}
