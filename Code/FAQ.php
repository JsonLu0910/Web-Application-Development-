<html>
    <head>
        <title>FAQ</title>
	    <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">

        <?php
            include 'connectdb.php';
            $searchval = null;

            if (isset($_GET['searchitem'])) 
            {
                $searchval = strtoupper($_GET['searchitem']);    
            }
            
            if($searchval == null)
            {
                $sql ="SELECT * FROM faq ORDER BY FID";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC);
            }
            else
            {
                // $sql = "SELECT * FROM faq WHERE '$searchval' IN(FID,Fcate,Fquestion,Fanswer) ORDER BY FID"; // display the searching result
                $sql ="SELECT * FROM faq WHERE Fquestion LIKE '%$searchval%' OR Fanswer LIKE '%$searchval%'";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC);
            }
            

            if(isset($_GET['order-delivery']))
            {
                $sql ="SELECT * FROM faq WHERE Fcate = 'ORDER-DELIVERY' ORDER BY FID";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC);
            }
            else if(isset($_GET['Returns']))
            {
                $sql ="SELECT * FROM faq WHERE Fcate = 'RETURNS' ORDER BY FID";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC);
            }
            else if(isset($_GET['Product-Stock']))
            {
                $sql ="SELECT * FROM faq WHERE Fcate = 'PRODUCT-STOCK' ORDER BY FID";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC); 
            }
            else if(isset($_GET['all']))
            {
                $sql ="SELECT * FROM faq ORDER BY FID";
                $display = $connection->query($sql);
                $display->setFetchMode(PDO::FETCH_ASSOC);
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
             <hr>
             <button onclick="topFunction()" id="myBtn" title="Go to top">^</button>
             <h3 style="text-align: center"> How can we help? </h3>
             <h1 style="text-align: center"> Find the right answer</h1>

            <div class = "containers">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <ul class="faq">
                        <li><button type= "submit" name="order-delivery" value="ORDER-DELIVERY">Order-Delivery</button></li>
                        <li><button type= "submit" name="Returns" value="RETURNS">Returns</button></li>
                        <li><button type= "submit" name="Product-Stock" value="PRODUCT-STOCK">Product-Stock</button></li>
                        <li><button type= "submit" name="all" value="all">See All</button></li>
                        <li class="faqsearch"><input type="text" name="searchitem" placeholder="Search.."><button type="submit"><img src="image/search-icon.jpg"></button></li>
                    </ul> 
                </form>

               <?php
                    if($display->rowCount() > 0)
                    {
                        while($faq = $display->fetch())
                        {
                            echo "
                            <button class='question'>".$faq['Fquestion']."</button>
                            <div class='answer'>
                                <p>".$faq["Fanswer"]."</p>
                            </div>";
                        }
                    }
                    else
                        echo "No result found. Try again later.";
                ?>
                <script>
                    var acc = document.getElementsByClassName("question");
                    var i;

                    for (i = 0; i < acc.length; i++) 
                    {
                        acc[i].addEventListener("click", function() 
                        {
                            this.classList.toggle("active");
                            var panel = this.nextElementSibling;
                            if (panel.style.maxHeight) {
                            panel.style.maxHeight = null;
                            } else {
                            panel.style.maxHeight = panel.scrollHeight + "px";
                            } 
                        }
                        );
                    }
                </script>
            </div>
            <script>
                //Get the button
                var mybutton = document.getElementById("myBtn");

                // When the user scrolls down 20px from the top of the document, show the button
                window.onscroll = function() {scrollFunction()};

                function scrollFunction() 
                {
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) 
                    {
                        mybutton.style.display = "block";
                    } else 
                    {
                        mybutton.style.display = "none";
                    }
                }

                // When the user clicks on the button, scroll to the top of the document
                function topFunction() 
                {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                }
            </script>
        </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>