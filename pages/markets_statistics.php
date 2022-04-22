<?php
$sql = mysqli_query($mysql, "SELECT SUM(sum) as costs FROM warehouse.pirkejai
join warehouse.krepselio_prekes on pirkejai.id = krepselio_prekes.basket_id
join warehouse. parduotuve on pirkejai.parduotuve_id = parduotuve.id
WHERE parduotuve_id = 1;");
$markets1 = mysqli_fetch_column($sql);

$sql = mysqli_query($mysql, "SELECT  SUM(sum) as costs FROM warehouse.pirkejai
join warehouse.krepselio_prekes on pirkejai.id = krepselio_prekes.basket_id
join warehouse. parduotuve on pirkejai.parduotuve_id = parduotuve.id
WHERE parduotuve_id = 6;");
$markets2 = mysqli_fetch_column($sql);

$sql = mysqli_query($mysql, "SELECT SUM(sum) as costs FROM warehouse.pirkejai
join warehouse.krepselio_prekes on pirkejai.id = krepselio_prekes.basket_id
join warehouse. parduotuve on pirkejai.parduotuve_id = parduotuve.id
WHERE parduotuve_id = 9;");
$markets3 = mysqli_fetch_column($sql);

$sql = mysqli_query($mysql, "SELECT SUM(sum) as costs FROM warehouse.pirkejai
join warehouse.krepselio_prekes on pirkejai.id = krepselio_prekes.basket_id
join warehouse. parduotuve on pirkejai.parduotuve_id = parduotuve.id
WHERE parduotuve_id = 25;");
$markets4 = mysqli_fetch_column($sql);

$sql = mysqli_query($mysql, "SELECT SUM(krepselio_prekes . amount) as popular_product, krepselio_prekes . product_id
FROM warehouse . pirkejai
         join warehouse . krepselio_prekes on pirkejai . id = krepselio_prekes . basket_id
         join warehouse.parduotuve p on pirkejai . parduotuve_id = p.id
where p . id = 1
group by krepselio_prekes . product_id
order by popular_product desc
LIMIT 1");
$product1 = mysqli_fetch_row($sql);

$sql = mysqli_query($mysql, "SELECT SUM(krepselio_prekes . amount) as popular_product, krepselio_prekes . product_id
FROM warehouse . pirkejai
         join warehouse . krepselio_prekes on pirkejai . id = krepselio_prekes . basket_id
         join warehouse.parduotuve p on pirkejai . parduotuve_id = p.id
where p . id = 6
group by krepselio_prekes . product_id
order by popular_product desc
LIMIT 1");
$product2 = mysqli_fetch_row($sql);

$sql = mysqli_query($mysql, "SELECT SUM(krepselio_prekes . amount) as popular_product, krepselio_prekes . product_id
FROM warehouse . pirkejai
         join warehouse . krepselio_prekes on pirkejai . id = krepselio_prekes . basket_id
         join warehouse.parduotuve p on pirkejai . parduotuve_id = p.id
where p . id = 9
group by krepselio_prekes . product_id
order by popular_product desc
LIMIT 1");
$product3 = mysqli_fetch_row($sql);

$sql = mysqli_query($mysql, "SELECT SUM(krepselio_prekes . amount) as popular_product, krepselio_prekes . product_id
FROM warehouse . pirkejai
         join warehouse . krepselio_prekes on pirkejai . id = krepselio_prekes . basket_id
         join warehouse.parduotuve p on pirkejai . parduotuve_id = p.id
where p . id = 25
group by krepselio_prekes . product_id
order by popular_product desc
LIMIT 1");
$product4 = mysqli_fetch_row($sql);

?>

<fieldset>
    <legend>Markets profit</legend>
    <table>
        <tr>
            <th>Maxita</th>
            <th>Sveikas maistas</th>
            <th>RIO pasazas</th>
            <th>Trololo</th>
        </tr>
        <tr>
            <td><?php echo $markets1 ?> eu</td>
            <td><?php echo (float)$markets2 ?> eu</td>
            <td><?php echo $markets3 ?> eu</td>
            <td><?php echo $markets4 ?> eu</td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <legend>Popular product</legend>
    <table>
        <tr>
            <th></th>
            <th>Product id</th>
            <th>sold</th>
        </tr>
        <tr>
            <td>Maxita</td>
            <td><?php echo $product1[1] ?></td>
            <td><?php echo $product1[0] ?> pieces</td>
        </tr>
        <tr>
            <td>Sveikas maistas</td>
            <td><?php echo $product2[1] ?></td>
            <td><?php echo $product2[0] ?> pieces</td>
        </tr>
        <tr>
            <td>RIO pasazas</td>
            <td><?php echo $product3[1] ?></td>
            <td><?php echo $product3[0] ?> pieces</td>
        </tr>
        <tr>
            <td>Trololo</td>
            <td><?php echo $product4[1] ?></td>
            <td><?php echo $product4[0] ?> pieces</td>
        </tr>
    </table>
</fieldset>
