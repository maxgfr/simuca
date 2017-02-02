<?php

	class UserFabrique {
		
		public static function getUser (&$dataErrors, $idUser, $login, $password, $role) {
			$user = User::getDefaultUser();
			$dataErrors = array();
			
			try 
			{
				$user-> setId($idUser);
			}catch(Exception $e) {
				$dataErrors["idUser"] =  $e->getMessage()."<br/>\n";
			}

			try {
				$user->setLogin($login);
			}catch(Exception $e) {
				$dataErrors["login"] =  $e->getMessage()."<br/>\n";
			}

			try {
				$user->setPasswd($password);
			}catch(Exception $e) {
				$dataErrors["password"] =  $e->getMessage()."<br/>\n";
			}

			try {
				$user->setRole($role);
			}catch(Exception $e) {
				$dataErrors["auteur"] =  $e->getMessage()."<br/>\n";
			}

		}
		
	}
	
?>