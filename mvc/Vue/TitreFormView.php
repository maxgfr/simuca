<?php

	use FormManager as FormManager;


    /** @brief Implémente la génération de formulaire HTML de saisie de Titre. Les formulaires peuvent être vierges ou pré-remplis avec d'éventuels messages d'erreur sur la forme des attributs.*/
	class TitreFormView {

		/** @brief Méthode de génération d'un formulaire HTML vierge. */
		public static function getDefaultFormHTML($action) {
			return self::getFormHTML($action,Titre::getDefaultInstance());

		}


		/** @brief Méthode de génération d'un formulaire HTML pré-rempli. */
		public static function getFormHTML($action,$titre,$filteringPolicy=ValidationUtils::SANITIZE_POLICY_NONE) {

			TitreValidation::filterTitre($titre,false,$filteringPolicy);
			$htmlCode = FormManager::beginForm("post",$action);
			$htmlCode .= FormManager::addTextInput("Titre","nom","nom",$titre->nom);
			$htmlCode .= FormManager::addTextInput("Auteur","auteur","auteur",$titre->auteur);
			$htmlCode .= FormManager::addTextInput("Album","album","album",$titre->album);
			$htmlCode .= FormManager::addSubmitButton("Envoyer","class=\"sansLabel\"");
			$htmlCode .= FormManager::endForm();

			return $htmlCode;

		}

		/** Génère un message d'erreur associé à un attribut, s'il en existe un.
		* Le texte du message est formé du message d'erreur contenu dans dataError.
		* @param $dataError Tableau associatif (nom d'attribut => message d'erreur )
		* @param $fieldName nom de l'attribut considéré */
		private static function addErrorMsg($dataError, $fieldName){
			if (!empty($dataError[$fieldName])){
				$htmlCode = "<span class=\"errorMsg\">".htmlentities($dataError[$fieldName], ENT_COMPAT, "UTF-8")."</span>";
			}
			else{
			$htmlCode="";
			}

			return $htmlCode;
		}

		/** @brief Méthode de génération de formulaire HTML pré-rempli avec erreurs. Génère des messages d'erreur associés aux attribut, s'il en existe.  */
		public static function getFormErrorsHtml($action,$titre,$dataError,$filteringPolicy = ValidationUtils::SANITIZE_POLICY_NONE){

			TitreValidation::filterTitre($titre,false,$filteringPolicy);
			$htmlCode = FormManager::beginForm("post",$action);
			$htmlCode .= self::addErrorMsg($dataError, "nom");
			$htmlCode .= FormManager::addTextInput("Titre","nom","nom",$titre->nom);
			$htmlCode .= self::addErrorMsg($dataError, "auteur");
			$htmlCode .= FormManager::addTextInput("Auteur","auteur","auteur",$titre->auteur);
			$htmlCode .= self::addErrorMsg($dataError, "album");
			$htmlCode .= FormManager::addTextInput("Album","album","album",$titre->album);
			$htmlCode .= FormManager::addSubmitButton("Envoyer","class=\"sansLabel\"");
			$htmlCode .= FormManager::endForm();

			return $htmlCode;

		}

		/** @brief Méthode de génération d'un formulaire HTML caché prérempli. Permet de transmettre les données d'une instance via $_POST. Tous les attributs du formulaire sont de type "hidden".  */
		public static function getHiddenFormHtml($action,$titre,$buttonText,$filteringPolicy=ValidationUtils::SANITIZE_POLICY_NONE) {

			TitreValidation::filterTitre($titre, false, $filteringPolicy);
			$htmlCode = FormManager::beginForm("post", $action);
			$htmlCode .= FormManager::addHiddenInput("nom", "nom", $titre->nom);
			$htmlCode .= FormManager::addHiddenInput("auteur", "auteur", $titre->auteur);
			$htmlCode .= FormManager::addHiddenInput("album", "album", $titre->album);
			$htmlCode .= FormManager::addSubmitButton($buttonText, "class=\"sansLabel\"");
			$htmlCode .= FormManager::endForm();

			return $htmlCode;

		}

	}
?>
