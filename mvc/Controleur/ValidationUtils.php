<?php
/******************************************************************************\
*     Copyright (C) 2016 by Rémy Malgouyres                                    *
*     http://malgouyres.org                                                    *
*                                                                              *
* File ValidationUtils.php created on 10/11/2016 by remy                       *
*                                                                              *
* The program is distributed under the terms of the GNU General Public License *
*                                                                              *
\******************************************************************************/

/** @brief Permet la validation des données pour éviter les injections HTML
 * Typiquement, les données reçues via $_REQUEST sont filtrées avant d'être
 * affichées dans une page ou re-soumises dans un formulaire.
 * Plusieurs politiques de filtrage (nettoyage ou échappement) sont prévues. */
class ValidationUtils {
  // Politiques de nettoyage et d'échappement :
	
	/** 1) Ne rien filtrer ni changer */
	const SANITIZE_POLICY_NONE = 0;
  /** 2) Supprimer les balises HTML uniquement, mais ne pas échapper.
		* Laisser les quotes " et apostrophes ' inchangées */
  const SANITIZE_POLICY_DISCARD_HTML_NOQUOTE = 1;
  /** 3) Supprimer les balises HTML et échapper les quotes " et '.
   * Laisser les quotes et apostrophes inchangées */
  const SANITIZE_POLICY_DISCARD_HTML = 2;
	/** 4) Échapper toutes les caractères spéciaux HTML (<, >, ", etc.) */
  const SANITIZE_POLICY_ESCAPE_SPECIAL_CHARS = 3;
	/** 5) Échapper toutes les entités HTML (y compris les accents, etc.) */
  const SANITIZE_POLICY_ESCAPE_ENTITIES = 4;

  /** @brief Méthode de Nettoyage et/ou d'échappement
	 * @param $chaine {inOut} la chaîne de caractères à filtrer
	 * @param $policy la politique de filtrage (voir constantes de classe)
	 * @return false en cas d'échec ($chaine n'est pas une chaîne) */
  private static function filterMethod(&$chaine, $policy){
    // Si la chaine n'est pas définie, on met une chaîne vide
    $chaine = isset($chaine) ? $chaine : "";
		switch($policy){
			case self::SANITIZE_POLICY_DISCARD_HTML_NOQUOTE:
				// Supprimer les balises uniquement, mais ne pas échapper
				$chaine = filter_var($chaine, FILTER_SANITIZE_STRING,
																			FILTER_FLAG_NO_ENCODE_QUOTES);
				break;
			case self::SANITIZE_POLICY_DISCARD_HTML:
				// Supprimer les balises et échapper les quotes " et '.
				$chaine = filter_var($chaine, FILTER_SANITIZE_STRING, ENT_QUOTES);
				break;
			case self::SANITIZE_POLICY_ESCAPE_SPECIAL_CHARS:
				// Échapper toutes les caractères spéciaux HTML (<, >, ", etc.)
				$chaine = htmlspecialchars($chaine, ENT_QUOTES, 'UTF-8');
				break;
			case self::SANITIZE_POLICY_ESCAPE_ENTITIES:
				// Échapper toutes les entités HTML (y compris les accents, etc.)
				$chaine = htmlentities($chaine, ENT_QUOTES, 'UTF-8');
				break;
			default: // SANITIZE_POLICY_NONE: rien à faire
		}
    return $chaine === false ? false : true;
  }
	
  /** @brief Méthode d'Inversion d'échappement
	 * @param $chaine la chaîne de caractères à restaurer suite à un échappement
	 * @param $policy la politique de filtrage (voir constantes de classe) */
  private static function filterMethodReverse(&$chaine, $policy){
    // Si la chaine n'est pas définie, on met une chaîne vide
    $chaine = isset($chaine) ? $chaine : "";
		switch($policy){
      case self::SANITIZE_POLICY_DISCARD_HTML:
				// On restaure justes les simples et doubles quotes qui sont html-encodées
				$tmp = preg_replace('/^\&quot\;$/', "\"", isset($chaine) ? $chaine : "");
				$chaine = preg_replace('/^\&39\;$/', "'", $tmp);
				break;
 		  case self::SANITIZE_POLICY_ESCAPE_SPECIAL_CHARS:
			  // On inverse l'encodage des caractères spéciaux HTML
				$chaine = htmlspecialchars_decode($chaine, ENT_QUOTES, 'UTF-8');
				break;
			case self::SANITIZE_POLICY_ESCAPE_ENTITIES:
				// On inverse l'encodage des entités HTML
				$chaine = htmlentities_decode($chaine, ENT_QUOTES, 'UTF-8');
				break;
			default: // SANITIZE_POLICY_DISCARD_HTML_NOQUOTE: Rien à restaurer
							 // SANITIZE_POLICY_NONE: rien à faire
		}
  }
	
  /** @brief Méthode de (Nettoyage et/ou d'échappement)
	 * 										et/ou d'inversion d'échappement
	 * @param $chaine la chaîne de caractères à filtrer
	 * @param $reversed true s'il faut appliquer une inversion d'échappement
	 *                 false s'il faut appliquer un nettoyage et/ou échappement
	 * @param $policy la politique de filtrage (voir constantes de classe) **/
  public static function filterString(&$chaine, $reversed, $policy){
    if (!isset($policy)){
      throw new \Exception("Politique de filtrage non définie");
    }
    return $reversed ? self::filterMethodReverse($chaine, $policy) :
		       self::filterMethod($chaine, $policy);
  }
}
?>
