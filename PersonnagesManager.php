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
    	$q = $this->_db->prepare('INSERT INTO personnagestp(nom) VALUES(:nom)');

    	$q->bindValue(':nom', $perso->getNom());

    	$q->execute();

    	$perso->hydrate(['id' => $this->_db->lastInsertId(),'degats' => 0]);
    }

    public function get($info)
    {
    	if (is_numeric($info)) {
            $q = $this->_db->query('SELECT id, nom, degats FROM personnagestp WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            return new PersonnageTp($donnees);
        }else
        {
            $q = $this->_db->prepare('SELECT id, nom, degats FROM personnagestp WHERE nom = :nom');
            $q->execute([':nom' => $info]);
            return new PersonnageTp($q->fetch(PDO::FETCH_ASSOC));
        }
    }

    public function getList($nom)
    {
    	$persos = [];

    	$q = $this->_db->prepare('SELECT id, nom, degats FROM personnagestp WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom' => $nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
			$persos[] = new PersonnageTp($donnees);
		}

		return $persos;
    }

    public function update(PersonnageTp $perso)
    {
    	$q = $this->_db->prepare('UPDATE personnagestp SET degats = :degats WHERE id = :id');

	    $q->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
	    $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);

	    $q->execute();
    }

    public function delete(PersonnageTp $perso)
    {
    	$this->_db->exec('DELETE FROM personnagestp WHERE id = '.$perso->getId());
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM personnagestp')->fetchColumn();
    }

    public function exists($info)
    {
        if (is_numeric($info))
            return (bool) $this->_db->query('SELECT COUNT(*) FROM personnagestp WHERE id = '.$info)->fetchColumn();

        $q = $this->_db->prepare('SELECT COUNT(*) FROM personnagestp WHERE nom = :nom');
        $q->execute([':nom' => $info]);

        return (bool) $q->fetchColumn();
    }

    /*******SETTERS***********/

    public function setDb(PDO $db)
    {
    	$this->_db = $db;
    }

}