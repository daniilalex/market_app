<?php
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];

    $sql = "INSERT INTO warehouse.parduotuve (pavadinimas, adresas) VALUES ('$name', '$address')";
    mysqli_query($mysql, $sql);
}


$sql_shop = mysqli_query($mysql, "SELECT * FROM warehouse.parduotuve");
$shops = mysqli_fetch_all($sql_shop, MYSQLI_ASSOC);
?>

<h1>Market Places</h1>

<fieldset>
    <legend>Our partners</legend>
    <table>
        <tr>
            <th>Market Name</th>
            <th>Address</th>
        </tr>
        <?php
        foreach ($shops as $shop) { ?>
            <tr>
                <td><a href="index.php?page=shop_products&id=<?php echo $shop['id'] ?>"><?php echo $shop['pavadinimas'] ?></a></td>
                <td><?php echo $shop['adresas'] ?></td>
            </tr>
        <?php } ?>
    </table>
</fieldset>
<br><br>
<form action="index.php" method="post">
    <input type="text" name="name" placeholder="market name"><br><br>
    <input type="text" name="address" placeholder="address"><br><br>
    <input type="submit" value="create market" id="submit">
</form>

