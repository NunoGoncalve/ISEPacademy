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

        $Query="Select ID, Name, Description from Steps where CourseID=".$CourseID;
        $modulos=exeDBList($Query);

        $Query="Select UserID, Name, Rating, Review, ReviewDate from Interaction inner join User on Interaction.UserID=User.ID where CourseID=".$CourseID." and Status=2 and ReviewDate<>'0000-00-00'";
        $reviews=exeDBList($Query);

        if(empty($CourseInfo)){
            echo '<script type="text/javascript">document.location.href="catalogo.php"</script>';
        }
        if(isset($_SESSION["UserID"])){
            $Query = "Select Favourite, Status from Interaction where CourseID=".$CourseID." AND UserID=".$_SESSION["UserID"];
            $Info = exeDB($Query);
            
            $Query="Select StepID from UserSteps where CourseID=".$CourseID." and Done=1 and UserID=".$_SESSION["UserID"];
            $temp=exeDBList($Query);

            $modulosConcluidos = [];

            while($row = mysqli_fetch_assoc($temp)) {
                $modulosConcluidos[] = $row["StepID"];
            }
            if(empty($Info)){
                $Info["Favourite"]=0;
                $Info["Status"]=0;
                $Flag=1;
            }
        }else{
            $Info["Favourite"]=0;
            $Info["Status"]=0;
            $Flag=2;
            $_SESSION["Role"]=0;
        }
        
	
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

        function review(){            
            $.post("funcoes.php",{
            Func:"review",
            <?php echo "CourseID:".$CourseID?>,
            Rating:document.querySelector('[name="rating"]').value,
            Review:document.getElementById("comment").value
            },function(data, status){
                if(data=="ok") { 
                    alert("Feedback registado");
                    document.location.reload();
                }
            },"text");	          
        }

        function save(StepID){            
            $.post("funcoes.php",{
            Func:"UserStep",
            <?php echo "CourseID:".$CourseID?>,
            StepID:StepID
            },function(data, status){
                if(data=="ok") { 
                    document.getElementById("StepBtn"+StepID).innerHTML='Concluido!';
                    document.getElementById("StepBtn"+StepID).onclick='';
                }
                else{
                    alert("Parabéns acabou o curso! Pode deixar feedback")
                    document.location.reload();
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
            if(<?php echo $_SESSION["Role"]?>==1){
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
                        document.getElementById("sub").setAttribute("onclick", "subscribe()");
                    break;
                    case 1:
                        document.getElementById("sub").innerHTML='Inscrito!';
                        document.getElementById("sub").onclick='';
                    break;
                    case 2:   
                        document.getElementById("review").className='columns mb-2';
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
            else{ 
                document.getElementById("sub").setAttribute("hidden", "hidden");
                document.getElementById("fav").setAttribute("hidden", "hidden");
                document.getElementById("sub").className="";
                document.getElementById("fav").className="";
            }
        }
    </script>
    <style>
        .hero-body{
            background-image: url('img/cursos/<?php echo $CourseID?>.jpg');
            background-size: contain;
        }
    </style>
</head>

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
<?php       if($Info["Status"]>=1 || $_SESSION["Role"]>1){ ?>
                <!--<div class="boxes columns is-4" style="margin-top: 2%; padding:2%">
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
                <div class="boxes columns is-4" style="gap:7rem; margin-top: 2%; padding:2%">-->
                    
                 <div class="descricao column box block">
                 <div class="title is-5"> <?php echo $CourseInfo["Name"]?></div>
                        <div class="subtitle is-6">
                            Bem vindo ao curso <?php echo $CourseInfo["Name"]?> clica no botão abaixo para teres acesso a toda a informação disponivel.<br>
                            Boa sorte! Não te esqueças de deixar o teu feedback quando completares o curso<br><br>
                        <!--<a href="cursos/curso<?php echo $CourseID?>.pdf"  class="button is-link is-outlined" target="_blank">Acede ao curso</a>-->
                        </div><br>
                     <div class="title is-5">
                         Módulos/Etapas
                     </div><br>
                     <?php while ($modulo = mysqli_fetch_assoc($modulos)) : ?>
                         <details class="module-details">
                             <summary>
                                 <h4 class="title is-5 mb-0">
                                     Módulo <?php echo $modulo['ID']; ?>: 
                                     <?php echo htmlspecialchars($modulo['Name']); ?>
                                 </h4>
                             </summary>
                             <div class="module-content">
                                 <p><?php echo $modulo['Description']; ?></p>
                             </div>
                             <div class="is-flex is-justify-content-flex-end">
<?php                           if(in_array($modulo['ID'], $modulosConcluidos)){
                                    echo '<button class="button is-primary" id="StepBtn'.$modulo['ID'].'">Concluido!</button>';
                                }else{
                                    echo '<button class="button is-primary" onclick="save('.$modulo['ID'].')"  id="StepBtn'.$modulo['ID'].'">Marcar como concluido</button>';
                                }?>
                            </div>
                         </details>
                     <?php endwhile; ?>
                 </div>
             </div>
<?php       } ?>
            
            
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="box" style="margin-top: 2%; padding: 2%">
                <div class="columns mb-2 is-hidden" id="review">
                    <div class="column is-1">
                        <figure class="image is-48x48 ml-5">
                            <img class="is-rounded" src="img/users/default.png" alt="Imagem do utilizador">
                        </figure>
                    </div>
                    <div class="column">
                        <form id="feedbackForm">
                            <div class="field">
                                <div class="control">
                                    <div class="rating" style="font-size: 1rem;">
                                        <input type="radio" id="star5" name="rating" value="5" />
                                        <label for="star5"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4" />
                                        <label for="star4"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3" />
                                        <label for="star3"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2" />
                                        <label for="star2"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1" />
                                        <label for="star1"><i class="fas fa-star"></i></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="control">
                                    <textarea class="textarea is-small" id="comment" placeholder="Partilha a tua experiência sobre o curso" rows="2" style="min-height: 2.5em;"></textarea>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="control">
                                    <button type="button" class="button is-small is-primary" onclick="review()">Enviar Feedback</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <hr>
                <div class="title is-6">Outros comentários</div>
<?php           while($review = mysqli_fetch_assoc($reviews)){?>
                    <div class="columns mb-2">
                        <div class="column is-1">
                            <figure class="image is-48x48 ml-5">
                                <img class="is-rounded" src="img/users/default.png" alt="Imagem do utilizador">
                            </figure>
                        </div>
                        <div class="column">
                            <strong><?php echo $review["Name"]?></strong>
                            <div class="stars-display">
<?php                       for ($i = 0; $i < 5; $i++) { ?>
                                <span class="icon is-small">
                                    <i class="fas fa-star <?= $i < $review["Rating"] ? 'has-text-warning' : '' ?>"></i>
                                </span>
<?php                       } ?>
                                <span class="is-size-7 has-text-grey ml-2">
                                <?php echo date("d-m-Y", strtotime($review["ReviewDate"]))?>
                                </span>
                            </div>
                            <p class="mt-2"><?php echo $review["Review"]?></p>
                        </div>
                    </div>
<?php           }?>  
            </div>
        </div>
    </section>
    <?php include 'footer.php';}?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('.rating input');
        ratingInputs.forEach((input) => {
            input.addEventListener('change', function() {
                const selectedValue = this.value;
                const stars = document.querySelectorAll('.rating label i');
                
                stars.forEach((star, index) => {
                    if (5 - index <= selectedValue) {
                        star.style.color = '#ffb400';
                    } else {
                        star.style.color = '#ddd';
                    }
                });
            });
        });
    });
</script>
</html>