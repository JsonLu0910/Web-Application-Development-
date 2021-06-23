<?php
    $delpromo = $_POST['Sid'];
    $sql = "DELETE FROM shoes_discount WHERE Sid = $delpromo";
    $p = $connection->query($sql);
    $sql = "SELECT shoes.Sid, shoes.Sname, shoes.Spic, shoes.Sprice , shoes_discount.discount_percent, shoes_discount.discount_price, shoes_discount.valid_from, shoes_discount.valid_until FROM shoes RIGHT JOIN shoes_discount ON shoes.Sid=shoes_discount.Sid ORDER BY shoes.Sid"; 
    $p = $connection->query($sql);
    $p->setFetchMode(PDO::FETCH_ASSOC);
    echo "<script>alert('Promotion Record deleted succesfully');</script>";
?>