<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departement_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeDepartements($campus='')
	{
		if (!empty($campus)) $where = 'WHERE campus_id='.intval($campu);
		else $where='';
			$requete = 'SELECT campus_id, campus_nom, dept_id, dept_nom, dept_loc, dept_loc_actif
			FROM velo_dept_universitaire
			JOIN velo_campus ON campus_id = dept_campus_id
			LEFT JOIN 
				(SELECT t.loc_dept_id AS did, COUNT(*) AS dept_loc
				FROM velo_locataire t GROUP BY t.loc_dept_id)
				AS dtid ON dtid.did = dept_id
			LEFT JOIN
				(SELECT p.loc_dept_id AS did, COUNT(*) AS dept_loc_actif
				FROM velo_locataire p
				JOIN velo_loue ON loue_loc_id = p.loc_id
				WHERE loue_date_rendu_effective > "0000-00-00"
				GROUP BY p.loc_dept_id)
				AS dpid ON dpid.did = dept_id
			'.$where.' 
			ORDER BY campus_nom, dept_nom';
		$query = $this->db->query($requete);
		return $query->result();
	}

	public function getDepartement($id)
	{
		$req = 'SELECT dept_nom, dept_campus_id FROM velo_dept_universitaire WHERE dept_id = ?';
		$query = $this->db->query($req, array($id));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}

	public function ajouter($departement,$campus)
	{
		$req = 'INSERT INTO velo_dept_universitaire (dept_nom, dept_campus_id) VALUES (?, ?)';
		return $this->db->query($req, array($departement,$campus));
	}
	
	public function modifier($id, $departement, $campus)
	{
		$req = 'UPDATE velo_dept_universitaire SET dept_nom = ?, dept_campus_id = ? WHERE dept_id = ?';
		return $this->db->query($req, array($departement, $campus, $id));
	}
	
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_dept_universitaire WHERE dept_id = ?';
		return $this->db->query($req, array($id));
	}
}

/* End of file billet_model.php */
/* Location: ./application/models/billet_model.php */
