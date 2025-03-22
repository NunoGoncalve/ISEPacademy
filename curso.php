<?php 
    include 'conexao.php';
    $Sel = "Select Name, CardDesc, PagDesc, Price, Category from Course where ID=".$_GET["ID"]."";
    $exe = mysqli_query($conexao, $Sel);
    $row = mysqli_fetch_assoc($exe);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Curso Teste</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function favourite(){
            $.post("funcoes.php",{
                func:"favourite", 
                UserID:<?php echo "1, 
                CourseID:".$_GET["ID"]?>
            
            },function(data, status){
				if(data=="ok"){
                    alert("Curso adicionado aos favoritos!");
                    document.getElementById("fav").innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-solid fa-heart" id="heart"></i></span>Adicionado!';

                }
				else{}
			},"text");	
        }
    </script>
</head>

<style>
    .hero-body{
        background-image: url('https://www.site.pt/wp-content/uploads/2022/01/o-que-e-php-845x480.jpg');
        background-size: contain;
    }

    .lista{
        margin: 2% 5%;
    }

</style>

<body>
    <section class="hero is-medium">
        <div class="hero-body">
        </div>
    </section>
    <section class="lista">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li>
                    <a href="#">
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Cursos</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span><?php echo $row["Name"]?></span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
    <section class="content">
        <div class="container">
            <div class="title">
                Curso <?php echo $row["Name"]?>
            </div>
            <div class="subtitle">
            <?php echo $row["CardDesc"]?>
            </div>
            <div class="boxes columns is-4" style="gap:7rem; margin-top: 2%; padding:2%">
                <div class="descricao column box block">
                    <div class="title is-5">
                        Descrição
                    </div>
                    <div class="subtitle is-6">
                        <?php echo $row["PagDesc"]?>
                    </div>
                </div>
                
                <div class="pagamento column box is-3">
                    <div class="title is-3">
                        <?php echo number_format($row['Price'], 2);?>
                    </div>
                    <button class="button is-success has-text-primary-100" style="width: 100%">Compra Aqui!</button>
                    <button class="button is-link is-outlined" id="fav" onclick="favourite()" style="width: 100%; margin-top: 2%">
                        <span class="icon" style="margin-right:1%">
                            <i class="far fa-heart" id="heart"></i>
                        </span>
                         Adicione aos favoritos
                    </button>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php';?>
</body>
</html>