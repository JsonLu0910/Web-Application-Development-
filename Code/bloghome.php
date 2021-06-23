<html>
    <head>
        <title>Blog Home</title>
        <link rel="stylesheet" href="style/mystyle.css">
        <link rel="stylesheet" href="style/Webstyle.css">
        <link rel="stylesheet" href="style/blog.css">
    </head>
    <body>

        <?php
            include 'connectdb.php';

            $sql = "SELECT * FROM blog ORDER BY id";
            $record = $connection->query($sql);
            $record->setFetchMode(PDO::FETCH_ASSOC);

        ?>

        <div id ="main">
            <?php 
                session_start();
                include 'includes/header.php';
            ?>
            <?php include 'includes/navigation.php';?>

            <h1 id="blogheader" > Blog HomePage</h1>

            <div class="containers">
                <?php while ($blog = $record->fetch()):?>
                    <div class="blog">
                        <form action="displayBlog.php" method="GET">
                            <h1><?php echo $blog['Headline'];?><h1>
                            <?php echo "<img src='data:image/png;base64,".base64_encode( $blog['pic'] )."' alt='' width=25% height=25% >" ?><br/><br/>
                            <input type="hidden" name="bid" value='<?php echo $blog["id"];?>'>
                            <input type="submit" name="seemore" value="See More">
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>