<?php


    //Permet d'accéder et mettre à jour les données de la tbale User dans la base de données (au moins les opérations CRUD).
	class UserGateway{


		/**Vérifie que le couple login/password existe dans la table User
		* @return le rôle de l'utilisateur su login/passord valide, une erreur sinon */
		public static function getRoleByPassword(&$dataError , $login , $hashedPassword)
		{

			// Exécution de la requête via la classe de connexion (singleton). Le exceptions éventuelles, personnalisées, sont gérés par le Contrôleur
			$args=array($login); // Arguments de la requête
			$queryResults = DataBaseManager::getInstance()->prepareAndExecuteQuery('SELECT * FROM utilisateur WHERE login=?',$args);
			//Si la requête a fonctionné
			if($queryResults !== false)
			{

				if(count ($queryResults) == 1) {
					$row = $queryResults[0];
				}
				//Compare les deux mots de passe
				if(count ($queryResults) != 1 || $row['passwd'] != $hashedPassword){
					$dataError['login'] = "login ou password incorrect";
					return "";
				}
				return $row['role'];
			}

			else{
				$dataError['login'] = "Impossible d'acceder a la table des utilisateurs";
				return "";
			}
			
			// DataBaseManager::destroyQueryResults($queryResults);
		}
		
	}
?>