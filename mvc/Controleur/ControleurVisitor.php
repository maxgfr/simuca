<?php


    /** @brief ControleurVisitor identifie l'action et appelle la méthode pour construire le modèle correspondant à l'action avec le rôle "visitor". Le controleur appelle aussi la Vue correspondante. Il ne gère pas les exceptions, qui remontent au Front Controller. */
    class ControleurVisitor {

        function __construct ($action){
            ///On distingue des cas d’utilisation, suivant l’action
            switch($action) {
                case "auth" :
                    $this->actionAuth();
                    break;
                case "validateAuth" :
                    $this->actionValidateAuth();
                    break;

                case "getTitreById" : // Affichage d'un titre à partir de son ID
                    $this->actionGet();
                    break;

                case "getAllTitre" : // Affichage de tous les titres
                    $this->actionGetAll();
                    break;

                default : // L'action indéfinie ( page par défaut , ici accueil )
                    require(Config::getVues()["default"]);
                    break;
            }
        }

        /** @brief Implemente l’action "auth" : saisie du login/password */
        private function actionAuth(){
            $model=new Model(array());
            require(Config::getVues()["authentification"]);
        }

        /** @brief Implemente l’action "validateAuth" : Validation du login/password et création de session. */
        private function actionValidateAuth(){
            ValidationRequest::validationLogin($dataError, $email, $password);
            $model=Authentication::checkAndInitiateSession($email, $password, $dataError);
            if($model->getError()===false){
                require(Config::getVues()["defaultAdmin"]);
            }else{
                require(Config::getVues()["authentification"]);
            }
        }

        /** @brief Implemente l'action "get" : Récupère une instance à partir de ID */
        private function actionGet () {
            $rawId = isset($_REQUEST['idTitre']) ? $_REQUEST['idTitre'] : "" ;
            $idTitre = filter_var($rawId , FILTER_SANITIZE_STRING);
            $model = ModelTitre::getModelTitre($idTitre);
            if($model->getError() === false){
                require(Config::getVues()["afficheTitre"]);
            }else{
                require(Config::getVuesErreur()["default"]);
            }

        }

        /** @brief Implemente l'action "get-all" : Récupère toutes les instances*/
        private function actionGetAll () {
            $model = ModelCollectionTitre::getModelTitreAll();
            if($model->getError() === false){
                require(Config::getVues()["afficheCollectionTitre"]);
            }else{
                require(Config::getVuesErreur()["default"]);
            }

        }


     }
?>