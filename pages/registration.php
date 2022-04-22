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
        header('Location', 'index.php?page=login' . $email);
    }
foreach ($errors as $error) { ?>
    <ul>
        <?php echo $error ?>
    </ul>
<?php }
}?>


<h1>Register</h1>

<form action="index.php?page=register" method="post">
    <fieldset>
        <legend>Registration:</legend>
        Name: <input type="text" name="name">
        <br><br>
        Job Position : <select name="job_position">
            <option value="0">Job position</option>
            <option value="sandelininkas"<?php
            if (($job ?? null) == 'sandelininkas') {
                echo 'selected';
            } ?>>Warehouse worker
            </option>
            <option value="vadybininkas"<?php
            if (($job ?? null) == 'vadybininkas') {
                echo 'selected';
            } ?>>Market manager
            </option>

        </select>
        <br><br>
        Email : <input type="email" name="email" value="<?php echo $email ?? null ?>"><br><br>
        Password: <input type="password" id="password" name="password">
        <br><br>
        <input type="submit" value="Uzregistruoti" id="submit">
        <hr>
    </fieldset>
</form>
