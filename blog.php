<?php session_start(); include 'funcoes.php';

$posts = getBlog();

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
    <script>
        function togglePost(){
            document.getElementById('modal').classList.toggle('is-active');
        }
        function newPost(){
            $.post("funcoes.php", {
                Func: "newPost",
                title: document.getElementById("title").value,
                desc: document.getElementById("desc").value
            }, function (data) {
                if (data=="ok") {
                    document.location = "blog.php";
                }
            }, "text");
        }
    </script>
</head>

<body>

    <?php include 'navbar.php'; ?>
        
    <!-- Contenido principal -->
    <article class="section ">
        <div class="container blog">
            <div class="scroll">
<?php           while($post = mysqli_fetch_assoc($posts)){?>
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">
                            <img src="<?php
                                if (file_exists("img/users/" . $post['UserID'] . ".png")) {
                                    echo "img/users/" . $post['UserID'] . ".png";
                                } else {
                                    echo "img/users/default.png";
                                }
                                ?>" alt="Foto de perfil" style="max-height:256px;max-width:256px">
                            </p>
                        </figure>
                        <div class="media-content blog">
                            <div class="content">
                                <p><?php echo $post["Name"]?></p>
                                <h3><?php echo $post["Title"]?></h3>
                                <?php echo $post["Description"]?>
                            
                            </div>
                        </div>
                    </article>
<?php           } ?>
            </div><br>
            
            <div class="is-flex is-justify-content-flex-end"><button class="button is-primary" onclick="togglePost()">Adicionar post</button></div>
        </div>
    </article>
    <div class="modal" id="modal">
        <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">New post</p>
                    <button class="delete" aria-label="close" onclick="togglePost()"></button>
                </header>
                <section class="modal-card-body">
                <div class="field">
                    <label class="label" >Titulo</label>    
                    <input required class="input" id="title">
                </div>
                <div class="field">
                    <div class="control">
                        <textarea class="textarea is-primary" id="desc" required></textarea>
                        <p class="help is-danger" id="course-description-error"></p>
                    </div>
                </div>
                </section>
                <footer class="modal-card-foot">
                <div class="buttons">
                    <button class="button is-primary" onclick="newPost()">Save changes</button>
                    <button class="button" onclick="togglePost()">Cancel</button>
                </div>
            </footer>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>

</html>