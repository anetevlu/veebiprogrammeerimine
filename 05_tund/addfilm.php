<?php
	require("../../../config_vp.php");
	require("functions_film.php");
	$userName = "Anete Vaalu";
	$dataBase = "if19_anete_va_1";
	
	$filmInfoHTML = readAllFilms(); //ehk panid funktsiooni käima
	$filmTitle = null;
	$filmYear = date("Y");
	$filmDuration = 80;
	$filmGenre = null;
	$filmCompany = null;
	$filmDirector = null;

	$notice = null;
	
	//var_dump ($_POST);
	//kui nuppu on vajutatud kas ss mingi muutuja ehk submitFilm sai väärtuse ehk is'set 
	if(isset($_POST["submitFilm"])){
			$filmTitle = $_POST["filmTitle"];
		$filmYear = $_POST["filmYear"];
		$filmDuration = $_POST["filmDuration"];
		$filmGenre = $_POST["filmGenre"];
		$filmCompany = $_POST["filmCompany"];
		$filmDirector = $_POST["filmDirector"];
			//salvestame kui vähemalt pealkiri on olemas
			if(!empty($_POST["filmTitle"])){
			//saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmCompany"], $_POST["filmDirector"]);
			saveFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmCompany, $filmDirector);
			$filmTitle = null;
			$filmYear = date("Y");
			$filmGenre = null;
			$filmCompany = null;
			$filmDirector = null;
			} else {
				$notice = "Palun siseta filmi pealkiri!";
		}
	}
		
	//käsin võtta headeri sealt failist
	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  <h2>Eesti filmid, lisame uue</h2>
  <p>Täida kõik väljad ja lisa film andmebaasi: </p>
  <form method="POST">
	<label>Sisesta pealkiri:</label><input type="text" value="<?php echo $filmTitle; ?>" name="filmTitle">
	<br>
	<label>Filmi tootmisaasta</label><input type="number" min="1912" max="2019" value="<?php echo $filmYear; ?>" name="filmYear">
	<br>
	<label>Filmi kestus (min): </label><input type="number" min="1" max="300" value="<?php echo $filmDuration; ?>" name="filmDuration">
	<br>
	<label>Filmi žanr: </label><input type="text" value="<?php echo $filmGenre; ?>" name="filmGenre">
	<br>
	<label>Filmi tootja: </label><input type="text" value="<?php echo $filmCompany; ?>" name="filmCompany">
	<br>
	<label>Filmi lavastaja: </label><input type="text" value="<?php echo $filmDirector; ?>" name="filmDirector">
	<br>
	<input type="submit" value="Salvesta filmi info" name="submitFilm">
</form>
  <?php
  echo $notice;
  //echo "Server: " .$serverHost .", kasutaja: " .$serverUsername;
  //echo $filmInfoHTML;
  ?>
</body>
</html>