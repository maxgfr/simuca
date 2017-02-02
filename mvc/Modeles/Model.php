<?php

	/** @brief Classe de base pour toutes les classes contenant des modèles. Cette classe vise seulement à factoriser le code concernant les données d'erreurs (tableau associatif dont les valeurs sont des messages d'erreur)*/
	class Model{
		
		protected $dataError;
		

		/** @brief return false en l'absence d'erreurs, la collection d'erreurs sinon
		@return un tableau associatif dont les valeurs sont des messages d'erreur. */
		public function getError(){
			if(empty($this->dataError)){
				return false;
			}
			return $this->dataError;
		}
		
		/* @brief Constructeur 
		@return un tableau associatif dont les valeurs sont des messages d'erreur. (par exemple un tableau vide, au début d'un traitement) */
		public function __construct($dataError){
			$this->dataError = $dataError;
		}
		
	}

?>
