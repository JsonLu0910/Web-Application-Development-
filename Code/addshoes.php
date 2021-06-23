<html>
    <head>
        <title>Add shoes</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">


        <?php
            try
            {
                include 'connectdb.php';
                $connection->beginTransaction();
                $add= false;
        
                if (isset($_POST["add"]))
                {   
                    if(isset($_POST['name']) && isset($_POST['gender']) && isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_FILES['pic'])
                    && isset($_POST['year']) && isset($_POST['detail']))
                    {
                        $name = $_POST['name'];
                        $gender = $_POST['gender'];
                        $category = $_POST['category'];
                        $brand = $_POST['brand'];
                        $price = $_POST['price'];
                        $detail = $_POST['detail'];
                        $year = $_POST['year'];
                        $pic = addslashes(file_get_contents($_FILES['pic']['tmp_name']));
                        
                        $sql = "INSERT INTO shoes (Sid,Sname, Sgender, Scategory, Sbrand, Spic, Sprice,Sdetails,Syear) VALUES (NULL,'$name','$gender','$category','$brand','$pic','$price','$detail','$year')";
                        $add= $connection->query($sql);
                        $connection->commit();

                        $sql2 = "SELECT Sid, Sgender FROM shoes ORDER BY Sid DESC LIMIT 1";
                        $result = $connection->query($sql2);
                        $row = $result->fetch();
        
                        if($add)
                        {
                            if($row["Sgender"]=="MEN"){
                                    $id = $row['Sid'];
                                    for ($x = 8; $x <= 12; $x+=0.5) {
                            
                                        $sql = $connection->prepare("INSERT INTO `shoes_size` (`SSID`, `Sid`, `Ssize`, `StockQuantity`) VALUES (NULL, '$id', '$x', '10')");
                                        $sql->execute();
                                        }
                                }
                                else if($row["Sgender"]=="WOMEN"){
                                    $id = $row['Sid'];
                                    for ($x = 4; $x <= 8; $x+=0.5) {
                            
                                        $sql = $connection->prepare("INSERT INTO `shoes_size` (`SSID`, `Sid`, `Ssize`, `StockQuantity`) VALUES (NULL, '$id', '$x', '10')");
                                        $sql->execute();
                                        }
                                }
                                else if($row["Sgender"]=="KIDS"){
                                    $id = $row['Sid'];
                                    for ($x = 3.5; $x <= 6; $x+=0.5) {
                            
                                        $sql = $connection->prepare("INSERT INTO `shoes_size` (`SSID`, `Sid`, `Ssize`, `StockQuantity`) VALUES (NULL, '$id', '$x', '10')");
                                        $sql->execute();
                                        }
                                }
                            echo "<script>alert('succesfully add new shoes record into database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                        else{
                            echo "<script>alert('Failed to add in new shoes to database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
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
        <div id ="main">
            <?php 
                session_start();
                include 'includes/header.php';
            ?>
            <?php include 'includes/navigation.php';?>
            <h1>Add shoes</h1>    
            <div class="containerCS">
                <form action="" method="POST" enctype="multipart/form-data">
                        <label>Shoes Name:</label>
                        <input type="text"  name="name"  placeholder="Shoes name..." require="required">

                        <label>Gender: </label>
                        <select name="gender">
                            <option value="MEN">MEN</option>
                            <option value="WOMEN">WOMEN</option>
                            <option value="KIDS">KIDS</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Category: </label>
                        <select name="category">
                            <option value="BASKETBALL">BASKETBALL</option>
                            <option value="CASUAL">CASUAL</option>
                            <option value="RUNNING">RUNNING</option>
                            <option value="SKATE-CANVAS">SKATE-CANVAS</option>
                            <option value="SANDALS-FLIPFLOPS">SANDALS-FLIPFLOPS</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Brand: </label>
                        <select name="brand">
                            <option value="NIKE">Nike</option>
                            <option value="ADIDAS">Adidas</option>
                            <option value="PUMA">Puma</option>
                            <option value="JORDAN">Jordan</option>
                            <option value="CONVERSE">Converse</option>
                            <option value="VANS">Vans</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Price(RM)</label>
                        <input type="number" name="price" placeholder="exp: 369.00" min="0" require="required">

                        <label>Shoes details</label>
                        <input type="text" name="detail" placeholder="exp: black color" require="required" >

                        <label>Release Year</label>
                        <input type="text" name="year" placeholder="exp: 2015" require="required">

                        <label for="pic">Shoes Picture</label><br/>
                        <input type="file" name="pic" id ="pic">
                        
                        <input type="submit" name="add" id="add" value="Submit">
                </form>
            </div>      
        </div>

        <?php include 'includes/footer.php';?>
    </body>
</html>