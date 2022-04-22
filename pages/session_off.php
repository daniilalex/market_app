<?php
$done = $_GET['action'] ?? null;
if ($done == 'done') {
    $sql_basket_value = mysqli_query($mysql, "delete from warehouse.krepselio_prekes where basket_id = {$_SESSION['user']}
order by id desc limit 1");
    $sql_basket_cart = mysqli_query($mysql, "delete from warehouse.pirkejai where id = {$_SESSION['user']}
order by id desc limit 1");

    unset($_SESSION['market']);

    header('Location: index.php');
}
