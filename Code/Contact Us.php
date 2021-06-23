<html>
    <head>
        <title>Contact Us</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">
    </head>
    <body>

        <?php
            $nameErr = $emailErr = $phoneErr = $subErr = $desErr= "";
            $currentdate = date("Y-m-d");

            function notifyUserfunction($msg) 
            {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }

            if(isset($_POST['submit']))
            {
                include 'connectdb.php';

                if (empty($_POST['fullname'])) 
                {
                    $nameErr = "Name is required";
                }
                else 
                {
                    $name =$_POST['fullname'];
                }

                if (empty($_POST['phoneno']))
                {
                    $phoneErr = "Phone number is empty";
                }
                else
                {
                     $phone =$_POST['phoneno'];
                }

                if (empty($_POST['email'])) 
                {
                    $emailErr = "Email is required";
                } 
                else 
                {
                    $email =$_POST['email'];
                }

                if (empty($_POST['subject'])) 
                {
                    $subErr = "subject is empty";
                } 
                else 
                {
                    $subject =$_POST['subject'];
                }

                if(empty($_POST['Description']))
                {
                    $desErr = "description is empty";
                }
                else
                {
                    $description =$_POST["Description"];
                }

                if(!empty($_POST['fullname']) && !empty($_POST['phoneno']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['Description']))
                {
                    $newform = $connection -> exec ("insert into contact_us (CSID,name,phone,email,subject,description,status,date) values (null,'$name','$phone','$email', '$subject','$description','uncheck','$currentdate')");
                    
                    notifyUserfunction("Your query will be review soon by our staff. Thank you.");
                }
                
            }
        ?>

        <div id ="main">
            <?php 
                session_start();
                include 'includes/header.php';
            ?>
            <?php include 'includes/navigation.php';?>
	    <hr>
            <p class="AU"> Shoester's Customer Service team are always ready to let our customer a hand. You can just contact Us based on the method below:</p>
            <p class="AU"><strong> By Email:</strong> <a href="mailto:low.ch.wan@gmail.com">customercare@gmail.com</a></p>

            <h2> By Phone:</h2>
            <p class="AU"> For Customer care enquiry, Please call: +6019-45678910</p>
            <p class="AU"> 9.00 A.M. - 8.00 P.M (Monday to Saturday, excluded Public Holidays)</p>
            <p class="AU"> Calls are charged at your standard network rate and may be recorded for training purposes.</p>

            <h2>Contact Form</h2>
            <div class="containerCS">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <label for="fname">Full Name:</label>
                    <input type="text" id="fname" name="fullname"  placeholder="Your name..(No symbol)">
                    <span class="error">* <?php echo $nameErr;?></span><br/><br/>

                    <label for="phoneno">Phone number:</label>
                    <input type="text" id="phoneno" name="phoneno"  placeholder=" exp: 0123456789">
                    <span class="error">* <?php echo $phoneErr;?></span><br/><br/>

                    <label for="Femail">Email Address:</label>
                    <input type="email" id="Femail" name="email" placeholder="xxx@gmail.com">
                    <span class="error">* <?php echo $emailErr;?></span><br/><br/>

                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" placeholder="purpose of query">
                    <span class="error">* <?php echo $subErr;?></span><br/><br/>

                    <label for="Description">Description:</label><br/>
                    <textarea id="Description" name="Description" placeholder="Write something.."></textarea>
                    <span class="error">* <?php echo $desErr;?></span><br/><br/>
            
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </div>

        <?php include 'includes/footer.php';?>

    </body>
</html>