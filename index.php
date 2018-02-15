<?php

function chargerClasse($classe)
{
    require $classe . '.php'; // On inclut la classe correspondante au paramètre passé.
}

spl_autoload_register('chargerClasse'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

$perso1 = new Personnage(5,null,0,'Perso 1');
$perso1->parler();
echo "Experience: ".$perso1->getExperience()."\n";
echo "Force     : ".$perso1->getForce()."\n";
echo "Degats    : ".$perso1->getDegats()."\n\n";

echo "--------------------------------------------";

$perso2 = new Personnage(17,null,0,'Perso 2');
$perso2->parler();
echo "Experience: ".$perso2->getExperience()."\n";
echo "Force     : ".$perso2->getForce()."\n";
echo "Degats    : ".$perso2->getDegats()."\n\n";

echo "--------------------------------------------\n\n";

$perso1->frapper($perso2);
echo "Perso 1 frappe Perso 2";

echo "\n\n--------------------------------------------\n\n";

$perso1->frapper($perso2);
echo "Perso 1 frappe Perso 2";

echo "\n\n--------------------------------------------";

$perso1->parler();
echo "Experience: ".$perso1->getExperience()."\n";
echo "Force     : ".$perso1->getForce()."\n";
echo "Degats    : ".$perso1->getDegats()."\n\n";

echo "--------------------------------------------";
$perso2->parler();
echo "Experience: ".$perso2->getExperience()."\n";
echo "Force     : ".$perso2->getForce()."\n";
echo "Degats    : ".$perso2->getDegats()."\n\n";

echo "--------------------------------------------\n\n";

$perso2->frapper($perso1);
echo "Perso 2 frappe Perso 1";

echo "\n\n--------------------------------------------";

$perso1->parler();
echo "Experience: ".$perso1->getExperience()."\n";
echo "Force     : ".$perso1->getForce()."\n";
echo "Degats    : ".$perso1->getDegats()."\n\n";

echo "--------------------------------------------";
$perso2->parler();
echo "Experience: ".$perso2->getExperience()."\n";
echo "Force     : ".$perso2->getForce()."\n";
echo "Degats    : ".$perso2->getDegats()."\n\n";

echo "--------------------------------------------\n\n";
