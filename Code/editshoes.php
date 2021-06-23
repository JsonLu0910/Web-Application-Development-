<html>
<head>
    <title>Edit Shoes</title>
    <link rel="stylesheet" href="style/mystyle.css">
    <link rel="stylesheet" href="style/Webstyle.css">

    <?php
            include 'connectdb.php';
            $update = false;
            if(isset($_GET['Sid']))
            {
                $id = $_GET['Sid'];
                $sql = "SELECT * from shoes WHERE Sid = $id";
                $record = $connection->query($sql);
                $record->setFetchMode(PDO::FETCH_ASSOC);
                $data = $record->fetch();
            }
            
            if (isset($_POST['update']))
            {   
                if(!empty($_POST['name']) && isset($_POST['gender']) && isset($_POST['category']) && isset($_POST['brand']) && !empty($_POST['price']) && isset($_POST['year'])
                && isset($_POST['detail']))
                {
                    $name = $_POST['name'];
                    $gender = $_POST['gender'];
                    $category = $_POST['category'];
                    $brand = $_POST['brand'];
                    $price = $_POST['price'];
                    $detail = $_POST['detail'];
                    $year = $_POST['year'];
                    $sql = "UPDATE shoes SET Sname='$name',Sgender='$gender',Scategory='$category',Sbrand='$brand',Sprice=$price,Sdetails= '$detail', Syear='$year' where Sid =$id";
                    $update = $connection->query($sql);
                }
                else if(empty($_POST['name']) || empty($_POST['price']) || empty($_POST['detail']) || empty($_POST['year']))
                {
                    echo "<script>alert('all field cannot be blank!');</script>";
                }

                if($update)
                {
                    echo "<script>alert('succesfully updated the record with shoes ID $id');";
                    echo "window.location ='adminpanel.php';</script>";
                }
                else{
                    echo "<script>alert('No changes made to this record with shoes ID $id');";
                    echo "window.location ='adminpanel.php';</script>";
                }
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

            <h2> Edit shoes detail <?php echo $_GET['Sid']?></h2>

            <div class = "containerCS">
                <form action="" method="POST">
                        <label>Shoes Name:</label>
                        <input type="text"  name="name"  value="<?php echo $data['Sname'];?>">

                        <label>Gender: </label>
                        <select name="gender">
                            <option value="MEN" <?php if($data['Sgender']=="MEN") echo 'selected="selected"'; ?>>MEN</option>
                            <option value="WOMEN"<?php if($data['Sgender']=="WOMEN") echo 'selected="selected"'; ?>>WOMEN</option>
                            <option value="KIDS"<?php if($data['Sgender']=="KIDS") echo 'selected="selected"'; ?>>KIDS</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Category: </label>
                        <select name="category">
                            <option value="BASKETBALL"<?php if($data['Scategory']=="BASKETBALL") echo 'selected="selected"'; ?>>BASKETBALL</option>
                            <option value="CASUAL"<?php if($data['Scategory']=="CASUAL") echo 'selected="selected"'; ?>>CASUAL</option>
                            <option value="RUNNING"<?php if($data['Scategory']=="RUNNING") echo 'selected="selected"'; ?>>RUNNING</option>
                            <option value="SKATE-CANVAS"<?php if($data['Scategory']=="SKATE-CANVAS") echo 'selected="selected"'; ?>>SKATE-CANVAS</option>
                            <option value="SANDALS-FLIPFLOPS"<?php if($data['Scategory']=="SANDALS-FLIPFLOPS") echo 'selected="selected"'; ?>>SANDALS-FLIPFLOPS</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Brand: </label>
                        <select name="brand">
                            <option value="NIKE"<?php if($data['Sbrand']=="NIKE") echo 'selected="selected"'; ?>>Nike</option>
                            <option value="ADIDAS"<?php if($data['Sbrand']=="ADIDAS") echo 'selected="selected"'; ?>>Adidas</option>
                            <option value="PUMA"<?php if($data['Sbrand']=="PUMA") echo 'selected="selected"'; ?>>Puma</option>
                            <option value="JORDAN"<?php if($data['Sbrand']=="JORDAN") echo 'selected="selected"'; ?>>Jordan</option>
                            <option value="CONVERSE"<?php if($data['Sbrand']=="CONVERSE") echo 'selected="selected"'; ?>>Converse</option>
                            <option value="VANS"<?php if($data['Sbrand']=="VANS") echo 'selected="selected"'; ?>>Vans</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Price(RM)</label>
                        <input type="text" name="price" value="<?php echo $data['Sprice']?>" >

                        <label>Shoes details</label>
                        <input type="text" name="detail" value="<?php echo $data['Sdetails']?>" >

                        <label>Release Year</label>
                        <input type="text" name="year" value="<?php echo $data['Syear']?>" >

                        <label>Shoes Picture</label><br/>
                        <input type="file" name="PIC" accept="image/*">
                        
                        <input type="submit" name="update" value="Submit">
                </form>
            </div>

    </div>

    <?php include 'includes/footer.php';?>

</body>

</html>