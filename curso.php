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

        $Query="Select UserID, Name, Rating, Review, ReviewDate from Interaction inner join User on Interaction.UserID=User.ID where CourseID=".$CourseID." and ReviewDate<>'0000-00-00'";
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
            Rating:document.querySelector('[name="rating"]:checked').value,
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
                    document.getElementById("StepBtn"+StepID).innerHTML=
                    '<svg width="16" height="16" viewBox="0 0 24 24" fill="none"'+
                    'xmlns="http://www.w3.org/2000/svg" class="check-icon">'+
                    '<path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'+
                    '</svg>Concluído';
                    document.getElementById("StepBtn"+StepID).onclick='';
                    document.getElementById("StepBtn"+StepID).className='btn-completed';
                    document.getElementById("badge"+StepID).className='.module-badge completed';

                }
                else{
                    alert("Parabéns acabou o curso! O certificado foi enviado para o seu email. Não se esqueça de deixar feedback")
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
<?php                   $startDate = strtotime($CourseInfo["StartDate"]); // Converte a string da data do curso para timestamp
                        $today = strtotime(date("d-m-Y"));
                        if($startDate>$today){?>
                            document.getElementById("sub").innerHTML='Inscreve-te!';
                            document.getElementById("sub").setAttribute("onclick", "location.href='pagamento.php?CourseID=<?php echo $CourseID?>';");
<?php                   }else{?>
                            document.getElementById("sub").innerHTML='Fechado!';
                            document.getElementById("sub").setAttribute("onclick", "");
<?php                   }?>
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
        
    function toggleModule(headerElement) {
        // Toggle active class for current header
        headerElement.classList.toggle('active');
    }

    function togglePdf(id){
        document.getElementById('PdfModal').classList.toggle('is-active');
        if(id>0){
            document.getElementById('Framepdf').src="cursos/<?php echo $CourseID?>/"+id+".pdf";
        }
        
    }

    </script>
    <style>
        .hero-body{
            background-image: url('img/cursos/<?php echo $CourseID?>.jpg');
            background-size: contain;
        }

        .modules-wrapper {
            --primary-color: #718293;
            --completed-color: #2ec4b6;
            --bg-color: #ffffff;
            --text-color: #333333;
            --border-color: #e9ecef;
            --hover-color: #f8f9fa;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }
    
        .modules-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
            padding: 0 0.5rem;
        }
        
        .modules-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .module-card {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            background-color: var(--bg-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .module-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .module-header {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            position: relative;
            transition: background-color 0.2s ease;
        }
        
        .module-header:hover {
            background-color: var(--hover-color);
        }
        
        .module-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 0.75rem;
        }

        .module-badge.completed {
            background-color: var(--completed-color);
            
        }
        
        .module-name {
            font-weight: 500;
            font-size: 1rem;
            color: var(--text-color);
            flex-grow: 1;
        }
        
        .module-toggle {
            color: #888;
            transition: transform 0.3s ease;
        }
        
        .module-header.active .module-toggle {
            transform: rotate(180deg);
        }
        
        .module-content {
            padding: 0;
            padding-left: 1rem;
            padding-right: 1rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }
        
        .module-header.active + .module-content {
            padding: 1rem;
            max-height: 90%;
            border-top: 1px solid var(--border-color);
        }
        
        .module-content p {
            margin: 0 0 1rem;
            color: #555;
            line-height: 1.5;
            font-size: 0.95rem;
        }
        
        .module-actions {
            display: flex;
            justify-content: space-between;
        }
        
        .btn-action, .btn-completed {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .btn-action {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-completed {
            background-color: var(--completed-color);
            color: white;
        }
        
        .check-icon {
            stroke: white;
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
                    <button class="button is-primary" id="sub" onclick="location.href='pagamento.php';"" style="width: 100%"> </button>
                    <button class="button is-link is-outlined" id="fav" onclick="favourite()" style="width: 100%; margin-top: 2%"> </button>
                       
                </div>
            </div>
<?php       if($Info["Status"]>=1 || $_SESSION["Role"]>1){ ?>             
                <div class="descricao column box block">
                    <div class="title is-5"> <?php echo $CourseInfo["Name"]?></div>
                        <div class="subtitle is-6">
                            Bem vindo ao curso <?php echo $CourseInfo["Name"]?> abaixo tens acesso a toda a informação disponivel.<br>
                            Não te esqueças de deixar o teu feedback quando completares o curso.<br> Boa sorte!<br>
                            
                        </div><br>
                        <div class="section">
                            <div class="modules-wrapper">
                            <h3 class="modules-title">Módulos/Etapas</h3>
                                <div class="modules-list">
<?php                               while ($modulo = mysqli_fetch_assoc($modulos)) : ?>
                                        <div class="module-card">
                                            <div class="module-header" onclick="toggleModule(this)">
                                                <div class="module-badge <?php if(in_array($modulo['ID'], $modulosConcluidos)){ echo "completed";} ?>" id="badge<?php echo $modulo['ID']; ?>"><?php echo $modulo['ID']; ?></div>
                                                <div class="module-name"><?php echo htmlspecialchars($modulo['Name']); ?></div>
                                                <div class="module-toggle">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            
                                            <div class="module-content">
                                                <p><?php echo $modulo['Description']; ?></p>
                                                
                                                <div class="module-actions">

                                                    <button onclick="togglePdf(<?php echo $modulo['ID']; ?>)" class="button is-link is-outlined">Abrir ficheiro</button>
<?php                                               
                                                    if($_SESSION["Role"]>1):

                                                    elseif(in_array($modulo['ID'], $modulosConcluidos)): ?>
                                                        <button class="btn-completed" id="StepBtn<?php echo $modulo['ID']; ?>">
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="check-icon">
                                                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            Concluído
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn-action" onclick="save(<?php echo $modulo['ID']; ?>)" id="StepBtn<?php echo $modulo['ID']; ?>">
                                                            Marcar como concluído
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
    <?php                           endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php       } ?>        
        </div>
    </section>
    <div class="modal" id="PdfModal">
        <div class="modal-background"></div>
            <div class="modal-card pdf" >
            <header class="modal-card-head">
                    <p class="modal-card-title">Módulo</p>
                    <button class="delete" aria-label="close" onclick="togglePdf()"></button>
                </header>
                <section class="modal-card-body">
                <div class="field pdf">
                <iframe class="Framepdf" title="Iframe Example" id="Framepdf"></iframe>
                </div>
                </section>
        </div>
    </div>
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