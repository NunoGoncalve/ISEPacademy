<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Curso Teste</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<style>
    .hero-body{
        background-image: url('https://www.site.pt/wp-content/uploads/2022/01/o-que-e-php-845x480.jpg');
        background-size: contain;
    }

    .lista{
        margin: 2% 5%;
    }

</style>

<body>
    <section class="hero is-medium">
        <div class="hero-body">
        </div>
    </section>
    <section class="lista">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li>
                    <a href="#">
                        <span>Catálogo</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Cursos</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Curso Teste</span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
    <section class="content">
        <div class="container">
            <div class="title">
                Curso PHP Coding
            </div>
            <div class="subtitle">
                Aprenda PHP do zero e torne-se um desenvolvedor web profissional!
            </div>
            <div class="boxes columns is-4" style="gap:7rem; margin-top: 2%; padding:2%">
                <div class="descricao column box block">
                    <div class="title is-5">
                        Descrição
                    </div>
                    <div class="subtitle is-6">
                        Neste curso, você dominará a linguagem PHP, desde os conceitos fundamentais até técnicas avançadas de programação. Explore a criação de sites dinâmicos, manipulação de bancos de dados com MySQL, desenvolvimento de APIs e boas práticas de segurança.
                    </div>
                </div>
                
                <div class="pagamento column box is-3">
                    <div class="title is-3">
                        99.99€
                    </div>
                    <button class="button is-success has-text-primary-100" style="width: 100%">Compra Aqui</button>
                    <button class="button is-link is-outlined" style="width: 100%; margin-top: 2%">
                        <span class="icon" style="margin-right:1%">
                            <i class="far fa-heart"></i>
                        </span>
                         Adicione aos favoritos
                    </button>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php';?>
</body>
</html>