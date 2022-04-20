<?php
//take products from warehouse and products tables
$products = mysqli_query($mysql, "SELECT sandelis.product_id, produktai.product_title,produktai.price,produktai.expire_date, sandelis.product_rest FROM  warehouse.sandelis join warehouse.produktai on sandelis.product_id = produktai.id");
$products = mysqli_fetch_all($products, MYSQLI_ASSOC);
//take markets value
$markets = mysqli_query($mysql, "SELECT parduotuve.id, parduotuve.pavadinimas FROM warehouse.parduotuve");
$markets = mysqli_fetch_all($markets, MYSQLI_ASSOC);

if (isset($_POST['product_id'])) {
    //take one product values which I have chosen
    $product = "SELECT * FROM warehouse.produktai WHERE produktai.id = {$_POST['product_id']}";
    $product = mysqli_fetch_row(mysqli_query($mysql, $product));

//    take the products rest from warehouse which I have chosen
    $warehouseRest = mysqli_query($mysql, "SELECT sandelis.product_rest FROM warehouse.sandelis join warehouse.produktai on sandelis.product_id = {$_POST['product_id']}");
    $warehouseRest = mysqli_fetch_column($warehouseRest);

//post method
    $market_id = $_POST['market_id'];
    $product_id = $_POST['product_id'];
    $product_amount = $_POST['product_rest'];
    $price = $product[3];
    $errors = [];
    $today = date('Y-m-d');
    $toExpire = date('Y-m-d', strtotime('+ ' . $product[4] . 'days'));
    printPre($product[4]);

//take margin value from table
    $discount = mysqli_query($mysql, "SELECT * FROM warehouse.parduotuves_marza WHERE parduotuves_id = '$market_id'");
    $margins = mysqli_fetch_all($discount, MYSQLI_ASSOC);

//create new variables for checks
    $product_title = $product[2];
    $category = $product[1];

    foreach ($margins as $margin) {

        if ($category == 'fruits' && $margin['type'] == 'banana') {
            $price = number_format($price * ($price / 100 * $margin['marza']), 2);
            printPre($price);

        } else if ($category == 'drinks' && $margin['type'] == 'coca_cola') {
            $price = number_format($price * ($price / 100 * $margin['marza']), 2);
            printPre($price);

        } else if ($product_title == 'banana' && $margin['type'] == 'banana') {
            $price = number_format($price * ($price / 100 * $margin['marza']), 2);
            printPre($price);

        } else if ($category == 'food' && $margin['type'] == 'expired') {
            $price = number_format($price * ($price / 100 * $margin['marza']), 2);
            printPre($price);
        }
    }

//take value 'expired' from markets
    $sql_margin = mysqli_query($mysql, "SELECT parduotuves_marza.parduotuves_id, marza FROM warehouse.parduotuves_marza WHERE type = 'expired'");
    $shop_margins = mysqli_fetch_all($sql_margin, MYSQLI_ASSOC);

//with a loop I update products price in the markets.
    //update product utilize in utilize column
    foreach ($shop_margins as $margin) {

        $sql_expired = mysqli_query($mysql, "UPDATE warehouse.parduotuves_prekes SET price = (price / 100 * {$margin['marza']}) WHERE parduotuve_id = {$margin['parduotuves_id']} and expire_date = '$today'");

        $sql_utilize = mysqli_query($mysql, "UPDATE warehouse.parduotuves_prekes SET utilize = 1 WHERE expire_date = '$today' < '$toExpire' and utilize = 0 and parduotuve_id = {$margin['parduotuves_id']}");
    }

    if ($product_amount == '') {
        $errors[] = 'You have not select an amount';
    }
    if ($product_id == null) {
        $error[] = 'Please select a product';
    }

    foreach ($errors as $error) { ?>
        <li><?php echo $error ?></li>
    <?php }

    if (empty($errors)) {
        $newBalance = (int)$warehouseRest - (int)$product_amount;

        $toShop = "INSERT INTO warehouse.parduotuves_prekes (parduotuve_id, product_id, product_rest, price, expire_date) VALUES ('$market_id', '$product_id', '$product_amount', ' $price', '$toExpire')";
        mysqli_query($mysql, $toShop);

        $updateWarehouse = "UPDATE warehouse.sandelis SET product_rest = '$newBalance' WHERE sandelis.product_id = '$product_id'";
        mysqli_query($mysql, $updateWarehouse);
    }
} ?>


<h3>Market products</h3>
<hr>
<form action="index.php?page=to_market" method="post">
    <select name="market_id" id="id">
        <option value="0">Choose market:</option>
        <?php foreach ($markets as $market) { ?>
            <option value="<?php echo $market['id'] ?>"><?php echo $market['pavadinimas'] ?></option>
        <?php } ?>
    </select><br><br>
    <select name="product_id">
        <option value="0">Choose product:</option>
        <?php foreach ($products as $product) { ?>
            <option value="<?php echo $product['product_id'] ?>"><?php echo $product['product_title'] ?>
                (<?php echo $product['product_rest'] ?>)
            </option>
        <?php } ?>
    </select><br><br>
    <input type="number" name="product_rest" placeholder="product amount"><br><br>
    <input type="submit" value="make order" id="submit">
</form>

