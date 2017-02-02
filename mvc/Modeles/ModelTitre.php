<?php
	
	require_once("Model.php");

	class ModelTitre extends Model{
		
		//Instance d'un titre,données métier du modèle
		private $titre;
		//titre principal de la vue
		private $nom;
		
		/** Donne accès à la donnée titre */
		public function getData(){
			return $this->titre;
		}
		

		/** @brief Retourne un modèle avec une instance de titre par défaut dans une instance de Personne donnée. */
		public static function getModelDefaultTitre(){
			$model = new self(array());
			$model->titre = Titre::getDefaultTitre();
			$model->nom = "Saisie d'un nouveau titre";
			return $model;
		}
		
		/** @brief Retourne un modèle avec une instance de titre à partir de son ID par accès à la couche Persistance.*/
		public static function getModelTitre($idTitre){
			$model = new self(array());
			$model->titre = TitreGateway::getTitreById($model->dataError, $idTitre);
			$model->nom = "Affichage d'un titre";
			return $model;
		}


		/** @brief Modifie une titre dans la couche Persistance. */
		public static function getModelDefaultTitreUpdate($inputArray){
			$model = new self(array());
			$model->titre = TitreGateway::updateTitre($model->dataError, $inputArray);
			$model->nom = "Le titre a été mis à jour";
			return $model;
		}
		
		/** @brief Insère une titre en créant un nouvel ID dans la BD. */
		public static function getModelTitreCreate($inputArray){
			$model = new self(array());
			$model->titre = TitreGateway::createTitre($model->dataError, $inputArray);
			$model->nom = "Le titre a été inséré";
			return $model;
		}

		/** @brief ISupprime une titre dans la BD et retourne le titre. */
		public static function deleteTitre($idTitre){
			$model = new self(array());
			$model->titre = TitreGateway::deleteTitre($model->dataError, $idTitre);
			$model->nom = "Le titre a été supprimé";
			return $model;
		}

	}

?>
