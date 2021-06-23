<html>
    <head>
        <title>Footwear - Shoester Malaysia</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">
        <link rel="stylesheet" href="style/footwearstyle.css">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <script>
            function enableAddToCartbtn(){
                const x = document.getElementById("btn-cart");
                x.disabled = false;
                x.className = x.className.replace(" disable", " enable");
            }
        </script>
        <?php include 'connectdb.php';?>
        <?php
            $sid=null;
            if (isset($_GET['sid'])) {
                $sid = $_GET['sid'];}

            $currentTime = date("Y-m-d");
            $sql = "SELECT * From shoes LEFT JOIN shoes_discount ON shoes.Sid = shoes_discount.Sid AND 
            shoes_discount.valid_from <= '$currentTime'AND shoes_discount.valid_until > '$currentTime' WHERE shoes.Sid = '$sid'";

            $sql2 = "SELECT * From shoes_size WHERE shoes_size.Sid = '$sid'";
            $sql3 = "SELECT * From shoes_review WHERE shoes_review.Sid = '$sid' ORDER BY shoes_review.ReviewDate DESC";

            $result = $connection->query($sql);
            $result2 = $connection->query($sql2);
            $result3 = $connection->query($sql3);
            $shoe = $result->fetch();

        ?>
    </head>

    <body>
        <div id="main">
            <header class='header'>
                <?php 
                    session_start();
                    include 'includes/header.php';
                ?>
                <?php include 'includes/navigation.php';?>
            </header>
            <hr>
            <div class="card-wrapper">
                <div class="card">
                    <!-- card upper left -->
                    <div id="product-image"class="product-image">
                        <?php echo "<img src='data:image/png;base64,".base64_encode( $shoe['Spic'] )."' alt=''>";?>
                        <hr>
                    </div>
                    


                    <!-- card right -->
                    <div id="product-content"class="product-content">
                        <?php echo"<img class='brand-image' src='image/brand/".$shoe["Sbrand"].".jpg' alt=''>";?>
                        <?php echo"<h2 class='product-title'>".$shoe["Sname"]."</h2>";?>
                        <div class="product-price">
                            <?php
                                if($shoe["Sdid"]!==null){
                                    
                                    echo"<p class='normal-price'>Normal Price: <span>RM ".$shoe["Sprice"]."</span></p>
                                    <p class='discount-price'>Discount Price: <span>RM ".$shoe["discount_price"]." (".number_format($shoe["discount_percent"],0)."%)</span></p>";
                                    
                                }
                                else{
                                    echo"<p class='price'><span>RM ".$shoe["Sprice"]."</span></p>";
                                }
                            ?>
                            
                        </div>
                        <form method="POST" action="cart.php?action=add&sid=<?php echo $sid; ?>">
                            <div class="product-size">
                                <p class="sm-title">Size selection - Choose UK size in stock:</p>
                                <div class="size-selection-container">
                                    <?php
                                        if ($result2->rowCount() > 0) {
                                            // output data of each row
                                            while($sizes = $result2->fetch()) {
                                                if($_SESSION['loggedIn'] == 0)
                                                    echo"<input type='radio' id='".$sizes['Ssize']."' name='shoesize' class='hidebox' value='".$sizes['Ssize']."' disabled onclick='enableAddToCartbtn()'>";
                                                else
                                                    echo"<input type='radio' id='".$sizes['Ssize']."' name='shoesize' class='hidebox' value='".$sizes['Ssize']."' onclick='enableAddToCartbtn()'>";
                                                echo"    
                                                <label for='".$sizes['Ssize']."' class='lbl-radio'>
                                                    <div class='display-box'>
                                                        <div class='size'>".$sizes['Ssize']."</div>
                                                    </div>
                                                </label>
                                                ";
                                                
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="shoe-quantity">
                                <p class="sm-title">Quantity:</p>
                                
                                    <select class="quantity" name="quantity" id="quantity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                
                            </div>

                            <?php
                                if($_SESSION['loggedIn'] == 0){
                                    echo"<p class='sm-title' style='color:rgb(224, 61, 61);'>Please log in as member to continue purchasing.</p>";
                                }
                            
                            ?>
                            <div class='product-btns'>
                                    <button type='submit' id='btn-cart' class='btn-cart disable' disabled>ADD TO CART</button>
                            </div>
                        </form>
                    </div>
                    

                    <!-- card lower left -->
                    <div id="item-info" class="item-info">
                        <div class="itemInfoTabs">
                            <button id="tab-info"  class="tab-button selected" onclick="openTab(event,'info')">Product Info</button>
                            <button id="tab-review" class="tab-button" onclick="openTab(event,'review')">Review</button>
                            <button id="tab-delivery" class="tab-button" onclick="openTab(event,'delivery')">Delivery</button>
                            <button id="tab-return" class="tab-button" onclick="openTab(event,'return')">Return</button>
                            <hr>
                        </div>
                        <div class="itemInfoContainer">
                            <div id="info" class="infoContainer tab selected">
                                <?php
                                    echo "<p>".$shoe["Sdetails"]."</p>";
                                ?>
                                
                            </div>

                            <div id="review" class="reviewContainer tab" >
                                <?php
                                    if ($result3->rowCount() > 0) {
                                        // output data of each row
                                        while($reviews = $result3->fetch()) {
                                            echo"
                                                <div class='review-box'>
                                                    <p class='reviewer'>".$reviews['Reviewer']."</p>
                                                    <p class='review-date'>".$reviews['ReviewDate']."</p>
                                                    <p class='review'>".$reviews['Review']."</p>
                                                </div>
                                            ";

                                        }
                                    } else{
                                        echo"<p> No review </p>";
                                    }
                                ?>
                                
                            </div>

                            <div id="delivery" class="deliveryContainer tab" >
                                <p>Standard Delivery:
                                    <br/><br/>Delivery within 7 to 14 days. RM15
                                    <br/>Free Delivery on orders over RM400.</p>
                            </div>

                            <div id="return" class="returnContainer tab">
                                <p>Returns are accepted if returned within 30 days of receipt. Only items that are unworn, unaltered, unwashed, 
                                    and in sellable condition can be returned.
                                    <br/><br/>To be eligible for a return, your item must be in the same condition that you received it. Any accompanying tags 
                                    must be intact and in original packaging.
                                    <br/><br/>Return Option:
                                    <br/><br/>1. Free returns in-store
                                    <br/><br/>2. Return by post as below
                                    <br/><br/>JD Returns Centre:
                                    <br/>LF Logistics Services (M) Sdn Bhd (JD Sports Returns)
                                    <br/>Address: LOT 22202, Jalan Gambus 33/4,
                                    <br/>Seksyen 33,
                                    <br/>40400 Shah Alam, Selangor
                                    <br/>Malaysia
                                </p>
                            </div>
                            <hr>
                        </div>
                        <script>
                            function openTab(evt, tabName) {
                            var i;
                            var x = document.getElementsByClassName("tab");
                            for (i = 0; i < x.length; i++) {
                                x[i].className = x[i].className.replace(" selected", "");
                            }

                            var tablinks = document.getElementsByClassName("tab-button");
                            for (i = 0; i < x.length; i++) {
                                tablinks[i].className = tablinks[i].className.replace(" selected", "");
                            }
                            document.getElementById(tabName).className += " selected";
                            evt.currentTarget.className += " selected";  
                            }
                        </script>
                    </div>
                </div>
            
            </div>


        </div>
        <?php include 'includes/footer.php';?>
    </body>

</html>