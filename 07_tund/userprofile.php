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
	
	$notice = null;
	$mydescription = null;

	if(isset($_POST["submitProfile"])){
		$notice = storeUserProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
		if(!empty($_POST["description"])){
		  $myDescription = $_POST["description"];
		}
		$_SESSION["bgColor"] = $_POST["bgcolor"];
		$_SESSION["txtColor"] = $_POST["txtcolor"];
	} else {
		$myProfileDesc = showMyDesc();
			if(!empty($myProfileDesc)){
		  	$myDescription = $myProfileDesc;
		}
	}
	
	
		
	
	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  
  <!--profiili loomine -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">
	</form>
	<hr>

	<p><a href="?logout=1">Logi välja</a> / Tagasi <a href="home.php">avalehele</a></p> <!-- <a> on html element millega lingid asju -->

</body>
</html>