<?php

class PersonnagesManager
{

    /*******ATTRIBUTS***********/

    private $_db;

    /*******CONSTRUCTEUR***********/

    function __construct($db)
    {
        $this->setDb($db);
    }

    /*******FONCTIONS***********/

    public function add(PersonnageTp $perso)
    {
        $now = new DateTime('NOW');
        $today = $now->format('Y-m-d');

        $q = $this->_db->prepare('INSERT INTO personnagestp(nom,dateDerniereConnexion) VALUES(:nom,:dateDerniereConnexion)');

        $q->bindValue(':nom', $perso->getNom());
        $q->bindValue(':dateDerniereConnexion', $today);

        $q->execute();

        $perso->hydrate([
            'id' => $this->_db->lastInsertId(),
            'degats' => 0,
            'niveau' => 1,
            'experience' => 0,
            'puissance' => 5,
            'dateDernierCoupPorte' => NULL,
            'dateDerniereConnexion' => $today,
            'nbCoupsPortes' => 0
        ]);
    }

    public function get($info)
    {
        if (is_numeric($info)) {
            $q = $this->_db->query('SELECT * FROM personnagestp WHERE id = ' . $info);

        } else {
            $q = $this->_db->prepare('SELECT * FROM personnagestp WHERE nom = :nom');
            $q->execute([':nom' => $info]);
        }

        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        $update = false;

        $now = new DateTime('NOW');
        $today = $now->format('Y-m-d');

        if ($donnees['dateDernierCoupPorte'] != NULL)
        {
            if ($donnees['dateDernierCoupPorte'] < $today) {
                $donnees['nbCoupsPortes'] = 0;
                $update = true;
            }
        }

        if ($donnees['dateDerniereConnexion'] < $today) {
            $donnees['degats'] -= PersonnageTp::RECUPERATION_DEGATS;
            $donnees['dateDerniereConnexion'] = $today;
            $update = true;
        }

        if ($update) {
            $q = $this->_db->prepare('UPDATE personnagestp SET dateDerniereConnexion = :dateDerniereConnexion, degats = :degats, nbCoupsPortes = :nbCoupsPortes WHERE id = :id');
            $q->bindValue(':id', $donnees['id'], PDO::PARAM_INT);
            $q->bindValue(':dateDerniereConnexion', $today, PDO::PARAM_INT);
            $q->bindValue(':degats', $donnees['degats'], PDO::PARAM_INT);
            $q->bindValue(':nbCoupsPortes', $donnees['nbCoupsPortes'], PDO::PARAM_INT);
            $q->execute();
        }

        return new PersonnageTp($donnees);
    }

    public function getList($nom)
    {
        $persos = [];

        $q = $this->_db->prepare('SELECT * FROM personnagestp WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom' => $nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
            $persos[] = new PersonnageTp($donnees);
        }

        return $persos;
    }

    public function update(PersonnageTp $perso)
    {
        $q = $this->_db->prepare('UPDATE personnagestp SET degats = :degats, niveau = :niveau, experience = :experience, puissance = :puissance, nbCoupsPortes = :nbCoupsPortes, dateDernierCoupPorte = :dateDernierCoupPorte, dateDerniereConnexion = :dateDerniereConnexion WHERE id = :id');

        $q->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $q->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
        $q->bindValue(':puissance', $perso->getPuissance(), PDO::PARAM_INT);
        $q->bindValue(':nbCoupsPortes', $perso->getNbCoupsPortes(), PDO::PARAM_INT);
        $q->bindValue(':dateDernierCoupPorte', $perso->getDateDernierCoupPorte(), PDO::PARAM_STR);
        $q->bindValue(':dateDerniereConnexion', $perso->getDateDerniereConnexion(), PDO::PARAM_STR);

        $q->execute();
    }

    public function delete(PersonnageTp $perso)
    {
        $this->_db->exec('DELETE FROM personnagestp WHERE id = ' . $perso->getId());
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM personnagestp')->fetchColumn();
    }

    public function exists($info)
    {
        if (is_numeric($info))
            return (bool)$this->_db->query('SELECT COUNT(*) FROM personnagestp WHERE id = ' . $info)->fetchColumn();

        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnagestp WHERE nom = :nom');
        $q->execute([':nom' => $info]);

        return (bool)$q->fetchColumn();
    }

    /*******SETTERS***********/

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}