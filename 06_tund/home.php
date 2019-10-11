<?php
	require("../../../config_vp.php");
	require("functions_main.php");  
	require("functions_user.php");
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
  <p><a href="?logout=1">Logi välja</a> / <a href="userprofile.php"> Kasutajaprofiil</a></p> <!-- <a> on html element millega lingid asju

</body>
</html>