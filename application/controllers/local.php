<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class local extends MY_Controller {

	public function index($campus='', $campusId='')
	{
		$this->theme->set_titre('Liste des locaux');
		$this->load->model('local_model', 'local');
		$this->load->model('campus_model', 'campus');
		$this->load->model('ville_model', 'ville');
		$donnees = array(
			'campus' => $this->campus->listeCampusTri(),
			'local' => $this->local->listeLocal('', intval($campusId)),
			'ville' => $this->ville->listeVille(),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('local/index', $donnees);
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('local', 'Local',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
		$this->form_validation->set_rules('adresse', 'Adresse',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
		$this->form_validation->set_rules('campus', 'Campus',
		'trim|required|xss_clean|callback_check_campus');
		$this->form_validation->set_rules('ville', 'Ville',
		'trim|required|xss_clean|callback_check_ville');
	}
	
	public function tri()
	{
			$this->theme->set_titre('Trier par campus');
			$this->theme->view('local/ajouter', $donnees);

	}

	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		$this->load->model('campus_model', 'campus');
		$this->load->model('ville_model', 'ville');
		$lc[0] = "Aucun";
		$lv[0] = "Aucune";
		foreach ($this->campus->listeCampusTri() as $data)
			$lc[$data->campus_id] = $data->campus_nom;
		foreach ($this->ville->listeVille() as $data)
			$lv[$data->ville_id] = $data->ville_nom;
		$donnees = array(
			'listeCampus' => $lc,
			'listeVille' => $lv,
		 	'info' => $this->session->flashdata('info'));

		if ($this->form_validation->run() == true)
		{
			$this->load->model('local_model', 'local');
			if ($this->local->ajouter($this->input->post('local'),$this->input->post('adresse'),$this->input->post('campus'),$this->input->post('ville')))
				$message = 'Local ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du local.';

			$this->session->set_flashdata('info', 'Ajout réalisé avec succès !');
			redirect('/local', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['local'] = array('name' => 'local',
				'id' => 'local',
				'type' => 'text',
				'value' => $this->form_validation->set_value('local'),
			);

			$donnees['adresse'] = array('name' => 'adresse',
				'id' => 'adresse',
				'type' => 'text',
				'value' => $this->form_validation->set_value('adresse'),
			);

			$this->theme->set_titre('Créer un local');
			$this->theme->view('local/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		$this->load->model('campus_model', 'campus');
		$this->load->model('ville_model', 'ville');
		
		foreach ($this->campus->listeCampusTri() as $data)
			$lc[$data->campus_id] = $data->campus_nom;
		foreach ($this->ville->listeVille() as $data)
			$lv[$data->ville_id] = $data->ville_nom;
			
		$donnees = array(
			'listeCampus' => $lc,
			'listeVille' => $lv,
		 	'info' => $this->session->flashdata('info'));
		
		if ($this->form_validation->run() == true)
		{
			$this->load->model('local_model', 'local');
			if ($this->local->modifier($this->input->post('local'),$this->input->post('adresse'), $this->input->post('campus'),$this->input->post('ville'),intval($id)))
				$message = 'Local modifié avec succès !';
			else
				$message = 'Erreur lors de la modification du local.';

			$this->session->set_flashdata('info', 'Modification réalisée avec succès !');
			redirect('/local', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$local = $this->input->post('local', TRUE);
			$adresse = $this->input->post('adresse', TRUE);
			$campus = $this->input->post('campus', TRUE);
			$ville = $this->input->post('ville', TRUE);
			$this->load->model('local_model', 'local');
			$localSelectionne = $this->local->listeLocal(intval($id));
			$localSelectionne = $localSelectionne[0];
			if (empty($local))
			{
				$val['local'] = $localSelectionne->local_nom;
			}
			else
				$val['local'] = $this->form_validation->set_value('local');

			if (empty($campus))
			{
				$val['campus'] = $localSelectionne->campus_nom;
			}
			else
				$val['campus'] = $this->form_validation->set_value('campus');
				
			if (empty($ville))
			{
				$val['ville'] = $localSelectionne->local_ville_id;
			}
			else
				$val['ville'] = $this->form_validation->set_value('ville');

			if (empty($adresse))
			{
				$val['adresse'] = $localSelectionne->local_adresse;
			}
			else
				$val['adresse'] = $this->form_validation->set_value('adresse');

			$donnees['local'] = array('name' => 'local',
				'id' => 'local',
				'type' => 'text',
				'value' => $val['local']
			);


			$donnees['adresse'] = array('name' => 'adresse',
				'id' => 'adresse',
				'type' => 'text',
				'value' => $val['adresse']
			);
			$donnees['campus'] = $val['campus'];
			$donnees['ville'] = $val['ville'];

			$this->theme->set_titre('Modifier un local');
			$this->theme->view('local/modifier', $donnees);
		}
	}
	
	public function supprimer($id)
	{
		$this->load->model('local_model', 'local');
		if ($this->local->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du local.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/local', 'refresh');
	}

	public function check_campus($id)
	{
	if ($id > 0)
		return true;

	$this->form_validation->set_message('check_campus',"Choisissez un campus.");
	return false;
	}

	public function check_ville($id)
	{
	if ($id > 0)
		return true;

	$this->form_validation->set_message('check_ville',"Choisissez une ville.");
	return false;
	}
}
