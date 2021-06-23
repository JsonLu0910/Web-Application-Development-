<html>
    <div id="mySidebar" class ="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href = "maindashboard.php">Home</a>
        <a href = "shopfootwear.php">Shop</a>
        <a href = "FAQ.php">FAQ</a>
        <a href = "About Us.php">About Us</a>
        <a href = "Contact Us.php">Contact Us</a>
        <?php 
            if($_SESSION['userlevel'] == 2)
            {
                echo "<a id='admin' href = 'adminpanel.php'>Admin Panel</a>";
            }  
        ?>  
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }

    </script>

    <div class= "nav">
        <ul>
            <li><button class="openbtn" onclick="openNav()">☰ MENU</button></li>
            <li class = "btn"><a href="shopfootwear.php?gender=men">Men</a>
                <div class= "dropcontent">
                    <a href= "shopfootwear.php?gender=men&category=basketball">BasketBall</a>
                    <a href= "shopfootwear.php?gender=men&category=casual">Casual</a>
                    <a href= "shopfootwear.php?gender=men&category=running">Running</a>
                    <a href= "shopfootwear.php?gender=men&category=sandals-flipflops">Sandals & FlipFlops</a>
                    <a href= "shopfootwear.php?gender=men&category=skate-canvas">Skate & Canvas</a>
                </div>
            </li>
            <li class = "btn"><a href="shopfootwear.php?gender=women">Women</a>
                <div class= "dropcontent">
                    <a href= "shopfootwear.php?gender=women&category=basketball">BasketBall</a>
                    <a href= "shopfootwear.php?gender=women&category=casual">Casual</a>
                    <a href= "shopfootwear.php?gender=women&category=running">Running</a>
                    <a href= "shopfootwear.php?gender=women&category=sandals-flipflops">Sandals & FlipFlops</a>
                    <a href= "shopfootwear.php?gender=women&category=skate-canvas">Skate & Canvas</a>
                </div>
            </li>
            <li><a href="shopfootwear.php?gender=kids">Kids</a></li>
            <li class = "btn"><a href="#Brands">Brands</a>
                <div class= "dropcontent">
                    <a href = "shopfootwear.php?brand=nike">Nike</a>
                    <a href = "shopfootwear.php?brand=adidas">Adidas</a>
                    <a href = "shopfootwear.php?brand=puma">Puma</a>
                    <a href = "shopfootwear.php?brand=jordan">Jordan</a>
                    <a href = "shopfootwear.php?brand=converse">Converse</a>
                    <a href = "shopfootwear.php?brand=vans">Vans</a>
                </div>
            </li>
            <li><a href="salesfootwear.php">Sales</a></li>
            <li><a href="bloghome.php">Blog</a></li>
        </ul>
    </div>
<html>