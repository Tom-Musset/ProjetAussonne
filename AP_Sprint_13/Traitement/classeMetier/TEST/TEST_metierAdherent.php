<?php
use PHPUnit\Framework\testCase;
include_once('Outil/autoload.php');

class TEST_metierAdherent extends testCase{
    private metierAdherent $Adh1;
    private metierEquipe $Eq1;
    private metierTitulaire $En1;
    private metierSpecialite $Spe1;

    /**
     * @before
     */
    public function testEnvironment(){
        $Adh1 = new metierAdherent(1, "musset", "tom", 20, "M", "tom", "tom");
        $En1 = new metierTitulaire(1, "bartez", "rené", "bartez","16/05/2002");
        $Spe1 = new metierSpecialite(1,"football");
        $Eq1 = new metierEquipe(1, "PSG", 11, 17, 30, "M", $En1,  $Spe1);

        $Adh1->setLEquipeDeLAdherent($Eq1); 
        
        $this->assertEquals($Adh1->afficheAdherent(), "musset | tom | 20 | M | tom | ");
    }
}
