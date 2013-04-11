<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modele extends MY_Controller {

	public function index()
	{
		$this->theme->set_titre('Liste des modèles');

		$this->load->model('modele_model', 'modele');

		$donnees = array(
			'modeles' => $this->modele->listeModeles(),
			'modelesAnnuels' => $this->modele->listeModelesAnnuels(),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('modele/index', $donnees);
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('modele', 'Modèle',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
	}
	
	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();

		if ($this->form_validation->run() == true)
		{
			$this->load->model('modele_model', 'modele');
			if ($this->modele->ajouter($this->input->post('modele')))
				$message = 'Modèle ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du modèle.';

			$this->session->set_flashdata('info', $message);
			redirect('/modele', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['modele'] = array('name' => 'modele',
				'id' => 'modele',
				'type' => 'text',
				'value' => $this->form_validation->set_value('modele'),
			);

			$this->theme->set_titre('Ajouter un modèle de vélo');
			$this->theme->view('modele/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		
		if ($this->form_validation->run() == true)
		{
			$this->load->model('modele_model', 'modele');
			if ($this->modele->modifier(intval($id), $this->input->post('modele')))
				$message = 'Modèle modifié avec succès !';
			else
				$message = 'Erreur lors de la modification du modèle.';

			$this->session->set_flashdata('info', $message);
			redirect('/modele', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$modele = $this->input->post('modele', TRUE);
			if (empty($modele))
			{
				$this->load->model('modele_model', 'modele');
				$modeleSelectionne = $this->modele->getModele(intval($id));
				$val['modele'] = $modeleSelectionne->modele_nom;
			}
			else
				$val['modele'] = $this->form_validation->set_value('modele');
				

			$donnees['modele'] = array('name' => 'modele',
				'id' => 'modele',
				'type' => 'text',
				'value' => $val['modele']
			);

			$this->theme->set_titre('Modifier un modèle');
			$this->theme->view('modele/modifier', $donnees);
		}
	}
	
	public function supprimer($id)
	{
		$this->load->model('modele_model', 'modele');
		if ($this->modele->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du modele.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/modele', 'refresh');
	}
}
