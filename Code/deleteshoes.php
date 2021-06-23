<?php
    $delete = $_POST['Sid'];
    $sql = "DELETE FROM shoes_discount WHERE Sid=$delete";
    $record = $connection->query($sql);
    $sql = "DELETE FROM shoes WHERE Sid = $delete";
    $record = $connection->query($sql);
    $sql = "SELECT * FROM shoes ORDER BY Sid"; 
    $record = $connection->query($sql);
    $record->setFetchMode(PDO::FETCH_ASSOC);
    echo "<script>alert('Record deleted succesfully');</script>";
?>