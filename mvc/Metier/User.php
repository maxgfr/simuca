<?php

	class User {

		use UserProperties;

		private $idUser;
		private $login;
		private $password;
		private $role;

		public function __construct ($idUser, $login, $password, $role)  {
			$this->setIdUser($idUser);
			$this->setLogin($login);
			$this->setPassword($password);
			$this->setRole($role);
		}

		public static function getDefaultUser() {
			$user = new User("X", "X", "X", "admin");
			$user->idUser = "";
			$user->login = "";
			$user->password = "";
			$user->role = "";
			return $user;
		}

	}
?>