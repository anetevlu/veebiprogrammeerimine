<?php
	require("../../../config_vp.php");
	require("functions/functions_main.php");
	require("functions/functions_film.php");
	require("functions/functions_user.php");
  	$dataBase = "if19_anete_va_1";
	//kui pole sisseloginud
	if(!isset($_SESSION["userID"])){
		//siis jõuga sisselogimise lehele
		header("Location: page.php");
		exit();
	}
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	$userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
	$filmInfoHTML = null;
	//var_dump($_POST);
	
	unset($_SESSION["filmPersonAdded"]);
	unset($_SESSION["filmAdded"]);
	unset($_SESSION["filmProfessionAdded"]);
	
	if(isset($_POST["submit1"])){
		$filmInfoHTML = showFullDataByPerson();	
	}
	$filmInfoHTML = showFullDataByPerson();

	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  <p><a href="?logout=1">Logi välja</a> / Tagasi <a href="home.php">avalehele</a></p>
  <h2>Eesti filmid ja filmitegelased</h2>
  <p>Lisa uut infot <a href="addfilminfo.php">siin</a>.</p>
  <p>Praegu on andmebaasis järgmised filmid:</p>
  <?php
  //echo "Server: " .$serverHost .", kasutaja: " .$serverUsername;
  echo $filmInfoHTML;
  ?>

</body>
</html>