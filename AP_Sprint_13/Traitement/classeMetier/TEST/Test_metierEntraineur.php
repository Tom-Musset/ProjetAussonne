<?php
use PHPUnit\Framework\TestCase;
include_once('Outil/autoload.php');
class Test_metierEntraineur extends TestCase
{
    private metierEntraineur $Entraineur;

    /** @test */
    public function initTestEnvironment()
    {
        $Entraineur = new metierEntraineur(1, "nom_Test", "login_test", "mdp_test");

        $this->assertSame("nom_Test", $Entraineur->getNomEntraineur());

    }
}


?>