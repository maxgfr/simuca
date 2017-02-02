<?php

	class Autoload{
		
		private static $m_instance;
		
		public static function load(){
			if(self::$m_instance !== null){
				throw new Exception("L'autoload ne peut etre chargé qu'une fois :".__CLASS__);
			}

			self::$m_instance = new self();

			if(!spl_autoload_register(array(self::$m_instance, "autoloadCallback"))){
				throw new Exception("Impossible de lancer l'autoload");
			}

		}
		
		public static function shutDown(){

			if(self::$m_instance !== null){

				if(!spl_autoload_unregister(array(self::$m_instance, "autoload"))){
					throw new Exception("Impossible d'arreter l'autoload");
				}

				self::$m_instance = null;
			}

		}
		
		private static function autoloadCallback($class){
			global $rootDirectory;
			$sourceFileName = $class.".php";
			$directoryList= array("", "Auth/","Config/", "Modeles/", "Metier/", "Controleur/", "Persistance/", "Vue/vues/", "Vue/", "../../../mvc/Config/");
			foreach($directoryList as $subDir){
				$filePath = $rootDirectory.$subDir.$sourceFileName;
				if(file_exists($filePath)){
					include($filePath);
				}
			}
		}
		
	}

?>