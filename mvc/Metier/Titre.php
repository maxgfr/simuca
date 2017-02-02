<?php


	class Titre {

		use TitreProperties;

		private $idTitre;
		private $genre;
		private $nom;
		private $album;
		private $auteur;
		private $song;
		private $dateAjout;
		
		
		// Constructeur
		public function __construct ($idTitre, $genre, $nom, $auteur, $album, $song, $dateAjout ) {
			$this->setIdTitre($idTitre);
			$this->setGenre($genre);
			$this->setNom($nom);
			$this->setAuteur($auteur);
			$this->setAlbum($album);
			$this->setSong($song);
			$this->setDateAjout($dateAjout);

		}
		
		public static function getDefaultTitre() {
			$titre = new Titre("","","","","","","");
			$titre->idTitre = "";
			$titre->genre = "";
			$titre->nom = "";
			$titre->auteur = "";
			$titre->album = "";
			$titre->song = "";
			$titre->dateAjout = "";
			return $titre;
		}
		
	}
?>