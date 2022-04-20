<?php
//get market id
$id = $_GET['id'] ?? null;
$_SESSION['market'] = $id;
printPre($_SESSION['market']);

//get values from chosen market
$sql = mysqli_query($mysql, "SELECT product_title,parduotuves_prekes.id,parduotuve_id, parduotuves_prekes.price, parduotuves_prekes.expire_date, product_rest FROM warehouse.parduotuves_prekes  join warehouse.produktai on parduotuves_prekes.product_id = produktai.id WHERE parduotuve_id = '$id' ");
$results = mysqli_fetch_all($sql);
printPre($results);

if (isset($_SESSION['market'])) {
    echo 'session is started';

    if (isset($_POST['product_amount'])) {
        $amount = $_POST['product_amount'];
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];

        $product_rest = mysqli_query($mysql, "SELECT product_rest, product_title FROM warehouse.parduotuves_prekes join warehouse.produktai on parduotuves_prekes.id = '$product_id'");
        $product_rest = mysqli_fetch_column($product_rest);


        $date = date('Y-m-d');

        $errors = [];

        $new_market_balance = (int)$product_rest - (int)$amount;
        $sum = number_format(((int)$amount * (float)$price), 2);

        if ($new_market_balance < 1) {
            $errors[] = 'Is not enough products in the market, please choose another one';
        }

        foreach ($errors as $error) { ?>
            <li><?php echo $error ?></li>
        <?php }

        if (empty($errors)) {
            $toCustomer = mysqli_query($mysql, "INSERT INTO warehouse.pirkejai (parduotuve_id, is_paid, paid_data) VALUES ('$id', '$sum', '$date')");

            $update_market_products = mysqli_query($mysql, "UPDATE warehouse.parduotuves_prekes SET product_rest = '$new_market_balance' WHERE parduotuves_prekes.product_id = '$product_id'");

            $customer_result = mysqli_query($mysql, "SELECT pirkejai.id FROM warehouse.pirkejai  where pirkejai.parduotuve_id = '$id'");
            $customer_result = mysqli_fetch_row($customer_result);

            $basket_id = $customer_result[0];
            $_SESSION['user'] = $basket_id;
            printPre($_SESSION['user']);

            if (isset($_SESSION['user'])) {
                echo 'You have added your products';
                $toBasket = mysqli_query($mysql, "INSERT INTO warehouse.krepselio_prekes (basket_id, product_id, amount, sum) VALUES ('$basket_id', '$product_id', '$amount', '$sum' )");
                $basket_cart = mysqli_query($mysql, "SELECT p.product_title, kp.amount, kp.sum from warehouse.krepselio_prekes kp
join warehouse.parduotuves_prekes pp on kp.product_id = pp.id
join warehouse.produktai p on pp.product_id = p.id
where kp.basket_id = {$_SESSION['user']}");
                $basket_values = mysqli_fetch_all($basket_cart, MYSQLI_ASSOC);
                $costs = mysqli_query($mysql, "select sum(sum) as costs from warehouse.krepselio_prekes where basket_id = {$_SESSION['user']} group by basket_id");
                $costs = mysqli_fetch_row($costs);
            }
        }
    }
}
?>
<div class="markets">
    <div class="market_in">
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
                            <form action="index.php?page=shop_products&id=<?php echo $id ?>" method="post">
                                <input type="hidden" name="product_id"
                                       value="<?php echo $result[1] ?>">
                                <input type="hidden" name="price"
                                       value="<?php echo $result[3] ?>">
                                <input type="number" name="product_amount"
                                       placeholder="amount">
                                <input type="submit" value="buy" id="submit">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </fieldset>
        <div class="back">
            <a href="index.php?page=session_off" id="submit">Clear your basket</a>
        </div>
    </div>

    <div class="market_out">
        <fieldset>
            <legend>Your basket</legend>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Amount</th>
                </tr>
                <?php foreach ($basket_values as $value) { ?>
                    <tr>
                        <td><?php echo $value['product_title'] ?></td>
                        <td><?php echo $value['amount'] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td> Your total costs are:
                        <?php echo $costs[0] ?> eu
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
</div>
