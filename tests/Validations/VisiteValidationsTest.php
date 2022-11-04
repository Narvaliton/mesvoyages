<?php

namespace tests\Validations;

use App\Entity\Environnement;
use App\Entity\Visite;                                                                                                                                                                                                                                                                                                                                                                                                             
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints;
/**
 * Description of VisiteValidationsTest
 *
 * @author maxco
 */
class VisiteValidationsTest extends KernelTestCase{
    public function getVisite():Visite{
        return(new Visite())
            ->setVille("New York")
            ->setPays('USA');
    }
    
    public function testValidNoteVisite(){
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);
    }
    
    public function testNonValidNoteHorsLimiteVisite(){
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1);
        $visite = $this->getVisite()->setNote(-1);
        $this->assertErrors($visite, 1);
    }
    
    public function testValidNoteLimite(){
       $visite = $this->getVisite()->setNote(20);
       $this->assertErrors($visite, 0);
       $visite = $this->getVisite()->setNote(0);
       $this->assertErrors($visite, 0);
    }
    
    public function testNonValidNoteVisite(){
        $visite = $this->getVisite()->setNote(40);
        $this->assertErrors($visite, 1);
        $visite = $this->getVisite()->setNote(-19);
        $this->assertErrors($visite, 1);
    }
    
    public function testValidTempMax(){
        $visite = $this->getVisite()
                ->setTempMin(4)
                ->setTempMax(18);
        $this->assertErrors($visite, 0);
    }
    
    public function testValidCloseTempMax(){
        $visite = $this->getVisite()
                ->setTempMin(4)
                ->setTempMax(5);
        $this->assertErrors($visite, 0);
    }
    
    public function testNonValidFarTempMax(){
        $visite = $this->getVisite()
                ->setTempMin(45)
                ->setTempMax(-2);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    
    public function testNonValidTempMax(){
        $visite = $this->getVisite()
                ->setTempMin(20)
                ->setTempMax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
    }
    
    public function testNonValidEqualsTempMax(){
        $visite = $this->getVisite()
                ->setTempMin(20)
                ->setTempMax(20);
        $this->assertErrors($visite, 1);
    }
    
    public function testValidAnterieurDatecreation(){
        $datetime = new \DateTime();
        $datetime->setDate(2022,2,4);
        $visite = $this->getVisite()
                ->setDatecreation($datetime);
        $this->assertErrors($visite,0);
    }
    
    public function testValidTodayDatecreation(){
        $datetime = new \DateTime('2022-04-11');
        $visite = $this->getVisite()
                ->setDatecreation($datetime);
        $this->assertErrors($visite,0, "Même jour doit marcher");
    }
    
    public function testNonValidLendemainDatecreation(){
        $datetime = new \DateTime();
        $datetime->setDate(2022,11,5);
        $visite = $this->getVisite()
                ->setDatecreation($datetime);
        $this->assertErrors($visite,1, "Le lendemain ne doit pas marcher");
    }
    
    public function testNonValidFuturDatecreation(){
        $datetime = new \DateTime();
        $datetime->setDate(2025,8,21);
        $visite = $this->getVisite()
                ->setDatecreation($datetime);
        $this->assertErrors($visite,1, "Une date postérieure ne doit pas marcher");
    }
    
    public function testValidAjoutEnvironnementPresent(){
        ($environnement = new Environnement())
                ->setNom('Mer');
        $visite = $this->getVisite()
                ->addEnvironnement($environnement);
        $visite ->addEnvironnement($environnement);
        $this->assertEquals(1, count($visite->getEnvironnements()));
    }
    
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }
    
    
}
