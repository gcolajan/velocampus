<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Velo extends MY_Controller {

	public function index($local="", $triLocal="", $modele="", $triModele="", $loue="",$triLoue="")
	{
		$this->theme->set_titre('Liste des vélos');
		$this->load->model('velo_model', 'velo');	
		$this->load->model('modele_model', 'modele');
		$this->load->model('local_model', 'local');

		$listeLocaux = array(0 => '[Locaux]');
		foreach ($this->local->getLocalTri() as $plocal)
			$listeLocaux[$plocal->local_id] = $plocal->local_nom;

		$listeLoue = array(0 => '[Loué]', 'oui' => 'oui', 'non' => 'non');
		
		$listeModele = array(0 => '[Modèles]');
		foreach ($this->modele->getModeleTri() as $pmod)
			$listeModele[$pmod->modele_id] = $pmod->modele_nom;

		
		$donnees = array(
			'velos' => $this->velo->listeVelosTri($triLocal, $triModele, $triLoue),
		 	'info' => $this->session->flashdata('info'),
		 	'listeLocaux'=> $listeLocaux,
		 	'listeLoue' => $listeLoue,
		 	'listeModele' => $listeModele);
				
		$this->theme->view('velo/index', $donnees);	
	}
	
	public function ficheVelo($velo_id='')
	{
		if (!($velo_id > 0)) $velo_id = 0;
		$this->load->model('velo_model', 'velo');
		$this->theme->set_titre('Fiche du vélo');
		$this->theme->view('velo/fiche', array(	'fiche' => $this->velo->ficheVelo($velo_id)));
	}
	
	public function creer_velo()
	{
		$this->form_validation->set_rules('achat_jour', 'Jour',
		'trim|required|xss_clean'); 
		$this->form_validation->set_rules('achat_mois', 'Mois',
		'trim|required|xss_clean'); 
		$this->form_validation->set_rules('achat_annee', 'Année',
		'trim|required|xss_clean'); 

		$this->load->model('velo_model', 'velo');
		$this->load->model('modele_model', 'modele');
		$this->load->model('local_model', 'local');
		
		$locaux = array();
		foreach ($this->local->getLocalTri() as $ploc)
			$locaux[$ploc->local_id] = $ploc->local_nom;
		
		$modeles = array();
		foreach ($this->modele->getModeleTri() as $pmodeles)
			$modeles[$pmodeles->modele_id] = $pmodeles->modele_nom;
		
		$donnees = array(
			'locaux' => $locaux,
			'modeles' => $modeles,
		 	'info' => $this->session->flashdata('info'));

		if ($this->form_validation->run() == true)
		{
			$date_ajout = $this->input->post('achat_annee').'-'.$this->input->post('achat_mois').'-'.$this->input->post('achat_jour');
		
			$etat_ajout = $this->velo->creer_velo(
				$date_ajout,
				date('d-m-Y').' '.$this->input->post('observations'),
				$this->input->post('modele'),
				$this->input->post('local'));
		
			if ($etat_ajout)												
				$message = 'Le vélo a été ajouté avec succès ! Il porte le numéro '.$this->db->insert_id().'.';
			else
				$message = 'Erreur lors de l\'ajout du vélo.';

			$this->session->set_flashdata('info', $message);
			redirect('/velo', 'refresh');
		}
		else
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	
			// Champ date achat : jour
			$donnees['achat_jour'] = array('name' => 'achat_jour',
				'id' => 'achat_jour',
				'type' => 'text',
				'pattern'=>'([0-2][0-9]|[3][0-1])',
				'placeholder'=>'JJ',
				'size'=>'2',
				'value' => date('d'),
			);

			// Champ date achat : mois
			$donnees['achat_mois'] = array('name' => 'achat_mois',
				'type' => 'text',
				'pattern'=>'([0][0-9]|[1][0-2])',
				'placeholder'=>'MM',
				'size'=>'2',
				'value' => date('m'),
			);

			// Champ date achat : année
			$donnees['achat_annee'] = array('name' => 'achat_annee',
				'type' => 'text',
				'pattern'=>'[0-9]{4}',
				'placeholder'=>'AAAA',
				'size'=>'4',
				'value' => date('Y'),
			);

			// Observations			
			$donnees['observations'] = array('name' => 'observations',
				'id' => 'observations',
				'type' => 'text',
				'value' => $this->form_validation->set_value('observations'),
			);
			
			// Modèle
			$donnees['modele'] = $this->form_validation->set_value('modele');
			
			// Local
			$donnees['local'] = $this->form_validation->set_value('local');
			
			$this->theme->set_titre('Créer un velo');
			$this->theme->view('velo/ajouter', $donnees);
		}
	}
		
	public function supprVelo($velo_id)
	{
		$this->load->model('velo_model', 'velos');
		if ($this->velos->supprVelo($velo_id))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression de la location.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/velo', 'refresh');
	}
	
	public function modifVelo($velo_id)
	{
		$this->form_validation->set_rules('achat_jour', 'Jour',
		'trim|required|xss_clean'); 
		$this->form_validation->set_rules('achat_mois', 'Mois',
		'trim|required|xss_clean'); 
		$this->form_validation->set_rules('achat_annee', 'Année',
		'trim|required|xss_clean'); 
		
		
		$this->form_validation->set_rules('submit', 'Submit', ''); 

		$this->load->model('velo_model', 'velo');
		$this->load->model('local_model', 'local');
		$this->load->model('modele_model', 'modele');
		
		$locaux = array();
		foreach ($this->local->getLocalTri() as $ploc)
			$locaux[$ploc->local_id] = $ploc->local_nom;
		
		$modeles = array();
		foreach ($this->modele->getModeleTri() as $pmodeles)
			$modeles[$pmodeles->modele_id] = $pmodeles->modele_nom;
		
		$donnees = array(
			'locaux' => $locaux,
			'modeles' => $modeles,
		 	'info' => $this->session->flashdata('info'));


		if($this->form_validation->run() == true)
		{
			$this->load->model('velo_model', 'velo');
			
			// On construit le champ "suivi"
			if (!empty($_POST['suivi_commentaire']))
				$suivi = $this->input->post('suivi_date').' '
						.$this->input->post('suivi_commentaire')."\n"
						.$this->input->post('suivi_entier');
			else 
				$suivi = $this->input->post('suivi_entier'); 
			
			if (!empty($_POST['obs_commentaire']))
				$obs = $this->input->post('obs_date').' '
						.$this->input->post('obs_commentaire')."\n"
						.$this->input->post('obs_entier');
			else 
				$obs = $this->input->post('obs_entier');
				
			$date_achat = $this->input->post('achat_annee').'-'
				.$this->input->post('achat_mois').'-'
				.$this->input->post('achat_jour');
			
			$etat_modification = $this->velo->modifVelo(
				$velo_id,
				$date_achat,
				$suivi,
				$obs,
				$this->input->post('modele'),
				$this->input->post('local'));
			
			if ($etat_modification)
				$message = 'Le vélo a été modifié avec succès !';
			else
				$message = 'Échec de la modification du vélo...';

			$this->session->set_flashdata('info', $message);
			redirect('/velo', 'refresh');
		}
		else // Si les données n'ont pas été envoyées ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			if (empty($_POST['velo_modele_id'])) # Données non envoyées, on charge avec la BDD
			{
				$this->load->model('velo_model', 'velo');
				$veloSelectionne = $this->velo->getVelo($velo_id);
				
				$tab_date=explode("-",$veloSelectionne->velo_date_achat);
				$val['achat_annee'] = $tab_date[0];
				$val['achat_mois'] = $tab_date[1];	
				$val['achat_jour'] = $tab_date[2];
				$val['suivi_entier'] = $veloSelectionne->velo_suivi;
				$val['suivi_date'] = date('d-m-Y');
				$val['suivi_commentaire'] = '';
				$val['obs_entier'] = $veloSelectionne->velo_observations;
				$val['obs_date'] = date('d-m-Y');
				$val['obs_commentaire'] = '';
				$val['modele'] = $veloSelectionne->velo_modele_id;
				$val['local'] = $veloSelectionne->velo_local_id;


			}
			else # Données en erreur : on récupère pour ré-afficher ensuite
			{
				$val['achat_annee'] = $this->input->post('velo_date_achat_annee');
				$val['achat_mois'] = $this->input->post('velo_date_achat_mois');	
				$val['achat_jour'] = $$this->input->post('velo_date_achat_jour');
				$val['suivi_entier'] = $this->input->post('suivi_entier');
				$val['suivi_date'] = $this->input->post('suivi_date');
				$val['suivi_commentaire'] = $this->input->post('suivi_commentaire');
				$val['obs_entier'] = $this->input->post('obs_entier');
				$val['obs_date'] = $this->input->post('obs_date');
				$val['obs_commentaire'] = $this->input->post('obs_commentaire');
				$val['modele'] = $this->input->post('modele');
				$val['local'] = $this->input->post('local');
			}
			
			// Champ date achat : jour
			$donnees['achat_jour'] = array('name' => 'achat_jour',
				'id' => 'achat_jour',
				'type' => 'text',
				'pattern'=>'([0-2][0-9]|[3][0-1])',
				'placeholder'=>'JJ',
				'size'=>'2',
				'value' =>$val['achat_jour'],
			);

			// Champ date achat : mois
			$donnees['achat_mois'] = array('name' => 'achat_mois',
				'type' => 'text',
				'pattern'=>'([0][0-9]|[1][0-2])',
				'placeholder'=>'MM',
				'size'=>'2',
				'value' =>$val['achat_mois'],
			);

			// Champ date achat : année
			$donnees['achat_annee'] = array('name' => 'achat_annee',
				'type' => 'text',
				'pattern'=>'[0-9]{4}',
				'placeholder'=>'AAAA',
				'size'=>'4',
				'value' =>$val['achat_annee'],
			);

			// Suivi : textarea
			$donnees['suivi_entier'] = array('name' => 'suivi_entier',
				'id' => 'suivi_entier',
				'type' => 'textarea',
				'value' => $val['suivi_entier']
			);
			
			// Suivi : date (pour ajouter un commentaire)
			$donnees['suivi_date'] = array('name' => 'suivi_date',
				'id' => 'suivi_date',
				'type' => 'text',
				'value' => $val['suivi_date'],
				'size' => 8,
				'pattern' => '([0-2][0-9]|[3][0-1])-([0][0-9]|[1][0-2])-[0-9]{4}'
			 );
			 
			 // Suivi : commentaire (facultatif)
			 $donnees['suivi_commentaire'] = array('name' => 'suivi_commentaire',
			 	'id' => 'suivi_commentaire',
				'type' => 'text',
				'value' => $val['suivi_commentaire'],
				'size' => 20
			 );

			// Observations : textarea
			$donnees['obs_entier'] = array('name' => 'obs_entier',
				'id' => 'obs_entier',
				'type' => 'textarea',
				'value' => $val['obs_entier']
			);
			
			// Observations : date (pour ajouter un commentaire)
			$donnees['obs_date'] = array('name' => 'obs_date',
				'id' => 'obs_date',
				'type' => 'text',
				'value' => $val['obs_date'],
				'size' => 8,
				'pattern' => '([0-2][0-9]|[3][0-1])-([0][0-9]|[1][0-2])-[0-9]{4}'
			 );
			 
			 // Observations : commentaire (facultatif)
			 $donnees['obs_commentaire'] = array('name' => 'obs_commentaire',
			 	'id' => 'obs_commentaire',
				'type' => 'text',
				'value' => $val['obs_commentaire'],
				'size' => 20
			 );

			// Modèle
			$donnees['modele'] = $val['modele'];
			
			// Local de stockage
			$donnees['local'] = $val['local'];
			
			
			$this->theme->set_titre('Modifier un vélo');
			$this->theme->view('velo/modifier', $donnees);
		}
	}
	
}


