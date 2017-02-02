<?php
/******************************************************************************\
*     Copyright (C) 2016 by Rémy Malgouyres                                    *
*     http://malgouyres.org                                                    *
*                                                                              *
* File ExpressionsRegexUtils.php created on 10/11/2016 by remy                 *
*                                                                              *
* The program is distributed under the terms of the GNU General Public License *
*                                                                              *
\******************************************************************************/

/** @brief Classe de définitions d'Expressions Régulières d'usage général.
 * Définit quelques expressions régulières utiles pour la langue locale supportée
 * et les routines de test sur une chaîne correspondant. */
class ExpressionsRegexUtils{
	/** @brief : expression régulière pour la langue Française avec accents */
	private static function getRegexLatin1(){
		return '/^[a-zA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿĀā \"\'\-\ ]*$/';
	}

  /** @brief : expression régulière pour la langue Française avec accents,
	 * et chiffres */
	private static function getRegexLatin1WithNumbers(){
	 return '/^[0-9a-zA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿĀā \"\'\-\ ]*$/';
	}
	
  /** @brief : expression régulière pour la langue Française avec accents, 
	 * chiffres et ponctuation */
	private static function getRegexLatin1WithNumbersAndPunctuation(){
	 return '/^[\!\.\:\;\?\,0-9a-zA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿĀā \"\'\-\ ]*$/';
	}

	/** @brief : Test expression régulière pour la langue Française avec accents
	 * avec conditions de longueur (par exemple pour un champ obligatoire) */
	public static function isValidLatin1($chaine, $minLength, $maxLength){
		return (isset($chaine) &&
					  strlen($chaine) >= $minLength && strlen($chaine) <= $maxLength
						&& preg_match(self::getRegexLatin1(), $chaine));				
	}

  /** @brief : Test expression régulière pour la langue Française avec accents
	 * et chiffres, avec conditions de longueur
	 * (par exemple pour un champ obligatoire) */
	public static function isValidLatin1WithNumbers($chaine, 
																											 $minLength, $maxLength){
		return (isset($chaine) &&
					  strlen($chaine) >= $minLength && strlen($chaine) <= $maxLength
						&& preg_match(self::getRegexLatin1WithNumbers(), $chaine));				
	}

  /** @brief : Test expression régulière pour la langue Française avec accents, 
	 * chiffres et ponctuation, avec conditions de longueur
	 * (par exemple pour un champ obligatoire) */
	public static function isValidLatin1WithNumbersAndPunctuation($chaine, 
																											$minLength, $maxLength){
		return (isset($chaine) &&
					  strlen($chaine) >= $minLength && strlen($chaine) <= $maxLength
			 && preg_match(self::getRegexLatin1WithNumbersAndPunctuation(), $chaine));				
	}

  /** @brief : Test expression régulière passée en paramètre
	 * avec conditions de longueur (par exemple pour un champ obligatoire) */
	public static function isValidString($chaine, $regExp, $minLength, $maxLength){
		return (isset($chaine) &&
					  strlen($chaine) >= $minLength && strlen($chaine) <= $maxLength
						&& preg_match($regExp, $chaine));				
	}
}
?>
