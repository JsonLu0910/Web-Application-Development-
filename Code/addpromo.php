<html>
    <head>
        <title>Add Promotion</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">

        <?php
            try
            {
                include 'connectdb.php';
                $connection->beginTransaction();
                $addpromo= false;
        
                if (isset($_POST["addpromo"]))
                {   
                    if(isset($_POST['id']) && isset($_POST['discount']) && isset($_POST['sdate']) && isset($_POST['Edate']))
                    {
                        $id = $_POST['id'];

                        $sql = "SELECT * FROM shoes WHERE Sid = '$id'";
                        $cal = $connection->query($sql);
                        $cal->setFetchMode(PDO::FETCH_ASSOC);
                        $data = $cal->fetch();
                        $discount = $_POST['discount'];
                        $dprice = ((100-$discount) * $data['Sprice'])/100 ;
                        $start = $_POST['sdate'];
                        $end = $_POST['Edate'];
                        
                        $sql = "INSERT INTO shoes_discount (Sdid,Sid,discount_percent,discount_price,create_date,valid_from, valid_until) VALUES (NULL,'$id','$discount','$dprice','$start','$start','$end')";
                        $add= $connection->query($sql);
                        $connection->commit();
        
                        if($add)
                        {
                            echo "<script>alert('Succesfully added new shoes Promotion record into database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                        else{
                            echo "<script>alert('Failed to add in new Promotion shoes to database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                    }
                }
            }
            catch (PDOException $e)
            {
                echo "<script>alert('Error. Please try again');</script>";
                echo $e;
                
            }
        ?>

    </head>

    <body>
        <div id ="main">
            <?php 
                session_start();
                include 'includes/header.php';
            ?>
            <?php include 'includes/navigation.php';?>

            <h1>Add Promotion's shoes</h1>    
            <div class="containerCS">
                <form action="" method="POST">
                        <label>Shoes ID:</label>
                        <input type="number"  name="id" min="1" placeholder="Shoes ID..." require="required">

                        <label>Discount Percent: </label>
                        <input type="number" id="discount" name="discount" min="0" max="100" require="required">

                        <label>Created Date: </label>
                        <input type="date" id="sdate" name="sdate" require="required">

                        <label>Ending Date: </label>
                        <input type="date" id="Edate" name="Edate"  require="required">
                        
                        <input type="submit" name="addpromo" id="addpromo" value="Submit">
                </form>
            </div>      

        </div>

        <?php include 'includes/footer.php';?>
    </body>
</html>