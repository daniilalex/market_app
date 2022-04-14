<?php
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$mysql = mysqli_connect('localhost', 'root', '', 'warehouse');
if ($mysql->connect_error) {
    echo 'Error number: ' . $mysql->connect_errno;
    echo 'Error: ' . $mysql->connect_error;
} else {
    echo 'Host info: ' . $mysql->host_info;
}

$page = $_REQUEST['page'] ?? null;

function isLoged(): bool
{
    if (isset($_SESSION['email'])) {
        return true;
    } else {
        return false;
    }
}

function printValue($arr)
{
    if ($arr->num_rows > 0) {
        while ($row = $arr->fetch_assoc()) {
            echo 'ID: ' . $row['id'] . '. ' . '</br></br>';
            echo 'Product category: ' . $row['category'] . '</br></br>';
            echo 'Title: ' . $row['product_title'] . '</br></br>';
            echo 'Price: ' . $row['price'] . '</br></br>';
            echo 'Expire date: ' . $row['expire_date'] . '</br></br>';
        }
    }
}

function getRole($mysql):string {
   $sql = "select role from warehouse.role join warehouse.darbuotojai d on role = d.role_id where pastas = '" . $_SESSION['email'] . "'";
   $result = mysqli_query($mysql, $sql);
   $result = mysqli_fetch_assoc($result);
   return $result['role'];
}

$today = date('Y-m-d');
//take price and expire date which is expired
$sql = mysqli_query($mysql, "SELECT parduotuves_prekes.price, parduotuves_marza.marza FROM warehouse.parduotuves_prekes join warehouse.parduotuves_marza on parduotuves_prekes.parduotuve_id = parduotuves_marza.parduotuves_id WHERE parduotuves_prekes.expire_date = '$today' and parduotuves_prekes.utilize = 0");
$expired = mysqli_fetch_all($sql, MYSQLI_ASSOC);







