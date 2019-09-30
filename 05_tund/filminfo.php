<?php
	require("../../../config_vp.php");
	require("functions_film.php");
	$userName = "Anete Vaalu";
	$dataBase = "if19_anete_va_1";
	
	$filmInfoHTML = readAllFilms(); //ehk panid funktsiooni käima
	
	
	//käsin võtta headeri sealt failist
	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  <h2>Eesti filmid</h2>
  <p>Praegu on andmebaasis järgmised filmid:</p>
  <?php
  //echo "Server: " .$serverHost .", kasutaja: " .$serverUsername;
  echo $filmInfoHTML;
  ?>
</body>
</html>