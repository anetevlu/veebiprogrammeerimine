<?php
	require("../../../config_vp.php");
	$userName = "Anete Vaalu";
	$dataBase = "if19_anete_va_1";
	require("functions_film.php");
	$filmInfoHTML = readAllFilms(); //ehk panid funktsiooni käima
	
	//var_dump ($_POST);
	//kui nuppu on vajutatud kas ss mingi muutuja ehk submitFilm sai väärtuse ehk is'set 
	if(isset($_POST["submitFilm"])){
		//salvestame kui vähemalt pealkiri on olemas
		if(!empty($_POST["filmTitle"])){
		saveFilmInfo($_POST["filmTitle"], $_POST["filmYear"], $_POST["filmDuration"], $_POST["filmGenre"], $_POST["filmCompany"], $_POST["filmDirector"]);
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
	<label>Sisesta pealkiri</label><input type="text" name="filmTitle">
	<br>
	<label>Filmi tootmisaasta</label><input type="number" min="1912" max="2019" value="2019" name="filmYear">
	<br>
	<label>Filmi kestus (min): </label><input type="number" min="1" max="300" value="80" name="filmDuration">
	<br>
	<label>Filmi žanr: </label><input type="text" name="filmGenre">
	<br>
	<label>Filmi tootja: </label><input type="text" name="filmCompany">
	<br>
	<label>Filmi lavastaja: </label><input type="text" name="filmDirector">
	<br>
	<input type="submit" value="Salvesta filmi info" name="submitFilm">
</form>
  <?php
  //echo "Server: " .$serverHost .", kasutaja: " .$serverUsername;
  //echo $filmInfoHTML;
  ?>
</body>
</html>