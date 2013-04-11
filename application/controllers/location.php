<?php if ( ! defined('BASEPATH')) exit('pas d\'acces direct permis');

class Location extends MY_Controller
{
	public function index()
	{
		$this->theme->set_titre('Liste des locations');
		$this->load->model('location_model', 'location');
		$donnees = array(
			'location' => $this->location->listeLocation(),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('location/index', $donnees);
	}

	private function reglesFormulaire()
	{
			$this->form_validation->set_rules('identifiant_velo','"Vélo"','required|xss_clean|encode_php_tags|check_velo');
			$this->form_validation->set_rules('identifiant_locataire','"Locataire"','required|xss_clean|encode_php_tags|check_locataire');
			$this->form_validation->set_rules('location_date_debut_annee_location','"date_debut_theorique"','required|xss_clean|encode_php_tags');
			$this->form_validation->set_rules('location_date_debut_mois_location','"date_debut_theorique"','required|xss_clean|encode_php_tags|callback_check_date');
			$this->form_validation->set_rules('location_date_debut_jour_location','"date_debut_theorique"','required|xss_clean|encode_php_tags');
			$this->form_validation->set_rules('location_cadenas1','"cadenas 1"','xss_clean|encode_php_tags|callback_check_cadenas');
			$this->form_validation->set_rules('location_cadenas2','"cadenas 2"','xss_clean|encode_php_tags|callback_check_cadenas');
			$this->form_validation->set_rules('location_cadenas3','"cadenas 3"','xss_clean|encode_php_tags|callback_check_cadenas');
			$this->form_validation->set_rules('location_duree_theorique','"durée théorique de location"','required|xss_clean|encode_php_tags|callback_check_duree');
	}

		public function ajouterLocation()
		{
			$this->reglesFormulaire();
			$this->form_validation->set_rules('submit', 'Submit', ''); 

		$this->load->model('velo_model', 'velo');
		$this->load->model('locataires_model', 'locataire');
		$donnees = array(
			'identifiant_velo' => $this->velo->getListeVeloLocationDispo(),
			'identifiant_locataire' => $this->locataire->listeLocatairesTri(),
		 	'info' => $this->session->flashdata('info'));

		if ($this->form_validation->run() == true)
			{
			$this->load->model('location_model', 'location');
			if ($this->location->ajouterLocation(
												$this->input->post('location_date_debut_annee_location').'-'.$this->input->post('location_date_debut_mois_location').'-'.$this->input->post('location_date_debut_jour_location'),
												$this->input->post('location_cadenas1'),
												$this->input->post('location_cadenas2'),
												$this->input->post('location_cadenas3'),
												$this->input->post('location_duree_theorique'),
												$this->input->post('identifiant_velo'),
												$this->input->post('identifiant_locataire')))
				$message = 'La location a été ajoutée avec succès !';
			else
				$message = 'Erreur lors de l\'ajout de la location.';

			$this->session->set_flashdata('info', $message);
			redirect('/location', 'refresh');
			}
		else
			{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

	//récuperer date courante
	$format = "d";
	$location_date_debut_jour_location=date($format);
	$format = "m";
	$location_date_debut_mois_location=date($format);
	$format = "Y";
	$location_date_debut_annee_location=date($format);


			$donnees['location_date_debut_jour_location'] = array('name' => 'location_date_debut_jour_location',
				'id' => 'location_date_debut_jour_location',
				'type' => 'text',
				'pattern'=>'([0-2][0-9]|[3][0-1])',
				'placeholder'=>'JJ',
				'size'=>'2',
				'value' =>$location_date_debut_jour_location,
			);

			$donnees['location_date_debut_mois_location'] = array('name' => 'location_date_debut_mois_location',
				'id' => 'location_date_debut_mois_location',
				'type' => 'text',
				'pattern'=>'([0][0-9]|[1][0-2])',
				'placeholder'=>'MM',
				'size'=>'2',
				'value' =>$location_date_debut_mois_location,
			);

			$donnees['location_date_debut_annee_location'] = array('name' => 'location_date_debut_annee_location',
				'id' => 'location_date_debut_annee_location',
				'type' => 'text',
				'pattern'=>'[0-9]{4}',
				'placeholder'=>'AAAA',
				'size'=>'4',
				'value' =>$location_date_debut_annee_location,
			);

			$donnees['location_cadenas1'] = array('name' => 'location_cadenas1',
				'id' => 'location_cadenas1',
				'type' => 'text',
				'size'=>'3',
				'value' => $this->form_validation->set_value('location_cadenas1'),
			);

			$donnees['location_cadenas2'] = array('name' => 'location_cadenas2',
				'id' => 'location_cadenas2',
				'type' => 'text',
				'size'=>'3',
				'value' => $this->form_validation->set_value('location_cadenas2'),
			);

			$donnees['location_cadenas3'] = array('name' => 'location_cadenas3',
				'id' => 'location_cadenas3',
				'type' => 'text',
				'size'=>'3',
				'value' => $this->form_validation->set_value('location_cadenas3'),
			);

			$donnees['location_duree_theorique'] = array('name' => 'location_duree_theorique',
				'id' => 'location_duree_theorique',
				'type' => 'text',
				'size'=>'8',
				'value' => $this->form_validation->set_value('location_duree_theorique'),
			);


			$this->theme->set_titre('Créer une location');
			$this->theme->view('location/ajouter', $donnees);
			}
		}


		public function modifierLocation($id_locataire,$id_velo,$date_location)
		{
			$this->reglesFormulaire();
			$this->form_validation->set_rules('submit', 'Submit', ''); 

		$this->load->model('velo_model', 'velo');
		$this->load->model('locataires_model', 'locataire');
		$donnees = array(
			'identifiant_velo_actuel'=> $this->velo->getVeloLocationActuel($id_velo),
			'identifiant_velo' => $this->velo->getListeVeloLocationDispo(),
			'identifiant_locataire' => $this->locataire->listeLocatairesTri(),
		 	'info' => $this->session->flashdata('info'));


		if($this->form_validation->run() == true)
		{
			$this->load->model('location_model', 'location');
			if ($this->location->modifierLocation(
												$this->input->post('location_date_debut_annee_location').'-'.$this->input->post('location_date_debut_mois_location').'-'.$this->input->post('location_date_debut_jour_location'),
												$date_location,
												$this->input->post('location_cadenas1'),
												$this->input->post('location_cadenas2'),
												$this->input->post('location_cadenas3'),
												$this->input->post('location_duree_theorique'),
												$this->input->post('identifiant_velo'),
												$id_velo,
												$this->input->post('identifiant_locataire'),
												$id_locataire))
				$message = 'La location a été modifiée avec succès !';
			else
				$message = 'Erreur lors de la modification de la location.';

			$this->session->set_flashdata('info', $message);
			redirect('/location', 'refresh');
		}
		else
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$location = $this->input->post('location', TRUE);
			if (empty($location))
			{
				$this->load->model('location_model', 'location');
				$locationSelectionne = $this->location->getLocation($id_locataire,$id_velo,$date_location);
				$val['identifiant_locataire'] = $locationSelectionne->loue_loc_id;
				$val['identifiant_velo'] = $locationSelectionne->loue_velo_id;
				$tab_date=explode("-",$locationSelectionne->loue_date_location);
				$val['location_date_debut_annee_location'] = $tab_date[0];
				$val['location_date_debut_mois_location'] = $tab_date[1];	
				$val['location_date_debut_jour_location'] = $tab_date[2];
				$val['location_cadenas1'] = $locationSelectionne->loue_cadenas1;
				$val['location_cadenas2'] = $locationSelectionne->loue_cadenas2;
				$val['location_cadenas3'] = $locationSelectionne->loue_cadenas3;
				$val['location_duree_theorique'] = $locationSelectionne->loue_duree_theorique;

			}
			else
				$val['location'] = $this->form_validation->set_value('location');

			$donnees['location_date_debut_jour_location'] = array('name' => 'location_date_debut_jour_location',
				'id' => 'location_date_debut_jour_location',
				'type' => 'text',
				'pattern'=>'([0-2][0-9]|[3][0-1])',
				'placeholder'=>'JJ',
				'size'=>'2',
				'value' => $val['location_date_debut_jour_location'],
			);

			$donnees['location_date_debut_mois_location'] = array('name' => 'location_date_debut_mois_location',
				'id' => 'location_date_debut_mois_location',
				'type' => 'text',
				'pattern'=>'([0][0-9]|[1][0-2])',
				'placeholder'=>'MM',
				'size'=>'2',
				'value' =>$val['location_date_debut_mois_location'],
			);

			$donnees['location_date_debut_annee_location'] = array('name' => 'location_date_debut_annee_location',
				'id' => 'location_date_debut_annee_location',
				'type' => 'text',
				'pattern'=>'[0-9]{4}',
				'placeholder'=>'AAAA',
				'size'=>'4',
				'value' => $val['location_date_debut_annee_location'],
			);

			$donnees['location_cadenas1'] = array('name' => 'location_cadenas1',
				'id' => 'location_cadenas1',
				'type' => 'text',
				'size'=>'3',
				'value' => $val['location_cadenas1']
			);

			$donnees['location_cadenas2'] = array('name' => 'location_cadenas2',
				'id' => 'location_cadenas2',
				'type' => 'text',
				'size'=>'3',
				'value' => $val['location_cadenas2']
			);

			$donnees['location_cadenas3'] = array('name' => 'location_cadenas3',
				'id' => 'location_cadenas3',
				'type' => 'text',
				'size'=>'3',
				'value' => $val['location_cadenas3']
			);

			$donnees['location_duree_theorique'] = array('name' => 'location_duree_theorique',
				'id' => 'location_duree_theorique',
				'type' => 'text',
				'size'=>'8',
				'value' => $val['location_duree_theorique']
			);

				$this->theme->set_titre('Modifier une location');
				$this->theme->view('location/modifier', $donnees);
		}
	}

