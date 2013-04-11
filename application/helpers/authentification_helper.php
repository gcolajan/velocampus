<?php
function genererHash($mdp) {
	$SALT = 'g8fjo3D099G9';
	return md5($SALT.$mdp);
}
