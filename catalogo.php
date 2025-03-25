<?php session_start(); ?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Cursos</title>
    <!-- Importar CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">

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
                include 'conexao.php';
                $Sel = "Select * from Course";
                $exe = mysqli_query($conexao, $Sel);
                while($row = mysqli_fetch_assoc($exe)){ 
            ?>
            <!-- Inicio del bloque de cursso que se repetirá -->
            <article class="column is-3-desktop is-4-tablet is-6-mobile">
                <div class="card product-card"><a href="curso.php?ID=<?php echo $row['ID']; ?>">
                        <div class="card-image">
                            <div class="product-image">
                                <img src="<?php echo "img/layout/img".$row['ID'].".jpg"; ?>" alt="<?php echo $row['Name']; ?>">
                            </div>
                        </div>
                        <div class="card-content product-content">
                            <p class="subtitle is-6"><?php echo $row['Category']; ?></p>
                            <p class="title is-5"><?php echo $row['Name']; ?></p>
                            <p class="content" id="cardText"><?php echo $row['CardDesc']; ?></p>
                            <p class="product-price">€<?php echo number_format($row['Price'], 2); ?></p>
                            <div class="product-actions">
                                <div class="buttons">
                                    <a href="curso.php?ID=<?php echo $row['ID']; ?>"
                                        class="button is-info is-outlined is-fullwidth">Ver detalhes</a>
                                    <button class="button is-primary is-fullwidth">Inscrever</button>
                                </div>
                            </div>
                        </div>
                </div>
            </article>
            <?php } ?>
            <!-- Fin del bloque de curso -->

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
    </article>
    <?php include 'footer.php';?>
</body>

</html>