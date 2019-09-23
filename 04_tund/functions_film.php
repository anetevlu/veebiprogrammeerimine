<?php
function readAllFilms(){
	//loeme ab-st andmeid, config failis kasutaja ja pwd ei pea igakord uuesti sisestama
	//loome ab-ga ühenduse
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
	//valmistame ette päringu stmt - statement
	$stmt = $conn->prepare("SELECT pealkiri, aasta FROM film");
	//seome päringust saadava tulemuse muutujaga filmTitle
	$stmt->bind_result($filmTitle, $filmYear);
	//käivitame sql päringu, fetch - võta andmed mis pärisid, while - saad teha midagi millegi ajal
	$stmt->execute();
	$filmInfoHTML = null;
	while ($stmt->fetch()){
		$filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
		$filmInfoHTML .= "<p>Tootmisaasta: " .$filmYear ."</p>";
		//.= ehk lisan juurde on punkti tähendus seal
	}
	$stmt->close();
	$conn->close();
	//sulgesime ühenduse
	//väljastab väärtuse
	return $filmInfoHTML;
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