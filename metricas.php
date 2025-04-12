<?php session_start();
include 'funcoes.php';
//Total de Utilizadores na plataforma
$Query = "Select COUNT(*) as count from User Where Role>0";
$temp = exeDB($Query);
$totalUser=$temp['count'];

$Query = "SELECT * FROM Course where Status=1";
$cursos=exeDBList($Query);

$Query = "SELECT Count(ID) FROM Course where Status=1";
$Ncursos=exeDB($Query);
$Ncursos=$Ncursos["Count(ID)"];

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
$Query = "SELECT COUNT(*) as PessoasCompletadas from Interaction where Status = 1;";
$CursosFeitos = exeDB($Query);
$PessoasComCompletados=$CursosFeitos['PessoasCompletadas'];

//O nº de cursos lecionados/Completados
$Query = "SELECT COUNT(*) as CursosConcluidos from Course where EndDate <NOW();";
$CursosConcluidos = exeDB($Query);

$Query = "SELECT Sum(Price) as lucro from Course inner join Interaction on ID=CourseID where Interaction.Status>0";
$temp = exeDB($Query);
$Lucro=$temp["lucro"];

//Percentagem de Users
$CursosPorAcabar=$PessoasComMenosAcabados/$totalUser*100;
$CursosCompletados=$PessoasComCompletados/$totalUser*100;

?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function CourseStats(list){
            if(list.selectedIndex!=0){
                document.getElementById("CourseStats").innerHTML=list[list.selectedIndex].innerHTML;
                $.post("funcoes.php",{
                    Func:"Stats",
                    Name:list[list.selectedIndex].innerHTML
                },function(data, status){
                    if(data!="") { 
                        const [Stat1, Stat2, Stat3] = data.split('|');
                        document.getElementById("stat1").innerHTML=Stat1;
                        document.getElementById("stat2").innerHTML=Stat2;
                         document.getElementById("stat3").innerHTML=Stat3+"%";
                    }
                },"text");	
            }else{
                document.getElementById("CourseStats").innerHTML="Selecione um curso";
                document.getElementById("stat1").innerHTML=0;
                document.getElementById("stat2").innerHTML=0;
                document.getElementById("stat3").innerHTML="0%";
            }
            
        }
    </script>
</head>
<style>
    .courses{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .coursestats{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
    .column.stat{
        display: flex;
        flex-direction: column;
        align-content: center;
        justify-content: center;
        align-items: center;
    }
</style>
<body>
    <?php include 'navbar.php'; ?>
    <div class="spacing"></div>
    <h1 class="title is-1 has-text-centered mb-6">Métricas de Isep Academy</h1>
    
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
                        <p class="stats-number"><?php echo $totalUser ?></p>
                        <p class="stats-label has-text-grey">Utilizadores na plataforma</p>
                    </div>
                    
                </div>
                
                <div class="column is-4">
                    <div class="stats-card card-bestseller has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-briefcase fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo number_format($Lucro, 2); ?>€</p>
                        <p class="stats-label has-text-grey">Lucro</p>
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

                <div class="column is-4">
                    <div class="stats-card card-courses has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo $Ncursos ?></p>
                        <p class="stats-label has-text-grey">Cursos lecionados</p>
                    </div>
                </div>

                <div class="column is-4">
                    <div class="stats-card card-certs has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                                <i class="fas fa-certificate fa-2x"></i>
                            </span>
                        </div>
                        <p class="stats-number"><?php echo number_format($CursosCompletados,0)?>%</p>
                        <p class="stats-label has-text-grey">Cursos completados</p>
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
                
                <div class="column is-8">
                    <div class="stats-card card-bestseller has-background-white box">
                        <div class="card-icon has-background">
                            <span class="icon is-large has-text">
                            <i class="fa-solid fa-chart-simple fa-2x"></i>
                            </span>
                        </div>
                        <div class="courses">
                            <p class="stats-number" id="CourseStats">Selecione um curso </p>
                            <div class="select">
                                <select onchange="CourseStats(this)" id="list">
                                    <option>Selecione um curso</option>
                                    <?php 
                                    while($curso = mysqli_fetch_assoc($cursos)){
                                        echo '<option>'.$curso["Name"].'</option>';
                                    
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <!--<div class="coursestats">
                            <p class="stats-number" id="stat1">0</p>
                            <p class="stats-number" id="stat2">0</p>
                            <p class="stats-number" id="stat3">0</p>
                        </div>
                        <div class="coursestats">
                            <p class="stats-label has-text-grey">Número de inscritos</p>
                            <p class="stats-label has-text-grey">Número de concluidos</p>
                            <p class="stats-label has-text-grey">Taxa de finalização</p>
                        </div>-->
                        <div class="columns">
                            <div class="column is-4 stat">
                                <p class="stats-number" id="stat1">0</p>
                                <p class="stats-label has-text-grey">Número de inscritos</p>
                            </div>
                            <div class="column is-4 stat">
                                <p class="stats-number" id="stat2">0</p>
                                <p class="stats-label has-text-grey">Número de concluidos</p>
                            </div>
                            <div class="column is-4 stat">
                                <p class="stats-number" id="stat3">0%</p>
                                <p class="stats-label has-text-grey">Taxa de finalização</p>
                            </div>
                        </div>
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