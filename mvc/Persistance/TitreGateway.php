<?php

	/** Permet d'accéder/mettre à jour les données de la table Titre dans la base de données (au moins les opérations CRUD). Les méthodes génèrent le code SQL pour des requêtes préparée, puis font appel à la classe Connection (DataBaseManager) pour préparer et exécuter les requêtes. Les méthodes retournent, selon la requête considérée, des instances ou collections d'instances de titre, résultats d'une requête SELECT, ou ligne impactée par la requête (INSERT, UPDATE, DELETE). Les méthodes retournent les erreurs sur les données incorrectes dans un tableau associatif dataError, et pevent rejeter des exceptions en cas de problèmes d'accès à la BD (serveur inaccessible par exemple) */
	class TitreGateway{

		/** Permet de récupérer une titre à partir de son ID.
 		* @param $dataError : données d'erreurs ( coupletype => message ) par réfénce
 		* @param $idTitre : clé primaire du titre à récupérer
		* @return instance d'un titre en cas de succès, undefined sinon.
 		* @throws en cas de problème d'accès à la bdd*/
		public static function getTitreById(&$dataError, $idTitre){
			if (isset($idTitre)) {
				// Exécution de la requête via la classe de connexion (singleton)
				// Les exceptions éventuelles, personnalisées, sont gérées plus haut
				$args=array($idTitre); // Arguments de la requête
				$queryResults=DataBaseManager::getInstance()->prepareAndExecuteQuery("SELECT * FROM titre WHERE idTitre = ?", $args);
		 		// Si l'exécution de la requête a fonctionné
				if(isset($queryResults) && is_array ($queryResults)) {
		 			//Si une et une seule adresse a été trouvée
					if (count($queryResults)=== 1) {
						$row=$queryResults[0];
						$titre =TitreFabrique::getValidInstance($dataErrorAttributes,$row);
						$dataError = array_merge( $dataError , $dataErrorAttributes); // fusion

					} else{
						$titre=null;
						$dataError["persistance"] = "Titre introuvable";
					}
				} else{
					$titre=null;
					$dataError["persistance"] = "Impossible d'accéder aux données";
				}
			} else{
				$titre=null;
				$dataError["persistance"] = "Titre introuvable";
			}

			return $titre;
		}




		/** Permet de récupérer une collection de titre représentés dans la table.
 		* @param $dataError : données d'erreurs ( coupletype => message ) par référence
 		* @return collection de titre en cas de succès, collection vide sinon
 		* @throws en cas de problème d'accès à la bdd */
		public static function getTitreAll(&$dataError){
			//Exécution de la requête via la classe de connexion (singleton)
			//Les exceptions éventuelles , personnalisées , sont gérées plus haut
			$queryResults = DataBaseManager::getInstance()->prepareAndExecuteQuery("SELECT * FROM titre");

			//Construction de la collection des résultats (fabrique)
			$collectionTitre = array();
			// Si l'exécution de la requête a fonctionné
			if($queryResults !== false){
				foreach($queryResults as $row){
					// Ajout d'un titre dans la collection' :
					$titre =TitreFabrique::getValidInstance($dataErrorAttributes,$row);
					$collectionTitre[] = $titre;
					$dataError = array_merge($dataError , $dataErrorAttributes); // fusion
				}
			}else{
				$dataError["persistance-get"] = "Problème d'accès aux donneés";
			}
			return $collectionTitre;
		}



		/** @brief Met à jour un titre ( Update )
 		* @param $dataError : données d'erreurs ( coupletype => message ) par référence
 		* @param $inputArray tableau associatif dont les clefs correspondent aux noms des attributs de titre. Passage par référence pour éviter une copie.
		* @return l'instance d'un titre (erreurs ET instance du titre modifié)
 		* @throws en cas de problème d'accès à la bdd*/
		public static function updateTitre (&$dataError, $inputArray) {
			//Tentative de construction d'une instance ( et filtrage )
			$titre=TitreFabrique::getValidInstance($dataErrorAttributes,$inputArray);
			//Si la forme des attributs sont corrects ( expressions régulières - setters )
			if (empty($dataErrorAttributes)) {
				// Execution de la requête de mise à jour :
            	$queryResults = DataBaseManager::getInstance()->prepareAndExecuteQueryAssoc("UPDATE titre SET idTitre=:idTitre, genre=:genre, nom=:nom, auteur=:auteur, album=:album, song=:song, dateAjout=:dateAjout WHERE idTitre=:idTitre", $inputArray);
	            if($queryResults === false){
	                $dataError["persistance"] = "Probleme d'accés aux données";
	            }
            }else {
				$dataError = array_merge($dataError, $dataErrorAttributes); // fusion
			}
			return $titre;	
		}

		/** @brief Insère un nouveau titre( Create )
		* @param $dataError : données d'erreurs ( coupletype => message ) par référence
		* @param $inputArray tableau associatif dont les clefs correspondent aux noms des attributs de titre. Passage par référence pour éviter une copie.
		* @return l'instance d'un titre (erreurs ET instance du titre modifié)
 		* @throws en cas de problème d'accès à la bdd*/
		public static function createTitre (&$dataError, $inputArray) {
			//Tentative de construction d'une instance ( et filtrage )
			$titre=TitreFabrique::getValidInstance($dataErrorAttributes,$inputArray);
			//Si la forme des attributs sont corrects ( expressions régulières - setters )
			if (empty($dataErrorAttributes)) {
				// Execution de la requête d'insertion' :
            	$queryResults = DataBaseManager::getInstance()->prepareAndExecuteQueryAssoc("REPLACE INTO Titre(idTitre,genre,nom,album,auteur,song,dateAjout) VALUES (:idTitre,:genre,:nom,:album,:auteur,:song,:dateAjout)", $inputArray);
	            if($queryResults === false){
	                $dataError["persistance"] = "Probleme d'execution de la requête";
	            }
            }else {
				$dataError = array_merge($dataError, $dataErrorAttributes); // fusion
			}

			$titre->setIdTitre($inputArray['idTitre']); // pour la valeur retournée

			return $titre;
		}

		/** @brief Suprimme une adresse à partir de sonn id
		* @param $dataError : données d'erreurs ( coupletype => message ) par référence
		* @param $inputArray tableau associatif dont les clefs correspondent aux noms des attributs de titre. Passage par référence pour éviter une copie.
		* @return l'instance d'un titre (erreurs ET instance du titre modifié)
 		* @throws en cas de problème d'accès à la bdd*/
		public static function deleteTitre (&$dataError, $idTitre) {

			// Testsil ’ adresseexisteetrécupérationsdonnéesàsupprimer
			$dataErrorIdSearch = array();
			$titre = self::getTitreById($dataErrorIdSearch,$idTitre);


			//Tentative de construction d'une instance ( et filtrage )
			$titre=TitreFabrique::getValidInstance($dataErrorAttributes,$inputArray);
			//Si la forme des attributs sont corrects ( expressions régulières - setters )
			if (empty($dataErrorIdSearch)) {
				$args= array($idTitre);
				// Execution de la requête via la classe de connexion (singleton) :
				// Les exceptions éventuelles, personnalisées sont gérées par le contrôleur
            	$queryResults = DataBaseManager::getInstance()->prepareAndExecuteQuery("DELETE FROM Titre WHERE idTitre=?",$args);
	            if($queryResults === false){
	                $dataError["persistance"] = "Probleme d'execution de la requête";
	            }
            }else {
				$dataError = array_merge($dataError, $dataErrorAttributes); // fusion
			}

			$titre->setIdTitre($inputArray['idTitre']); // pour la valeur retournée

			return $titre;
		}

	}

?>