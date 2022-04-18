<?php
//get market id
$id = $_GET['id'] ?? null;
//get values from form
$sql = mysqli_query($mysql, "SELECT product_title,product_id,parduotuve_id, parduotuves_prekes.price, parduotuves_prekes.expire_date, product_rest FROM warehouse.parduotuves_prekes  join warehouse.produktai on parduotuves_prekes.product_id = produktai.id WHERE parduotuve_id = '$id' ");
$results = mysqli_fetch_all($sql);

    $customers = $_POST['customer'];
    foreach ($customers as $customer) {
        printPre($customer);
    }
if (isset($_POST['product_amount'])) {

    $amount = $_POST['product_amount'];
    $product_id = $_POST['product_id'];
    $product = mysqli_query($mysql, "SELECT pavadinimas, parduotuve_id, product_id, price,expire_date FROM warehouse.parduotuves_prekes join warehouse.parduotuve p on p.id = parduotuves_prekes.parduotuve_id where parduotuve_id = '$id'");
    $product = mysqli_fetch_row($product);

//    printPre($product);
    $product_rest = mysqli_query($mysql, "SELECT product_rest, product_title FROM warehouse.parduotuves_prekes join warehouse.produktai on product_id = '$product_id'");
    $product_rest = mysqli_fetch_column($product_rest);
//    var_dump($product_rest);
    $date = date('Y-m-d');
    $price = number_format($product[3], 2);
    $errors = [];
//    var_dump($price);
    $new_market_balance = (int)$product_rest - (int)$amount;
    $sum = (int)$amount * (int)$price;

    if ($new_market_balance < 1) {
        $errors[] = 'Is not enough products in the market, please choose another one';
    }

    foreach ($errors as $error) { ?>
        <li><?php echo $error ?></li>
    <?php }

    if (empty($errors)) {

        $toCustomer = mysqli_query($mysql, "INSERT INTO warehouse.pirkejai (parduotuve_id, is_paid, paid_data) VALUES ('$id', '$sum', '$date')");

        $update_market_products = mysqli_query($mysql, "UPDATE warehouse.parduotuves_prekes SET product_rest = '$new_market_balance' WHERE parduotuves_prekes.product_id = '$product_id'");

    }
}
?>

    <fieldset>
        <legend>Markets information</legend>
        <table>
            <th>Products</th>
            <th>Price</th>
            <th>Expire date</th>
            <th>Rest</th>
            <th>Buy</th>


            <?php foreach ($results as $result) { ?>
                <tr>
                    <td><?php echo $result[0] ?></td>
                    <td><?php echo $result[3] ?></td>
                    <td><?php echo $result[4] ?></td>
                    <td><?php echo $result[5] ?></td>
                    <td>
                        <input type="hidden" name="customer[<?php echo $result[1] ?>][product_id]"
                               value="<?php echo $result[1] ?>">
                        <input type="hidden" name="customer[<?php echo $result[1] ?>][price]"
                               value="<?php echo $result[3] ?>">
                        <input type="number" name="customer[<?php echo $result[1] ?>][product_amount]"
                               placeholder="amount">
                    </td>
                </tr>
            <?php } ?>
        </table>
    </fieldset>
    <input type="submit" value="buy" id="submit">
</form>
