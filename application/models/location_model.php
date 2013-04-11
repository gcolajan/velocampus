<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listeLocation()
	{
		$requete = '
		SELECT l.loue_loc_id,l.loue_velo_id,l.loue_date_location,l.loue_duree_theorique,m.modele_nom,loc.loc_nom,YEAR(v.velo_date_achat) AS annee_achat,l.loue_date_rendu_effective
		FROM velo_loue l 
		JOIN velo_velo v
		ON loue_velo_id=velo_id 
		JOIN velo_modele m
		ON velo_modele_id=modele_id
		JOIN velo_locataire loc
		ON loc_id=loue_loc_id
		ORDER BY loue_date_location';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function getLocation($id_locataire,$id_velo,$date_location)
	{
		$req = '
		SELECT *
		FROM velo_loue l
		WHERE loue_loc_id = ?
		AND loue_velo_id = ?
		AND loue_date_location = ?;';
		$query = $this->db->query($req, array($id_locataire,$id_velo,$date_location));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	
	public function ajouterLocation($location_date_debut_location,$location_cadenas1,$location_cadenas2,$location_cadenas3,$location_duree_theorique,$identifiant_velo,$identifiant_locataire)
	{
		$req = 'INSERT INTO velo_loue
 		(loue_date_location,loue_cadenas1,loue_cadenas2,loue_cadenas3,loue_duree_theorique,loue_velo_id,loue_loc_id,loue_date_rendu_effective) 
		VALUES (?,?,?,?,?,?,?,NULL)';
		return $this->db->query($req, array($location_date_debut_location,$location_cadenas1,$location_cadenas2,$location_cadenas3,$location_duree_theorique,$identifiant_velo,$identifiant_locataire));
	}
	
	public function modifierLocation($location_date_debut_location,$tempo_loca_date,$location_cadenas1,$location_cadenas2,$location_cadenas3,$location_duree_theorique,$identifiant_velo,$tempo_id_velo,$identifiant_loc,$tempo_identifiant_loc)
	{
		$req = 'UPDATE velo_loue 
		SET loue_duree_theorique = ?,
		loue_date_location = ?,
		loue_cadenas1 = ?,
		loue_cadenas2 = ?,
		loue_cadenas3 = ?,
		loue_velo_id = ?,
		loue_loc_id = ?,
		loue_date_rendu_effective = NULL
		WHERE loue_date_location = ?
		AND loue_velo_id = ?
		AND loue_loc_id = ?';

		return $this->db->query($req, array($location_duree_theorique, $location_date_debut_location, $location_cadenas1, $location_cadenas2, $location_cadenas3, $identifiant_velo, $identifiant_loc, $tempo_loca_date, $tempo_id_velo, $tempo_identifiant_loc));
	}
	
	public function supprimerLoc($id_locataire,$id_velo,$date_location)
	{
		$req = 'DELETE FROM velo_loue
		WHERE loue_loc_id = ?
		AND loue_velo_id = ?
		AND loue_date_location = ?;';
		return $this->db->query($req, array($id_locataire,$id_velo,$date_location));
	}

	public function arreterLoc($id_locataire,$id_velo,$date_location)
	{
		$req='UPDATE velo_loue
		SET loue_date_rendu_effective=NOW()
		WHERE loue_loc_id = ?
		AND loue_velo_id = ?
		AND loue_date_location = ?;';

		return $this->db->query($req, array($id_locataire,$id_velo,$date_location));
	}

	public function recommenceLoc($id_locataire,$id_velo,$date_location)
	{
		$req='UPDATE velo_loue
		SET loue_date_rendu_effective=NULL
		WHERE loue_loc_id = ?
		AND loue_velo_id = ?
		AND loue_date_location = ?;';

		return $this->db->query($req, array($id_locataire,$id_velo,$date_location));
	}

	public function testerVeloTjrsDispo($id_velo)
	{
		$req='SELECT COUNT(*) AS nb
		FROM velo_loue WHERE loue_velo_id = ?
		AND  loue_date_rendu_effective IS NULL;';

		$res = $this->db->query($req, array($id_velo));
		$data = $res->row();
		
		if ($data->nb == 0)
			return true;
		else
			return false;
	}

	// TODO : Diviser cette requête en 3 : locataire / vélo / location, jointures à 9 tables : NON
	public function donneesFicheLocation($id_locataire,$id_velo,$date_location)
	{
	$req='SELECT l.loue_loc_id, l.loue_velo_id, l.loue_date_location, l.loue_cadenas1, l.loue_cadenas2, l.loue_cadenas3, l.loue_duree_theorique, l.loue_date_rendu_effective, loc.loc_nom, loc_prenom, v.velo_date_achat, m.modele_nom, lo.local_nom, vi.ville_nom, cam.campus_nom, dept.dept_nom, stat.statut_nom
	FROM velo_loue l, velo_locataire loc, velo_velo v, velo_modele m, velo_local lo, velo_ville vi, velo_campus cam, velo_dept_universitaire dept, velo_statut stat
	WHERE l.loue_loc_id=loc.loc_id
	AND loc.loc_statut_id=stat.statut_id
	AND loc.loc_dept_id=dept.dept_id
	AND l.loue_velo_id=v.velo_id
	AND v.velo_modele_id=m.modele_id
	AND v.velo_local_id=lo.local_id
	AND lo.local_ville_id=vi.ville_id
	AND lo.local_campus_id=cam.campus_id

	AND l.loue_loc_id = ?
	AND l.loue_velo_id = ?
	AND l.loue_date_location = ?';

	$query = $this->db->query($req, array($id_locataire,$id_velo,$date_location));
	return $query->row();
	}
}
