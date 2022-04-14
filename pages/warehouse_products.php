<?php
$results = mysqli_query($mysql, "SELECT * FROM warehouse.sandelis");

$action = $_GET['action'] ?? null;

if ($action === 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM warehouse.sandelis WHERE id = '$id'";
    mysqli_query($mysql, $sql);
    header('Location: index.php?page=warehouse_products');
}
?>
<h3>Products inside warehouse</h3>
<fieldset>
    <legend>Warehouse products</legend>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product rest</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result['product_id'] ?></td>
            <td><?php echo $result['product_rest'] ?></td>
            <td><a class="order"
                   href="index.php?page=warehouse_products&action=delete&id=<?php echo $result['id'] ?>">Delete</td>
        </tr>
        <?php } ?>
    </table>
</fieldset>
