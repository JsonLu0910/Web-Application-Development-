<?php 
    session_start();
?>
<html>
    <head>
        <title>My Cart - Shoester Malaysia</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">
        <link rel="stylesheet" href="style/cartstyle.css">
        <script>
            function openFootwearPage(sid){
                console.log(sid);
                window.location.href = "footwear.php?sid=" + sid;
            }
            function displayMssg(mssg){
                setTimeout(function(){
                    var x = document.getElementById("hidden-text");
                    if(mssg=="addSucc"){
                        x.innerHTML = "The item added successfully to your cart.";
                        x.className = "successMssg";
                        Console.log("faefefafew");
                    } else if(mssg=="addFailed"){
                        x.innerHTML = "The item already in your cart.";
                        x.className = "failedMssg";
                    } else if(mssg=="deleteSucc"){
                        x.innerHTML = "The item removed successfully from your cart.";
                        x.className = "successMssg";
                    }
                }, 100);
               
            }
        </script>
        
        <?php
            include 'connectdb.php';
            // Create connection
            $connection = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sid=null;
            if (isset($_GET['sid'])) {
                $sid = $_GET['sid'];}

            
            if(!empty($_GET["action"])) {
                switch($_GET["action"]) {
                    case "add":
                        if(!empty($_POST["quantity"])&&!empty($_POST["shoesize"])) {
                            $currentTime = date("Y-m-d");
                            $sql = "SELECT s.sid, s.sname, s.sgender, s.scategory, s.sbrand, s.spic, s.sprice, s.syear, sd.discount_price From shoes s LEFT JOIN shoes_discount sd ON s.Sid = sd.Sid 
                            AND sd.valid_from <= '$currentTime'AND sd.valid_until > '$currentTime' WHERE s.Sid = '$sid'";
                            $result = $connection->query($sql);
                            $productByCode = $result->fetch();

                            $itemArray = array('sid'=>$productByCode["sid"], 'sname'=>$productByCode["sname"], 'sgender'=>$productByCode["sgender"],
                            'scategory'=>$productByCode["scategory"], 'sbrand'=>$productByCode["sbrand"], 'spic'=>$productByCode["spic"], 'sprice'=>$productByCode["sprice"],
                            'syear'=>$productByCode["syear"], 'discount_price'=>$productByCode["discount_price"], 'quantity'=>$_POST["quantity"], 'shoesize'=>$_POST["shoesize"]);
                            
                            if(isset($_SESSION["cart_item"])) {
                                $itemArrayId = array_column($_SESSION["cart_item"], "sid");
                                if(!in_array($_GET["sid"], $itemArrayId)){
                                    $count = count($_SESSION["cart_item"]);
                                    $_SESSION["cart_item"][$count] = $itemArray;
                                    echo "<script>displayMssg('addSucc')</script>";
                                } else {
                                    echo "<script>displayMssg('addFailed')</script>";
                                }

            
                            } else {
                                $_SESSION["cart_item"][0] = $itemArray;
                                echo "<script>displayMssg('addSucc')</script>";
                            }
                        }
                    break;
                    case "remove":
                        if(!empty($_SESSION["cart_item"])) {
                            foreach($_SESSION["cart_item"] as $keys => $item) {
                                    if($_GET["sid"] == $item["sid"])
                                        unset($_SESSION["cart_item"][$keys]);				
                                    if(empty($_SESSION["cart_item"]))
                                        unset($_SESSION["cart_item"]);
                            }
                            echo "<script>displayMssg('deleteSucc')</script>";
                        }
                    break;
                    case "empty":
                        unset($_SESSION["cart_item"]);
                    break;	
                }
            }

            if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
            }
        ?>
    </head>
    
    <body>
        <div id="main">
            <header class='header'>
                <?php include 'includes/header.php';?>
                <?php include 'includes/navigation.php';?>
            </header>
            <hr/>
            <div id="shopping-cart">
                <div class="txt-heading"> <h3> SHOPPING CART </h3> </div>
                <div><a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a></div>
                
                <p id="hidden-text">1</p>
                <?php
                    if(isset($_SESSION["cart_item"])){
                        $total_quantity = 0;
                        $total_price = 0;
                ?>	
                <table class="tbl-cart" cellpadding="10" cellspacing="1">
                    <tbody>
                        <tr>
                        
                        <th colspan="2"style="text-align:left;" width="13%">Item</th>
                        <th style="text-align:left;" width="5%">Category</th>
                        <th style="text-align:left;" width="5%">Size</th>
                        <th style="text-align:right;" width="3%">Quantity</th>
                        <th style="text-align:right;" width="7%">Unit Price</th>
                        <th style="text-align:right;" width="7%">Price</th>
                        <th style="text-align:center;" width="5%">Remove</th>
                        </tr>	
                        <?php	
                            if(!empty($_SESSION["cart_item"])){
                                $total_price = 0;
                                foreach ($_SESSION["cart_item"] as $keys => $item){
                            ?>
                            <tr>
                                <?php echo"<td  width='5%'><img src='data:image/png;base64,".base64_encode($item['spic'])."' class='cart-item-image' /></td>";?>
                                <td class="bold"><?php echo $item["sname"]; ?></td>
                                <td><?php echo $item["scategory"]; ?></td>
                                <td><?php echo "UK ".$item["shoesize"]; ?></td>
                                <td align="right"><?php echo $item["quantity"]; ?></td>
                                <td class="bold" style="text-align:right;">
                                <?php
                                    if($item["discount_price"]!=null){
                                        echo "RM ".$item["discount_price"];
                                        $item_price = $item["discount_price"] * $item["quantity"];
                                    } else {
                                        echo "RM ".$item["sprice"];
                                        $item_price = $item["sprice"] * $item["quantity"];
                                    }
                                ?></td>
                                <td class="bold" style="text-align:right;"><?php echo "RM ". number_format($item_price,2); ?></td>
                                <td style="text-align:center;"><a href="cart.php?action=remove&sid=<?php echo $item["sid"]; ?>" class="btnRemoveAction"><img src="image/icon-delete.png" alt="Remove Item" /></a></td>
                                </tr>
                                <?php
                                $total_quantity += $item["quantity"];
                                $total_price += $item_price;
                                }
                            }
                                ?>
                        <tr>
                        <td colspan="4" align="right">Total:</td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><strong><?php echo "RM ".number_format($total_price, 2); ?></strong></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br><br>		
                <?php
                } else {
                ?>
                <div class="no-records">There are no items in your cart.</div>
                <div class="no-records"><a id="contShopbtn" href="shopfootwear.php">CONTINUE SHOPPING</a></div>
                <?php 
                }
                ?>
                </div>
            </div>
            <?php include 'includes/footer.php';?>
    </body>
</html>