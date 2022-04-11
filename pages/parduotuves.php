<?php
$results = mysqli_query($mysql, "SELECT * FROM warehouse.parduotuve");

if (isset($_POST['name'])) {
    var_dump($_POST);
    $name = $_POST['name'];
    $address = $_POST['address'];

    $sql = "INSERT INTO warehouse.parduotuve (pavadinimas, adresas) VALUES ('$name', '$address')";
     mysqli_query($mysql, $sql);
    $results = mysqli_fetch_assoc($results);
    var_dump($results);
}
?>

<h1>Market Places</h1>

<fieldset>
    <legend>Musu Partneriai</legend>
    <table>
        <tr>
            <th>Pavadinimas</th>
            <th>Adresas</th>
        </tr>
            <?php
            foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result['pavadinimas'] ?></td>
            <td><?php echo $result['adresas'] ?></td>
        </tr>
        <?php } ?>
    </table>
</fieldset>
<br><br>
<form action="index.php" method="post">
    <input type="text" name="name" placeholder="parduotuves pavadinimas"><br><br>
    <input type="text" name="address" placeholder="adresas"><br><br>
    <input type="submit" value="sukurti parduotuve" id="submit">
</form>
