<?php

class Personnage01
{
	
	/*******ATTRIBUTS***********/

    private $_id;
    private $_nom;
    private $_forcePerso;
    private $_degats;
    private $_niveau;
    private $_experience;

    /*******CONSTRUCTEUR***********/

	// function __construct($id = null, $nom = null, $forcePerso = null, $degats = null, $niveau = null , $experience = null)
	function __construct(array $donnees)
	{
		// $this->setId($id);
		// $this->setNom($nom);
		// $this->setForcePerso($forcePerso);
		// $this->setDegats($degats);
		// $this->setNiveau($niveau);
		// $this->setExperience($experience);

		$this->hydrate($donnees);
	}

    /*******FONCTIONS***********/

	public function hydrate(array $donnees)
	{
		// if (isset($donnees["id"])) $this->setId($donnees["id"]);
		// if (isset($donnees["nom"])) $this->setNom($donnees["nom"]);
		// if (isset($donnees["forcePerso"])) $this->setForcePerso($donnees["forcePerso"]);
		// if (isset($donnees["degats"])) $this->setDegats($donnees["degats"]);
		// if (isset($donnees["niveau"])) $this->setNiveau($donnees["niveau"]);
		// if (isset($donnees["experience"])) $this->setExperience($donnees["experience"]);

		// Plus rapide
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method))
				$this->$method($value);
		}
	}

    /*******GETTERS***********/

	public function getId() { return $this->_id; }
	public function getNom() { return $this->_nom; }
	public function getForcePerso() { return $this->_forcePerso; }
	public function getDegats() { return $this->_degats; }
	public function getNiveau() { return $this->_niveau; }
	public function getExperience() { return $this->_experience; }

    /*******SETTERS***********/

    public function setId($id)
    {
    	$id = (int) $id;

    	if ($id > 0)
    		$this->_id = $id;
    }

    public function setNom($nom)
    {
    	if (is_string($nom) && strlen($nom) <= 30)
    		$this->_nom = $nom;
    }

    public function setForcePerso($forcePerso)
    {
    	$forcePerso = (int) $forcePerso;

    	if ($forcePerso >= 1 && $forcePerso <= 100)
    		$this->_forcePerso = $forcePerso;
    }

    public function setDegats($degats)
    {
    	$degats = (int) $degats;

    	if ($degats >= 0 && $degats <= 100)
    		$this->_degats = $degats;
    }

    public function setNiveau($niveau)
    {
    	$niveau = (int) $niveau;

    	if ($niveau >= 0 && $niveau <= 100)
    		$this->_niveau = $niveau;
    }

    public function setExperience($experience)
    {
    	$experience = (int) $experience;

    	if ($experience >= 0 && $experience <= 100)
    		$this->_experience = $experience;
    }

}