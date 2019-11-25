<?php
    require("../../../config_vp.php");
    require("functions/functions_main.php");
    require("functions/functions_user.php");
    require("functions/functions_pic.php");
    $dataBase = "if19_anete_vp";
  
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
    
    $notice = null;

    //piirid galerii lehel näidatava piltide arvu jaoks
    $page = 1;
    $limit = 3;
    $totalPics = countPublicImages(2);
    if(!isset($_GET["page"]) or $_GET["page"] < 1){
        $page = 1;
    } elseif (round($_GET["page"] - 1) * $limit > $totalPics) {
        $page = round($totalPics / $limit) -1;
    } else {
        $page = $_GET["page"];
    }
    $publicThumbsHTML = readAllPublicPicsPage(2, $page, $limit);   
    
    $toScript = "\t" .'<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
    $toScript .= "\t" .'<script type="text/javascript" src="javascript/modal.js" defer></script>' ."\n";
    require("header.php");
?>

<html>
    <body>
    <?php
        echo "<h1>" .$userName ." koolitöö leht</h1>";
    ?>
    <p>See leht on loodud koolis õppetöö raames
    ja ei sisalda tõsiseltvõetavat sisu!</p>
    <hr>
    <p><a href="?logout=1">Logi välja</a> / Tagasi <a href="home.php">avalehele</a></p>
    <hr>
    <h2>Avalike piltide galerii</h2>

    <!--Teeme modaalakna, W3schools eeskuju-->
<div 
    id="myModal" class="modal">
	<!--Sulgemisnupp-->
	<span id="close" class="close">&times;</span>
	<!--pildikoht-->
	<img id="modalImg" class="modal-content">
	<div id="caption"></div>
	
	<div id="rating" class="modalcaption">
		<label><input id="rate1" name="rating" type="radio" value="1">1</label>
		<label><input id="rate2" name="rating" type="radio" value="2">2</label>
		<label><input id="rate3" name="rating" type="radio" value="3">3</label>
		<label><input id="rate4" name="rating" type="radio" value="4">4</label>
		<label><input id="rate5" name="rating" type="radio" value="5">5</label>
		<input type="button" value="Salvesta hinnang" id="storeRating">
        <br>
        <span id="avgRating"></span>
	</div>
    
    <div id="gallery" class="thumbGallery">
	 	<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb '" alt="' .$altTextFromDb '" class="thumbs" data-fn="" data-id="">
	 	 <p>Autorinimi</p> 
	 	 <p id="score86">Hinne: 3.33</p> 
    </div> 

	
</div>
    <p>
    <!-- <p><a href="?page=1">Leht 1</a> / <a href="?page=2">Leht 2</a></p> -->
    <?php
    if($page > 1){
        echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> / ' ."\n";
    } else {
        echo "<span>Eelmine leht</span> / \n";
    }
    if($page * $limit < $totalPics){
        echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>' ."\n";
    } else {
        echo "<span>Järgmine leht</span> \n";
    }   
    ?>
   
   
	  <?php //The <div> element is often used as a container for other HTML elements to style them with CSS or to perform certain tasks with JavaScript.
		echo $publicThumbsHTML; //? on page ees see mis toimetab u nagu get
	  ?>
  </div>
</body>
</html>