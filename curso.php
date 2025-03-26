<?php 
    session_start();
	include 'funcoes.php';
	
	$CourseID=$_GET["ID"];
    $Flag=0;

    $Query = "Select Name, CardDesc, PagDesc, Price, Category, StartDate from Course where ID=".$CourseID;
    $CourseInfo = exeDB($Query);

    if(isset($_SESSION["UserID"])){
        $Query = "Select Favourite, Status from Interaction where CourseID=".$CourseID." AND UserID=".$_SESSION["UserID"];
        $Info = exeDB($Query);
        if(empty($Info)){
            $Info["Favourite"]=0;
            $Info["Status"]=0;
            $Flag=1;
        }
    }else{
        $Info["Favourite"]=0;
        $Info["Status"]=0;
        $Flag=2;
    }
	
?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Curso Teste</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>

        function subscribe(){
            if(<?php echo $Flag ?>==2){
                alert("Necessita de efetuar o login primeiro!");
            }else{
                $.post("funcoes.php",{
                Func:"subscribe",
                <?php echo "CourseID:".$CourseID.",
				Flag:".$Flag?>
                },function(data, status){
                    if(data=="ok") { 
                        document.getElementById("sub").innerHTML='Inscrito!';
                        document.getElementById("sub").onclick='';
                        alert("Inscrito com sucesso");
                        document.location="curso.php?ID=<?php echo $CourseID?>";
                    }
                    else{}
                },"text");	
            }
           
        }

        function favourite(){
            if(<?php echo $Flag ?>==2){
                alert("Necessita de efetuar o login primeiro!");
            }else{
                fav = document.getElementById("fav");
                $.post("funcoes.php",{
                    Func:"favourite",
                    Fav:fav.value,
                    <?php echo "CourseID:".$CourseID.",
                    Flag:".$Flag?>
                
                },function(data, status){
                    if(data=="ok" && fav.value==1){
                        fav.innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-solid fa-heart" id="heart"></i></span>Adicionado!';
                        fav.value=0;
                        alert("Curso adicionado aos favoritos!");                

                    }
                    else if(data=="ok"){
                        fav.innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-heart" id="heart"></i></span>Adicione aos favoritos';
                        fav.value=1;
                        alert("Curso removido dos favoritos");
                        
                    }
                },"text");	
            }
        }

		function onload(){		
			if(<?php echo $Info["Favourite"]?>){
				document.getElementById("fav").value=0;
				document.getElementById("fav").innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-solid fa-heart" id="heart"></i></span>Adicionado!';
			}else{
				document.getElementById("fav").value=1;
				document.getElementById("fav").innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-heart" id="heart"></i></span>Adicione aos favoritos';
			}

            switch (<?php echo $Info["Status"]?>){
                case 0:
				    document.getElementById("sub").innerHTML='Inscreve-te!';
                break;
                case 1:
				    document.getElementById("sub").innerHTML='Inscrito!';
                    document.getElementById("sub").onclick='';
                break;
                case 2: 

				    document.getElementById("sub").innerHTML='Concluido!';
                break;
            }
            
		}   
    </script>
</head>

<style>
    .hero-body{
		background-image: url('img/cursos/img<?php echo $CourseID?>.jpg');
        /*background-image: url('https://www.site.pt/wp-content/uploads/2022/01/o-que-e-php-845x480.jpg');*/
        background-size: contain;
    }

    .lista{
        margin: 2% 5%;
    }

</style>

<body onload="onload()">
    <?php include 'navbar.php';?>
    <section class="hero is-medium">
        <div class="hero-body">
        </div>
    </section>
    <section class="lista">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li>
                    <a href="index.php">
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="catalogo.php">
                        <span>Cursos</span>
                    </a>
                </li>
                <li>
                    <a href="curso.php?ID=<?php echo $CourseID?>">
                        <span><?php echo $CourseInfo["Name"]?></span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
    <section class="content">
        <div class="container">
            <div class="title">
                Curso <?php echo $CourseInfo["Name"]?>
            </div>
            <div class="subtitle">
            <?php echo $CourseInfo["CardDesc"]?>
            </div>
            <div class="boxes columns is-4" style="gap:7rem; margin-top: 2%; padding:2%">
                <div class="descricao column box block">
                    <div class="title is-5">
                        Descrição
                    </div>
                    <div class="subtitle is-6">
                        <?php echo $CourseInfo["PagDesc"]?>
                    </div>
                </div>
                <div class="pagamento column box is-3">
                    <div class="title is-3">
                        <?php echo number_format($CourseInfo['Price'], 2);?>€
                    </div>
                    <div class="title is-6">
                        Categoria: <?php echo $CourseInfo['Category'];?>
                    </div>
					<div class="title is-6">
                        Data de inicio: <?php echo $CourseInfo['StartDate'];?>
                    </div>
                    <button class="button is-success has-text-primary-100" id="sub" onclick="subscribe()" style="width: 100%">Inscreve-te!</button>
                    <button class="button is-link is-outlined" id="fav" onclick="favourite()" style="width: 100%; margin-top: 2%"> </button>
                </div>
            </div>
            <?php if($Info["Status"]==1){ ?>
                <div class="boxes columns is-4" style="margin-top: 2%; padding:2%">
                    <div class="descricao column box block">
                        <div class="title is-5">
                        <?php echo $CourseInfo["Name"]?>
                        </div>
                        <div class="subtitle is-6">
                            Bem vindo ao curso <?php echo $CourseInfo["Name"]?> clica no botão abaixo para teres acesso a toda a informação disponivel.<br>
                            Boa sorte! Não te esqueças de deixar o teu feedback quando completares o curso<br><br>
                        <a href="cursos/curso<?php echo $CourseID?>.pdf"  class="button is-link is-outlined" target="_blank">Acede ao curso</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
        </div>
    </section>
    <?php include 'footer.php';?>
</body>
</html>