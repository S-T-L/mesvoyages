<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author estel
 */
class VisiteValidationsTest extends KernelTestCase {

    public function getVisite(): Visite {
        return (new Visite())
                        ->setVille("New York")
                        ->setPays("USA");
    }

    public function testValidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait réussir");
    }

    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message = "") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursAttendues, $error, $message);
    }

    public function testNonValidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(21), 1, "21 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-1), 1, "-1 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(25), 1, "25 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-10), 1, "-10 devrait échouer");
    }

    public function testNonValidtempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(15)->setTempmax(2), 1, "15min et 2max devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(15)->setTempmax(15), 1, "15min et 15max devrait échouer");
    }

    public function testValidtempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(5)->setTempmax(10), 0, "5 et 10 devrait réussir");
        $this->assertErrors($this->getVisite()->setTempmin(10)->setTempmax(11), 0, "10 et 11 devrait réussir");
    }

    public function testValidDatecreationVisite() {
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourd'hui devrait réussir");
        //Soustrait 5 jours à la date actuelle, en utilisant l'intervalle de temps p5d
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0, "plus tôt devrait réussir");
    }

    public function testNonValidDatecreationVisite() {
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1, "plus tôt devrait échouer");
    }
}
