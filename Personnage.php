<?php

class Personnage
{
    /*******ATTRIBUTS***********/

    private $_force;
    private $_experience;
    private $_degats;
    private $_prenom;

    /*******CONSTRUCTEUR***********/

    public function __construct($force = null, $degats = null, $experience = null, $prenom = null)
    {
        $this->setForce($force);
        $this->setDegats($degats);
        $this->setExperience($experience);
        $this->setPrenom($prenom);
    }

    /*******FONCTIONS***********/

    public function gagnerExperience() // Une méthode augmentant l'attribut $experience du personnage.
    {
        $this->_experience++;
    }

    public function parler()
    {
        echo "\n\nJe suis un personnage, nom est ".$this->_prenom." !\n\n";
    }

    public function frapper(Personnage $persoAFrapper)
    {
        $persoAFrapper->_degats+= $this->_force;
        $this->gagnerExperience();
    }

    /*******GETTERS***********/

    public function getExperience()
    {
        return $this->_experience;
    }

    public function getForce()
    {
        return $this->_force;
    }

    public function getDegats()
    {
        return $this->_degats;
    }

    public function getPrenom()
    {
        return $this->_prenom;
    }

    /*******SETTERS***********/

    public function setDegats($degats = 0)
    {

        if ($degats == null)
            $degats = 0;

        if (!is_int($degats)) {
            trigger_error("Les dégats d'un personnage doit être un nombre entier.", E_USER_WARNING);
            return;
        }

        if ($degats > 100) {
            trigger_error("Les dégats d'un personnage ne peuvent dépasser 100.", E_USER_WARNING);
            return;
        }

        $this->_degats= $degats;
    }

    public function setPrenom($prenom = "Perso sans nom")
    {   
        if ($prenom == null)
            $prenom = "Perso sans nom";

        if (!is_string($prenom)) {
            trigger_error("Le prénom d'un personnage doit être une chaîne de caractère.", E_USER_WARNING);
            return;
        }

        $this->_prenom= $prenom;
    }

    public function setForce($force = 0)
    {
        if ($force == null)
            $force = 0;

        if (!is_int($force)) {
            trigger_error("La force d'un personnage doit être un nombre entier.", E_USER_WARNING);
            return;
        }

        if ($force > 100) {
            trigger_error("La force d'un personnage ne peut dépasser 100.", E_USER_WARNING);
            return;
        }

        $this->_force= $force;
    }

    public function setExperience($experience = 0)
    {
        if ($experience == null)
            $experience = 0;

        if (!is_int($experience)) {
            trigger_error("L'expérience d'un personnage doit être un nombre entier.", E_USER_WARNING);
            return;
        }

        if ($experience > 100) {
            trigger_error("L'expérience d'un personnage ne peut dépasser 100.", E_USER_WARNING);
            return;
        }

        $this->_experience= $experience;
    }
}