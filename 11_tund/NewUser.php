<?php
  require("../../../config_vp.php");
  require("functions_main.php");  
  require("functions_user.php");
  $dataBase = "if19_anete_vp";
  
  
  $notice = null;
  $name = null;
  $surname = null;
  $email = null;
  $gender = null;
  $birthMonth = null;
  $birthYear = null;
  $birthDay = null;
  $birthdate = null;
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //muutujad võimalike veateadetega
  $nameError = null;
  $surnameError = null;
  $birthMonthError = null;
  $birthYearError = null;
  $birthDayError = null;
  $birthdateError = null;
  $genderError = null;
  $emailError = null;
  $passwordError = null;
  $confirmpasswordError = null;
  
  //FOR tsükli näidis /kuidas näitame et i suureneb nt ühe võrra:i=$i+1; $i+=1; $i ++ <- see parim
  /*for ($i = 0; $i < 10; $i ++){
	  echo "Tsükkel: " .$i;
  }*/
    //kui on uue kasutaja loomise nuppu vajutatud
	
  if(isset($_POST["submitUserData"])){
	  //kui on sisestatud nimi
	  if(isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		  $name = test_input($_POST["firstName"]);
	  } else {
		  $nameError = " Palun sisestage eesnimi!";
	  }//eesnime kontrolli lõpp

	  if(isset($_POST["surName"]) and !empty($_POST["surName"])){
		  $surname = test_input($_POST["surName"]);
	  } else {
		  $surnameError = " Palun sisestage perekonnanimi!";
	  }//perekonnanime kontrolli lõpp

	  if(isset($_POST["gender"]) and !empty($_POST["gender"])){
		  $gender = test_input($_POST["gender"]);
	  } else {
		  $genderError = " Palun vali sugu!";
	  } //soo kontroll

	  if(isset($_POST["email"]) and !empty($_POST["email"])){
		  $email = test_input($_POST["email"]);
	  } else {
		  $emailError = " Palun sisesta E-maili aadress!";
	  }//emaili kontrolli lõpp

	  if(!isset($_POST["password"]) or empty($_POST["password"])){
		$passwordError = " Palun sisesta salasõna!";
		} else {
			if(strlen($_POST["password"]) < 8){
				$passwordError = " Sinu salasõna on liiga lühike!";
			}
		}

	  if (!isset($_POST["confirmpassword"]) or empty($_POST["confirmpassword"])){
		  $confirmpasswordError = " Palun sisesta salasõna teist korda ka!";
	  } else {
		  if($_POST["confirmpassword"] != $_POST["password"]){
			  $confirmpasswordError = " Sisestatud salasõnad ei olnud samasugused!";
		  }
	  }// parooli kontroll
		  //kas parool sobib? paroolikontroll: strlen($_POST["password"])<8 siis on liiga lühike, ei tohi ka tühi olla
	//kas parool ja confirm parool on sama asi?	  
		//kontrollime, kas sünniaeg sisestati ja kas on korrektne
	  if(isset($_POST["birthDay"]) and !empty($_POST["birthDay"])){
		  $birthDay = intval($_POST["birthDay"]);
	  } else {
		  $birthDayError = " Palun vali sünnikuupäev!";
	  }
	  
	  if(isset($_POST["birthMonth"]) and !empty($_POST["birthMonth"])){
		  $birthMonth = intval($_POST["birthMonth"]);
	  } else {
		  $birthMonthError = " Palun vali sünnikuu!";
	  }
	  
	  if(isset($_POST["birthYear"]) and !empty($_POST["birthYear"])){
		  $birthYear = intval($_POST["birthYear"]);
	  } else {
		  $birthYearError = " Palun vali sünniaasta!";
	  }  
		//kontrollime kas kp on valiidne - on olemas
		if(!empty($_POST["birthDay"]) and !empty($_POST["birthMonth"]) and !empty($_POST["birthYear"])){
			if(checkdate($birthMonth, $birthDay, $birthYear)){
				$tempDate = new DateTime($birthYear ."-" .$birthMonth ."-" .$birthDay);
				$birthdate = $tempDate->format("Y-m-d");
			} else {
				$birthdateError = " Valitud kuupäev on vigane!";
			}//checkdate lõpp
			
		}//kp valiidsuse kt lõpp

	//kui kõik on korras ss salvestame $nameError = null;
	if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty ($birthYearError) and empty ($birthDayError) and empty($birthdateError) and empty($genderError) and empty($emailError) and empty($passwordError) and empty($confirmpasswordError)){
		$notice = signUp($name, $surname, $birthdate, $gender, $email, $_POST["password"]);
	}//kõik korras
	

  } //kui on nuppu vajutatud
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Katselise veebi uue kasutaja loomine</title>
  </head>
  <body>
    <h1>Loo endale kasutajakonto</h1>
	<p>See leht on valminud TLÜ õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<a href="page.php">Logi sisse</a>
	<hr>
	
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
	  <label>Eesnimi:</label><br>
	  <input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError; ?></span><br>
      <label>Perekonnanimi:</label><br>
	  <input name="surName" type="text" value="<?php echo $surname; ?>"><span><?php echo $surnameError; ?></span><br>
	  <input type="radio" name="gender" value="2" <?php if($gender == "2"){		echo " checked";} ?>><label>Naine</label>
	  <input type="radio" name="gender" value="1" <?php if($gender == "1"){		echo " checked";} ?>><label>Mees</label><br>
	  <span><?php echo $genderError; ?></span><br>

	  <label>Sünnipäev: </label>
	  <?php
		echo '<select name="birthDay">' ."\n";
		echo "\t\t" .'<option value="" selected disabled>päev</option>' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo "\t\t" .'\t <option value="' .$i .'"';
			if($i == $birthDay){
				echo " selected";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "\t </select> \n";
	  ?>

	   <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		echo "\t\t" .'<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo "\t\t" .'<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünniaasta: </label>
	  <?php
	    echo '<select name="birthYear">' ."\n";
		echo "\t\t" .'<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo "\t\t" .'<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <span><?php echo $birthdateError ." " .$birthDayError ." " .$birthMonthError ." " .$birthYearError; ?></span>
	  <br>
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
	  <label>Salasõna (min 8 tähemärki):</label><br>
	  <input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
	  <label>Korrake salasõna:</label><br>
	  <input name="confirmpassword" type="password"><span><?php echo $confirmpasswordError; ?></span><br>
	  <input name="submitUserData" type="submit" value="Loo kasutaja"><span><?php echo $notice; ?></span>
	</form>
	<hr>
		
  </body>
</html>