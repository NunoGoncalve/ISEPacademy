<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

</head>

    <style>
        .button {
            background-color: #444f5a;
            color: white;

            @include mixins.until($mobile) {
                background-color: orange;
            }
        }
        .button:hover {
            background-color: #646b72;
        }

        /* Disable hover effect on specific navbar items */
        .navbar-item.no-hover:hover {
            background-color: transparent !important;
            color: inherit !important;
        }


    </style>

<body>
        <nav class="navbar has-shadow">
        
            <div class="navbar-brand">
                <a class="navbar-item no-hover" href="index.php">
                    <img src="img/ISEPacademy-logo.svg" alt="">
                </a>

                <a class="navbar-burger is-active" role="button" aria-label="menu" aria-expanded="false">
                    <span aria-hidden="true">sadsa</span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            


            <div class="navbar-menu">
                <ul class="navbar-end">
                    <a class="navbar-item" href="index.php">Inicio</a>
                    <a class="navbar-item" href="catalogo.php">Cursos</a>
                    <a class="navbar-item" href="#">Blog</a>
                    <a class="navbar-item" href="#">Forum</a>
                    <div class="navbar-item">
                        <a class="button" href="login.php">Log in</a>
                    </div>
                </ul>
            </div>
            
    
        </nav>

    

    

</body>
</html>