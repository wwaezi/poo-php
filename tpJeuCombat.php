<?php

function chargerClasse($classe)
{
    require $classe . '.php'; // On inclut la classe correspondante au paramètre passé.
}

spl_autoload_register('chargerClasse'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.

if (isset($_GET['deconnexion']))
{
    session_destroy();
    header('Location: http://localhost/poo-php/tpJeuCombat.php');
    exit();
}

if (isset($_SESSION['perso'])) // Si la session perso existe, on restaure l'objet.
{
    $perso = $_SESSION['perso'];
}

$db = new PDO('mysql:host=localhost;dbname=poophp;charset=utf8', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

$manager = new PersonnagesManager($db);

if (isset($_POST['nom']) && isset($_POST['creer']))
{
    $perso = new PersonnageTp(['nom' => $_POST['nom']]);

    $nom = $perso->getNom();

    if ($manager->exists($nom)) {
        $message = "Il y a déjà un personnage qui porte ce nom.";
        unset($perso);
    } elseif (!$perso->nomValide()) {
        $message = "Ce nom n'est pas valide.";
        unset($perso);
    } else {
        $manager->add($perso);
        $message = "Personnage créé !";
    }
}
elseif (isset($_POST['nom']) && isset($_POST['utiliser']))
{
    $nom = $_POST['nom'];
    if (!$manager->exists($nom))
    {
        $message = "Ce personnage n'existe pas.";
    }
    else
    {
        $perso = $manager->get($nom);
    }
}

if (isset($_GET['idPersoAFrapper']) && !empty($_GET['idPersoAFrapper']) && isset($perso))
{
    $idPersoAFrapper = $_GET['idPersoAFrapper'];

    if ($manager->exists($idPersoAFrapper)){
        $persoAFrapper = $manager->get($idPersoAFrapper);
        switch ($perso->frapper($persoAFrapper))
        {
            case PersonnageTp::PERSONNAGE_FRAPPE:
                $manager->update($perso);
                $manager->update($persoAFrapper);
                $message = "Tu viens de frapper ".$persoAFrapper->getNom().".";
                break;
            case PersonnageTp::PERSONNAGE_TUE:
                $manager->delete($persoAFrapper);
                $manager->update($perso);
                $message = "Tu viens de tuer ".$persoAFrapper->getNom().".";
                break;
            case PersonnageTp::CEST_MOI:
                $message = "Tu ne peux pas te frapper toi-même.";
                break;
            case PersonnageTp::LIMIT_COUPS_PORTES:
                $message = "Tu as suffisament frappé pour aujourd'hui.";
                break;
        }
    }
}

$nbDePerso = $manager->count();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>TP : Mini jeu de combat</title>

        <meta charset="utf-8" />
    </head>
    <body>

        <p>Nombre de personnages crées : <?php echo $nbDePerso; ?></p>

        <?php
            if (isset($message))
                echo "<p style='color:green'>".$message."</p>";
        ?>

        <?php if (!isset($perso)): ?>

            <form action="" method="post">
                <p>
                    Nom : <input type="text" name="nom" maxlength="50" value="<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>"/>
                    <input type="submit" value="Créer ce personnage" name="creer" />
                    <input type="submit" value="Utiliser ce personnage" name="utiliser" />
                </p>
            </form>

        <?php else: ?>

            <p><a href="?deconnexion=1">Se déconnecter</a></p>

            <fieldset>
                <legend>Mes informations :</legend>
                <p>
                    Nom : <?= htmlspecialchars($perso->getNom()) ?><br/>
                    Dégâts : <?= htmlspecialchars($perso->getDegats()) ?><br/>
                    Niveau : <?= htmlspecialchars($perso->getNiveau()) ?><br/>
                    Experience : <?= htmlspecialchars($perso->getExperience()) ?><br/>
                    Puissance : <?= htmlspecialchars($perso->getPuissance()) ?><br/>
                    Nombre de coups portés aujourd'hui : <?= htmlspecialchars($perso->getNbCoupsPortes()) ?>
                </p>
            </fieldset>


            <?php if ($nbDePerso > 1): ?>

                <p>Clique sur un personnage pour le frapper:</p>

                <fieldset>

                    <legend>Qui frapper ?</legend>

                    <?php foreach ($manager->getList($perso->getNom()) as $value): ?>
                        <table style="margin-left: 20px;">
                            <tr>
                                <td><a href="?idPersoAFrapper=<?= $value->getId() ?>"><?= htmlspecialchars($value->getNom()) ?></a> (dégâts : <?= $value->getDegats() ?>)</td>
                            </tr>
                        </table>
                    <?php endforeach; ?>

                </fieldset>

            <?php else: ?>

                <p>Aucun personnage à frapper tu es le seul.</p>

            <?php endif; ?>

        <?php endif; ?>
    </body>
</html>
<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
{
    $_SESSION['perso'] = $perso;
}
