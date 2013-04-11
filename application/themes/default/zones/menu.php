<div style="clear:both"></div>
<div id="menu">
<ul>
	<li><a href="/" title="Page d'accueil"><img src="/assets/images/home.png" alt="H" /></a></li>
	<li onclick="ssmenu()" onmouseover="document.getElementById('ssmenu').style.display='block'" onmouseout="document.getElementById('ssmenu').style.display='none'"><a title="Fonctions supplémentaires"><img src="/assets/images/goto.png" alt="+" /></a>
		<ul id="ssmenu">
			<li><a title="Liste des campus" href="/campus">Campus</a></li>
			<li><a title="Liste des départements" href="/departement">Départements</a></li>
			<li><a title="Liste des locaux" href="/local">Locaux</a></li>
			<li><a title="Liste des modèles" href="/modele">Modèles</a></li>
			<li><a title="Liste des statuts" href="/statut">Statuts</a></li>
		</ul>
	</li>
</ul>

<ul>
	<li><a title="Liste des locations" href="/location">Locations</a></li>
	<li><a title="Liste des locataires" href="/locataire">Locataires</a></li>
	<li><a title="Liste des vélos" href="/velo">Vélos</a></li>
	<li>
		<input type="text" size="2" placeholder="n° vélo" pattern="[0-9]{1,}" name="velo_r" id="velo_r" />
		<input type="button" value="&gt;" title="Rechercher un vélo" onclick="document.location = '/velo/ficheVelo/' + document.getElementById('velo_r').value" />
	</li>
</ul>
</div>
