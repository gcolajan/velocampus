<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Theme
{
	private $CI;
	private $var = array();
	private $decoupe = array('header' => '', 'speed' => '', 'menu' => '', 'footer' => '');
	private $theme = 'default';

/*
|===============================================================================
| Constructeur
|===============================================================================
*/

	public function __construct()
	{
		$this->CI = &get_instance();

		// Contenu de chaque page
		$this->var['output'] = '';

		//	Le titre est composé du nom de la méthode et du nom du contrôleur
		$this->var['titre'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class()) . ' - '.$this->CI->config->item('nom_site');

		//	Nous initialisons la variable $charset avec la même valeur que la clé de configuration initialisée dans le fichier config.php
		$this->var['charset'] = $this->CI->config->item('charset');

		// Initialisation des variables $css et $js pour les fichiers optionnels
		$this->var['css'] = array();
		$this->var['js'] = array();
	}

/*
|===============================================================================
| Méthodes pour modifier les variables envoyées au layout
|	. set_titre
|	. set_charset
|===============================================================================
*/
public function set_titre($titre, $ctrl=false)
{
	if(is_string($titre) AND !empty($titre))
	{
		if ($ctrl == false)
			$this->var['titre'] = $titre.' - '.$this->CI->config->item('nom_site');
		else
			$this->var['titre'] = $titre.' - ' . ucfirst($this->CI->router->fetch_class()) . ' - '.$this->CI->config->item('nom_site');
		return true;
	}
	return false;
}

public function set_charset($charset)
{
	if(is_string($charset) AND !empty($charset))
	{
		$this->var['charset'] = $charset;
		return true;
	}
	return false;
}


/*
|===============================================================================
| Méthodes pour ajouter des feuilles de CSS et de JavaScript
|	. ajouter_css
|	. ajouter_js
|===============================================================================
*/
public function ajouter_css($nom)
{
	if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
	{
		$this->var['css'][] = css_url($nom);
		return true;
	}
	return false;
}

public function ajouter_js($nom)
{
	if(is_string($nom) AND !empty($nom) AND file_exists('./assets/javascript/' . $nom . '.js'))
	{
		$this->var['js'][] = js_url($nom);
		return true;
	}
	return false;
}

/*
|===============================================================================
| Méthodes pour agir sur les vues du découpage actif
|	. set_header
|	. set_ariane
|	. set_speed
|	. set_menu
|	. set_footer
|===============================================================================
*/

public function set_header($header=array())
{
	if(is_array($header) AND !empty($header))
	{
		$this->decoupe['header'] = $header;
		return true;
	}
	return false;
}

public function set_ariane($ariane=array())
{
	if(is_array($ariane) AND !empty($ariane))
	{
		$this->decoupe['ariane'] = $ariane;
		return true;
	}
	return false;
}

public function set_speed($speed=array())
{
	if(is_array($speed) AND !empty($speed))
	{
		$this->decoupe['speed'] = $speed;
		return true;
	}
	return false;
}

public function set_menu($menu)
{
		$this->decoupe['menu'] = $menu;
		return true;
}

public function set_footer($footer=array())
{
	if(is_array($footer) AND !empty($footer))
	{
		$this->decoupe['footer'] = $footer;
		return true;
	}
	return false;
}



/*
|===============================================================================
| Méthodes pour charger les vues
|	. view
|	. views
|===============================================================================
*/

	// Chargement des découpes présentes
	public function charger_decoupes()
	{
		require_once('application/themes/'.$this->theme.'/controleur.php');
		if ($dir = opendir('application/themes/'.$this->theme.'/zones/'))
		{
			while($file = readdir($dir))
			{
				if ($file != '..' AND $file != '.')
				{
					$explode = explode('.', $file);
					$nom = $explode[0];

					$nom_controleur = 'Theme'.ucfirst($this->theme);
					$controleur_theme = new $nom_controleur;

					$controleur_theme->set_var($nom, $this->decoupe[$nom]); // Compilation avec les éléments externes et prédéfinis (controleur)

					$this->var[$nom] = $this->CI->load->view('../themes/'.$this->theme.'/zones/'.$nom, $controleur_theme->get_var($nom), true);
				}
			}
			closedir($dir);
		}
	}


	public function view($name, $data = array()) // view permet d'afficher une vue dans un layout.
	{
		$this->charger_decoupes();
		$this->var['output'] .= $this->CI->load->view($name, $data, true);

		$this->CI->load->view('../themes/'.$this->theme.'/template', $this->var);
	}

	public function views($name, $data = array()) // views permet de sauvegarder le contenu d'une ou plusieurs vues dans une variable, sans l'afficher immédiatement. Pour l'affichage, il faudra utiliser la méthode view.
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}
}

/* End of file theme.php */
/* Location: ./application/libraries/theme.php */

