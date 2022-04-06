<?php
if (isset($_POST['email'])) {
    $name = $_POST['name'];
    $job = $_POST['job_position'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Neteisingas el. pastas';
    }
    if (!preg_match('/[A-Za-z]/', $pass) || !preg_match('/[0-9]/', $pass)) {
        $errors[] = 'slaptazodyje turi buti raide ir skaicius';
    }
    if (strlen($name) < 3 || strlen($name) > 60) {
        $errors[] = 'vardas yra per ilgas arba per trumpas';
    }

    if ($email == $pass) {
        $errors[] = 'slaptazodis ir emailas negali buti vienodi';
    }
    $checkEmail = mysqli_query($mysql, "select * from warehouse.darbuotojai where pastas = '$email'");
    $checkEmail = mysqli_fetch_row($checkEmail);

    if ($checkEmail != null) {
        $errors[] = 'Pastas uzimtas';
    }
    if (empty($errors)) {
        $sql = "INSERT INTO warehouse.darbuotojai (vardas, role_id, pastas, slaptazodis) VALUES ('$name', '$job', '$email', '$pass')";
        mysqli_query($mysql, $sql);
        header('Location', 'index.php');
    }
}
?>
<h1>Register</h1>
<?php foreach ($errors as $error) { ?>
    <ul>
        <?php echo $error ?>
    </ul>
<?php } ?>

<form action="#" method="post">
    <fieldset>
        <legend>Registracija:</legend>
        Vardas : <input type="text" id="name" name="name">
        <br><br>
        Pareigybe : <select name="job_position" id="job_position">
            <option value="0">Jusu pareigybe</option>
            <option value="sandelininkas"<?php
            if (($job ?? null) == 'sandelininkas') {
                echo 'selected';
            } ?>>Sandelininkas
            </option>
            <option value="vadybininkas"<?php
            if (($job ?? null) == 'vadybininkas') {
                echo 'selected';
            } ?>>Vadybininkas
            </option>

        </select>
        <br><br>
        Pastas : <input type="email" name="email"><br><br>
        Slaptažodis: <input type="password" id="password" name="password">
        <br><br>
        <input type="submit" value="Uzregistruoti" id="submit">
        <hr>
    </fieldset>
</form>
