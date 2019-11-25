<?php
	function addPicData($fileName, $altText, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userID"], $fileName, $altText, $privacy);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi.";
		} else {
			$notice = " Pildi andmete salvestamine ebaõnnestus: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}//addpicdata

	
	function readAllPublicPics(){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while ($stmt->fetch()){
			$picHTML .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="' .$altTextFromDb .'">' ."\n";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $picHTML;
	}

	function readAllPublicPicsPage($privacy, $page, $limit){//muuda funktsiooni vastavalt sellele kuidas lehel näitamine muutub
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT vpphotos.id, vpusers.firstname, vpusers.lastname, vpphotos.filename, vpphotos.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos JOIN vpusers ON vpphotos.userid = vpusers.id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos.id WHERE vpphotos.privacy <= ? AND deleted IS NULL GROUP BY vpphotos.id DESC LIMIT ?, ?");
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?"); //LIMIT 5 hakkab esimest peale ja kuni viiendani, kui LIMIT 5,5 esimene viis jätab vahele, teine ütleb mitu näidata
		echo $conn->error; //väljastab thumbnailid koos omaniku nime ja hindega
		$skip = ($page - 1) * $limit;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($photoId, $_SESSION["userFirstname"], $_SESSION["userLastname"], $fileNameFromDb, $altTextFromDb, $rating);
		$stmt->execute();
		while ($stmt->fetch()){
			$picHTML .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="' .$altTextFromDb .'">' ."\n";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $picHTML;
	}

	function countPublicImages($privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($imageCountFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $imageCountFromDb;
		} else {
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>