<html>
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">

        <?php
            include 'connectdb.php';

            $val = null;
            $delete = null;
            $valpromo=null;
            $delpromo=null;
            $valcs=null;
            $valFaq=null;
            $valblog = null;

            //search record
            if (isset($_POST['searchitem'])) 
            {
                $val = $_POST['searchitem'];    
            }
                
            if($val == null) //display all if nothing to be search
            {
                $sql = "SELECT * FROM shoes ORDER BY Sid";
                $record = $connection->query($sql);
                $record->setFetchMode(PDO::FETCH_ASSOC);
            }  
            else
            {
                $sql = "SELECT * FROM shoes WHERE '$val' IN(Sid,Sname,Scategory,Sbrand,Sgender,Sdetails,Syear) ORDER BY Sid"; // display the searching result
                $record = $connection->query($sql);
                $record->setFetchMode(PDO::FETCH_ASSOC);
            }

            if (isset($_POST['delete']))        //delete record in shoes table
            {
                include "deleteshoes.php";
            }

            if(isset($_POST['searchpromo']))            //search in promotion tab
            {
                $valpromo=$_POST['searchpromo'];
            }

            if($valpromo == null)
            {
                $sql = "SELECT shoes.Sid, shoes.Sname, shoes.Spic, shoes.Sprice , shoes_discount.discount_percent, shoes_discount.discount_price, shoes_discount.valid_from, shoes_discount.valid_until FROM shoes RIGHT JOIN shoes_discount ON shoes.Sid=shoes_discount.Sid ORDER BY shoes.Sid";
                $p = $connection->query($sql);
                $p->setFetchMode(PDO::FETCH_ASSOC);
            }  
            else                //display result of search
            {
                $sql = "SELECT shoes.Sid, shoes.Sname, shoes.Spic, shoes.Sprice , shoes_discount.discount_percent, shoes_discount.discount_price, shoes_discount.valid_from, shoes_discount.valid_until FROM shoes RIGHT JOIN shoes_discount ON shoes.Sid=shoes_discount.Sid WHERE '$valpromo' IN(shoes.Sid,shoes.Sname, shoes_discount.discount_percent) ORDER BY Sid";
                $p = $connection->query($sql);
                $p->setFetchMode(PDO::FETCH_ASSOC);
            }

            if (isset($_POST['deletepromo']))        //delete record in promotion table
            {
                include "deletepromo.php";
            }

            if(isset($_POST['searchQuery']))
            {
                $valcs=$_POST['searchQuery'];
            }

            if($valcs == null)
            {
                $sql = "SELECT CSID,name,phone,email,subject,status,date FROM contact_us ORDER BY date";
                $a = $connection->query($sql);
                $a->setFetchMode(PDO::FETCH_ASSOC);
            }  
            else                //display result of search for query
            {
                $sql = "SELECT CSID,name,phone,email,subject,status,date FROM contact_us WHERE '$valcs' IN(CSID,name,phone,email,subject,status,date) ORDER BY date";
                $a = $connection->query($sql);
                $a->setFetchMode(PDO::FETCH_ASSOC);
            }

            if (isset($_POST['searchfaq'])) 
            {
                $valFaq = $_POST['searchfaq'];    
            }

            if (isset($_POST['deletefaq']))        //delete record in promotion table
            {
                include "deletefaq.php";
            }

            if($valFaq == null)
            {
                $sql = "SELECT * FROM faq ORDER BY FID";
                $FAQ = $connection->query($sql);
                $FAQ->setFetchMode(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql ="SELECT * FROM faq WHERE Fquestion LIKE '%$valFaq%' OR Fanswer LIKE '%$valFaq%'";
                $FAQ = $connection->query($sql);
                $FAQ->setFetchMode(PDO::FETCH_ASSOC);
            }

            if(isset($_POST['searchBlog']))
            {
                $valblog = $_POST['searchBlog'];
            }

            if(isset($_POST['deleteb']))
            {
                include 'deleteblog.php';
            }

            if($valblog ==null)
            {
                $sql = "SELECT id,Headline,pic,Author,Date,Category,Con FROM blog ORDER BY id";
                $blog = $connection->query($sql);
                $blog-> setFetchMode(PDO::FETCH_ASSOC);
            }
            else
            {
                $sql ="SELECT id,Headline,pic,Author,Date,Category,Con FROM blog WHERE Headline LIKE '%$valblog%' OR Author LIKE '%$valblog%' OR Category LIKE '%$valblog%' OR Con Like '%$valblog%' ORDER BY id";
                $blog = $connection->query($sql);
                $blog->setFetchMode(PDO::FETCH_ASSOC);
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
            <button onclick="topFunction()" id="myBtn" title="Go to top">^</button>
            <!--Tab links-->
            <div class="tabs">
                <button class="tablinks" onclick="opentab(event, 'shoeslist')" id="default">Manage Shoes</button>
                <button class="tablinks" onclick="opentab(event, 'Promotion')">Manage Promotion</button>
                <button class="tablinks" onclick="opentab(event, 'Query form list')">Manage Query</button>
                <button class="tablinks" onclick="opentab(event, 'Blog')">Manage Blog</button>
                <button class="tablinks" onclick="opentab(event, 'Faq')">Manage FAQ</button>
            </div>

            <!--Tab content-->
            <div id="shoeslist" class="tabcontent"> 
                <div class="adminfuns">
                    <ul>
                        <li>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="text" name="searchitem" placeholder="Search..">
                                <button type="submit"><img src="image/search-icon.jpg"></button>
                            </form>
                        </li>
                        <li style="float:right"><form action="addshoes.php" method="POST"><button type="submit" name="addshoes" id="addbtn" style="float:right">Add Shoes </button></form></li>
                    </ul>  
                </div>

                <table class="shoes">
                    <th>Shoe ID</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>shoes Details</th>
                    <th>Price(RM)</th>
                    <th>Release year</th>
                    <th colspan ="2">Action</th>

                    <?php while ($shoes = $record->fetch()):?>
                    <tr>
                        <td><?php echo $shoes['Sid'] ?></td>
                        <td><?php echo "<img src='data:image/png;base64,".base64_encode( $shoes['Spic'] )."' alt='' width=150 height=100 >" ?></td>
                        <td><?php echo $shoes['Sname']; ?></td>
                        <td><?php echo $shoes['Sgender']; ?></td>
                        <td><?php echo $shoes['Scategory']; ?></td>
                        <td><?php echo $shoes['Sbrand']; ?></td>
                        <td id="detail"><?php echo $shoes['Sdetails']; ?></td>
                        <td><?php echo $shoes['Sprice']; ?></td>
                        <td><?php echo $shoes['Syear']; ?></td>
                        <td><form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="hidden" name="Sid" value='<?php echo $shoes["Sid"];?>'>
                                <input type ="submit" class="adminbtn" name="delete" value="Delete">
                            </form>
                        </td>
                        <td><form action="editshoes.php" method="GET">
                                <input type="hidden" name="Sid" value='<?php echo $id=$shoes['Sid'];?>'>
                                <input type ="submit" class="adminbtn" name="edit" value="Edit">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </table>
            </div>
            
            <div id="Promotion" class="tabcontent">
                <div class="adminfuns">
                    <ul>
                        <li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="text" name="searchpromo" placeholder="Search..">
                                <button type="submit"><img src="image/search-icon.jpg"></button>
                            </form>
                        </li>
                        <li style="float:right"><form action="addpromo.php" method="POST"><button type="submit" name="addpromo" id="addbtn" style="float:right">Add Promotion shoes </button></form></li>
                    </ul>  
                </div>
                <table class="shoes">
                    <th>Shoe ID</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Discount %</th>
                    <th>discount Price</th>
                    <th>Original Price</th>
                    <th>Starting Date</th>
                    <th>End Date</th>
                    <th colspan ="2">Action</th>

                    <?php while ($promo = $p->fetch()):?>
                    <tr>
                        <td><?php echo $promo['Sid'] ?></td>
                        <td><?php echo "<img src='data:image/png;base64,".base64_encode( $promo['Spic'] )."' alt='' width=150 height=100 >" ?></td>
                        <td><?php echo $promo['Sname']; ?></td>
                        <td><?php echo $promo['discount_percent']; ?></td>
                        <td><?php echo $promo['discount_price']; ?></td>
                        <td><?php echo $promo['Sprice']; ?></td>
                        <td><?php echo $promo['valid_from']; ?></td>
                        <td><?php echo $promo['valid_until'];?></td>
                        <td><form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="hidden" name="Sid" value='<?php echo $promo["Sid"];?>'>
                                <input type ="submit" class="adminbtn" name="deletepromo" value="Delete">
                            </form>
                        </td>
                        <td><form action="editpromo.php" method="GET">
                                <input type="hidden" name="Sid" value='<?php echo $id=$promo['Sid'];?>'>
                                <input type ="submit" class="adminbtn" name="editpromo" value="Edit">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </table>
            </div>

            <div id="Query form list" class="tabcontent">
                <div class="adminfuns">
                        <ul>
                            <li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <input type="text" name="searchQuery" placeholder="Search..">
                                    <button type="submit"><img src="image/search-icon.jpg"></button>
                                </form>
                            </li>
                        </ul>  
                </div>
                    <table class="shoes">
                        <th>Index</th>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Email Address</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th colspan="2">Action</th>

                        <?php while ($cs = $a->fetch()):?>
                        <tr>
                            <td><?php echo $cs['CSID'] ?></td>
                            <td><?php echo $cs['name']; ?></td>
                            <td><?php echo $cs['phone']; ?></td>
                            <td><?php echo $cs['email']; ?></td>
                            <td><?php echo $cs['subject']; ?></td>
                            <td><?php echo $cs['status']; ?></td>
                            <td><?php echo $cs['date'];?></td>
                            <td><form  action="viewQuery.php" method="GET">
                                    <input type ="hidden" name="id" value='<?php echo $cs['CSID'];?>'>
                                    <input type ="submit" class="adminbtn" name="view" value="view">
                                </form>
                            </td>
                            <td><form action="updatestatus.php" method="GET">
                                    <input type="hidden" name="csid" value='<?php echo $cs['CSID'];?>'>
                                    <input type ="submit" class="adminbtn" name="updatestatus" value="update">
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
            </div>

            <div id="Blog" class="tabcontent">
                <div class="adminfuns">
                    <ul>
                        <li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="text" name="searchBlog" placeholder="Search..">
                                <button type="submit"><img src="image/search-icon.jpg"></button>
                            </form>
                        </li>
                        <li style="float:right"><form action="addblog.php" method="POST"><button type="submit" name="addblog" id="addbtn" style="float:right">Add new Blog </button></form></li>
                    </ul> 
                    
                    <table class="shoes">
                        <th>Blog ID</th>
                        <th>Blog title</th>
                        <th>Media</th>
                        <th>Author</th>
                        <th>Publish Date</th>
                        <th>Category</th>
                        <th>conclusion</th>
                        <th colspan="2">Action</th>

                        <?php while ($b = $blog->fetch()):?>
                        <tr>
                            <td><?php echo $b['id'] ?></td>
                            <td><?php echo $b['Headline']; ?></td>
                            <td><?php echo "<img src='data:image/png;base64,".base64_encode( $b['pic'] )."' alt='' width=150 height=100 >" ?></td>
                            <td><?php echo $b['Author']; ?></td>
                            <td><?php echo $b['Date']; ?></td>
                            <td><?php echo $b['Category']; ?></td>
                            <td><?php echo $b['Con'];?></td>
                            <td><form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <input type ="hidden" name="bid" value='<?php echo $b['id'];?>'>
                                    <input type ="submit" class="adminbtn" name="deleteb" value="Delete">
                                </form>
                            </td>
                            <td><form action="updateblog.php" method="GET">
                                    <input type="hidden" name="bid" value='<?php echo $b['id'];?>'>
                                    <input type ="submit" class="adminbtn" name="updateblog" value="update">
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>

            <div id="Faq" class="tabcontent">
                <div class="adminfuns">
                    <ul>
                        <li><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <input type="text" name="searchfaq" placeholder="Search..">
                                <button type="submit"><img src="image/search-icon.jpg"></button>
                            </form>
                        </li>
                        <li style="float:right"><form action="addFaq.php" method="POST"><button type="submit" name="addFaq" id="addbtn" style="float:right">Add FAQ </button></form></li>
                    </ul> 
                    
                    <table class="shoes">
                        <th>Index</th>
                        <th>FAQ Category</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th colspan="2">Action</th>
                    

                        <?php while ($f = $FAQ->fetch()):?>
                        <tr>
                            <td><?php echo $f['FID'] ?></td>
                            <td><?php echo $f['Fcate']; ?></td>
                            <td><?php echo $f['Fquestion']; ?></td>
                            <td><?php echo $f['Fanswer']; ?></td>
                            <td><form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <input type ="hidden" name="FID" value='<?php echo $f['FID'];?>'>
                                    <input type ="submit" class="adminbtn" name="deletefaq" value="Delete">
                                </form>
                            </td>
                            <td><form action="updatefaq.php" method="GET">
                                    <input type="hidden" name="FID" value='<?php echo $f['FID'];?>'>
                                    <input type ="submit" class="adminbtn" name="updatefaq" value="update">
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php';?>

        <script>
            function opentab(evt, tabname) 
            {
                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) 
                {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) 
                {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show the current tab, and add an "active" class to the button that opened the tab
                document.getElementById(tabname).style.display = "block";
                evt.currentTarget.className += " active";
            }
            // // Get the element with id="defaultOpen" and click on it
            document.getElementById("default").click();
        </script>

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
    </body>
</html>