<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locataires_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	// Liste des locataires nécessaire au tableau des locataires
	public function listeLocataire($campus = '', $dept='', $statut='', $possession='')
	{
		$conditions = '';
		if ($campus > 0)
			$conditions .= ' AND dept_campus_id = '.intval($campus);
		if ($dept > 0)
			$conditions .= ' AND dept_id = '.intval($dept);
		if ($statut > 0)
			$conditions .= ' AND statut_id = '.intval($statut);
		if ($possession != false)
		{
			$nbLoc = '(SELECT COUNT(*) FROM velo_loue WHERE loue_loc_id=loc_id)';
			if ($possession == 'oui') # les locataires actuellement en posession d'un vélo
				$conditions .= ' AND '.$nbLoc.' > 0 AND loue_date_rendu_effective IS NULL';
			else # les locataires qui ne possèdent plus de vélo
				$conditions .= ' AND ('.$nbLoc.' = 0 OR loue_date_rendu_effective IS NOT NULL)';
		}
	
		$requete= '
		SELECT loc_id, loc_nom, loc_prenom, ville_nom, dept_nom, statut_nom, loue_date_location, loue_date_rendu_effective, modele_nom, velo_id, YEAR(velo_date_achat) AS annee_achat, campus_nom,
		(SELECT COUNT(*) FROM velo_loue WHERE loue_loc_id=loc_id) AS nbLoc
		FROM velo_locataire
		JOIN velo_statut ON statut_id = loc_statut_id
		LEFT JOIN velo_ville ON ville_id = loc_ville_id
		LEFT JOIN velo_dept_universitaire ON dept_id = loc_dept_id
		LEFT JOIN velo_campus ON campus_id = dept_campus_id
		LEFT JOIN velo_loue ON loc_id = loue_loc_id
		LEFT JOIN velo_velo ON velo_id = loue_velo_id
		LEFT JOIN velo_modele ON velo_modele_id = modele_id
		WHERE 1 = 1
		'.$conditions.'
		ORDER BY loc_id, loue_date_location DESC ';
			 		
		$query = $this->db->query($requete);
		return $query->result();
	}
	
	public function listeLocatairesTri()
	{
		$req = 'SELECT loc.loc_id, loc.loc_nom, loc.loc_prenom 
			FROM velo_locataire loc
			ORDER BY loc.loc_nom';
		$query = $this->db->query($req);
		return $query->result();
	}

	// Données d'un locataire nécessaire lors de la mise à jour d'un locataire
	public function getLocataire($id)
	{
		$req ="SELECT * FROM velo_locataire WHERE loc_id = ?";
		$query = $this->db->query($req, array($id));
		return $query->row();
	}
	
	// Données d'un locataire nécessaire lors de la consultation de sa fiche
	public function getFicheLocataire($id)
	{
		$req ="SELECT loc_id, loc_nom, loc_prenom, loc_telephone, loc_email, loc_adresse, dept_id, dept_nom, statut_id, statut_nom, ville_id, ville_nom, ville_cp, campus_id, campus_nom, modele_id, modele_nom, velo_id, YEAR(velo_date_achat) AS annee_achat, loue_date_location, loue_date_rendu_effective, (SELECT COUNT(*) FROM velo_loue WHERE loue_loc_id=loc_id) AS nbLoc FROM velo_locataire
		JOIN velo_statut ON statut_id = loc_statut_id
		LEFT JOIN velo_ville ON ville_id = loc_ville_id
		LEFT JOIN velo_dept_universitaire ON dept_id = loc_dept_id
		LEFT JOIN velo_campus ON campus_id = dept_campus_id
		LEFT JOIN velo_loue ON loc_id = loue_loc_id
		LEFT JOIN velo_velo ON velo_id = loue_velo_id
		LEFT JOIN velo_modele ON velo_modele_id = modele_id
		WHERE loc_id = ?";
		$query = $this->db->query($req, array($id));
		return $query->row();
	}

	// Ajout d'un élément dans la table locataire
	public function ajouter($nom, $prenom, $tel, $mail, $adresse, $departement, $ville, $statut)
	{
		if ($departement == 0) $departement = NULL; // Le département peut ne pas être renseigné
		if ($ville == 0) $ville = NULL; // La ville peut ne pas être renseignée
		if ($tel == 0) $tel = NULL; // Le téléphone peut ne pas être renseigné
		
		$req = 'INSERT INTO velo_locataire (loc_nom, loc_prenom, loc_telephone, loc_email, loc_adresse, loc_dept_id, loc_ville_id, loc_statut_id) VALUES (?,?,?,?,?,?,?,?)';
		return $this->db->query($req, array($nom, $prenom, $tel, $mail, $adresse, $departement, $ville, $statut));
	}

	// Modification d'un élément dans la table locataire
	public function modifier($id, $nom, $prenom, $tel, $mail, $adresse, $departement, $ville, $statut)
	{
		if ($departement == 0) $departement = NULL; // Le département peut ne pas être renseigné
		if ($ville == 0) $ville = NULL; // La ville peut ne pas être renseignée
		if ($tel == 0) $tel = NULL; // Le téléphone peut ne pas être renseigné

		$req = 'UPDATE velo_locataire SET loc_nom = ?, loc_prenom = ?, loc_telephone = ?, loc_email = ?, loc_adresse  = ?, loc_dept_id = ?, loc_ville_id = ?, loc_statut_id = ? WHERE loc_id = ?';
		return $this->db->query($req, array($nom, $prenom, $tel, $mail, $adresse, $departement, $ville, $statut, $id));
	}

	// Suppression d'un élément dans la table locataire
	public function supprimer($id)
	{
		$req = 'DELETE FROM velo_locataire WHERE loc_id = ?';
		return $this->db->query($req, array($id));
	}

}

