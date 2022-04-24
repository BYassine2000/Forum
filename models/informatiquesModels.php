<?php

function getAllTopics() {
	global $bdd;
	$topics = $bdd->query("SELECT * FROM viewTopics WHERE id_cat = 'Informatiques'");
	$topics->execute();
	return $topics->fetchAll();
}

?>