<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locataire extends MY_Controller {

	public function index($campus='', $campusId='', $dept='', $deptId='', $statut='', $statutId='', $p='', $possession='')
	{
		if (!($campusId > 0)) $campusId = 0;
		if (!($deptId > 0)) $deptId = 0;
		if (!($statutId > 0)) $statutId = 0;
		if ($possession != 'oui' && $possession != 'non') $possession = false;
	
		$this->theme->set_titre('Liste des locataires');
		$this->load->model('departement_model', 'departement');
		$this->load->model('campus_model', 'campus');
		$this->load->model('statut_model', 'statut');
		$this->load->model('locataires_model', 'locataire');
		
		$listeCampus = array(0 => '[Campus]');
		foreach ($this->campus->listeCampus() as $pcampus)
			$listeCampus[$pcampus->campus_id] = $pcampus->campus_nom;
		
		$listeDept = array(0 => '[Départements]');
		foreach ($this->departement->listeDepartements() as $pdept)
			$listeDept[$pdept->dept_id] = $pdept->dept_nom;

		$listeStatut = array(0 => '[Statuts]');
		foreach ($this->statut->listeStatuts() as $pstatut)
			$listeStatut[$pstatut->statut_id] = $pstatut->statut_nom;

		$listePosession = array(0 => '[Vélo]', 'oui' => 'oui', 'non' => 'non');
		
		$donnees = array(
			'listeCampus' => $listeCampus,
			'listeDept' => $listeDept,
			'listeStatut' => $listeStatut,
			'listePossession' => $listePosession,
			'locataires' => $this->locataire->listeLocataire($campusId, $deptId, $statutId, $possession),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('locataires/index', $donnees);
	}
	
	public function desc($id)
	{
		$this->theme->set_titre('Profil d\'un locataire');
		$this->load->model('locataires_model', 'locataire');
		$this->theme->view('locataires/fiche', $donnees=array('fiche' => $this->locataire->getFicheLocataire(intval($id))));
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('nom', 'Nom',
		'trim|required|xss_clean|max_length[32]|min_length[3]');
		$this->form_validation->set_rules('prenom', 'Prénom',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
		$this->form_validation->set_rules('tel', 'Téléphone',
		'trim|xss_clean|exact_length[10]');
		$this->form_validation->set_rules('mail', 'Mail',
		'trim|xss_clean|valid_email');
		$this->form_validation->set_rules('statut', 'Statut',
		'trim|xss_clean|required|callback_check_statut');
	}
	
	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		$this->load->model('locataires_model', 'locataires');
		$this->load->model('ville_model', 'ville');
		$this->load->model('departement_model', 'departement');
		$this->load->model('statut_model', 'statut');
		
		$listeDept = array(0 => '[Départements]');
		foreach ($this->departement->listeDepartements() as $pdept)
			$listeDept[$pdept->dept_id] = $pdept->dept_nom;
		
		$listeVille = array(0 => '[Villes]');
		foreach ($this->ville->listeVille() as $pville)
			$listeVille[$pville->ville_id] = $pville->ville_nom;
		
		$listeStatut = array(0 => '[Statuts]');
		foreach ($this->statut->listeStatuts() as $pstatut)
			$listeStatut[$pstatut->statut_id] = $pstatut->statut_nom;
			
		
		$donnees = array(
			'departements' => $listeDept,
			'villes' => $listeVille,
			'statuts' => $listeStatut,
		 	'info' => $this->session->flashdata('info'));

		if ($this->form_validation->run() == true)
		{
			$this->load->model('locataires_model', 'locataires');
			
			$etat_ajout = $this->locataires->ajouter(
				$this->input->post('nom'),
				$this->input->post('prenom'),
				$this->input->post('tel'),
				$this->input->post('mail'),
				$this->input->post('adresse'),
				$this->input->post('departement'),
				$this->input->post('ville'),
				$this->input->post('statut'));
			
			if ($etat_ajout)
				$message = 'Locataire ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du locataire.';
			$this->session->set_flashdata('info', $message);
			redirect('/locataire', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['nom'] = array('name' => 'nom',
				'id' => 'nom',
				'type' => 'text',
				'minlength' => '3',
				'required' => 'required',
				'value' => $this->form_validation->set_value('nom')	);
			
			$donnees['prenom'] = array('name' => 'prenom',
				'id' => 'prenom',
				'type' => 'text',
				'minlength' => '3',
				'required' => 'required',
				'value' => $this->form_validation->set_value('prenom'));

			$donnees['tel'] = array('name' => 'tel',
				'id' => 'tel',
				'type' => 'text',
				'size' => 10,
				'pattern' => '[0-9]{10}',
				'value' => $this->form_validation->set_value('tel'));

			$donnees['mail'] = array('name' => 'mail',
				'id' => 'mail',
				'type' => 'email',
				'size' => 20,
				'value' => $this->form_validation->set_value('mail'));

			$donnees['adresse'] = array('name' => 'adresse',
				'id' => 'adresse',
				'type' => 'text',
				'size' => 20,
				'value' => $this->form_validation->set_value('adresse'));

			$donnees['ville'] = $this->form_validation->set_value('ville');
			$donnees['statut'] = $this->form_validation->set_value('statut');
			$donnees['departement'] = $this->form_validation->set_value('departement');

			$this->theme->set_titre('Créer un locataire');
			$this->theme->view('locataires/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		$id = intval($id);
	
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		
		$this->load->model('ville_model', 'ville');
		$this->load->model('departement_model', 'departement');
		$this->load->model('statut_model', 'statut');

		$listeDept = array(0 => '[Départements]');
		foreach ($this->departement->listeDepartements() as $pdept)
			$listeDept[$pdept->dept_id] = $pdept->dept_nom;
		
		$listeVille = array(0 => '[Villes]');
		foreach ($this->ville->listeVille() as $pville)
			$listeVille[$pville->ville_id] = $pville->ville_nom;
		
		$listeStatut = array(0 => '[Statuts]');
		foreach ($this->statut->listeStatuts() as $pstatut)
			$listeStatut[$pstatut->statut_id] = $pstatut->statut_nom;
			
		
		$donnees = array(
			'departements' => $listeDept,
			'villes' => $listeVille,
			'statuts' => $listeStatut,
		 	'info' => $this->session->flashdata('info'));
			
		if ($this->form_validation->run() == true)
		{
			$this->load->model('locataires_model', 'locataires');
			
			$etat_modif = $this->locataires->modifier(
				$id,
				$this->input->post('nom'),
				$this->input->post('prenom'),
				$this->input->post('tel'),
				$this->input->post('mail'),
				$this->input->post('adresse'),
				$this->input->post('departement'),
				$this->input->post('ville'),
				$this->input->post('statut'));
			
			if ($etat_modif)
				$message = 'Locataire modifié avec succès !';
			else
				$message = 'Erreur lors de la modification du locataire.';

			$this->session->set_flashdata('info', 'Modification réalisée avec succès !');
			redirect('/locataire', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$this->load->model('locataires_model', 'locataire');
			$loc = $this->locataire->getLocataire($id);
			
			if (!empty($_POST['send'])) // Si le formulaire a déjà été envoyé
			{
				$val['nom'] = $this->form_validation->set_value('nom');
				$val['prenom'] = $this->form_validation->set_value('prenom');
				$val['tel'] = $this->form_validation->set_value('tel');
				$val['mail'] = 	$this->form_validation->set_value('mail');
				$val['adresse'] = $this->form_validation->set_value('adresse');
				$val['ville'] = $this->form_validation->set_value('ville');
				$val['statut'] = $this->form_validation->set_value('statut');
				$val['departement'] = $this->form_validation->set_value('departement');
			}
			else
			{
				$val['nom'] = $loc->loc_nom;
				$val['prenom'] = $loc->loc_prenom;
				if (strlen($loc->loc_telephone) == 9) $val['tel'] = '0'.$loc->loc_telephone;
				else $val['tel'] = $loc->loc_telephone;
				$val['mail'] = $loc->loc_email;
				$val['adresse'] = $loc->loc_adresse;
				$val['ville'] = $loc->loc_ville_id;
				$val['statut'] = $loc->loc_statut_id;
				$val['departement'] = $loc->loc_dept_id;
			}
			
			$donnees['nom'] = array('name' => 'nom',
				'id' => 'nom',
				'type' => 'text',
				'minlength' => '3',
				'required' => 'required',
				'value' => $val['nom']);
			
			$donnees['prenom'] = array('name' => 'prenom',
				'id' => 'prenom',
				'type' => 'text',
				'minlength' => '3',
				'required' => 'required',
				'value' => $val['prenom']);

			$donnees['tel'] = array('name' => 'tel',
				'id' => 'tel',
				'type' => 'text',
				'size' => 10,
				'pattern' => '[0-9]{10}',
				'value' => $val['tel']);

			$donnees['mail'] = array('name' => 'mail',
				'id' => 'mail',
				'type' => 'email',
				'size' => 20,
				'value' => $val['mail']);

			$donnees['adresse'] = array('name' => 'adresse',
				'id' => 'adresse',
				'type' => 'text',
				'size' => 20,
				'value' => $val['adresse']);

			$donnees['ville'] = $val['ville'];
			$donnees['statut'] = $val['statut'];
			$donnees['departement'] = $val['departement'];

			$this->theme->set_titre('Modifier un locataire');
			$this->theme->view('locataires/modifier', $donnees);
		}
	}
	
	public function supprimer($id)
	{
		$this->load->model('locataires_model', 'locataires');
		if ($this->locataires->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du locataire.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/locataire', 'refresh');
	}

	public function check_statut($statut)
	{
		if(!($statut > 0) OR $statut == 0)
		{
		    $this->form_validation->set_message(__FUNCTION__, 'Veuillez renseigner un statut !');
		    return FALSE;
		}                
		else
		    return TRUE;
	}

}
