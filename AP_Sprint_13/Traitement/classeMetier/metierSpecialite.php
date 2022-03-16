<?php
Class metierSpecialite
{

    private $id‪Specialite; 
	private $libSpecialite; 

    //CONSTRUCTEUR

    public function __construct($unId‪Specialite, $unLibSpecialite)
		{
		$this->id‪Specialite = $unId‪Specialite;
		$this->libSpecialite = $unLibSpecialite;
		}

    //ACCESSEURS

	public function getIdSpecialite()
        {
            return $this->id‪Specialite;
        }
		
		
	public function getLibSpecialite()
		{
		return $this->libSpecialite;
		}


    //SETTEURS

    public function setId‪Specialite($unId‪Specialite)
    {
    $this->id‪Specialite = $unId‪Specialite;
    }

	public function setLibSpecialite($unLibSpecialite)
		{
		$this->libSpecialite = $unLibSpecialite;
		}
    		

}

?>