<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
        }

        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("img/01ISEPacademylogo.png");
            background-repeat: no-repeat;
            background-position: center; /* Centraliza a imagem */
        }

        .about-section {
            background: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .about-content {
            position: relative;
            z-index: 2;
        }

        .stats-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stats-box:hover {
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #363636;
            margin-bottom: 0.5rem;
        }

        .feature-card, .course-card {
            background-color: white;
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .feature-card:hover, .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .course-card {
            display: flex;
            flex-direction: column;
        }

        .course-card .card-content {
            flex-grow: 1;
        }

        .course-card .price-tag {
            font-size: 1.8rem;
            margin: 1rem 0;
        }

        .course-card .button {
            align-self: center;
            width: 100%;
        }

        .course-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(45deg, #363636, #4a4a4a);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .cta-section {
            background: rgba(250, 250, 250, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(238, 238, 238, 0.5);
            border-radius: 12px;
            padding: 3rem;
            margin: 4rem 0;
        }

        .price-tag {
            font-size: 2.5rem;
            color: #363636;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .enroll-button {
            background: linear-gradient(45deg, #4a4a4a, #363636);
            color: white;
            font-weight: bold;
            padding: 1.5rem 3rem;
            border-radius: 8px;
            border: none;
            font-size: 1.2rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .enroll-button:hover {
            background: linear-gradient(45deg, #363636, #4a4a4a);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="hero is-medium">
        <div class="hero-body">
        </div>
    </section>
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="columns is-vcentered">
                    <div class="column is-6">
                        <h2 class="title is-1 mb-6">Sobre o ISEP Academy</h2>
                        <p class="subtitle is-4 has-text-grey mb-5" style="max-width:75%; text-align: justify;">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorem autem dolor veniam voluptatem veritatis asperiores esse nobis ducimus incidunt repellendus at minima, voluptates excepturi consectetur earum id aspernatur. Odit, rem!
                        </p>
                    </div>
                    <div class="column is-6">
                        <div class="columns is-multiline">
                            <div class="column is-6">
                                <div class="stats-box">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-user-graduate fa-2x"></i>
                                    </span>
                                    <p class="stats-number">0000+</p>
                                    <p class="has-text-grey">Alunos Formados</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-briefcase fa-2x"></i>
                                    </span>
                                    <p class="stats-number">00%</p>
                                    <p class="has-text-grey">Taxa de Empregabilidade</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                    </span>
                                    <p class="stats-number">00+</p>
                                    <p class="has-text-grey">Instrutores Especialistas</p>
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="stats-box">
                                    <span class="icon is-large has-text-grey-dark mb-4">
                                        <i class="fas fa-handshake fa-2x"></i>
                                    </span>
                                    <p class="stats-number">000+</p>
                                    <p class="has-text-grey">Empresas Parceiras</p>
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
                        <h3 class="title is-4 mt-4">Cursos Acessiveis</h3>
                        <p class="has-text-grey">
                            Cursos Acessíveis que oferecem formação de qualidade a um preço justo, tornando assim a educação ao alcance de todos..
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
                            Curso 100% online, com aulas práticas e interativas.
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
            
                <?php 
                    $producto = [
                        'id' => 1,
                        'nombre' => 'PHP Coding',
                        'descripcion' => 'Vem connosco aprender sobre o mundo da informática!',
                        'precio' => 99.99,
                        'imagen' => 'img/cursos/img1.jpg',
                        'categoria' => 'Informática'
                    ];
                ?>
            
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
                
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>