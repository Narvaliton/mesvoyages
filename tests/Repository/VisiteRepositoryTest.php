<?php
namespace tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteRepositoryTest
 *
 * @author maxco
 */
class VisiteRepositoryTest extends KernelTestCase{
    
    public function recupRepository(): VisiteRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }
    
    public function testNbVisites(){
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(3, $nbVisites);
    }
    
    public function newVisite():Visite{
        $visite = (new Visite())
                ->setVille("Paris")
                ->setPays("France")
                ->setDatecreation(new \DateTime('now'));
        return $visite;
    }
    
    public function testAddVisite(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);
        $repository->add($visite, true);
        $this->assertEquals($nbVisites + 1, $repository->count([]), "Erreur lors de l'ajout");
    }
    
    public function testRemoveVisite(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository ->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites - 1, $repository->count([]), "Erreur lors de la suppression");  
    }
    
    public function testFindByEqualValue(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", "Paris");
        $nbVisites = count($visites);
        $this->assertEquals("Paris", $visites[0]->getVille());
    }
}