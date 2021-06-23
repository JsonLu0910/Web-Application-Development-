<?php
    $deleteblog = $_POST['bid'];
    $sql = "DELETE FROM blog WHERE id=$deleteblog";
    $BG = $connection->query($sql);
    $sql = "SELECT id,Headline,pic,Author,Date,Category,Con FROM blog";
    $BG = $connection->query($sql);
    $BG->setFetchMode(PDO::FETCH_ASSOC);
    echo "<script>alert('Record deleted succesfully');</script>";
?>