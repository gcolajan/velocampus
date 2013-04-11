<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ville_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getVille($id)
	{
	    $req = 'SELECT ville_id, ville_nom FROM velo_ville WHERE ville_id = ?';
		$query = $this->db->query($req, array($id));
		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}


	public function listeVille()
	{
		$req = 'SELECT ville_nom, ville_id FROM velo_ville ORDER BY ville_nom';
		$query = $this->db->query($req);
		return $query->result();

	}
}