<?php

    /** @ brief Permet d'initier une session après saisie du login / password . Permet aussi de restaurer la session d'un utilisateur déjà authentifié. */
    class Authentification {

        /** @brief Test du login/password dans la table User et création d'une session */
        //* @return Un modèle avec les données de l'utilisateur pour gestion des rôles Le modèle contient un tableau d'erreur non vide si l'identification échoue */
        public static function checkAndInitiateSession ($login, $password, $dataError)
        {

            // On vérifie que le mot de passe (aprè shashage SHA512) est bien celui en base de donnée .
            if(!empty($dataError)) {
                return new Model($dataError);
            }


            // On applique le hashage sur le mot de passe :
            $hashedPassword=hash("sha1",$password);
            $userModel =ModelUser::getModelUser ( $login , $hashedPassword ) ;
            if($userModel->getError() !== false ){
                return $userModel ;
            }
            
            // On crée une session avec les données de l'utilisateur :
            SessionUtils::createSession ($userModel->getEmail(),$userModel->getRole());
            session_write_close();
            return $userModel ;

        }

        /** @brief Restore la session si l'identificateur a déjà été identifié*/
        /** @return Un modèle de données de l'utilisateur pour gestion des rôles Le modèle contient un tableau d'erreur si la restauration de session échoue */
        public static function restoreSession()
        {

            $dataError = array();

            // Test pourvoir si l'identifiant de session existe et à la bonne forme (10 chiffres hexa entre 0 et f)
            if(!isset($_COOKIE['session-id']) || !preg_match( "/^[0-9a-fA-F]{20} $/" , $_COOKIE['session-id'])){
                $dataError['no-cookie'] = " Votre cookie a expirée , Merci de vous connecter à nouveau ...";
                $userModel = new Model($dataError);
            }

            else
            {
                // On a bien vérifié la forme par expression régulière
                $mySid = $_COOKIE['session-id'];
                // On récupère les données de session :
                session_id($mySid);
                // Le démarage de session
                session_start();

                // Test sur les données de session et contrôle par IP
                if ( !isset ($_SESSION['email']) || !isset ($_SESSION['role']) || !isset ($_SESSION['ipAddress']) || ($_SESSION ['ipAddress'] != $_SERVER['REMOTE_ADDR'])) { 
                    $dataError ['session'] = "Unable to recover user session.";
                    $userModel = new Model($dataError);
                } else {
                    // Création du modèle d'utilisateur :
                    $userModel = ModelUser::getModelUserFromSession ($_SESSION ['email'] , $_SESSION ['role']);
                }
                // Raffinement : on change leS ID aléatoires, en copiant la session dans une nouvelle. On regénère ensuite le cookie. Comme ça, le cookie n'est valable qu'unefois, et l’ID de session aussi ce qui limite beaucoup la possibilité d'un éventuel hacker
                $backupSessionEmail = $_SESSION ['email'];
                $backupSessionRole = $_SESSION ['role'];
                //On recrée une session :
                SessionUtils::createSession($backupSessionEmail,$backupSessionRole);
                //Flush des Données de Session, (sauvegardes immédiateur le disque)
                session_write_close();
            }
            return $userModel ;

        }

    }
?>