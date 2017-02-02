<?php
/******************************************************************************\
*     Copyright (C) 2016 by Rémy Malgouyres                                    *
*     http://malgouyres.org                                                    *
*                                                                              *
* File FormManager.php created on 10/11/2016 by remy                           *
*                                                                              *
* The program is distributed under the terms of the GNU General Public License *
*                                                                              *
\******************************************************************************/

/** @brief Cette classe sert à faciliter la génération de formulaires HTML. 
	* Elle fournit de méthodes pour générer le début, la fin du formulaire,
	* ainsi que les inputs, textarea et select avec les options de base.
	* Les options complémentaires des inputs peuvent être sélectionnées
	* via une variable $extraOptions des méthodes. */
class FormManager {
/** @brief génère la balise &lt;form&gt; avec méthode (Post, Get) et action (url) */
	public static function beginForm($method, $action, $css_class="", $extraOptions=""){
		if (!empty($css_class)){
			$css_class_option = "class=\"".$css_class."\" ";
		}
		return "<form method=\"".$method."\" action=\"".$action."\" "
				." accept-charset=\"utf-8\" " // On force le charset
				.$css_class_option.$extraOptions.">\n";
	}
	
	/** @brief ferme le formulaire */
	public static function endForm() {
		return "</form>";
	}

	/** méthode générique de génération d'un input
		* @param $labelText texte du label correspondant à l'input
		* @param $type type d'input : texte, date, checkbox, radio, submit...
		* @param $name name de l'input pour la correspondance label/input
		* @param $id ID de l'input pour la correspondance label/input
		* @param $value valeur initiale du champs de l'input
		* @param $extraOptions chaine de caractères contenant les options 
		* 							supplémentaires de l'input suivant la syntaxe HTML. */
	public static function addInput($labelText, $type, $name, $id, $value=null,
																								$extraOptions=""){
		// On échappe pour éviter tout injection
		$value =  ($value == null) ? "" : filter_var($value, FILTER_SANITIZE_STRING);
		$valueOption = " value=\"".$value."\" ";
		if ($extraOptions == null) {
			$extraOptions="";
		}
		$returnText = "<span class=\"formField\">";
		if ($labelText!=null && $labelText!=""){
			$returnText .= "<label for=\"".$id."\">".$labelText."</label>\n"; 
		}
		$returnText .= "<input type=\"".$type."\" name=\"".$name."\" id=\""
		               .$id."\" ".$valueOption." ".$extraOptions." />\n";
		$returnText .= "</span>";

		return $returnText;
	}
//! @cond Doxygen_Suppress
	/** @brief méthode pour générer un input de type text */
	public static function addTextInput($labelText, $name, $id, $size,
																			$value=null, $extraOptions=""){
		return self::addInput($labelText, "text", $name, $id, $value,
																						"size =\"".$size."\" ".$extraOptions);
	}

	/** @brief méthode pour générer un input de type password */
	public static function addPasswordInput($labelText, $name, $id, $size, 
																					$value=null, $extraOptions=""){
		return self::addInput($labelText, "password", $name, $id, $value, 
													"size =\"".$size."\" ".$extraOptions);
	}
	
	/** @brief méthode pour générer un input de type radio */
	public static function addRadioInput($labelText, $name, $id, $checked,
																				$value=null, $extraOptions=""){
		return self::addInput($labelText, "radio", $name, $id, $value, 
							(strcmp($checked, 'checked')==0)? "checked =\"checked\" "
																							:" ".$extraOptions);
	}

	/** @brief méthode pour générer un input de type checkbox */
	public static function addCheckboxInput($labelText, $name, $id, $checked,
																					$value, $extraOptions=""){
		return self::addInput($labelText, "checkbox", $name, $id, $value, 
							(strcmp($checked, 'checked')==0)? "checked =\"checked\" "
																							:" ".$extraOptions);
	}

	/** @brief méthode pour générer une zone de saisie &lt;textarea&gt; */
	public static function addTextArea($labelText, $name, $id, $rows, $cols,
																		 $value=null, $extraOptions=""){
		// On échappe, au moins pour les quotes, mais aussi
		// pour éviter tout injection
		$value =  ($value == null) ? "" : filter_var($value, FILTER_SANITIZE_STRING);
		$valueOption = " value=\"".$value."\" ";
		if ($extraOptions == null) {
			$extraOptions="";
		}
		$returnText .= "<p>\n";
		if ($labelText!=null  && $labelText!=""){
			$returnText .= "<label for=\"".$id."\">".$labelText."</label>\n"; 
		}
		$returnText .= "<textarea name=\"".$name."\" id=\"".$id."\" rows=\"".$rows
										."\" cols=\"".$cols."\" ".$extraOptions." >".$valueOption
										."</textarea>\n";
		$returnText .= "</p>\n";
		return $returnText;
	}

	/** @brief méthode pour générer un input de type file (upload) */
	public static function addUploadInput($labelText, $name, $id, $size,
																				$value="", $extraOptions=""){
		$valueOption = ($value == null) ? "value=\"\"" : " value=\"".$value."\" ";
		if ($extraOptions == null) {
			$extraOptions="";
		}
		return self::addInput($labelText, "file", $name, $id, $value,
													"size =\"".$size."\" ".$valueOption." ".$extraOptions);
	}

	/** @brief méthode  pour commencer une liste d'options &lt;select&gt; */
	public static function beginSelect($labelText, $name, $id, $multiple=false,
																		 $size=6){
		$returnText = "";
		if ($multiple){
			$multipleOption="multiple=\"multiple\" size=\"".$size."\"";
		}else{
			$multipleOption="";
		}
		if ($labelText!=null  && $labelText!=""){
			$returnText .= "<label for=\"".$id."\">".$labelText."</label>\n"; 
		}
		$returnText .= "<select name=\"".$name.($multiple === true ? "[ ]" : "")."\" id=\"".$id."\" "
									.$multipleOption.">\n";
		return $returnText;
	}

	/** @brief méthode simplifiée pour terminer une liste d'options &lt;select&gt; */
	public static function endSelect(){
		$returnText = "</select></p>\n";
		return $returnText;
	}

	/** @brief méthode simplifiée pour ajouter une &lt;option&gt; de liste &lt;select&gt;
	 **/
	public static function addSelectOption($value,$displayText, $selected=false){
		$returnText = "";
		if ($selected){
			$selectedOption="selected=\"selected\"";
		}else{ 
			$selectedOption="";
		}
		$returnText .= "<option value=\"".$value."\" ".$selectedOption.">"
									.$displayText."</option>\n";
		return $returnText;
	}	

	/** @brief méthode simplifiée pour générer un input de type radio */
	public static function addHiddenInput($name, $id, $value, $extraOptions=""){
		return self::addInput("", "hidden", $name, $id, "".$value, $extraOptions);
	}
	
	/** @brief méthode simplifiée pour générer un bouton submit */
	public static function addSubmitButton($value="Envoyer", $extraOptions=""){
		return self::addInput(null, "submit", "", "", $value, " ".$extraOptions);
	}
//! @endcond
}
?>
