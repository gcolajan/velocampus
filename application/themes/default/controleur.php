<?php
// Est appellé de manière indépendante (syntaxe identique).
// Doit toujours contenir les 4 zones décrites ci-dessous (problème de dépendance avec les contrôleurs)
// Le tableau de renvoi peut être rempli de manière totalement personnalisée pour le template
class ThemeDefault {

	private $db;

	private $header;
	private $speed;
	private $menu;
	private $footer;

	public function __construct() {
		$this->CI = get_instance();
		$this->CI->load->database();
	}

	private function set_header($tableau=array()) {
		$this->header = $tableau;
		return TRUE;
	}

	private function set_speed($tableau=array()) {
		$this->speed = $tableau;
		return TRUE;
	}

	private function set_menu($tableau=array()) {
		$this->menu = $tableau;
		return TRUE;
	}

	private function set_footer($tableau=array()) {
		$this->footer = $tableau;
		return TRUE;
	}

	public function set_var($var, $tableau=array()) {
		if ($var == 'header')
			$this->set_header($tableau);
		elseif ($var == 'speed')
			$this->set_speed($tableau);
		elseif ($var = 'menu')
			$this->set_menu($tableau);
		elseif ($var = 'footer')
			$this->set_footer($tableau);
		else
			return FALSE;
	}

	public function get_var($var) {
		if ($var == 'header' OR $var == 'speed' OR $var == 'menu' OR $var == 'footer')
			return $this->$var;
		else
			return FALSE;
	}

}

