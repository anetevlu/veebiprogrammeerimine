<?php
	$header = "<!DOCTYPE html> \n";
	$header .= '<html lang="et">'. "\n";
	$header .= "<head> \n";
	$header .= "\t" .'<meta charset="utf-8">' ."\n \t<title>" .$userName ." koolitöö</title> \n";
	$header .= "\t" ."<style> \n";
	$header .= "\t \t body{background-color: " .$_SESSION["bgColor"] ."; \n";
	$header .= "\t \t color: " .$_SESSION["txtColor"] ."\n";
	$header .= "\t }";
	$header .= "</style> \n";
	$header .= $toScript;
	$header .= "</head>";
	echo $header;
	?>	

