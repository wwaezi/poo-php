<?php

function chargerClasse($classe)
{
    require $classe . '.php'; // On inclut la classe correspondante au paramètre passé.
}

spl_autoload_register('chargerClasse'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

$db = new PDO('mysql:host=localhost;dbname=poophp;charset=utf8', 'root', '');

$request = $db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');

echo "\n\n";

while ($donnees = $request->fetch(PDO::FETCH_ASSOC)) {

	// $perso = new Personnage01(
	// 	$donnees['id'],
	// 	$donnees['nom'],
	// 	$donnees['forcePerso'],
	// 	$donnees['degats'],
	// 	$donnees['niveau'],
	// 	$donnees['experience']
	// );
	
	// $perso = new Personnage01(); // tous les arguments valent null par défaut 

	$perso = new Personnage01($donnees); // test de la fonction hydrate() 
	// $perso->hydrate($donnees); // test de la fonction hydrate() 

	echo $perso->getNom(), " a ", $perso->getForcePerso(), " de force, ", $perso->getDegats(), " de degats, ", $perso->getExperience(), " d'experience et est au niveau ", $perso->getNiveau();
	echo "\n\n";
}