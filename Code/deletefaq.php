<?php
    $deletefaq = $_POST['FID'];
    $sql = "DELETE FROM faq WHERE FID=$deletefaq";
    $QnA = $connection->query($sql);
    $sql = "SELECT * FROM faq ORDER BY FID"; 
    $QnA = $connection->query($sql);
    $QnA->setFetchMode(PDO::FETCH_ASSOC);
    echo "<script>alert('Record deleted succesfully');</script>";
?>