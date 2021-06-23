<html>
    <head>
        <title>Add Blog</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">

        <?php
            try
            {
                
                include 'connectdb.php';
                $add=false;
                $connection->beginTransaction();
        
                if (isset($_POST['addBLOG']))
                {   
                    if(isset($_POST['Aname']) && isset($_POST['category']) && isset($_POST['headline']) && isset($_POST['intro']) && isset($_POST['main']) && isset($_POST['subh']) && isset($_POST['conclusion']) && isset($_POST['date']) && isset($_FILES['img']))
                    {
                        $author = $_POST['Aname'];
                        $cate = $_POST['category'];
                        $head = $_POST['headline'];
                        $intro = $_POST['intro'];
                        $main = $_POST['main'];
                        $subh = $_POST['subh'];
                        $con = $_POST['conclusion'];
                        $date = $_POST['date'];
                        $img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
                        
                        $sql = "INSERT INTO blog (Headline,Introduction,Main,SubHeadline,Con, Date,Category,Author,id,pic) 
                        VALUES ('$head','$intro','$main','$subh','$con','$date','$cate','$author',NULL,'$img')";
                        $add= $connection->query($sql);
                        $connection->commit();
        
                        if($add)
                        {
                            echo "<script>alert('Succesfully added new Blog record into database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                        else{
                            echo "<script>alert('Failed to add in new Blog into database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                    }
                }
                else{
                    echo "Error.";
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

            <h1>Add Blog</h1>    
            <div class="containerCS">
                <form method="POST" enctype="multipart/form-data">
                        <label>Author: </label>
                        <input type="text" name="Aname" placeholder="Writer of the blog" required="required">

                        <label>Category: </label><br/>
                        <select name = "category">
                            <option value ="FootCare"> FootCare</option>
                            <option value ="Men"> Men</option>
                            <option value ="Women"> Women</option>
                        </select>

                        <br/>
                        <br/>
                        
                        <label> Headline: </label><br/>
                        <input type="text" name="headline" placeholder="headline" required="required">
                        
                        <br/>
                        <br/>

                        <label> Introduction: </label><br/>
                        <textarea id ="intro" name="intro" placeholder="Introduction of blog" required="required"></textarea>

                        <br/>
                        <br/>

                        <label>Main:</label><br/>
                        <textarea id="maincontent" name="main" placeholder="main content" required="required"></textarea>

                        <br/>
                        <br/>

                        <label>Sub-Headline:</label><br/>
                        <textarea id="subh" name="subh" placeholder="sub-headline" required="required"></textarea>

                        <br/>
                        <br/>

                        <label>Conclusion:</label><br/>
                        <textarea id="conclusion" name="conclusion" placeholder="conclusion" required="required"></textarea>

                        <br/>
                        <br/>

                        <label>Date:</label>
                        <input type="date" name="date" required="required">

                        <br/>
                        <br/>

                        <label>Image in Blog: </label><br/>
                        <input type="file" name="img" id="img">

                        <input type="submit" name="addBLOG" id="addBLOG">  
                </form>
            </div>      
        </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>