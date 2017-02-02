<?php
	// Répertoire racine du MVC
	$rootDirectory = dirname(__FILE__)."/mvc/";

	// URI de la racine du MVC ( sans la query string )
	$rootURI = explode("index.php" , $_SERVER['REQUEST_URI'])[0];

	// chargement de la classe Autoload pour autochargement des classes
	require_once($rootDirectory.'Config/Autoload.php');

	try {
		Autoload::load();
	} catch(Exception $e){
		require (Config::getVues()["default"]) ;
	}

	$ctrl = new ControleurFront();
?>


