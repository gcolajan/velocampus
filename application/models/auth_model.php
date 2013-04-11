<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	protected $pathAdmin;
	protected $pathSAdmin;
	
	public function __construct()
	{
		parent::__construct();
		$this->pathAdmin = $_SERVER['DOCUMENT_ROOT'].'/application/passwd/admin';
		$this->pathSAdmin = $_SERVER['DOCUMENT_ROOT'].'/application/passwd/superadmin';
	}
	
	public function getAdmin()
	{
		return $this->getLine($this->pathAdmin);
	}
	
	public function getSuperAdmin()
	{
		return $this->getLine($this->pathSAdmin);
	}
	
	public function setAdmin($hash)
	{
		$this->setLine($this->pathAdmin, $hash);
	}
	
	public function setSuperAdmin($hash)
	{
		$this->setLine($this->pathSAdmin, $hash);
	}
	
	private function getLine($fichier)
	{
		$retour = '';
		$fp = fopen($fichier, 'r');
		if (!feof($fp))
			$retour = fgets($fp);
		fclose($fp);
		
		return $retour;
	}
	
	private function setLine($fichier, $ligne)
	{
		$fp = fopen($fichier, 'w');
		fputs($fp, $ligne);
		fclose($fp);
	}
	
}
