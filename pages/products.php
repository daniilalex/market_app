<?php
$results = mysqli_query($mysql, "SELECT * FROM warehouse.produktai");
$secondResults = mysqli_fetch_array($results);

$action = $_GET['action'] ?? null;
if ($action === 'insert') { ?>
    <h1>Your choice is done</h1>
<?php } else { ?>
    <h1>Please insert a product</h1>
<?php }
if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $name = $_POST['title'];
    $price = $_POST['price'];
    $expire_date = $_POST['expire_date'];
    $errors = [];

    if ($name === $secondResults['product_title']) {
        $errors[] = 'This product exist';
    }

    if (empty($errors)) {
        $sql = "INSERT INTO warehouse.produktai (category, product_title, price, expire_date) VALUES ('$category', '$name', '$price', '$expire_date')";
        mysqli_query($mysql, $sql);
    }
    foreach ($errors as $error) { ?>
        <li>
            <?php echo $error ?>
        </li>
    <?php }

} else if ($action === 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM warehouse.produktai WHERE id = '$id'";
    mysqli_query($mysql, $sql);
} else if ($action === 'order') {
    $id = $_GET['id'];
    $rest = $_POST['product_amount'];
    $errors = [];

    if ($rest < 1) {
        $errors[] = 'Please insert more products';
    }
    if (empty($errors)) {
        $sql = "INSERT INTO warehouse.sandelis (product_id, product_rest) VALUES ('$id', '$rest')";
        mysqli_query($mysql, $sql);
    }
    foreach ($errors as $error) { ?>
        <li>
            <?php echo $error ?>
        </li>
    <?php }
} ?>
<h3>Insert Products</h3>
<div class="product">
    <form action="index.php?page=products&action=insert" method="post">
        <select name="category" id="category">
            <option value="0">Choose your category:</option>
            <option value="1">Food</option>
            <option value="2">Fruits</option>
            <option value="3">Drinks</option>
            <option value="3">Clothes</option>
            <option value="3">Electronics</option>
        </select><br><br>
        <input type="text" name="title" placeholder="product title" value=""><br><br>
        <input type="text" name="price" placeholder="price"><br><br>
        <input type="text" name="expire_date" placeholder="expire date"><br><br>
        <input type="submit" value="insert" id="submit">
    </form>
</div>
<hr>
<div class="table">
    <h1>Products</h1>
    <table>
        <tr>
            <th>Product category</th>
            <th>Product title</th>
            <th>Price</th>
            <th>Expire date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $result) { ?>
            <tr>
                <td><?php echo $result['category'] ?></td>
                <td><?php echo $result['product_title'] ?></td>
                <td><?php echo $result['price'] ?> eu</td>
                <td><?php echo $result['expire_date'] ?></td>
                <td>
                    <form action="index.php?page=products&action=order&id=<?php echo $result['id'] ?>" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $result['id'] ?>">
                        <input type="number" name="product_amount" value="amount" placeholder="amount">
                        <input type="submit" value="add to warehouse" id="submit">
                    </form>
                </td>
                <td><a class="order"
                       href="index.php?page=products&action=delete&id=<?php echo $result['id'] ?>">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<br>

