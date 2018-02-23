<?php

class Personnage
{
    /*******ATTRIBUTS***********/

    private $_force;
    private $_experience;
    private $_degats;
    private $_prenom;

    private static $_texteADire = "Je vais tous vous tuer !";

    /*******CONSTANTES***********/

    const FORCE_PETITE  = 20;
    const FORCE_MOYENNE = 50;
    const FORCE_GRANDE  = 80;
    
    /*******CONSTRUCTEUR***********/

    public function __construct($forceInitiale = self::FORCE_PETITE, $degats = null, $experience = null, $prenom = null)
    {
        $this->setForce($forceInitiale);
        $this->setDegats($degats);
        $this->setExperience($experience);
        $this->setPrenom($prenom);
    }

    /*******FONCTIONS***********/

    public function gagnerExperience() // Une méthode augmentant l'attribut $experience du personnage.
    {
        $this->_experience++;
    }

    public static function parler()
    {
        echo "\n\n".self::$_texteADire."\n\n";
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

    public function setForce($force = self::FORCE_PETITE)
    {
        if (in_array($force, [self::FORCE_PETITE, self::FORCE_MOYENNE, self::FORCE_GRANDE]))
            $this->_force= $force;
        else {
            trigger_error("Valeur de force invalide", E_USER_WARNING);
            return;
        }
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