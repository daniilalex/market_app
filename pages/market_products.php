<?php
$sql = mysqli_query($mysql, "SELECT pavadinimas, adresas, product_title, parduotuves_prekes.price from warehouse.parduotuves_prekes join warehouse.parduotuve on parduotuves_prekes.parduotuve_id = parduotuve.id join warehouse.produktai on parduotuves_prekes.produkto_id");
$results = mysqli_fetch_all($sql);

?>

<fieldset>
    <legend>Markets information</legend>
    <table>
        <th>Market</th>
        <th>Products</th>
        <th>Price</th>

        <?php foreach ($results as $result) { ?>
                <tr>
            <td><?php echo $result[0] ?></td>
            <td><?php echo $result[2] ?></td>
            <td><?php echo $result[3] ?></td>
                </tr>
       <?php } ?>
    </table>
</fieldset>
