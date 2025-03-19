<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Cursos</title>
    <!-- Importar Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <style>
        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .product-image {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
        }
        
        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-price {
            font-weight: bold;
            color: #4a4a4a;
            font-size: 1.2rem;
        }
        
        .product-actions {
            margin-top: auto;
        }
        .button.is-primary {
            background-color: #444f5a;
            border-color: transparent;
            color: #fff;
        }
        .button.is-primary:hover{
            background-color: #5a6877;
            border-color: #444f5a;
            color: #fff;
        }
        .button.is-link.is-outlined {
            background-color: #e6e6e6;
            border-color: #444f5a;
            color: #444f5a;
        }
        .button.is-link.is-outlined:hover{
            background-color: #718293;
        }

    </style>
</head>
<body>



    <!-- Encabezado de la página -->
    <section class="section">
        <div class="container">
             <!--<h1 class="title is-2 has-text-centered">Cursos Disponiveis</h1>
           <p class="subtitle has-text-centered">Descobre os nossos cursos aqui!</p>-->
        </div>
    </section>
    





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
                // Esta es la caja que se repetirá en un ciclo
                // Aquí se mostrará un solo producto como ejemplo
                // En un caso real, esto se repetiría para cada producto en la base de datos
                // Ejemplo de un producto
                $producto = [
                    'id' => 1,
                    'nombre' => 'PHP Coding',
                    'descripcion' => 'Vem connosco aprender sobre o mundo da informática!',
                    'precio' => 99.99,
                    'imagen' => 'img1.webp',
                    'categoria' => 'Informática'
                ];
                ?>
            
                <!-- Inicio del bloque de cursso que se repetirá -->
                <article class="column is-3-desktop is-4-tablet is-6-mobile">
                    <div class="card product-card" ><a href="detalhes_curso.php?id=<?echo $produto['id'];?>">
                        <div class="card-image">
                            <div class="product-image">
                                <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                            </div>
                        </div>
                        <div class="card-content product-content">
                            <p class="subtitle is-6"><?php echo $producto['categoria']; ?></p>
                            <p class="title is-5"><?php echo $producto['nombre']; ?></p>
                            <p class="content"><?php echo $producto['descripcion']; ?></p>
                            <p class="product-price">€<?php echo number_format($producto['precio'], 2); ?></p>
                            <div class="product-actions">
                                <div class="buttons">
                                    <a href="detalles.php?id=<?php echo $producto['id']; ?>" class="button is-link is-outlined is-fullwidth">Ver detalhes</a>
                                    <button class="button is-primary is-fullwidth">Inscrever</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Fin del bloque de curso -->
            
                
                <?php
                //Aquí comenzaría el ciclo para mostrar más productos
                // Por ejemplo:
                /*
                $productos = obtenerProductosDeLaBaseDeDatos();
                foreach ($productos as $producto) {
                    // Aquí iría el código HTML de la caja de producto que se repetirá para cada producto
                
                }
                */
                ?>
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
</body>
</html>