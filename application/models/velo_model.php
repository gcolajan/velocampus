<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Velo_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function getVelo($id)
	{
		$req = 'SELECT * FROM velo_velo WHERE velo_id = ?';
		$query = $this->db->query($req, array($id));

		if ($query->num_rows() > 0)
			return $query->row();
		
		return false;
	}
	

	public function listeVelos()
	{
		$requete = 'SELECT v.velo_id, l.local_nom, m.modele_nom, v.velo_date_achat, v.velo_suivi, v.velo_observations 
		            FROM velo_velo v, velo_modele m, velo_local l
		            WHERE v.velo_modele_id = m.modele_id
		            AND v.velo_local_id = l.local_id
		            ORDER BY v.velo_id';
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function ficheVelo($velo_id)
	{
	    $req = 'SELECT v.velo_id, l.local_nom, m.modele_nom, v.velo_date_achat, v.velo_suivi, v.velo_observations, lo.loue_date_rendu_effective, lo.loue_date_location, lo.loue_loc_id, loc_id, loc_nom, loc_prenom,
	                (SELECT COUNT(*) FROM velo_loue WHERE loue_velo_id=velo_id) AS nbLoc
		            FROM velo_velo v
		            JOIN velo_modele m ON v.velo_modele_id = m.modele_id
		            JOIN velo_local l ON v.velo_local_id = l.local_id
		            LEFT JOIN velo_loue lo ON lo.loue_velo_id = v.velo_id
		            LEFT JOIN velo_locataire ON loc_id = loue_loc_id
		            WHERE v.velo_id = ?
		            ORDER BY lo.loue_date_location DESC
		            LIMIT 1';
		$query = $this->db->query($req, array($velo_id));
		return $query->row();
	}
	
	public function creer_velo($velo_date_achat, $velo_observations, $velo_modele_id, $velo_local_id)
	{
	    $req = 'INSERT INTO velo_velo (velo_date_achat, velo_observations, velo_modele_id, velo_local_id) VALUES (?,?,?,?)';
		return $this->db->query($req, array($velo_date_achat, $velo_observations, $velo_modele_id, $velo_local_id));
	}
	
	
	public function supprVelo($velo_id)
	{
		$req = 'DELETE FROM velo_velo
		WHERE velo_id='.$velo_id.'';
		return $this->db->query($req, array($velo_id));
	}
	
	public function listeVelosTri($triLocal="", $triModele="", $triLoue="")
	{
	    if(!empty($triLocal)) $cond_local = 'AND v.velo_local_id = '.intval($triLocal);
	    else $cond_local="";
	    
	    if(!empty($triModele)) $cond_modele='AND v.velo_modele_id = '.intval($triModele);
	    else $cond_modele="";

		$nbLoc = '(SELECT COUNT(*) FROM velo_loue WHERE loue_loc_id=loc_id)'; 
	    if($triLoue=='oui') $cond_loue = 'AND '.$nbLoc.' > 0 AND lo.loue_date_rendu_effective IS NULL';
	    elseif ($triLoue == 'non') $cond_loue = 'AND ('.$nbLoc.' = 0 OR lo.loue_date_rendu_effective IS NOT NULL)';
	    else $cond_loue='';
	   
	   
		$req = 'SELECT v.velo_id, l.local_nom, m.modele_nom, v.velo_date_achat, lo.loue_date_rendu_effective 
			FROM velo_velo v
			JOIN velo_local l ON v.velo_local_id = l.local_id
			JOIN velo_modele m ON v.velo_modele_id = m.modele_id
			LEFT JOIN velo_loue lo ON v.velo_id = lo.loue_velo_id
			LEFT JOIN velo_locataire ON loc_id = loue_loc_id
			WHERE 1=1
			'.$cond_local.'
			'.$cond_modele.'
			'.$cond_loue.'
			GROUP BY velo_id
			ORDER BY velo_id DESC';
		
		$query = $this->db->query($req);
		return $query->result();
	}

	public function getVeloActuel($id_locataire,$id_velo,$date_location)
	{
			$req='SELECT v.velo_id, l.local_nom, m.modele_nom, v.velo_date_achat 
			FROM velo_velo v, velo_local l, velo_modele m, velo_loue lo, velo_locataire loc
			WHERE lo.loue_loc_id = loc.loc_id
			AND v.velo_local_id = l.local_id
			AND v.velo_modele_id = m.modele_id
			AND v.velo_id = lo.loue_velo_id
			AND v.velo_id = ?
			AND loc_id = ?
			AND lo.loue_date_location = ?';

			$query = $this->db->query($req, array($id_velo, $id_locataire, $date_location));
			return $query->result();
	}

	public function getListeVeloLocationDispo()
		{
			$req='SELECT v.velo_id, m.modele_nom, lo.local_nom, v.velo_date_achat, l.loue_date_rendu_effective, (SELECT COUNT(*) FROM velo_loue WHERE velo_id = loue_velo_id) AS nbLoc
		FROM velo_velo v
		JOIN velo_local lo
		ON v.velo_local_id=lo.local_id
		JOIN velo_modele m
		ON v.velo_modele_id=m.modele_id
		LEFT JOIN velo_loue l
		ON v.velo_id = l.loue_velo_id
		ORDER by velo_id, loue_date_location DESC';

			$query = $this->db->query($req);
			return $query->result();
		}

	public function getVeloLocationActuel($id_velo)
	{
		$req='SELECT v.velo_id, lo.local_nom, m.modele_nom, v.velo_date_achat 
			FROM velo_velo v
			JOIN velo_local lo 
			ON v.velo_local_id = lo.local_id
			JOIN velo_modele m 
			ON v.velo_modele_id = m.modele_id
			LEFT JOIN velo_loue l
			ON v.velo_id = l.loue_velo_id
			WHERE v.velo_id=?;';

			$query = $this->db->query($req,array($id_velo));
			return $query->result();
	}
	
	public function modifVelo($velo_id,$velo_date_achat,$velo_suivi,$velo_observations,$velo_modele_id,$velo_local_id)
	{
		$req = 'UPDATE velo_velo 
		SET velo_date_achat = ?,
		velo_suivi = ?,
		velo_observations = ?,
		velo_modele_id = ?,
		velo_local_id= ?
		WHERE velo_id = ?';
		return $this->db->query($req, array($velo_date_achat,$velo_suivi,$velo_observations,$velo_modele_id,$velo_local_id,$velo_id));
	}
	
	public function getDateAchat()
	{
	    $req = 'SELECT velo_id, velo_date_achat FROM velo_velo';
	    $query = $this->db->query($req);
		return $query->result();
	}	
}

