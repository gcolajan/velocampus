<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modele_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeModeles()
	{
		$requete = 'SELECT modele_id, modele_nom, (SELECT COUNT(*) FROM velo_velo WHERE modele_id = velo_modele_id) AS nb FROM velo_modele ORDER BY modele_nom';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function listeModelesAnnuels()
	{
		$requete = '
		SELECT modele_id, modele_nom, YEAR(velo_date_achat) AS annee, COUNT(*) AS qt, qtLibre
		FROM velo_velo
		JOIN velo_modele ON velo_modele_id = modele_id
		LEFT JOIN (SELECT loue_velo_id, COUNT(*) as qtLibre FROM velo_loue WHERE loue_date_rendu_effective > "0000-00-00") AS t
		ON loue_velo_id = velo_id
		GROUP BY YEAR(velo_date_achat), velo_modele_id
		ORDER BY YEAR(velo_date_achat) DESC, modele_nom ASC';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function getModele($id)
	{
		$req = 'SELECT modele_nom FROM velo_modele WHERE modele_id = ?';
		$query = $this->db->query($req, array($id));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	
	public function getModeleTri()
	{
	    $req = 'SELECT modele_id, modele_nom FROM velo_modele ORDER BY modele_nom';
		$query = $this->db->query($req);	
		return $query->result();    
	}
	
	public function ajouter($statut)
	{
		$req = 'INSERT INTO velo_modele (modele_nom) VALUES (?)';
		return $this->db->query($req, array($statut));
	}
	
	public function modifier($id, $modele)
	{
		$req = 'UPDATE velo_modele SET modele_nom = ? WHERE modele_id = ?';
		return $this->db->query($req, array($modele, $id));
	}
	
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_modele WHERE modele_id = ?';
		return $this->db->query($req, array($id));
	}
}
