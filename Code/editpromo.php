<html>
<head>
    <title>Edit Shoes</title>
    <link rel="stylesheet" href="style/mystyle.css">
    <link rel="stylesheet" href="style/Webstyle.css">

    <?php
        try
        {
            include 'connectdb.php';
            $update = false;
            if(isset($_GET['Sid']))
            {
                $id = $_GET['Sid'];
                $sql = "SELECT shoes.Sid, shoes.Sname, shoes.Spic, shoes.Sprice , shoes_discount.discount_percent, shoes_discount.discount_price, shoes_discount.valid_from, shoes_discount.valid_until FROM shoes RIGHT JOIN shoes_discount ON shoes.Sid=shoes_discount.Sid WHERE shoes_discount.Sid='$id' ORDER BY shoes.Sid";
                $record = $connection->query($sql);
                $record->setFetchMode(PDO::FETCH_ASSOC);
                $data = $record->fetch();
            }
            
            if (isset($_POST['updatepromo']))
            {   
                if(isset($_POST['discount']) && isset($_POST['sdate']) && isset($_POST['Edate']) && isset($_POST['dprice']))
                {
                    $sql = "SELECT * FROM shoes WHERE Sid='$id'";
                    $shoes = $connection->query($sql);
                    $shoes->setFetchMode(PDO::FETCH_ASSOC);
                    $shoesrecord = $shoes->fetch();
                    $discount = $_POST['discount'];
                    $start = $_POST['sdate'];
                    $end = $_POST['Edate'];
                    $dprice = ((100-$discount) * $data['Sprice'])/100 ;
                    $sql = "UPDATE shoes_discount SET discount_percent='$discount',valid_from='$start',valid_until='$end',discount_price='$dprice' WHERE shoes_discount.Sid ='$id'";
                    $update = $connection->query($sql);
                }
                else if(empty($_POST['discount']) || empty($_POST['dprice']))
                {
                    echo "<script>alert('Please fill all attributes below!');</script>";
                }

                if($update)
                {
                    echo "<script>alert('succesfully updated the Promotion record with shoes ID $id');";
                    echo "window.location ='adminpanel.php';</script>";
                }
                else{
                    echo "<script>alert('No changes made to this Promotion record with shoes ID $id');";
                    echo "window.location ='adminpanel.php';</script>";
                }
            }
        }
        catch (PDOException $e)
        {
            echo "<script>alert('Error. Please try again');</script>";
            
        }
    ?>

</head>

<body>
    <div id="main">
        <?php 
            session_start();
            include 'includes/header.php';
        ?>
        <?php include 'includes/navigation.php';?>

            <h2> Edit Promotion detail <?php echo $_GET['Sid'];?></h2>

            <div class = "containerCS">
                <form action="" method="POST">
                    <label>Shoes ID:</label>
                    <input type="number"  name="id"  min="1" value="<?php echo $_GET['Sid'];?>">

                    <label>Discount Percent: </label>
                    <input type="number" id="discount" name="discount" min="0" max="100" require="required" value="<?php echo $data['discount_percent'];?>">

                    <label>Discount Price(RM): </label>
                    <input type="number" id="dprice" name="dprice" value="<?php echo $data['discount_price'];?>" readonly>

                    <label>Starting Date: </label>
                    <input type="date" id="sdate" name="sdate" require="required" value="<?php echo $data['valid_from'];?>">

                    <label>Ending Date: </label>
                    <input type="date" id="Edate" name="Edate"  require="required" value="<?php echo $data['valid_until'];?>">
                    
                    <input type="submit" name="updatepromo" value="Submit">
                </form>
            </div>

    </div>

    <?php include 'includes/footer.php';?>

</body>

</html>