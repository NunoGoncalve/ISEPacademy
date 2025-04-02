<?php session_start(); include 'funcoes.php';?>

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
</head>

<body>

    <?php include 'navbar.php'; ?>
        
    <!-- Contenido principal -->
    <article class="section">
        <div class="container">
            <!-- Filtros y búsqueda (opcional) -->
            <div class="columns mb-5">
                <div class="column is-3">
                    <div class="field">
                        <label class="label">Categoría</label>
                        <div class="control">
                            <div class="select is-fullwidth">

                                <select>
                                    <option>Todas as categorías</option>
                                    <option>Informática</option>
                                    <option>Mecánica</option>
                                    <option>Eletricidade</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Buscar</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" placeholder="Buscar cursos...">
                            <span class="icon is-small is-left">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        


            <!-- Catálogo de cursos -->
            <div class="columns is-multiline">
                <?php
                    Switch ($_SESSION["Role"]) {
                        case 2:
                            $Query = "Select * from Course where TeacherID=".$_SESSION["UserID"]." AND Status<3";
                        break;
                        case 3:
                            $Query = "Select * from Course";
                        break;
                        default:
                            $Query = "Select * from Course where Status=1";
                        break;
                    }
                    $exe = exeDBList($Query);
                    
                    while($CourseInfo = mysqli_fetch_assoc($exe)){ 
                        
                ?>
                <!-- Inicio do bloco de curso que se repetirá -->
                <article class="column is-3-desktop is-4-tablet is-6-mobile <?php echo ($CourseInfo["Status"] > 1) ? 'unavailable-card' : '';?> " onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">
                    <div class="card product-card ">
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
                                    <?php if($_SESSION["Role"]>1){
                                            Switch ($CourseInfo["Status"]){
                                                case 1: 
                                                    echo '<a href="editar_curso.php?ID='.$CourseInfo['ID'].'" class="button is-info is-outlined is-fullwidth">Editar Curso</a>
                                                    <button class="button is-primary is-fullwidth is-red" onclick="DelCourse("'.$CourseInfo['ID'].'")">Remover</button>';
                                                    break;
                                                case 2: 
                                                    echo '<a class=" is-fullwidth"></a>
                                                    <button class="button is-primary is-fullwidth ">Em analise</button>';
                                                    break;
                                                case 3: 
                                                    echo '<a class=" is-fullwidth"></a>
                                                    <button class="button is-primary is-fullwidth ">Desativado</button>';
                                                    break;                                                                                                                                                       
                                            }   
                                        }else{
                                            echo '<a href="curso.php?ID='.$CourseInfo["ID"].'"
                                                class="button is-primary is-fullwidth">Ver detalhes</a>';
                                        }
                                        
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <?php } ?>
                <!-- Fim do bloco de curso -->
            </div>

            <!-- Paginación en caso de necesidad 
                <div class="pagination is-centered mt-6">
                    <ul class="pagination-list">
                        <li><a class="pagination-link is-current" aria-label="Ir a página 1" aria-current="page">1</a></li>
                        <li><a class="pagination-link" aria-label="Ir a página 2">2</a></li>
                        <li><a class="pagination-link" aria-label="Página 3">3</a></li>
                        <li><a class="pagination-link" aria-label="Ir a página 4">4</a></li>
                    </ul>
                </div>-->
        </div>
    </article>
    <?php include 'footer.php';?>
</body>

</html>