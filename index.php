<?php session_start(); include 'funcoes.php'; 
$Query="Select Count(DISTINCT UserID) as c from Interaction where Status=2";
$temp=exeDB($Query);
$AlunosFormados=$temp["c"];

$Query="Select Count(ID) as c from User where Role=2";
$temp=exeDB($Query);
$professores=$temp["c"];

$Query="Select Count(ID) as c from Course where Status=1";
$temp=exeDB($Query);
$cursos=$temp["c"];

$Query="Select Count(StepID) as c from UserSteps where Done=1";
$temp=exeDB($Query);
$modulosConcluidos=$temp["c"];



?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="hero is-medium" style="height: 400px;">
        <div class="hero-body" 
            style=" background-image: url('img/layout/hero-image.jpg'); background-size:cover; background-position: center;
                    background-repeat: no-repeat;" >
            <!-- Conteúdo do hero section -->
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="columns is-vcentered">
                    <div class="column is-6 fade-up">
                        <h2 class="title is-2 mb-5">Sobre o ISEP Academy</h2>
                        <p class="subtitle is-5 has-text-grey mb-5">
                        AVISO: As informações contidas são apenas para efeitos académicos!<br><br>O ISEP Academy conta com diversos cursos disponiveis desde cursos básicos a cursos avançados.<br> Este website foi desenvolvido com o objetivo de ajudar jovens estudantes que queiram aprender mais sobre a sua área ou pessoas que queiram aprender novas skills
                        </p>
                    </div>
                    <div class="column is-6">
                        <div class="columns is-multiline">
                            <div class="column is-6">
                                <div class="stats-box" style="box-shadow: 0 4px 8px #718293;">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-user-graduate fa-2x"></i>
                                    </span>
                                    <p class="stats-numberr"><?php echo $AlunosFormados?></p>
                                    <p class="has-text-grey">Alunos Formados</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box" style="box-shadow: 0 4px 8px #718293;">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-briefcase fa-2x"></i>
                                    </span>
                                    <p class="stats-numberr"><?php echo $modulosConcluidos?></p>
                                    <p class="has-text-grey">Módulos concluidos</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box" style="box-shadow: 0 4px 8px #718293;">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                    </span>
                                    <p class="stats-numberr"><?php echo $professores?></p>
                                    <p class="has-text-grey">Instrutores Especialistas</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box" style="box-shadow: 0 4px 8px #718293;">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-handshake fa-2x"></i>
                                    </span>
                                    <p class="stats-numberr"><?php echo $cursos?></p>
                                    <p class="has-text-grey">Cursos disponiveis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                <div class="column is-4">
                    <div class="feature-card">
                        <span class="icon is-large has-text-grey-dark">
                            <i class="fas fa-laptop-code fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mt-4">Cursos Acessíveis</h3>
                        <p class="has-text-grey">
                            Cursos que oferecem formação de qualidade a um preço justo, tornando a educação ao alcance de todos.
                        </p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="feature-card">
                        <span class="icon is-large has-text-grey-dark">
                            <i class="fas fa-users fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mt-4">Cursos 100% Online</h3>
                        <p class="has-text-grey">
                            Curso totalmente online, com aulas práticas e interativas.
                        </p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="feature-card">
                        <span class="icon is-large has-text-grey-dark">
                            <i class="fas fa-certificate fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mt-4">Certificado</h3>
                        <p class="has-text-grey">
                            Receba um certificado após concluir o curso.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section top-courses-section">
        <div class="container">
            <h2 class="title is-2 has-text-centered mb-6">Cursos Mais Populares</h2>
            
            <div class="columns is-multiline">
            <?php
                $Query = "SELECT Course.*, Count(CourseID) As Nsubs from Course inner join Interaction on Course.ID=Interaction.CourseID where Course.Status=1 group by Course.ID Order by (Nsubs) desc Limit 4";
                $exe = exeDBList($Query);
                while($CourseInfo = mysqli_fetch_assoc($exe)) { 
            ?>
            <!-- Inicio del bloque de cursso que se repetirá -->
            <article class="column is-3-desktop is-4-tablet is-20-mobile">
                <div class="card product-card" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">
                        <div class="card-image">
                            <div class="product-image">
                                <img src="<?php echo "img/layout/".$CourseInfo['ID'].".jpg"; ?>" alt="<?php echo $CourseInfo['Name']; ?>">
                            </div>
                        </div>
                        <div class="card-content product-content">
                            <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                            <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                            <p class="content" id="cardText"><?php echo $CourseInfo['CardDesc']; ?></p>
                            <div class="product-actions">
                                <div class="buttons">
                                    <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>"
                                        class="button is-primary is-fullwidth">Ver detalhes</a>                                   
                                </div>
                            </div>
                        </div>
                </div>
            </article>
            <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function checkVisibility() {
            const elements = document.querySelectorAll('.fade-up');
            
            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                // Se o elemento estiver visível na viewport
                if (rect.top <= windowHeight * 0.85) {
                    element.classList.add('visible');
                }
            });
        }

        setTimeout(checkVisibility, 300);

        window.addEventListener('scroll', checkVisibility);
    });
</script>
</html>