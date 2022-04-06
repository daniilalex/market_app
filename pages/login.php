<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    if (empty($email) || empty($password)) {
        $errors[] = 'Yra tusciu lauku';
    }
    $sql = "SELECT role_id FROM warehouse.darbuotojai WHERE pastas = '$email'";
    $results = mysqli_query($mysql, $sql);
    $results = mysqli_fetch_assoc($results);

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
        </select>
        <br><br>
        <input type="submit" value="Prisijungti" id="submit">
        <hr>
    </fieldset>
</form>