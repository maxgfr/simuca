<?php

	class TitreView{

		public static function getHtmlDevelopped($titre,$sanitizePolicy=ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){
			if(TitreValidation::filtertitre($titre,false,$sanitizePolicy)===false){
				return "Titre incorrect";
			}
			$htmlCode="<strong>Song :</strong><br/>\n";

			$idTitre = $titre->getIdTitre();
            $genre = $titre->getGenre();
            $nom = $titre->getNom();
            $album = $titre->getAlbum();
            $auteur = $titre->getAuteur();
            $song = $titre->getSong();
            $dateAjout = $titre->getDateAjout();

			$htmlCode.=$nom;
			if(!empty($nom))
				$htmlCode.="<br/>";

			$htmlCode.=$genre;
			if(!empty($genre))
				$htmlCode.="<br/>";

			$htmlCode.=$auteur;
			if(!empty($auteur))
				$htmlCode.="<br/>";

			$htmlCode.="<img src=\"upload/cover/".$album."\" height=\"200\" width=\"200\"></img><br/>";
			if(!empty($album))
				$htmlCode.="<br/>";

			$htmlCode.="<audio controls=\"controls\"><source src=\"upload/song/".$song."\" type=\"audio/mp3\"/></audio>";
			if(!empty($song))
				$htmlCode.="<br/>";


			$htmlCode.=$dateAjout;
			if(!empty($dateAjout))
				$htmlCode.="<br/><br/>";
			
			return $htmlCode;
		}

		public static function getHtmlCompact($titre, $sanitizePolicy=ValidationUtils::SANITIZE_POLICY_ESCAPE_ENTITIES){

			$nom = $titre->getNom();
            $album = $titre->getAlbum();
            $auteur = $titre->getAuteur();

			if(titreValidation::filtertitre($titre,false,$sanitizePolicy)===false){
				return"Titre incorrect";
			}
			$htmlCode="";

			$htmlCode.="<h5>".$auteur;
			if(!empty($auteur))
				$htmlCode.=" - ";

			$htmlCode.=$nom."</h5>";
			if(!empty($nom))
				$htmlCode.="<br/>";
			
			return$htmlCode;
		}
	}
?>