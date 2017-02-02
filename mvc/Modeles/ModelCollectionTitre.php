<?php

	
	/** @brief Classe Modèle pour stocker une collection d'Adresse */
	class ModelCollectionTitre extends Model{

		/** Collection de titres, données métier du modèle */
		private $collectionTitre;

		/**Donne accès à la collection d'adresses */
		public function getData(){
			return $this->collectionTitre;
		}

		/** @brief Constructeur par défaut (privé, crée des collections vides) */
		private function __contruct(){
			$this->collectionTitre = array();
			$this->dataError = array();
		}

		/** @brief Retourn un modèle avec la collection de toutes les adresses par accès à la bdd */
		public static function getModelTitreAll(){
			$model = new self(array());
			// Appel de la couche d'accès aux données :
			$model->collectionTitre = TitreGateway::getTitreAll($model->dataError);
			return $model ;
		}
	}
?>
