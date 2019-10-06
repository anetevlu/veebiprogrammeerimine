<?php
	require("../../../config_vp.php");
	require("functions_main.php");  
	require("functions_user.php");
	$dataBase = "if19_anete_vp";
	
	$userName = "sisse logimata kasutaja";
	
	$notice = "";
	$email = "";
	$emailError = "";
	$passwordError = "";
	
	$photoDir = "../photos/";
	$picFileTypes = ["image/jpeg", "image/png"];	
	$monthsET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$weekdaysET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	$hourNow = date("H");
	$monthNow = date("m");
	$weekdayNow = date("N");
	$dateNow = date("d");
	$yearNow = date("Y");
	$timeNow = date("H:i:s");
	$fullTimeNow = date("d.m.Y H:i:s");
	
	
	$partOfDay = "hägune aeg";
	if($hourNow < 8) {
		$partOfDay = "varane hommik";
	}
	if($hourNow == 12) {
		$partOfDay = "keskpäev";
	}
	if($hourNow > 12) {
		$partOfDay = "peale lõunat";
	}
	if($hourNow >= 20) {
		$partOfDay = "hiline õhtu";
	}
	//info semestri kulgemise kohta
	$semesterStart = new DateTime("2019-9-2");
	$semesterEnd = new DateTime("2019-12-13");
	$semesterDuration = $semesterStart->diff($semesterEnd);
	$today = new DateTime("now");
	$fromSemesterStart = $semesterStart->diff($today);
	//var_dump($fromSemesterStart);
	$semesterInfoHTML = "<p>Siin peaks olema info semestri kulgemise kohta</p>";
	$elapsedValue = $fromSemesterStart->format("%r%a");
	$durationValue = $semesterDuration->format("%r%a");
	//echo $testValue;
	//<meter min="0" max="155" value="33">Väärtus</meter>
	if($elapsedValue > 0){
		$semesterInfoHTML = "<p>Semester on täies hoos: ";
		$semesterInfoHTML .= '<meter min="0" max="' .$durationValue .'" ';
		$semesterInfoHTML .= 'value="' .$elapsedValue .'">';
		$semesterInfoHTML .= round($elapsedValue / $durationValue * 100, 1) ."%";
		$semesterInfoHTML .= "</meter>";
		$semesterInfoHTML .="</p>";
	}
	if ($elapsedValue < 0) {
		$semesterInfoHTML = "<p>Semester ei ole veel alanud.</p>";
	}
	if ($elapsedValue > 103) {
		$semesterInfoHTML = "<p>Semester on läbi!</p>";
	}
	//<img src="../photos/tlu_terra_600x400_1.jpg" alt="TLÜ Terra õppehoone"> <- see on html keeles pildi jaoks
	//foto lisamine lehele
	$allPhotos = [];
	$dirContent = array_slice(scandir($photoDir), 2);
	//var_dump($dirContent);
	//foreach on nagu võtaks käega korvist porgandeid
	foreach ($dirContent as $file) {
		$fileInfo = getImageSize($photoDir .$file);
		//var_dump($fileInfo);
		if(in_array($fileInfo["mime"], $picFileTypes) == true){
			array_push($allPhotos, $file); //kontrollisid kas on fail, kui jah siis lisatakse sinna allphotos massiivi
		}
	}	
	//var_dump($allPhotos);
	$picCount = count($allPhotos);
	$picNum = mt_rand(0, ($picCount - 1));
	//echo $allPhotos[$picNum];
	$photoFile = $photoDir .$allPhotos[$picNum];
	$randomImgHTML = '<img src="' .$photoFile .'" alt="TLÜ Terra õppehoone">';
	//lisame lehe päise

	if(isset($_POST["login"])){
		if(isset($_POST["email"]) and !empty($_POST["email"])){
			$email = test_input($_POST["email"]);
		} else {
			$emailError = " Palun sisesta E-maili aadress kasutajatunnusena!";
		}
		if(!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
			$passwordError = " Palun sisesta parool!";
		}
		if(empty($emailError) and empty($passwordError)){
			$notice = signIn($email, $_POST["password"]);
		} else {
			$notice = " Sisse logimine ebaõnnestus.";
		}
	}


	require("header.php");
?>
<body>
	<?php
	echo "<h1>" .$userName ." koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <?php
	echo $semesterInfoHTML;
  ?>
  <hr>
  <p>Lehe avamise hetkel oli aeg:
  <?php
  //echo $fullTimeNow;
	echo $weekdaysET[$weekdayNow - 1] .", " .$dateNow .". " .$monthsET[$monthNow -1] ." " .$yearNow .", kell " .$timeNow;
  ?>
  .</p>
  <?php
  //echo "<p>Lehe avamise hetkel oli " .$weekdaysET[$weekdayNow - 1]. ".</p>";
  ?>
  <?php
  echo "<p>Lehe avamise hetkel oli " .$partOfDay. ".</p>";
  ?>
  <p>Ilusat uut kooliaastat!</p>
  
  <P>Kasutame php serverit, mille kohta saab infot <a href="serverinfo.php">siit</a>!</p>
  <hr>
  	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
	<label>Kasutajatunnus (email): </label><br>
	<input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
	<label>Salasõna: </label><br>
	<input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
	<input name="login" type="submit" value="logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>

  <hr>
  <?php {
	  echo $randomImgHTML;
  }
  ?>
</body>
<footer>
<hr>
<h3>Kontaktinfo:</h3>
<p>anetevlu@tlu.ee</p>
<p>Narva mnt 25</p>
</footer>
</html>