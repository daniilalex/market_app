<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = 'There are empty spaces';
    }
    $sql = "SELECT role_id FROM warehouse.darbuotojai WHERE pastas = '$email'";
    $results = mysqli_query($mysql, $sql);
    $results = mysqli_fetch_assoc($results);

    if (empty($errors)) {
        $_SESSION['email'] = $email;
        header('Location: index.php');
    }

    foreach ($errors as $error) { ?>
        <div>
            <?php echo $error ?>
        </div>
    <?php }
} ?>


<form action="index.php?page=login" method="post">
    <fieldset>
        <legend>Log in:</legend>
        Email : <input type="email" id="email" name="email" value="<?php echo $_GET['email'] ?? null ?>">
        <br><br>
        Password: <input type="password" id="password" name="password">
        <br><br>
        </select>
        <br><br>
        <input type="submit" value="Log in" id="submit">
        <hr>
    </fieldset>
</form>