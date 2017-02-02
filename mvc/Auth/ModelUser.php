<?php

	/** @brief Classe Modèle pour les données de l'utilisateur
	* e-mail (qui sert ici de email), rôle (visitor, admin, etc...)
	* Les données peuvent venir d'une session ou d'un accès à la BD. */
	class ModelUser extends Model
	{

		//adresse email de l'utilisateur
		private $email;
		//rôle de l'utilisateur
		private $role;
		
		/** Constructeur par défaut (Init. du tableau d'erreurs à vide) */
		public function __construct ($dataError) {
			parent::__construct ($dataError);
		}
		
		/** Permet d' obtenir l'adresse email (email) */
		public function getEmail(){
			return $this->email;
		}
		
		/** Permet d'obtenir le rôle (et donc les droits)*/
		public function getRole () {
			return $this->role;
		}
		
		/** @brief Remplie les données de l'utilisateur à partir du email/password par accès à la BD (UserGateway)
		* @param $email email de l'utilisateur servant d'ID unique
		* @param $hashedPassword mot de passe après hashage */
		public static function getModelUser ($email,$hashedPassword) {
			$model = new self(array());
			// Appel de la couche d'accès aux données :
			$model->role=UserGateway::getRoleByPassword ($model->dataError,$email,$hashedPassword);
			if ( $model->role !== false ) {
				$model->email = $email;
			} else {
				$model->dataError ['email'] = "Login ou mot de passe incorrect";
			}
			return $model ;
		}
		
		/** @brief Remplie des données de l'utilisateur à partir de la session
		* @param $email email de l'utilisateur servant d'ID unique
		* @param $role Rôle de l'utilisateur */
		public static function getModelUserFromSession ($email , $role) {
			$model=new self(array());
			$model->role = $role;
			return $model;
		}
	}
?>