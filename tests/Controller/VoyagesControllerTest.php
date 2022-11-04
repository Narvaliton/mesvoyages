<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use symfony\Component\HttpFoundation\Response;
/**
 * Description of VoyagesControllerTest
 *
 * @author maxco
 */
class VoyagesControllerTest extends WebTestCase{
    
    public function testAccessPage(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', "New York");
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        //clic sur le lien (le nom d'une ville)
        $client->clickLink('New York');
        //récuperation du résultat du clic
        $response = $client->getResponse();
        dd($client->getRequest());
        //constrole si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        //récuperation de la route et contre qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/103', $uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        //simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'New York'
        ]);
        //vérifie le nombres de ligne obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        //verifie si la ville correspond à la recherche
        $this->assertSelectorTextcontains('h5', 'New York');
    }
}
