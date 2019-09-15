<?php
	$userName = "Anete Vaalu";
	$fullTimeNow = date("d.m.Y H:i:s");
	$hourNow = date("H");
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
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
  <?php
  echo $userName;
  ?>
  Esimene üritus</title>
</head>
<body>
	<?php
	echo "<h1>" .$userName . "koolitöö leht</h1>";
	?>
  <p>See leht on loodud koolis õppetöö raames ja ei sisalda tõsiseltvõetavat sisu.</p>
  <hr>
  <p>Lehe avamise hetkel oli aeg:
  <?php
  echo $fullTimeNow;
  ?>
  .</p>
  <?php
  echo "<p>Lehe avamise hetkel oli " .$partOfDay. ".</p>";
  ?>
  <hr>
  <p>Ilusat uut kooliaastat!</p>
  
  <P>Kasutame php serverit, mille kohta saab infot <a href="serverinfo.php">siit</a>!</p>
  
</body>
</html>