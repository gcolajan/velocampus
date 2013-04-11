<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statut_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeStatuts()
	{
		$requete = '
		SELECT statut_id, statut_nom, nbTotal, nbPartiel
		FROM velo_statut
		LEFT JOIN (
		SELECT loc_statut_id AS sid, COUNT( * ) AS nbTotal
		FROM velo_locataire
		GROUP BY loc_statut_id
		) AS t ON statut_id = t.sid
		LEFT JOIN (
		SELECT loc_statut_id AS sid, COUNT( * ) AS nbPartiel
		FROM velo_locataire
		JOIN velo_loue ON loue_loc_id = loc_id
		WHERE loue_date_rendu_effective > "0000-00-00"
		GROUP BY loc_statut_id
		) AS p ON statut_id = p.sid
		ORDER BY statut_nom';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function getStatut($id)
	{
		$req = 'SELECT statut_nom FROM velo_statut WHERE statut_id = ?';
		$query = $this->db->query($req, array($id));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	
	public function ajouter($statut)
	{
		$req = 'INSERT INTO velo_statut (statut_nom) VALUES (?)';
		return $this->db->query($req, array($statut));
	}
	
	public function modifier($id, $statut)
	{
		$req = 'UPDATE velo_statut SET statut_nom = ? WHERE statut_id = ?';
		return $this->db->query($req, array($statut, $id));
	}
	
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_statut WHERE statut_id = ?';
		return $this->db->query($req, array($id));
	}
}

/* End of file billet_model.php */
/* Location: ./application/models/billet_model.php */
