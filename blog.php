<?php session_start(); include 'funcoes.php'; 


?>

<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Cursos</title>
    <!-- Importar CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
</head>

<body>

    <?php include 'navbar.php'; ?>
        
    <div class="section">
        <div class="columns is-centered  is-multiline">
            <?php $posts = getBlogPosts();

                while ($post = mysqli_fetch_assoc($posts)) {

            ?>
            <div class="column is-3" >
                <a href="post.php?id=<?php echo $post['ID']?>">
                    <div class="card on-hover-up" style="height: 100%;" >
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img src="<?php echo "img/blog/".$post['ID'].".jpg"; ?>" alt="">
                            </figure>
                        </div>

                        <div class="card-content">
                            <h2 class="title is-5">
                            <?php echo $post["Title"]?>
                            </h2>

                            <p><?php echo $post["Description"]?></p>
                            
                        </div>

                        
                    </div>
                </a>
            </div>

<?php       }?>
        </div>


    
        <div class="columns is-centered my-6">

            <div class="column is-9">
                <nav class="pagination is-right" role="navigation" aria-label="pagination">
            
            <?php 
                $pages = CountPages();
                    if(isset($_GET['page']) && $_GET['page'] > 1) {

                        ?>
                        <a href="?page=<?php echo $_GET['page'] - 1 ?>" class="pagination-previous">Previous</a>
                        <?php 
                    }    
                ?>
                
                
                <?php 
                    if(isset($_GET['page']) && $_GET['page'] < $pages) {
                        ?>
                        <a href="?page=<?php echo $_GET['page'] + 1 ?>" class="pagination-next">Next page</a>
                        <?php 
                    }    
                ?>  



                <ul class="pagination-list">
                    
                    
                    <?php 
                    if($pages <= 5 ) {
                        for ($i = 1; $i <= $pages; $i++) {
                            echo '<li><a href="?page=' . $i . '" class="pagination-link">'. $i .'</a></li>'; 
                        }
                    }
                    else {
                        echo '<li><a href="?page=1" class="pagination-link" aria-label="Goto page 1">1</a></li>';
                        echo '<li><span class="pagination-ellipsis">&hellip;</span></li>';
                        
                        $middle = intdiv($pages, 2);
                        
                        if($pages % 2 == 0) {
                            
                            echo '<li><a href="?page=' . $middle . '" class="pagination-link">'. $middle .'</a></li>'; 
                            echo '<li><a href="?page=' . $middle + 1 . '" class="pagination-link">'. $middle + 1 .'</a></li>'; 
                        } 
                        else {
                            echo '<li><a href="?page=' . $middle . '" class="pagination-link">'. $middle .'</a></li>';
                            echo '<li><a href="?page=' . $middle - 1 . '" class="pagination-link">'. $middle - 1 .'</a></li>'; 
                            echo '<li><a href="?page=' . $middle + 1 . '" class="pagination-link">'. $middle + 1 .'</a></li>'; 
                        }

                        echo '<li><span class="pagination-ellipsis">&hellip;</span></li>';
                        echo '<li><a href="?page='. $pages .' " class="pagination-link" aria-label="Goto page 86">'. $pages .'</a></li>';

                    }
                    ?>

                    
                    
                    
                    
                </ul>
            </nav>
                </div>
        </div>
        <div class="spacing"></div>            
        
    </div> 
</body>

</html>