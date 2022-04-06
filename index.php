<?php
include_once 'config.php';
$mysql = mysqli_connect('localhost', 'root', '', 'warehouse');

$email = $_POST['email'];
$_SESSION['email'] = $email;
var_dump($_SESSION);
$sql = "SELECT pareigybe FROM warehouse.darbuotojai WHERE pastas = '$email'";
$results = mysqli_query($mysql, $sql);
$results = mysqli_fetch_assoc($results);


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
        <?php if (isLoged() === true) {
            foreach ($results as $result) {
                if ($result === 'sandelininkas') {
                    ?>
                    <td>
                        <a href="index.php?page=warehouse_man">Sandelio darbuotojas</a>
                    </td>
                    <td>
                        <a href="index.php?page=logout">Atsijungti</a>
                    </td>
                <?php } else { ?>
                    <td>
                        <a href="index.php?page=manager">Vadybininkas</a>
                    </td>
                    <td>
                        <a href="index.php?page=logout">Atsijungti</a>
                    </td>
                <?php }
            }
        } ?>
    </tr>
</table>

<?php
if ($page === null) {
    include 'pages/parduotuves.php';
} else if ($page === 'register') {
    include 'pages/registration.php';
} else if ($page === 'login') {
    include 'pages/login.php';
} else if ($page === 'logout') {
    include 'pages/logout.php';
}

?>
<br/><br/>
<!--footer-->
<?php
echo date('Y-m-d H:i:s');
?>
</body>
</html>