<?php
	function readAllFilms(){
		//loeme ab-st andmeid, config failis kasutaja ja pwd ei pea igakord uuesti sisestama
		//loome ab-ga ühenduse
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		//valmistame ette päringu stmt - statement
		$stmt = $conn->prepare("SELECT pealkiri, zanr, lavastaja, kestus, tootja, aasta FROM film");
		//seome päringust saadava tulemuse muutujaga filmTitle
		$stmt->bind_result($filmTitle, $filmGenre, $filmDirector, $filmDuration, $filmCompany, $filmYear);
		//käivitame sql päringu, fetch - võta andmed mis pärisid, while - saad teha midagi millegi ajal
		$stmt->execute();
		$filmInfoHTML = null;
		while ($stmt->fetch()){
			$filmDurationH = $filmDuration; //floor roundib alla mitte üles!!!!!
			if(floor($filmDuration / 60) > 1 and $filmDuration % 60 > 1){
				$filmDurationH = floor($filmDuration / 60) ." tundi ja " .$filmDuration % 60 ." minutit.";
			} elseif (floor($filmDuration / 60) > 1 and $filmDuration % 60 == 1){
				$filmDurationH = floor($filmDuration / 60) ." tundi ja " .$filmDuration % 60 ." minut.";
			} elseif (floor($filmDuration / 60) > 0 and $filmDuration % 60 > 1){
				$filmDurationH = floor($filmDuration / 60) ." tund ja " .$filmDuration % 60 ." minutit.";
			} elseif (floor($filmDuration / 60) > 0 and $filmDirector % 60 == 1) {
				$filmDurationH = floor($filmDuration / 60) ." tund ja " .$filmDuration % 60 ." minut.";
			} else {
				if ($filmDuration % 60 == 1){
					$filmDurationH = $filmDuration % 60 ." minut.";
				} else {
					$filmDurationH = $filmDuration % 60 ." minutit.";
				}
			}
			$filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
			$filmInfoHTML .= "<p> Žanr: " .$filmGenre .", lavastaja: " .$filmDirector .". Kestus: " .$filmDurationH ." Tootnud: " .$filmCompany ." aastal " .$filmYear .".</p>";
			//.= ehk lisan juurde on punkti tähendus seal

		}
		$stmt->close();
		$conn->close();
		//sulgesime ühenduse
		//väljastab väärtuse
		return $filmInfoHTML;
	}
	function filmsLongerThan(){
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT pealkiri FROM film WHERE kestus > 90");
		echo $conn->error;
		$stmt->bind_result($filmTitle);
		$stmt->execute();
		$filmsLongerThan = null;

		while($stmt->fetch()){
			$filmsLongerThan .="<p>" .$filmTitle ." kestab kauem kui 90 min.</p>";
		}

		$stmt->close();
		$conn->close();
		return $filmsLongerThan;
	}




	function saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector){
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);	
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		//s- string, i - integer täisarv, d - decimal murdarv, ehk selles järjekorras nagu on pealkiri tootja jnejne ehk pealkiri on string -> s
		$stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector);
		$stmt->execute();
		$stmt->close();
		$conn->close();

		}
?>