<?php

class PersonnageTp
{

	/*******ATTRIBUTS***********/

    private $_id;
    private $_nom;
    private $_degats;
    private $_niveau;
    private $_experience;
    private $_puissance;
    private $_nbCoupsPortes;
    private $_dateDernierCoupPorte;
    private $_dateDerniereConnexion;

    /*******CONSTANTES***********/

	const LIMIT_COUPS_PORTES    = 3;
	const RECUPERATION_DEGATS   = 10;

	const CEST_MOI              = 1;
	const PERSONNAGE_TUE        = 2;
	const PERSONNAGE_FRAPPE     = 4;

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
		if ($persoAFrapper->getId() != $this->_id) {

            $now = new DateTime('NOW');
            $today = $now->format('Y-m-d');

            if ($this->getDateDernierCoupPorte() != NULL) {
                if ($this->getDateDernierCoupPorte() < $today) {
                    $this->_nbCoupsPortes = 0;
                }
            }

            if ($this->_nbCoupsPortes < self::LIMIT_COUPS_PORTES) {
                $this->_nbCoupsPortes++;
                $this->_dateDernierCoupPorte = $today;
                $this->gagnerExperience();
                return $persoAFrapper->recevoirDegats($this);
            }
            else
                return self::LIMIT_COUPS_PORTES;
        }
		else
			return self::CEST_MOI;
	}

    public function gagnerExperience()
    {
        $this->setExperience($this->_experience + 40);

        if ($this->_experience == 100 && $this->_niveau < 100) {
            $this->setNiveau( $this->_niveau + 1);
            $this->setExperience(0);
            $this->setPuissance($this->_puissance + 1);
        }
	}

	public function recevoirDegats(PersonnageTp $persoQuiFrappe)
	{
		$this->_degats += $persoQuiFrappe->getPuissance();

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
	public function getNiveau() { return $this->_niveau; }
	public function getExperience() { return $this->_experience; }
	public function getPuissance() { return $this->_puissance; }
	public function getNbCoupsPortes() { return $this->_nbCoupsPortes; }
	public function getDateDernierCoupPorte() { return $this->_dateDernierCoupPorte; }
	public function getDateDerniereConnexion() { return $this->_dateDerniereConnexion; }

    /*******SETTERS***********/

    public function setDateDerniereConnexion($dateDerniereConnexion)
    {
        $this->_dateDerniereConnexion = $dateDerniereConnexion;
    }

    public function setDateDernierCoupPorte($dateDernierCoupPorte)
    {
        $this->_dateDernierCoupPorte = $dateDernierCoupPorte;
    }

    public function setNbCoupsPortes($nbCoupsPortes)
    {
        $nbCoupsPortes = (int) $nbCoupsPortes;

        if ($nbCoupsPortes < 0)
            $nbCoupsPortes = 0;

        $this->_nbCoupsPortes = $nbCoupsPortes;
    }

    public function setPuissance($puissance)
    {
        $puissance = (int) $puissance;

        if ($puissance > 100)
            $puissance = 100;

        if ($puissance < 5)
            $puissance = 5;

        $this->_puissance = $puissance;
    }

    public function setNiveau($niveau)
    {
        $niveau = (int) $niveau;

        if ($niveau > 100)
            $niveau = 100;

        if ($niveau < 1)
            $niveau = 1;

        $this->_niveau = $niveau;
    }

    public function setExperience($experience)
    {
        $experience = (int) $experience;

        if ($experience > 100)
            $experience = 100;

        if ($experience < 0)
            $experience = 0;

        $this->_experience = $experience;
    }

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

    	if ($degats < 0)
    	    $degats = 0;

    	if ($degats > 100)
    	    $degats = 100;

    	$this->_degats = $degats;
    }

}