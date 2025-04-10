<?php session_start();
include 'funcoes.php';
//Total de Utilizadores na plataforma
$Query = "Select COUNT(*) as count from User";
$contadorUsers = exeDB($Query);
$total=$contadorUsers['count'];


//O curso mais vendido/Com Mais inscritos
$Query = "SELECT c.Name as NomeCurso, COUNT(*) as Maior from Interaction i JOIN Course c ON CourseID=c.ID where i.Status > 0 GROUP BY CourseID ORDER BY Maior desc, c.Name;";
$CursoMaisVendido = exeDB($Query);

//O curso menos vendido
$Query = "SELECT c.Name as NomeCurso, COUNT(*) as Maior from Interaction i JOIN Course c ON CourseID=c.ID where i.Status > 0 GROUP BY CourseID ORDER BY Maior asc, c.Name;";
$CursoMenosVendido = exeDB($Query);


//O Curso Menos Completado
$Query = "SELECT c.Name as NomeCurso, COUNT(*) as Maior from Interaction i JOIN Course c ON CourseID=c.ID where i.Status = 1 GROUP BY CourseID ORDER BY Maior desc, c.Name;";
$CursoMenosCompletado = exeDB($Query);

//Nº de pessoas que não acabaram cursos
$Query = "SELECT c.Name as NomeCurso, COUNT(*) as Menos from Interaction i JOIN Course c ON CourseID=c.ID where i.Status = 1;";
$CursoMenosAcabado = exeDB($Query);
$PessoasComMenosAcabados=$CursoMenosAcabado['Menos'];

//Nº de pessoas que completaram cursos
$Query = "SELECT COUNT(*) as PessoasCompletadas from Interaction i where i.Status = 1;";
$CursosFeitos = exeDB($Query);
$PessoasComCompletados=$CursosFeitos['PessoasCompletadas'];

//O nº de cursos lecionados/Completados
$Query = "SELECT COUNT(*) as CursosConcluidos from Course i where EndDate <NOW();";
$CursosConcluidos = exeDB($Query);

//Percentagem de Users
$CursosPorAcabar=$PessoasComMenosAcabados/$total*100;
$CursosCompletados=$PessoasComCompletados/$total*100;

?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="hero is-medium">
        <div class="hero-body">
            <!-- Conteúdo do hero section -->
        </div>
    </section>

    <section class="dashboard-section">
        <div class="container">
            <div class="columns is-multiline is-variable is-4">

                <div class="column is-4">
                    <div class="stats-card card-users has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-user-graduate fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $contadorUsers['count'] ?></p>
                        <p class="stats-label has-text-grey">Utilizadores na plataforma</p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="stats-card card-courses has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $CursosConcluidos['CursosConcluidos']; ?></p>
                        <p class="stats-label has-text-grey">Cursos lecionados</p>
                    </div>
                </div>
                <!--<div class="column is-4">
                    <div class="stats-card card-least has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $CursoMenosCompletado['NomeCurso']; ?></p>
                        <p class="stats-label has-text-grey">Curso menos concluído</p>
                    </div>
                </div>-->

                <div class="column is-4">
                    <div class="stats-card card-certs has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-certificate fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo number_format($CursosCompletados,0)?>%</p>
                        <p class="stats-label has-text-grey">Pessoas com cursos completados</p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="stats-card card-incomplete has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo number_format($CursosPorAcabar,0)?>%</p>
                        <p class="stats-label has-text-grey">Pessoas com cursos por acabar</p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="stats-card card-incomplete has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $CursoMenosVendido['NomeCurso']?></p>
                        <p class="stats-label has-text-grey">Curso Menos Vendido</p>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="stats-card card-bestseller has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-briefcase fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $CursoMaisVendido['NomeCurso']; ?></p>
                        <p class="stats-label has-text-grey">Curso mais vendido</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {

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