<?php
$mysql = mysqli_connect('localhost', 'root', '', 'warehouse');
if ($mysql->connect_error) {
    echo 'Error number: ' . $mysql->connect_errno;
    echo 'Error: ' . $mysql->connect_error;
} else {
    echo 'Host info: ' . $mysql->host_info;
}