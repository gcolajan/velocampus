<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Local_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeLocal($local='', $campus='')
	{
		// Utilisé quand on modifie un local
		if($local > 0)
			$where = 'WHERE local_id = '.intval($local);
		else
			$where = '';
		
		// Utilisé quand on applique un tri
		if ($campus > 0) // Un 0 équivaut à "empty"
			$where  .= 'WHERE local_campus_id = '.intval($campus);
			
		$requete = '
		SELECT local_id, local_nom,local_adresse,local_campus_id,local_ville_id,ville_nom, campus_nom, nbVelo
		FROM velo_local
		JOIN velo_campus ON local_campus_id = campus_id
		JOIN velo_ville ON local_ville_id = ville_id
		LEFT JOIN (
		SELECT velo_local_id AS sid, COUNT( * ) AS nbVelo
		FROM velo_velo
		GROUP BY velo_local_id
		) AS t ON local_id = t.sid
		'.$where.'
		ORDER BY campus_nom, local_nom';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function getLocal($id)
	{
	    $req = 'SELECT local_id, local_nom FROM velo_local WHERE local_id = ?';
		$query = $this->db->query($req, array($id));
		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	
	public function getLocalTri()
	{
	    $req = 'SELECT local_id,local_nom FROM velo_local ORDER BY local_nom';
		$query = $this->db->query($req);	
		return $query->result();    
	}
	
	public function ajouter($local,$adresse,$campus,$ville)
	{
		$req = 'INSERT INTO velo_local (local_nom,local_adresse,local_campus_id,local_ville_id) VALUES (?,?,?,?)';
		return $this->db->query($req, array($local,$adresse,$campus,$ville));
	}
	
	public function modifier($local, $adresse, $campus, $ville, $id)
	{
	$req = 'UPDATE velo_local SET local_nom = ?,local_adresse = ?, local_campus_id = ?, local_ville_id=? WHERE local_id = ?';
		return $this->db->query($req, array($local, $adresse,$campus,$ville,$id));
	}
	
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_local
		WHERE local_id=?';
		return $this->db->query($req, array($id));
	}
}
