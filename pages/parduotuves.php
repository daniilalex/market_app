<?php

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];

    $sql = "INSERT INTO warehouse.parduotuve (pavadinimas, adresas) VALUES ('$name', '$address')";
    mysqli_query($mysql, $sql);
}

$id = $_GET['id'] ?? null;
$sql_shop = mysqli_query($mysql, "SELECT * FROM warehouse.parduotuve");
$shops = mysqli_fetch_all($sql_shop, MYSQLI_ASSOC);
var_dump($shops);


?>

<h1>Market Places</h1>

<fieldset>
    <legend>Musu Partneriai</legend>
    <table>
        <tr>
            <th>Pavadinimas</th>
            <th>Adresas</th>
        </tr>
        <!--        <tr>-->
        <!--            <form action="index.php" method="get">-->
        <!--                <input type="hidden" name="page" value="shop">-->
        <!--                <select name="shop_id">-->
        <!--                    <option value="0">Choose market:</option>-->
        <!--                    --><?php
        //                    foreach ($shops as $shop) {
        //                        ?>
        <!--                        <option value="--><?php //echo $shop['id'] ?><!--">-->
        <?php //echo $shop['pavadinimas'] ?><!--</option>-->
        <!--                    --><?php //} ?>
        <!--                </select><br><br>-->
        <!--                <input type="submit" value="Select market" id="submit">-->
        <!---->
        <!--            </form>-->
        <!--        </tr>-->
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
    <input type="text" name="name" placeholder="parduotuves pavadinimas"><br><br>
    <input type="text" name="address" placeholder="adresas"><br><br>
    <input type="submit" value="sukurti parduotuve" id="submit">
</form>

<!--select parduotuves_prekes.product_rest, count(*), product_id from parduotuves_prekes join parduotuve p on parduotuves_prekes.parduotuve_id = p.id where parduotuve_id = 1 group by product_id;-->
<!--SELECT COUNT(DISTINCT parduotuves_prekes.product_rest)-->
<!--FROM warehouse.parduotuves_prekes-->
