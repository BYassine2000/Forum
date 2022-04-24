<?php

function getAllTopics() {
	global $bdd;
	$topics = $bdd->query("SELECT * FROM viewTopics WHERE id_cat = 'Jeux-vidéos'");
	$topics->execute();
	return $topics->fetchAll();
}

?>