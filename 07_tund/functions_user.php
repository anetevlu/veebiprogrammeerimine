<?php
 //käivitame sessiooni
 session_start();
 //var_dump($_SESSION);

	function signUp($name, $surname, $birthdate, $gender, $email, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("INSERT INTO vpusers3 (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
		echo $conn->error;		
		/*valmistame parooli salvestamiseks ette, parool kodeeritakse!!!! mitte ei lasta ns tekstina andmebaasi!!!!!!!, 
		salt ehk salasõna soolamine, kui krüpteeritakse ss sarnase algoritmiga krüpteerides võib juhtuda et need segased koodid 
		mis saame võib olla ikka segane ja asjad lähevad sassi, 'sool' mis sinna juurde lisatakse on random*/
		//rand võtan juhusliku arvu, krüpteerin sha1-ga ära ja positsioonist 0 kuni 22 topin otsa 
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $name, $surname, $birthdate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice = "Uue kasutaja loomine õnnestus!";
		} else {
			$notice = "Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error;
		}



		$stmt->close();
		$conn->close();
		return $notice;
	}

	function signIn($email, $password){
		$notice = "";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT password FROM vpusers3 WHERE email=?");
		echo  $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($passwordFromDB);
		if($stmt->execute()){
			//kui päring õnnestus siis:
			if($stmt->fetch()){
				//kasutaja eksisteerib ABs
				if(password_verify($password, $passwordFromDB)){ //parooli õigsuse kontroll ehk verify võrdleb sisestatut sellega mis ABs on: if(password_verify($password, $passwordFromDB)
					//kui salasõna matchib
					$stmt->close();
					$stmt = $conn->prepare("SELECT id, firstname, lastname FROM vpusers3 WHERE email=?");
					echo $conn->error;
					$stmt->bind_param("s", $email);
					$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
					$stmt->execute();
					$stmt->fetch();
					$notice = "Sisse logis " .$firstnameFromDb ." " .$lastnameFromDb;
					//salvestame kasutaja nime sessiooni muutujatesse 
					$_SESSION["userID"] = $idFromDb;
					$_SESSION["userFirstname"] = $firstnameFromDb;
					$_SESSION["userLastname"] = $lastnameFromDb;

					//loeme kasutaja profiili sisselogimisel
					$stmt->close();
					$stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpusers3profiles WHERE userid=?");
					echo $conn->error;
					$stmt->bind_param("i", $_SESSION["userID"]);
					$stmt->bind_result($bgColorFromDb, $txtColorFromDb);
					$stmt->execute();
					if($stmt->fetch()){
						$_SESSION["bgColor"] = $bgColorFromDb;
						$_SESSION["txtColor"] = $txtColorFromDb;
					} else {
						$_SESSION["bgColor"] = "#FFFFFF";
						$_SESSION["txtColor"] = "#000000";
					}

					$stmt->close();
					$conn->close();

					header("Location: home.php");
					exit();

				} else {
					$notice = "Vale salasõna.";
				}
			} else {
				$notice = " Sellist kasutajat (" .$email .") ei eksisteeri!";
			}
		} else {
			$notice = " Sisse logimisel tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}//sisse logimise finish

	//kasutajaprofiili salvestamine
	function storeuserprofile($description, $bgColor, $txtColor){
		$notice = "";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT id FROM vpusers3profiles WHERE userid=?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userID"]);
		$stmt->bind_result($idFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			//kui profiil on olemas, ss uuendame
			$stmt->close();
			$stmt = $conn->prepare("UPDATE vpusers3profiles SET description =?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $description, $bgColor, $txtColor, $_SESSION["userID"]);
			if($stmt->execute()){
				$notice = "Profiil uuendatud!";
				$_SESSION["bgColor"] = $bgColor;
				$_SESSION["txtColor"] = $txtColor;
			} else {
				$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
			}
			//$notice = "Profiil olemas, ei salvetsanud midagi!";
		} else {
			//profiili pole, nüüd salvestame
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vpusers3profiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["userID"], $description, $bgColor, $txtColor);
			if($stmt->execute()){
				$notice = " Profiili salvestamine õnnestus!";
			} else {
				$notice = " Profiili salvestamisel tekkis tehniline viga: " .$stmt->error;
			}

		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function showMyDesc(){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT description FROM vpusers3profiles WHERE userid=?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userID"]);
		$stmt->bind_result($descriptionFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $descriptionFromDb;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>