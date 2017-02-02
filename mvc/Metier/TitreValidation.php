<?php

    use ValidationUtils as ValidationUtils;

    /** @brief Permet la validation initiale des données d'un Titre.
    * Typiquement, les données qui viennent du client reçues (via $_REQUEST...)
    * Nettoyage de toutes les chaînes. Initialisation des inputs inexistants */
    class TitreValidation {

        /** @brief Validation et initialisation des données d'une instance Titre à partir d'une instance de POPO Titre
        * @param $titre d'une instance de Titre
        * @param $reversed pour appliquer la méthode d'inversion d'échappement false pour la méthode de nettoyage et/ou d'échappement
        * @param $policy l'une des politiques définie par ValidationUtils */
        public static function filterTitre($titre,$reversed,$policy){
            // du fait que ce soit private
            $idTitre = $titre->getIdTitre();
            $genre = $titre->getGenre();
            $nom = $titre->getNom();
            $album = $titre->getAlbum();
            $auteur = $titre->getAuteur();
            $song = $titre->getSong();
            $dateAjout = $titre->getDateAjout();

            ValidationUtils::filterString($idTitre,$reversed,$policy);
            ValidationUtils::filterString($genre,$reversed,$policy);
            ValidationUtils::filterString($nom,$reversed,$policy);
            ValidationUtils::filterString($album,$reversed,$policy);
            ValidationUtils::filterString($auteur,$reversed,$policy);
            ValidationUtils::filterString($song,$reversed,$policy);
            ValidationUtils::filterString($dateAjout,$reversed,$policy);
        }

        /** @brief Validation et initialisation des données d'une adresse à partir des données reçues dans les tableau associatif (typiquement $_REQUEST ou $_POST).
        * @param $inputArray tableau associatif dont les clefs contiennent les noms des attributs de Titre
        * @param $titre { inOut } Instance de titre à créer ou initialiser
        * @param $policy l'une des politiques définies par ValidationUtils */
        public static function validationInput ($inputArray,&$titre,$policy) {
            if(!is_object($titre)||!preg_match("/Titre$/",get_class($titre))){
                $titre=Titre::getDefaultTitre();
            }
            $titre->setIdTitre($inputArray['idTitre']);
            $titre->setGenre($inputArray['genre']);
            $titre->setNom($inputArray['nom']);
            $titre->setAuteur($inputArray['auteur']);
            $titre->setAlbum($inputArray['album']);
            $titre->setSong($inputArray['song']);
            $titre->setDateAjout($inputArray['dateAjout']);
            self::filtertitre($titre,false,$policy);
        }

    }
?>