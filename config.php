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
            echo 'ID: ' . $row['id'] . '. ';
            echo 'Name: ' . $row['name'] . '</br></br>';
        }
    }
}


