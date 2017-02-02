<?phps

	trait UserProperties {
		
		public function getIdUser() {
			return $this->idUser;
		}

		public function getLogin() {
			return $this->login;
		}

		public function getPassword() {
			return $this->password;
		}

		public function getRole() {
			return $this->role;
		}

		public function setIdUser ($idUser) {
			global $regex_FR_LANG_WITH_NUMBERS;
			if(!isValidString($idUser, $regex_FR_LANG_WITH_NUMBERS, 10,10)){
				throw new Exception("idUser invalide");
			}
			$this->idUser = empty($idUser) ? "" : $idUser;
		}
		
		public function setLogin ($login) {
			global $regex_FR_LANG_WITH_NUMBERS;
			if(!isValidString($corps, $regex_FR_LANG_WITH_NUMBERS, 2,20)){
				throw new Exception("login invalide");
			}
			$this->login = empty($login) ? "" : $login;
		}
		
		public function setPassword($password) {
			global $regex_FR_LANG_WITH_NUMBERS;
			if(!isValidString($password, $regex_FR_LANG_WITH_NUMBERS, 6,40)){
				throw new Exception("mot de passe invalide");
			}
			$this->password = empty($password) ? "" : $password;
		}
		
		public function setRole($role) {
			global $regex_FR_LANG_WITH_NUMBERS;
			if(!isValidString($role, $regex_FR_LANG_WITH_NUMBERS, 2,20)){
				throw new Exception("role invalide");
			}
			$role->auteur = empty($role) ? "" : $role;
		}		
		
	}

?>