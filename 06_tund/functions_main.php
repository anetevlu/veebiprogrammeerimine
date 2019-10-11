<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
//trim - eemaldab tühikuid ja muud jama; stripslashes eemaldab kaldkriipse; specialchars 
?>