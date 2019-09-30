<?php
	function signUp($name, $surname, $email, $gender, $birthDate, $password){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("INSERT INTO vpusers3 (firstname, lastname, birthdate, gender, email, password) VALUES (?,?,?,?,?,?)");
		echo $conn->error;
		
		/*valmistame parooli salvestamiseks ette, parool kodeeritakse!!!! mitte ei lasta ns tekstina andmebaasi!!!!!!!, 
		salt ehk salasõna soolamine, kui krüpteeritakse ss sarnase algoritmiga krüpteerides võib juhtuda et need segased koodid 
		mis saame võib olla ikka segane ja asjad lähevad sassi, 'sool' mis sinna juurde lisatakse on random*/
		//rand võtan juhusliku arvu, krüpteerin sha1-ga ära ja positsioonist 0 kuni 22 topin otsa 
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $option);
		
		$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice = "Uue kasutaja loomine õnnestus!";
		} else{
			$notice = "Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error;
		}



		$stmt->close();
		$conn->close();
		return $notice;
	}

function signIn($email, $password){
	
	//parooli õigsuse kontroll ehk verify võrdleb sisestatut sellega mis ABs on: if(password_verify($password, $passwordFromDB)
}

?>