<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteValidationsTest
 *
 * @author Carl Fremault
 */
class VisiteValidationsTest extends KernelTestCase {

    public function getVisite(): Visite {
        return (new Visite())
                        ->setVille("New York")
                        ->setPays("USA");
    }

    public function assertErrors(Visite $visite, int $nbErreursAttendus, string $message = "") {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($visite);
        $this->assertCount($nbErreursAttendus, $error, $message);
    }

    public function testValidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(10), 0);
        $this->assertErrors($this->getVisite()->setNote(0), 0);
        $this->assertErrors($this->getVisite()->setNote(20), 0);
    }

    public function testNonValidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(21), 1);
        $this->assertErrors($this->getVisite()->setNote(-1), 1);
        $this->assertErrors($this->getVisite()->setNote(42), 1);
        $this->assertErrors($this->getVisite()->setNote(-68), 1);
    }

    public function testValidTempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(-10)->setTempmax(30), 0);
        $this->assertErrors($this->getVisite()->setTempmin(22)->setTempmax(23), 0);
    }

    public function testNonValidTempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(-10), 1);
        $this->assertErrors($this->getVisite()->setTempmin(22)->setTempmax(22), 1);
    }
    
    public function testValidDatecreationVisite() {
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0);
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0);
    }
    
    public function testNonValidDatecreationVisite() {
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1);
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1);
    }

}
