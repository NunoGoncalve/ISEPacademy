<?php session_start(); include 'funcoes.php'; ?>
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

    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="columns is-vcentered">
                    <div class="column is-6">
                        <h2 class="title is-1 mb-6">Sobre o ISEP Academy</h2>
                        <p class="subtitle is-4 has-text-grey mb-5" style="max-width:75%; text-align: justify;">
                        AVISO: As informações contidas são apenas para efeitos académicos!<br><br>
                        O ISEP Academy conta com diversos cursos disponíveis desde cursos básicos a cursos avançados.<br>
                        Este website foi desenvolvido com o objetivo de ajudar jovens estudantes que queiram aprender mais sobre a sua área ou pessoas que queiram aprender novas skills.
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
                $Query = "SELECT Course.*, Count(CourseID) As Nsubs from Course inner join Interaction on Course.ID=Interaction.CourseID group by Course.ID Order by (Nsubs) desc";
                $exe = exeDBList($Query);
                while($CourseInfo = mysqli_fetch_assoc($exe)) { 
            ?>
            <!-- Inicio del bloque de cursso que se repetirá -->
                <article class="column is-3-desktop is-4-tablet is-6-mobile is-one-third">
                    <div class="card product-card">
                        <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>">
                            <div class="card-image">
                                <div class="product-image">
                                    <img src="<?php echo "img/layout/img".$CourseInfo['ID'].".jpg"; ?>" alt="<?php echo $CourseInfo['Name']; ?>">
                                </div>
                            </div>
                            <div class="card-content product-content">
                                <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                                <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                                <p class="content" id="cardText"><?php echo $CourseInfo['CardDesc']; ?></p>
                                <p class="product-price">€<?php echo number_format($CourseInfo['Price'], 2); ?></p>
                                <div class="product-actions">
                                    <div class="buttons">
                                        <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>"
                                            class="button is-info is-outlined is-fullwidth">Ver detalhes</a>
                                        <button class="button is-primary is-fullwidth">Inscrever</button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
            <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>