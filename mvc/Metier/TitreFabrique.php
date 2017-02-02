<?php

	/**@brief Implémente la construction d’une instance d’un titre validé à partir des données, par exemple saisies dans un formulaire.Les erreurs générées dans les validateurs des attributs, qui reflètent la logique métier, qui sont reçues via des exceptions, sont accumulées dans un tableau associatif d’erreurs, pour générer le cas échéant une vue d’erreur.*/
	class TitreFabrique {

		/**@brief permet de valider l’ID unique.
		*@param $idTitre {inOut} identifiant unique à valider/réinitialiser*/
	    protected static function validateIdTitre (&$idTitre ) {
		    if ( !ExpressionsRegexUtils::isValidLatin1WithNumbers($idTitre ,1,150)) {
		    $tmp = $idTitre ; 
		    $idTitre = "";
		    throw new \Exception (" Erreur, le idTitre du titre \"" .$tmp."\" devrait comporter au plus 150 caractères (alphabétiques, chiffres sans ponctuation)" );
			}
	    }

	    /**@brief permet de valider le genre du titre.
		*@param $genre {inOut} genre à valider/réinitialiser*/
		protected static function validateGenre (&$genre) {
		    if ( !ExpressionsRegexUtils::isValidLatin1WithNumbers($genre ,1,150)) {
		    $tmp = $genre ; 
		    $genre = "";
		    throw new \Exception (" Erreur, le genre du titre \"" .$tmp."\" devrait comporter au plus 150 caractères (alphabétiques, chiffres sans ponctuation)" );
			}
		}

	    /**@brief permet de valider le nom du titre.
		*@param $nom {inOut} nom à valider/réinitialiser*/
		protected static function validateNom(&$nom) {
		    if ( !ExpressionsRegexUtils::isValidLatin1WithNumbers($nom ,1,150)) {
		    $tmp = $nom ; 
		    $nom = "";
		    throw new \Exception (" Erreur, le nom du titre \"" .$tmp."\" devrait comporter au plus 150 caractères (alphabétiques, chiffres sans ponctuation)" );
			}
		}

		/**@brief permet de valider l'auteur du titre.
		*@param $auteur {inOut} auteur à valider/réinitialiser*/
		protected static function validateAuteur(&$auteur) {
		    if ( !ExpressionsRegexUtils::isValidLatin1WithNumbers( $auteur , 1 , 150) ) {
		        $tmp =$auteur ; 
		        $auteur ="";
		    throw new \Exception (" Erreur , le nom de l'auteur \"" .$tmp."\" devrait comporter au plus 150 caractères (alphabétiques, chiffres sans ponctuation)" );
			}
		}

		/**@brief permet de valider l'album du titre.
		*@param $album {inOut} album à valider/réinitialiser*/
		protected static function validateAlbum(&$album) {
		    if (!isset($album)) {
		        $tmp =$album; 
		        $album ="";
		    throw new \Exception (" Erreur , le chemin de l'album doit être complété ! " );
			}
		}

		/**@brief permet de valider l'song du titre.
		*@param $song {inOut} song à valider/réinitialiser*/
		protected static function validateSong(&$song) {
		    if (!isset($song)) {
		        $tmp =$song; 
		        $song ="";
		    throw new \Exception (" Erreur , le chemin de la musique doit être comlété !" );
			}
		}


		/**@brief permet de valider la date Ajout du titre.
		*@param $dateAjout {inOut} dateAjout à valider/réinitialiser*/
		protected static function validateDateAjout(&$dateAjout) {
		    if ( !isset($dateAjout) ) {
		        $tmp =$dateAjout ; 
		        $dateAjout ="";
		    throw new \Exception (" Erreur , la date doit etre renseigné" );
			}
		}


		/**@brief Validation des attributs d’une instance de titre (par exemple à partir des données saisies dans un formulaire via $_REQUEST)Pour chaque attribut de la classe, si une exception est générée lors de la validation de l’attribut, le message d’exception est ajouté dans un tableau associatif d’erreurs. Ces messages d’exception sont ainsi retournés vers le contrôleur.
		*@param $dataErrors {out} tableau associatif d’erreurs
		*@param $titre {inOut} instance de titre*/
		public static function validateInstance (&$dataErrors , &$titre) {

			// du fait que ce soit private
            $idTitre = $titre->getIdTitre();
            $genre = $titre->getGenre();
            $nom = $titre->getNom();
            $album = $titre->getAlbum();
            $auteur = $titre->getAuteur();
            $song = $titre->getSong();
            $dateAjout = $titre->getDateAjout();

			$dataErrors = array();

			try {
				self::validateIdTitre($idTitre);
			}catch(Exception $e) {
				$dataErrors["idTitre"] =  $e->getMessage()."<br/>\n";
			}

			try {
				self::validateGenre($genre);
			}catch(Exception $e) {
				$dataErrors["genre"] =  $e->getMessage()."<br/>\n";
			}

			try {
				self::validateNom($nom);
			}catch(Exception $e) {
				$dataErrors["nom"] =  $e->getMessage()."<br/>\n";
			}

			try {
				self::validateAuteur($auteur);
			}catch(Exception $e) {
				$dataErrors["auteur"] =  $e->getMessage()."<br/>\n";
			}

			try {
				self::validateAlbum($album);
			}catch(Exception $e) {
				$dataErrors["album"] =  $e->getMessage()."<br/>\n";
			}

			try {
				self::validateSong($song);
			}catch(Exception $e) {
				$dataErrors["song"] =  $e->getMessage()."<br/>\n";
			}
			
			try {
				self::validateDateAjout($dateAjout);
			}catch(Exception $e) {
				$dataErrors["dateAjout"] =  $e->getMessage()."<br/>\n";
			}

		 }

		/** @brief Obtention d'une instance validée de la classe Adresse (par exemple à partir des données saisies dans un formulaire). Cette méthode attend un tableau associatif (typiquement $_REQUEST). Les valeurs du tableau sont nettoyées ou échappées par une politique de filtrage définie dans ValidationUtils. Un paramètre passé par référence retourne les messages d'exceptions. La méthode crée une instance et valide ses attributs avec self::validateInstance(). Ces messages d'exception sont ainsi retournés vers le contrôleur. 
		*@param $dataErrors {out} tableau associatif d’erreurs
		*@param $inputArray tableau associatif dont les clefs contiennent les noms des attributs de Titre. Passage par référence pour éviter une recopie.
		*@param $policy=SANITIZE_POLICY_DISCARD_HTML politique de nettoyage
		*@return une instance de titre validée
		*@see AdresseValidation
		*@see ValidationUtils*/ 
		public static function getValidInstance (&$dataErrors , &$inputArray ,$policy=ValidationUtils::SANITIZE_POLICY_DISCARD_HTML_NOQUOTE){

			TitreValidation::validationInput($inputArray,$titre,$policy);
			self::validateInstance($dataErrors,$titre);

			return $titre ;
		}

	}
?>