	public function ficheLocation($id_locataire,$id_velo,$date_location)
	{

	$this->load->model('location_model', 'location');
		$donnees = array(
			'fiche'=> $this->location->donneesFicheLocation($id_locataire,$id_velo,$date_location),
			);

	$this->theme->set_titre('Fiche location');
	$this->theme->view('location/fiche',$donnees);



	}

	public function supprimerLocation($id_locataire,$id_velo,$date_location)
	{
		$this->load->model('location_model', 'location');
		if ($this->location->supprimerLoc($id_locataire,$id_velo,$date_location))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression de la location.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/location', 'refresh');
	}

	public function arreterLocation($id_locataire,$id_velo,$date_location)
	{
		$this->load->model('location_model', 'location');
		if ($this->location->arreterLoc($id_locataire,$id_velo,$date_location))
			$message = 'Arrêt réalisé avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de l\'arrêt de la location.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/location', 'refresh');
	}

	public function recommencerLocation($id_locataire,$id_velo,$date_location,$date_rendu_effective)
	{
		$this->load->model('location_model', 'location');

		if ($this->location->testerVeloTjrsDispo($id_velo))
			{
			$message = 'Le vélo est toujours disponible ! ';
			if ($this->location->recommenceLoc($id_locataire,$id_velo,$date_location))
				{
				$message = $message.'Reprise location réalisée avec succès !';
				}
			else
				{
				$message = $message.'Une erreur s\'est produite lors de la reprise de la location.';
				}
			}
		else
		{
			$message = 'Impossible de reprendre la location : le vélo n\'est plus disponible !';
		}
		$this->session->set_flashdata('info', $message);
		redirect('/location', 'refresh');
	}

	public function check_date($mois)
	{
		if (checkdate($mois,$this->input->post('location_date_debut_jour_location'),$this->input->post('location_date_debut_annee_location')))
			return true;

		$this->form_validation->set_message('check_date',"Date incorrecte");
		return false;
	}

	public function check_cadenas($cadenas)
	{
		if ($cadenas < 0)
		{
			$this->form_validation->set_message('check_cadenas',"N° cadenas incorrect");
			return false;
		}

		if (!is_numeric($cadenas) AND !empty($cadenas))
		{
				$this->form_validation->set_message('check_cadenas',"N° cadenas doit être un entier:\n Veuillez ressaisir les cadenas.");
				return false;
		}
		return true;
	}

	public function check_duree($duree)
	{
	if ($duree!=0 && $duree>0)
		return true;

	$this->form_validation->set_message('check_duree',"Duree location incorrecte");
	return false;
	}
	
	public function check_velo($velo)
	{
		if (!($velo > 0))
		{
			$this->form_validation->set_message(__FUNCTION__, 'Veuillez spécifier un vélo.');
			return false;
		}
		return true;
	}

	public function check_locataire($loc)
	{
		if (!($loc > 0))
		{
			$this->form_validation->set_message(__FUNCTION__, 'Veuillez spécifier un locataire.');
			return false;
		}
		return true;
	}
}

?>
