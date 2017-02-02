<?php

	trait TitreProperties {

		public function getIdTitre() {
			return $this->idTitre;
		}

		public function getGenre() {
			return $this->genre;
		}

		public function getNom() {
			return $this->nom;
		}

		public function getAlbum() {
			return $this->album;
		}

		public function getAuteur() {
			return $this->auteur;
		}

		public function getSong() {
			return $this->song;
		}

		public function getDateAjout() {
			return $this->dateAjout;
		}


		public function setIdTitre ($idTitre) {
			$this->idTitre = empty($idTitre) ? "" : $idTitre;
		}

		public function setGenre ($genre) {
			$this->genre = empty($genre) ? "" : $genre;
		}
		
		public function setNom($nom) {
			$this->nom = empty($nom) ? "" : $nom;
		}

		public function setAlbum ($album) {
			$this->album = empty($album) ? "" : $album;
		}

		public function setAuteur ($auteur) {
			$this->auteur = empty($auteur) ? "" : $auteur;
		}

		public function setSong ($song) {
			$this->song = empty($song) ? "" : $song;
		}
		
		public function setDateAjout ($dateAjout) {
			$this->dateAjout = empty($dateAjout) ? "" : $dateAjout;
		}
		
	}
?>