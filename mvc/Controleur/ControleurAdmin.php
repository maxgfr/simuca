<?php

	/** @brief ControleurAdmin identifie l'action et appelle la méthode pour construire le modèle correspondant à l'action avec le rôle "admin". Le controleur appelle aussi la Vue correspondante. Il ne gère pas les exceptions, qui remontent au Front Controller. */

	class ControleurAdmin {

		/** @brief C'est dans le contructeur que le contrôleur fait son travail . */
		function __construct ( $action ) {
			// On distingue des cas d'utilisation suivant l'action
			switch ( $action ) {

				case "getTitreById": // Affichage d'un titre à partir de son ID
					$this->actionGet();
					break ;
				case "getAllTitre" : // Affichage de tous les titres
					$this->actionGetAll();
					break ;
				case "adTitre" : // Ajout d'un titre
					$this->actionKeyIn();
					break ;
				case "editTitre" : //Modification d'informations sur le titre
					$this->actionEdit();
					break ;
				case "postTitre" : // Met à jour un titre dans la BD
					$this->actionUpdate();
					break ;
				case "putTitre" : // Cration d'un nouveau titre dans la BD
					$this->actionCreate();
					break ;
				case "deleteTitre" : // Supression d'un titre à partir de son ID
					$this->actionDelete();
					break ;
				default : // L'action indéfinie (page par défaut, ici accueil)
					require (Config::getVues()["defaultAdmin"]);
					break ;
			}

		}


		/** @brief Implemente l'action "get" : Récupère une instance à partir de ID */
		private function actionGet () {
			$rawId = isset($_REQUEST['idTitre']) ? $_REQUEST['idTitre'] : "" ;
	        $idTitre = filter_var($rawId , FILTER_SANITIZE_STRING);
	        $model = ModelTitre::getModelTitre($idTitre);
	        if($model->getError() === false){
	            require(Config::getVues()["afficheTitreCompact"]);
	        }else{
	            require(Config::getVuesErreur()["default"]);
	        }

		}

		/** @brief Implemente l'action "get-all" : Récupère toutes les instances*/
		private function actionGetAll () {
	        $model = ModelCollectionTitre::getModelTitreAll();
	        if($model->getError() === false){
	            require(Config::getVues()["afficheCollectionTitre"]);
	        }else{
	            require(Config::getVuesErreur()["default"]);
	        }

		}

		/** @brief Implemente l'action "adTitre" : Affiche un formulaire vierge */
		private function actionKeyIn () {
	        $model = ModelCollectionTitre::getModelDefaultTitre();
	        require(Config::getVues()["saisieTitreCreate"]);
		}


			/** @brief Implemente l'action "edit ” : Affiche un formulaire de modification */
		private function actionEdit () {
			//ID de l'instance à modifier
			$rawId = isset($_REQUEST['idTitre']) ? $_REQUEST['idTitre'] : "" ;
			$idTitre = filter_var ($_REQUEST[ 'idTitre'],FILTER_SANITIZE_STRING);
			$model =ModelTitre::getModelTitre($idTitre);
			if ( $model->getError() === false ) {
				require(Config::getVues()["saisieTitreUpdate"]);
			} else {
				require(Config::getVuesErreur()["default"]);
			}
		}



		/** @brief Implémente l'action "update" : Met à jour une instance dans la BD */
		private function actionUpdate () {
			//Construction du modèle avec l'adresse validée
			$model = ModelTitre::getModelDefaultTitreUpdate($_POST);
			if($model->getError() === true) {
				if (!empty($model->getError()['persistance'])){
					// Erreur d'accès à la bdd
					require(Config::getVuesErreur()["default"]);
				} else {
					// Erreur de saisie
					require(Config::getVuesErreur()["saisieTitreUpdate"]);
				}
			}
		}

		/** @brief Implémente l'action "create" : Crée une instance dans la BD */
		private function actionCreate () {
			//Construction du modèle avec l'adresse validée
			$model = ModelTitre::getModelTitreCreate($_POST);
			if ( $model->getError ( ) === false ) {
				require(Config::getVues()["afficheTitreCompact"]);
			} else {
				if (!empty($model->getError()['persistance'])){
					// Erreur d'accès à la base de donnée
					require(Config::getVuesErreur()["default"]);
				} else {
					// Erreur de saisie
					require(Config::getVuesErreur()["saisieTitreCreate"]);

				}
			}
		}

		/** @brief Implémente l'action "delete" : Supprime une instance via son ID */
		private function actionDelete () {

			// ID de l'instance à supprimer
			$idTitre = filter_var ($_REQUEST[ 'idTitre'],FILTER_SANITIZE_STRING);

			$model =ModelTitre::deleteTitre($idTitre);
			if ( $model->getError ( ) === false ) {
				require(Config::getVues()["deleteSucess"]);
			} else {
				require(Config::getVuesErreur()["default"]);
			}
		}
	}
?>