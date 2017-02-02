<?php
/******************************************************************************\
*     Copyright (C) 2016 by Rémy Malgouyres                                    *
*     http://malgouyres.org                                                    *
*                                                                              *
* File DataBaseManager.php created on 10/11/2016 by remy                       *
*                                                                              *
* The program is distributed under the terms of the GNU General Public License *
*                                                                              *
\******************************************************************************/

/** @brief Permet de gérer la connexion à une base de données (ici MySQL)
 * L'exécution de requêtes SQL avec préparation "offerte service compris".
 * La classe est gérée avec le pattern SINGLETON, qui permet
 * d'avoir un exemplaire unique du gestionaire de connexion,
 * pour une connexion persistante.
 * La classe encapsule complètement PDO, y compris les exceptions. */
class DataBaseManager{
  /** Gestionnaire de connexion à la base de données avec PDO */
	private  $dbh = null;
	
  /** Référence de l'unique instance de la classe suivant le modèle Singleton.
   * Initialement null */
  private static $instance=null;
  
  /** @brief Constructeur qui crée une instance de PDO avec données UTF8
   * Le constructeur est privé : Personne ne peut créer des instances 
   * car dans le singleton il ne doit y avoir qu'une seule instance.
   * Récupère les exception PDO et établit le mode d'erreur "EXCEPTION".
   * @throws exception personnalisée en cas d'exception PDO */
  private function __construct(){ 
    try {
      Config::getAuthData($db_host, $db_name, $db_user, $db_password);
      // Création de l'instance de PDO (database handler).
      $this->dbh = new \PDO($db_host.$db_name, $db_user, $db_password);
			      // Rendre les erreurs PDO détectables et gérables par exceptions :
      $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->dbh->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');

    }catch (\PDOException $e){
      throw new \Exception("Erreur de connexion à la base de données. "
			  ."Vous n'avez pas besoin d'en savoir plus...");
    }
  }       
  
  /** @brief Méthode statique publique d'accès à l'unique instance.
   * Si l'instance n'existe pas, elle est crée. On retourne l'unique instance */
  public static function getInstance()
  {
    if (null === self::$instance) {
      self::$instance = new self;
    }
    return self::$instance;
  }
	
	
  /** @brief Prépare et exécute une requête.
   * @param $requete requête avec des ?
   * @param $args arguments à lier (binder) aux ? dans la requête
	 * 							Passage par référence pour éviter une recopie.
   * @return false si la requête échoue,
   *         true si succès ET requête différente de SELECT, 
   *         ou résultats du SELECT dans un array à double entrée PHP standard
   * @throws exception personnalisée en cas d'exception PDO */
  public function prepareAndExecuteQuery($requete, &$args = null){
		// Si aucun argument n'a été fourni
		if ($args === null){
        $args = array();
		}
    // récupération du nombre d'arguments :
    $numargs = count($args);

    // Une requête préparée ne doit pas contenir de guillemets !!!
    if (empty($requete) || !is_string($requete) ||
															preg_match('/(\"|\')+/', $requete) !== 0){
      throw new \Exception("Erreur concernant la sécurité. "
			  ."Requête incomplètement préparée.");
    }

    // On ne laisse pas remonter d'exceptions PDO
    try{
      // Préparation de la requête
      $statement = $this->dbh->prepare($requete);
      if ($statement !== false){
				// On parcours les arguments en commençant au deuxième
				// on commence après le paramètre $requete
				for ($i=1 ; $i <= $numargs; $i++){
					// Lien entre l'argument et le "?" numéro i
					// (rappel : les "?" sont numérotés à partir de 1)
					$statement->bindParam($i, $args[$i-1]);
				}
				// Exécution de la requête préparée :
				$statement->execute();
      }
    }catch (\Exception $e){
      return false;
    }

    if ($statement === false){
      return false;
    } 
	    
    try{
      // Transfert des résultats de la requête dans un array
      $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
      // destruction des données du PDOstatement
      $statement->closeCursor();
    } catch (\PDOException $e){
      // La requête a été exécutée mais pas de résultats
      // La requête n'est pas de type SELECT...
      $results = true;
    }

    // Libération via la grabage collector
    $statement = null;

    return $results; // retour des données de requête
  }
	
	/** @brief Prépare et exécute une requête.
   * @param $requete  requête avec des ":name" pour PDO::prepare
   * @param $args tableau associatif des valeurs à lier aux ":name"
	 *              Les clés "quelqueChose" du tableau associatif args
	 * 							doivent correspondre aux ":quelqueChose" de requete
	 * 							Passage par référence pour éviter une recopie.
   * @return false si la requête échoue,
   *         true si succès ET requête différente de SELECT, 
   *         ou résultats du SELECT dans un array à double entrée PHP standard
   * @throws exception personnalisée en cas d'exception PDO */
  public function prepareAndExecuteQueryAssoc($requete, &$args = null){
		// Si aucun argument n'a été fourni
		if ($args === null){
        $args = array();
		}
		
    // récupération du nombre d'arguments :
    $numargs = count($args);
		
    // Une requête préparée ne doit pas contenir de guillemets !!!
    if (empty($requete) || !is_string($requete) ||
															preg_match('/(\"|\')+/', $requete) !== 0){
      throw new \Exception("Erreur concernant la sécurité. "
													."Requête incomplètement préparée.");
    }
		
    // On ne laisse pas remonter d'exceptions PDO
    try{
      // Préparation de la requête
      $statement = $this->dbh->prepare($requete);
      if ($statement !== false){ // si la syntaxe est correcte
				// On recherche dans la requete les valeurs à associer via bindParam
				// Chaînes de la forme ":quelqueChose"
				preg_match_all("/\:[a-zA-Z][a-zA-Z0-9]+/", $requete,
												$keyCollection, PREG_PATTERN_ORDER);
				// On parcours les arguments de la requête
				foreach ($keyCollection[0] as $key){
					$associativeKey = substr($key, 1); // clé dans le tableau $args
					$statement->bindParam($key, $args[$associativeKey]);
				}
				// Exécution de la requête préparée :
				$statement->execute();
      }
    }catch (\Exception $e){
      return false;
    }

    if ($statement === false){
      return false;
    } 
	    
    try{
      // Transfert des résultats de la requête dans un array
      $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
      // destruction des données du PDOstatement
      $statement->closeCursor();
    } catch (\PDOException $e){
      // La requête a été exécutée mais pas de résultats
      // La requête n'est pas de type SELECT...
      $results = true;
    }

    // Libération via la grabage collector
    $statement = null;

    return $results; // retour des données de requête
	}
  
  /** @brief on interdit le clonage (pour le pattern singleton). */
  private function __clone(){}
} 
?>
