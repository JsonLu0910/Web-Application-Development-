<html>
    <head>
        <title>Add FAQ</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">

        <?php
            try
            {
                include 'connectdb.php';
                $connection->beginTransaction();
                $addFaq= false;
        
                if (isset($_POST["addfaq"]))
                {   
                    if(isset($_POST['category']) && isset($_POST['question']) && isset($_POST['answer']))
                    {
                        $category = $_POST['category'];
                        $question = $_POST['question'];
                        $answer = $_POST['answer'];
                        
                        $sql = "INSERT INTO faq (FID,Fcate,Fquestion,Fanswer) VALUES (NULL,'$category','$question','$answer')";
                        $add= $connection->query($sql);
                        $connection->commit();
        
                        if($add)
                        {
                            echo "<script>alert('Succesfully added new FAQ record into database.');";
                            echo "window.location ='adminpanel.php';</script>";
                        }
                        else{
                            echo "<script>alert('Failed to add in new FAQ into database.');";
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

            <h1>Add FAQ</h1>    
            <div class="containerCS">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <label>Question Category</label><br/>
                        <select name = "category">
                            <option value ="ORDER-DELIVERY"> ORDER-DELIVERY</option>
                            <option value ="RETURNS"> RETURNS</option>
                            <option value ="PRODUCT-STOCK"> PRODUCT-STOCK</option>
                        </select>

                        <br/>
                        <br/>

                        <label>Question :</label>
                        <textarea id="question" name="question" placeholder="Your question.."></textarea>

                        <br/>
                        <br/>

                        <label>Answer: </label>
                        <textarea id="answer" name="answer" placeholder="Your question.."></textarea>

                        <br/>

                        <input type="submit" name="addfaq" id="addfaq" value="Submit">  
                </form>
            </div>      

        </div>

        <?php include 'includes/footer.php';?>
    </body>
</html>