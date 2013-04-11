<?php

function sql_to_human($sql, $format='litteral') {
	//$tableauJours = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'sameidi', 'dimanche');
	$tableauMois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

	if ($format == 'litteral')
	{
		$ensemble = explode('-', $sql);
		$date = $ensemble[2].' '.$tableauMois[$ensemble[1]-1].' '.$ensemble[0];
	}
	else
		$date = mdate('%d/%m/%Y - %H:%i', mysql_to_unix($sql));
	 
	return $date;
}

