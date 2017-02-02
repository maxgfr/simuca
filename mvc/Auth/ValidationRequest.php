<?php

	/** @brief Validation les données de login/password reçues via $_REQUEST | Nettoyage de toutes les chaînes | Initialisationàvidedesinputsinexistants */
	class ValidationRequest {

		/** @brief Nettoie une chaîne avec filter_var et FILTER_SANITIZE_STRING. */
		private static function sanitizeString ( $chaine ) {
			return isset ( $chaine ) ? filter_var ( $chaine , FILTER_SANITIZE_STRING) : "" ;
		}

        /** @brief Validation et initialisation des données du login/password à partier des données reçues dans les tableau superglobal $_REQUEST. */
        public static function validationLogin (&$dataError, &$email, &$password)
        {

        	if (!isset($dataError)) {
				$dataError=array();
			}

			//Test sur la forme des données de login et mot de passe :
			$wouldBePasswd=$_POST["motdepasse"];
			if (empty( $wouldBePasswd ) ) 
			{
				$password = ""; 
				$dataError [ "login"] = "Votre mot de passe doit être complété." ;
			} else {
				$password = $wouldBePasswd ;
			}
			if ( filter_var ($_POST["mail"] , FILTER_VALIDATE_EMAIL) == FALSE) {
				$email = "";
				$dataError ["login"] = "Adresse email invalide" ;
			} else {
				$email = $_POST[ "mail"] ;
			}
        }



	}
?>
