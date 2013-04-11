<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeCampus()
	{
		$requete = '
		SELECT campus_id, campus_nom, effectif, locaux,
		(SELECT COUNT(*) FROM velo_dept_universitaire WHERE dept_campus_id = campus_id) AS nbDept
		FROM velo_campus
		LEFT JOIN
		(SELECT local_campus_id AS lid, COUNT(*) as locaux FROM velo_local GROUP BY local_campus_id) AS l
		ON lid = campus_id
		LEFT JOIN
		(SELECT dept_campus_id as did, COUNT(*) as effectif FROM velo_dept_universitaire JOIN velo_locataire ON loc_dept_id = dept_id GROUP BY dept_campus_id) AS d
		ON did = campus_id
		ORDER BY campus_nom';
		$query = $this->db->query($requete);
		return $query->result();
	}

	public function listeCampusTri()
	{
		$req = 'SELECT campus_nom, campus_id FROM velo_campus ORDER BY campus_nom';
		$query = $this->db->query($req);
		return $query->result();

	}

	public function getCampus($id)
	{
		$req = 'SELECT campus_nom FROM velo_campus WHERE campus_id = ?';
		$query = $this->db->query($req, array($id));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	
	public function ajouter($campus)
	{
		$req = 'INSERT INTO velo_campus (campus_nom) VALUES (?)';
		return $this->db->query($req, array($campus));
	}
	
	public function modifier($id, $campus)
	{
		$req = 'UPDATE velo_campus SET campus_nom = ? WHERE campus_id = ?';
		return $this->db->query($req, array($campus, $id));
	}
	
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_campus WHERE campus_id = ?';
		return $this->db->query($req, array($id));
	}
}
