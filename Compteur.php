<?php

class Compteur
{
    /*******ATTRIBUTS***********/
	
	private static $_compteur = 0;

    /*******CONSTRUCTEUR***********/

	function __construct()
	{
		self::$_compteur++;
	}

    /*******GETTERS***********/

	public static function getCompteur()
	{
		return self::$_compteur;
	}
}