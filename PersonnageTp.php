<?php

class PersonnageTp
{
	
	/*******ATTRIBUTS***********/

    private $_id;
    private $_nom;
    private $_degats;

    /*******CONSTANTES***********/

	const FORCE             = 30;

	const CEST_MOI          = 1;
	const PERSONNAGE_TUE    = 2;
	const PERSONNAGE_FRAPPE = 3;

     /*******CONSTRUCTEUR***********/

	function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

    /*******FONCTIONS***********/

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method))
				$this->$method($value);
		}
	}

	public function frapper(PersonnageTp $persoAFrapper)
	{
		if ($persoAFrapper->getId() != $this->_id)
			return $persoAFrapper->recevoirDegats();
		else
			return self::CEST_MOI;
	}

	public function recevoirDegats()
	{
		$this->_degats += self::FORCE;

		if ($this->_degats >= 100)
			return self::PERSONNAGE_TUE;
		
		return self::PERSONNAGE_FRAPPE;
	}

    public function nomValide()
    {
        $nom = $this->_nom;
        if (is_string($nom) && strlen($nom) <= 30 && strlen($nom) >= 3)
            return true;

        return false;
    }

	/*******GETTERS***********/

	public function getId() { return $this->_id; }
	public function getNom() { return $this->_nom; }
	public function getDegats() { return $this->_degats; }

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

    public function setDegats($degats)
    {
    	$degats = (int) $degats;

    	if ($degats >= 0 && $degats <= 100)
    		$this->_degats = $degats;
    }

}