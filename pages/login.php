<?php
$mysql = mysqli_connect('localhost', 'root', '', 'warehouse');
$employers = mysqli_query($mysql, "SELECT * FROM warehouse.darbuotojai LIMIT 2");
$sql = "SELECT pastas, pareigybe FROM warehouse.darbuotojai";
$results = mysqli_query($mysql, $sql);
$results = mysqli_fetch_assoc($results);
var_dump($results);

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $job = $_POST['job_position'];
    $errors = [];

    if (empty($email) || empty($password) || empty($job)) {
        $errors[] = 'Yra tusciu lauku';
    }
    if (empty($errors)) {
        $_SESSION['email'] = $email;
        header('Location: index.php');
    }
}
?>

<?php foreach ($errors as $error) { ?>
<div>
    <?php echo $error ?>
</div>
<?php } ?>

<form action="#" method="post">
    <fieldset>
        <legend>Prisijungimas:</legend>
        Paštas : <input type="email" id="email" name="email">
        <br><br>
        Slaptažodis: <input type="password" id="password" name="password">
        <br><br>
        Pareigybe: <select name="job_position" id="id">
            <option value="0">Jusu pareigybe</option>
            <?php foreach ($employers as $employer) { ?>
                <option value="<?php echo $employer['id'] ?>"><?php echo $employer['pareigybe'] ?></option>
            <?php } ?>
        </select>
        <br><br>
        <input type="submit" value="Prisijungti">
        <hr>
    </fieldset>
</form>