<?php 
    session_start();
    if(!isset($_GET["ID"])){
        echo '<script type="text/javascript">document.location.href="catalogo.php"</script>';
    }else{
        include 'funcoes.php';
        
        $CourseID=$_GET["ID"];
        $Flag=0;


        $Query = "Select Name, CardDesc, PagDesc, Price, Category, StartDate, EndDate from Course where ID=".$CourseID;
        $CourseInfo = exeDB($Query);

        if(empty($CourseInfo)){
            echo '<script type="text/javascript">document.location.href="catalogo.php"</script>';
        }
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

        $Query2="Select ID, Name,Description from Steps where CourseID=".$CourseID;
        $modulos=exeDBList($Query2);
        $exe = exeDBList($Query2);

?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - <?php echo $CourseInfo["Name"]?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function subscribe(){            
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

        function favourite(){
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

        function delCourse(){
            $.post("funcoes.php",{
            Func:"DelCourse",
            <?php echo "CourseID:".$CourseID?>
            },function(data, status){
                if(data=="ok") {   
                    alert("Pedido de remoção enviado");
                    document.location="catalogo.php";
                }
                else{}
            },"text");	
        }

		function onload(){		
			if(<?php echo $Info["Favourite"]?>){
				document.getElementById("fav").value=0;
				document.getElementById("fav").innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-solid fa-heart" id="heart"></i></span>Adicionado!';
			}else{
				document.getElementById("fav").value=1;
				document.getElementById("fav").innerHTML='<span class="icon" style="margin-right:1%"><i class="far fa-heart" id="heart"></i></span>Adicione aos favoritos';
			}

            if(<?php echo $Flag;?>==2){
                document.getElementById("sub").hidden='true';
                document.getElementById("fav").hidden=true;
            }else if(<?php echo $_SESSION["Role"]?>==1){
                switch (<?php echo $Info["Status"]?>){
                    case 0:
                        document.getElementById("sub").innerHTML='Inscreve-te!';
                        document.getElementById("sub").onclick="subscribe()";
                    break;
                    case 1:
                        document.getElementById("sub").innerHTML='Inscrito!';
                        document.getElementById("sub").onclick='';
                    break;
                    case 2: 

                        document.getElementById("sub").innerHTML='Concluido!';
                    break;
                }
                
            }else if(<?php echo $_SESSION["Role"]?>>1){
                document.getElementById("sub").innerHTML='Editar curso';
                document.getElementById("sub").setAttribute('onclick','document.location="editar_curso.php?ID=<?php echo $CourseID?>"');
                document.getElementById("sub").className="button is-info is-outlined";
                document.getElementById("fav").innerHTML='Remover curso';
                document.getElementById("fav").setAttribute('onclick','delCourse()');
                document.getElementById("fav").className="button is-primary";
            }
            
		}   
    </script>
</head>

<style>
    .hero-body{
		background-image: url('img/cursos/<?php echo $CourseID?>.jpg');
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
                    </div><br>
                    
                    <div class="subtitle is-5">
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
                        Data de inicio: <?php echo date("d-m-Y", strtotime($CourseInfo['StartDate']));;?>
                    </div>
                    <div class="title is-6">
                        Data de Fim: <?php echo date("d-m-Y", strtotime($CourseInfo['EndDate']));;?>
                    </div>                                   
                    <button class="button is-primary" id="sub" onclick="subscribe()" style="width: 100%"> </button>
                    <button class="button is-link is-outlined" id="fav" onclick="favourite()" style="width: 100%; margin-top: 2%"> </button>
                       
                </div>
            </div>
            <div class="boxes columns is-4" style="gap:7rem; margin-top: 2%; padding:2%">
                <div class="descricao column box block">
                    <div class="title is-5">
                        Módulos/Etapas
                    </div><br>
                    <?php while ($modulos = mysqli_fetch_assoc($exe)) : ?>
                        <details class="module-details">
                            <summary>
                                <h4 class="title is-5 mb-0">
                                    Módulo <?php echo htmlspecialchars($modulos['ID']); ?>: 
                                    <?php echo htmlspecialchars($modulos['Name']); ?>
                                </h4>
                            </summary>
                            <div class="module-content">
                                <p><?php echo htmlspecialchars($modulos['Description']); ?></p>
                            </div>
                        </details>
                    <?php endwhile; ?>
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
    <?php include 'footer.php';}?>
</body>
</html>