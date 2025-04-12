<!DOCTYPE html>
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Cursos</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

    <?php include 'navbar.php'; ?>

    <?php 
        //session_start();

        include 'funcoes.php';

        if(isset($_GET["id"])) {
            $postId = $_GET["id"];
            $Query = "SELECT * FROM Blog WHERE ID=".$postId;
            $post = exeDB($Query);
            $content = json_decode($post['Content'], true);
        }   
    ?>

    <div class="section">
        <div class="columns is-centered is-4">
            <div class="column is-8">
                <div class="card">
                    <div class="card-image">
                        <figure class="image">
                            <img src="img/blog/<?php echo $postId . '.jpg'  ?>" alt=""  style="height: 350px;">
                        </figure>
                    </div>
                    <div class="card-content">
                       
                        <h2 class="title is-5">
                                <?php echo $post['Title'] ?>
                        </h2>

                        <p class="mb-5">
                            <?php echo $post['Description'] ?>
                        </p>

                        <?php 
                            foreach ($content as $body) {
                            
                        ?>  
                            <h2 class="title is-5"><?php echo $body["title"]?></h2>
                            <p> <?php foreach ($body['paragraphs'] as $paragraph) { ?> </p>
                                <p class="mb-5"><?php echo $paragraph ?></p>
                           <?php }?>
                        <?php }?>

                    </div>
                </div>
            </div>

            <div class="column is-3">

                <h2 class="mb-5">Ultimos Posts</h2>
                
                <aside>
                    
                    <?php 

                        $Query = "SELECT * FROM Blog ORDER BY PublishDate DESC LIMIT 3";
                        $posts = exeDBList($Query);
                        while ($post = mysqli_fetch_assoc($posts)) { 
                    ?>       
                    
                    
                        <a class="media" href="?id=<?php echo $post["ID"]?>">
                            <div class="media-left">
                                <figure class="image is-64x64">
                                    <img src="img/blog/<?php echo $post['ID'] . '.jpg'  ?>" alt="" style="height: 100%;">
                                </figure>
                            </div>
        
                            <div class="media-content">
                                <h2 class="title is-6"><?php echo $post['Title']?></h2>
                                <h3 class="subtitle is-6"><?php echo $post['PublishDate']?> </h3>
                            </div>
                        </a>         
                    
                    <?php 
                        }
                    ?>

                </aside>
            </div>
        </div>


    </div>
    

    <?php include 'footer.php'; ?>
</body>
</html>