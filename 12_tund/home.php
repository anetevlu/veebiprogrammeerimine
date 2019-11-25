<?php
	require("../../../config_vp.php");
	require("functions/functions_main.php");  
	require("functions/functions_user.php");
	$dataBase = "if19_anete_vp";
	
	//kontroll, kui pole sisse loginud
	if(!isset($_SESSION["userID"])) {
		//siis jõuga sisse logimise lehele
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
	
	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  <p><a href="?logout=1">Logi välja</a></p><!-- <a> on html element millega lingid asju -->
  <ul>
	<li><a href="userprofile.php"> Kasutajaprofiil</a></li>
	<li><a href="messages.php">Sõnumid</a></li>
	<li><a href="showfilminfo.php">Filmid</a></li>
	<li><a href="picupload.php">Piltide üleslaadimine</a></li>
	<li><a href="publicgallery.php">Avalike piltide galerii</a></li>
	<li><a href="pagegallery.php">Lae siin üles pilt, mida näidatakse avalehel</a></li>

	</ul>	  

</body>
</html>