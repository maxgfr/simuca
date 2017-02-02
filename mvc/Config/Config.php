<?php


	/** @brief Classe de configuration : Elle donne accès aux paramères spécifiques contenat l'application tellles que les chemins vers les vues, les vues d'erreur, les hash pour les ID de sessions, etc... */
	class Config {
		

		/** @brief Données nécessaires à la connexion à la base de données. Les valeurs pourraient être initialisées à partir d'un fichier de configuration  séparé (require('configuration.php')) pour faciliter la maintenance */ 
		public static function getAuthData(&$db_host , &$db_name , &$db_user , &$db_password )
		{
			$db_host="mysql:host=localhost;";
			$db_name="dbname=exemplebd";
			$db_user ="root" ;
			$db_password="" ;
		}

		/** @brief retourne le tableau des chemins vers les vues */
		public static function getVues() 
		{
			global $rootDirectory; //racine du site
			$vueDirectory = $rootDirectory."Vue/vues/"; //répertoire contenant les vues
			return array("default" => $vueDirectory."vueAccueil.php",
						 "defaultAdmin" => $vueDirectory."vueAdmin.php",
			 			 "authentification" => $vueDirectory."vueConnexion.php",
			 			 "afficheTitre" => $vueDirectory."vueAfficheTitre.php",
			 			 "afficheTitreCompact" => $vueDirectory."vueAfficheTitreLight.php",
			 			 "afficheCollectionTitre" => $vueDirectory."vueCollectionTitre.php",
			 			 "saisieTitreCreate" => $vueDirectory."vueSaisieTitreCreate.php",
						 "saisieTitreUpdate" => $vueDirectory."vueSaisieTitreUpdate.php",
						 "deleteSucess" => $vueDirectory."vueDeleteSucess.php");
		}

		
		/** @brief retourne le tableau des chemins vers les vues d'erreur */
		public static function getVuesErreur() 
		{
			global $rootDirectory;  //racine du site
			$vueDirectory = $rootDirectory."Vue/vues/"; //répertoire contenant les vues d'erreur
 			return array("default" => $vueDirectory."vueErreurDefault.php",
 						 "authentification" => $vueDirectory."vueConnexionErreur.php",
 						 "saisieTitreCreate" => $vueDirectory."vueSaisieTitreCreateErreur.php",
 						 "saisieTitreUpdate" => $vueDirectory."vueSaisieTitreUpdateErreur.php");
		}	
		
		
		/** @brief retourne l'URI sans le nom d'hôte du site et sans la query string du répertoire racine de notre architecture MVC */
		public static function getRootURI()
		{
			global $rootURI ;
			return $rootURI ;
		}

		/** @brief retourne le tableau des URLS vers les feuilles de style CSS */
		public static function getStyleSheetsURL()
		{
			//Répertoire contenant les styles css
			//Le nettoyage par filter_var évite tout risque d'injection XSS
			$cssDirectoryURL = filter_var("http://".$_SERVER['SERVER_NAME'].self::getRootURI()."css/", FILTER_SANITIZE_URL) ;
			return array("default" => $cssDirectoryURL."bootstrap.css");
 		}

 		/** @brief Génère 10 chiffres hexa aléatoires (soit 5 octets) : */
 		public static function generateRandomId ()
		{
			// Génération de 5 octets (pseudo) aléatoires codés en hexa
			$cryptoStrong = false ; // Variable pour passage par référence
			$octets= openssl_random_pseudo_bytes (5,$cryptoStrong);
			return bin2hex ($octets);
		}

	}

?>
