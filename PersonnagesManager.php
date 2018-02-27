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
        $q = $this->_db->prepare('INSERT INTO personnagestp(nom,dateDernierCoupPorte) VALUES(:nom,:dateDernierCoupPorte)');

        $now = new DateTime('NOW');

        $q->bindValue(':nom', $perso->getNom());
        $q->bindValue(':dateDernierCoupPorte', $now->format('Y-m-d'));

        $q->execute();


        $perso->hydrate([
            'id' => $this->_db->lastInsertId(),
            'degats' => 0,
            'niveau' => 1,
            'experience' => 0,
            'puissance' => 5,
            'dateDernierCoupPorte' => $now->format('Y-m-d'),
            'nbCoupsPortes' => 0
        ]);
    }

    public function get($info)
    {
        if (is_numeric($info)) {
            $q = $this->_db->query('SELECT * FROM personnagestp WHERE id = ' . $info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            return new PersonnageTp($donnees);
        } else {
            $q = $this->_db->prepare('SELECT * FROM personnagestp WHERE nom = :nom');
            $q->execute([':nom' => $info]);
            return new PersonnageTp($q->fetch(PDO::FETCH_ASSOC));
        }
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
        $q = $this->_db->prepare('UPDATE personnagestp SET degats = :degats, niveau = :niveau, experience = :experience, puissance = :puissance, nbCoupsPortes = :nbCoupsPortes, dateDernierCoupPorte = :dateDernierCoupPorte WHERE id = :id');

        $q->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
        $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $q->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $q->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
        $q->bindValue(':puissance', $perso->getPuissance(), PDO::PARAM_INT);
        $q->bindValue(':nbCoupsPortes', $perso->getNbCoupsPortes(), PDO::PARAM_INT);
        $q->bindValue(':dateDernierCoupPorte', $perso->getDateDernierCoupPorte()->format('Y-m-d'), PDO::PARAM_INT);

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