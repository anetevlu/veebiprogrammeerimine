<?php
	require("functions/functions_user.php");
	require("../../../config_vp.php");
	$dataBase = "if19_anete_vp";
	//võtame vastu saadetud info
	$rating = $_REQUEST["rating"];
	$photoId = $_REQUEST["photoId"];

	 //kui pole sisseloginud
	 if(!isset($_SESSION["userID"])){
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
    
	//võtame vastu saadetud info
	
	$response = "Läks hästi, hinne: " .$rating * 2;
	echo $response;
	//saadan ratingu info ABsse
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["dataBase"]);
	$stmt = $conn->prepare("INSERT INTO photoratings (photoid, userid, rating) VALUES (?,?,?)");
	echo $conn->error;	
	$stmt->bind_param("iii", $photoId, $_SESSION["userID"], $rating);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	//küsin uue keskmise hinde
	$stmt = $conn->prepare("SELECT AVG(rating) FROM photoratings WHERE photoid=?");
	$stmt->bind_param("i", $photoId);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$conn->close();
	echo round($score, 2);


	//SELECT AVG(rating)FROM vpphotoratings WHERE photoid=?
	//round($score, 2); 
	//Selle keskmise hinde näitamiseks võiks modaalaknasse lisada ühe <span> elemendi, mille sisse (innerHTML) see väärtus pannakse.
?>