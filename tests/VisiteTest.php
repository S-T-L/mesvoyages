<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author estel
 */
class VisiteTest extends TestCase{
    public function testGetDatecreationString(){
        $visite= new Visite();
        $visite->setDatecreation(new \DateTime("2024/04/24"));
        $this->assertEquals("24/04/2024", $visite->getDateCreationString());
    }
}
