<?php
unset($_SESSION['market']);
$sql_basket_value = mysqli_query($mysql, "delete from warehouse.krepselio_prekes 
order by id desc limit 1");
$sql_basket_cart = mysqli_query($mysql, "delete from warehouse.pirkejai
order by id desc limit 1");

header('Location: index.php');
