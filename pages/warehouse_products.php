<?php
$results = mysqli_query($mysql, "SELECT * FROM warehouse.sandelis");

?>
<h3>Products inside warehouse</h3>
<fieldset>
    <legend>Warehouse products</legend>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product rest</th>
        </tr>
        <?php foreach ($results as $result) { ?>
        <tr>
            <th><?php echo $result['product_id'] ?></th>
            <th><?php echo $result['product_rest'] ?></th>
        </tr>
        <?php } ?>
    </table>
</fieldset>
