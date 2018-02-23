<?php

function chargerClasse($classe) {
    require $classe . '.php'; // On inclut la classe correspondante au paramètre passé.
}
spl_autoload_register('chargerClasse'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

$db      = new PDO('mysql:host=localhost;dbname=poophp;charset=utf8', 'root', '');
$manager = new PersonnagesManager($db);
$perso   = new Personnage01([
	'nom'        => 'Victor',
	'forcePerso' => 5,
	'degats'     => 0,
	'niveau'     => 1,
	'experience' => 0
]);

$manager->add($perso);
echo "Ok !";