<?php
$wareWithName = mysqli_query($mysql, "SELECT product_title, product_id, product_rest, sandelis.id FROM warehouse.sandelis join warehouse.produktai on sandelis.product_id = produktai.id");
$results = mysqli_fetch_all($wareWithName, MYSQLI_ASSOC);

$action = $_GET['action'] ?? null;
if ($action == 'delete') {
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
            <th>Product Title</th>
            <th>Product rest</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result['product_title'] ?></td>
            <td><?php echo $result['product_rest'] ?></td>
            <td><a class="order"
                   href="index.php?page=warehouse_products&action=delete&id=<?php echo $result['id'] ?>">Delete</td>
        </tr>
        <?php } ?>
    </table>
</fieldset>
