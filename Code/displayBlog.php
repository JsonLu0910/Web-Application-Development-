<?php
    try
    {
        include 'connectdb.php';

        if(isset($_GET['bid']))
        {
            $id=$_GET['bid'];
            $sql = "SELECT * FROM blog WHERE id ='$id'";
            $q = $connection->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
        }
        else
        {
            echo "<script>alert('Error Opening Blog with '$id');";
            echo "window.location ='bloghome.php';</script>";
        }
    }
    catch (PDOException $e)
    {
        echo "<script>alert('Error. Please try again');</script>";
    }
?>

<html>
<style>
h3
{
    margin-left: 10;
    font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif
}

h1
{
    font-family:Georgia, 'Times New Roman', Times, serif;
    margin-left: 75;
    margin-right: 100;
    font-weight: bold;
}
    
img 
{
    display: block;
    margin-left: 50;
    margin-right: auto;
}

p, h2, ul, h4
{
    margin-left: 50;
    margin-right: 50;
}

.input
{
    margin-left:50px;
    font-size:30px;
}

</style>
    <head>
        <title>Blog Page</title> 
    </head>
    <body>
        <div class="header">
            <h2><a href="bloghome.php">< Back</a></h2>
            <h2>Blog</h2>
        </div>
        <?php while ($row = $q->fetch()): ?>

        <table class="input">        
            <th>Date</th>
            <th>Category</th>
            <th>Author</th>     
            <tr>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['Category']; ?></td>
                <td><?php echo $row['Author']; ?></td>
            </tr>               
         </table>

		<?php echo $row['Headline']; ?>
	    <br>
	    <?php echo "<img src='data:image/png;base64,".base64_encode( $row['pic'] )."'>" ?></td>
	    <br>
        <h2>Introduction</h2>
            
            <?php echo $row['Introduction']; ?>

            
        <h2>Main</h2>
            
            <?php echo $row['Main']; ?>
        

        <h2>Sub-HeadLine</h2>
                
            <?php echo $row['SubHeadline']; ?>

        

        <h2>Conclusion</h2>
                
            <?php echo $row['Con']; ?>

        <?php endwhile; ?> 
 
    </body>
</html>