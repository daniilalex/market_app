<?php
include_once 'config.php';
?>


<hr>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse!</title>
</head>
<body>
    <style><?php include 'C:\xampp\htdocs\codeacademy\my_web\style.css' ?>
    </style>
<!--menu-->
<table>
    <tr>
        <td>
            <a href="index.php">Parduotuves</a>
        </td>
        <td>
            <a href="index.php?page=shop_products">Parduotuves prekes</a>
        </td>
        <?php if (isLoged() === false) { ?>
            <td>
                <a href="index.php?page=login">Login</a>
            </td>
            <td>
                <a href="index.php?page=register">Register</a>
            </td>
        <?php } ?>
        <?php if (isLoged() === true) { ?>
            <td>
                <a href="index.php?page=warehouse_man">Sandelio darbuotojas</a>
            </td>
            <td>
                <a href="index.php?page=logout">Atsijungti</a>
            </td>
        <?php } ?>
    </tr>
</table>

    <?php
if ($page === null) {
    include 'pages/parduotuves.php';
} elseif ($page === 'register') {
    include 'pages/registration.php';
} ?>
<br/><br/>
<!--footer-->
<?php
echo date('Y-m-d H:i:s');
?>
</body>
</html>