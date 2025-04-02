<?php session_start();
include 'funcoes.php'; ?>

<!DOCTYPE html >
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<style>

    html, body {
        height: 100%; /* Make sure the page takes the full height */
        display: flex;
        flex-direction: column; /* Makes the body a vertical flex container */
    }

    .dashboard-custom-border {
        border-right: 2px solid black;
    }

    .box.no-padding {
        padding: 0px;
    }

    .custom-card {
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
    }

    .has-divider {
  border-right: 2px solid rgba(0, 0, 0, 0.1); /* Light gray */
}


</style>

<body>
    <div class="section">
        <nav class="navbar py-3">
            <div class="navbar-brand">
                <a class="navbar-item no-hover" href="index.php">
                    <img src="img/ISEPacademy-logo.svg" alt="">
                </a>

                <a class="navbar-burger is-active" role="button" aria-label="menu" aria-expanded="false">
                    <span aria-hidden="true"></span>
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
                        <?php 
                        if(isset($_SESSION["UserID"])){
                            echo '<a class="button GreyBtn" href="userpage.php">Conta</a>';
                        }else{
                            echo '<a class="button GreyBtn" href="login.php">Log in</a>';
                        }
                            
                        ?>
                    </div>
                </ul>
            </div>
        </nav>
    </div>



    <div class="section">
        <div class="columns is-gapless custom-card">
            
            <!-- Menu lateral, desaparece em dispositivos mobile-->
            <div id="side-bar" class="column is-3-desktop is-4-tablet is-hidden-mobile has-divider" style="">
                
                <div id="profile" class="columns p-4">
                    <div class="column">
                        
                        <div class="">
                            <figure class="image is-128x128">
                                <img src="img/users/default.png" alt="Image" />
                            </figure>
                        </div>
                        
                        
                        <div class="">
                                <div class="">
                                        <p><strong>example@gmail.com</strong>
                                        <br>
                                        <small>Usuario_de_teste</small></p>
                                </div>
                            </div>
                    </div>
                </div> 
                
                <div id="options" class="columns p-4">
                        <div class="column">
                            <aside class="menu">
                                <p class="menu-label">General</p>
                                <ul class="menu-list">
                                    <li><a>Dashboard</a></li>
                                    <li><a>Customers</a></li>
                                </ul>
                                <p class="menu-label">Administration</p>
                                <ul class="menu-list">
                                    <li><a>Team Settings</a></li>
                                    <li>
                                    
                                    </li>
                                    <li><a>Invitations</a></li>
                                    <li><a>Cloud Storage Environment Settings</a></li>
                                    <li><a>Authentication</a></li>
                                </ul>
                                <p class="menu-label">Transactions</p>
                                <ul class="menu-list">
                                    <li><a>Payments</a></li>
                                    <li><a>Transfers</a></li>
                                    <li><a>Balance</a></li>
                                </ul>
                        </aside>
                    </div>
                </div>


            </div>
            
            <!-- top bar para o menu hamburger, obs -> so é visivel em dispositivos mobile -->
            <div class="column is-hidden-tablet">
                <div class="columns p-6"> 
                    <div class="column has-background-danger">
                        <h2>hamburger</h2>
                    </div>
                </div>
            </div>

            <!-- Display de conteudo -->
            <div class="column">
                <div class="columns p-6">
                    <div class="column">
                        <h2>My Courses</h2> 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
                    $cursos = getUserSubs();
                    while ($curso = mysqli_fetch_assoc($cursos)) {
                    echo '<div class="card">
                                <div class="card-image"
                                    <div class="product-image">
                                        <img style="width:200px" src="img/layout/img' . $curso["ID"] . '.jpg" alt="">
                                    </div>
                                </div>
                                <div class="card-content product-content">
                                    <p class="subtitle is-6">' . $curso["Name"] . '</p>
                                    <p class="title is-5">' . $curso["Category"] . '</p>    
                                </div>
                            </div>';
                    }?>
    





    <footer class="footer is-fixed-bottom" style="margin-top:8%;padding-bottom: 70px;padding-top: 25px;">
    <div class="columns">
        <div class="column">
            <h4 class="bd-footer-title has-text-weight-medium has-text-left"> 
                    ISEP Academy
            </h4> 
            <p class="bd-footer-link has-text-left">
                © 2025 ISEP Academy - Todos os direitos reservados.  
                <br>
                Aprenda com os melhores! Oferecemos cursos online de alta qualidade para impulsionar sua carreira. Entre em contato! | Siga-nos nas redes sociais. 🚀
            </p>
        </div>
        <div class="column">
            <br>
            <figure class="image" style="max-width: 50%; margin: auto;">
                <img src="img/01ISEPacademylogo.png" alt="logo ISEP Academy">
            </figure>
        </div>
    </div>
</footer>

    <script>

    </script>

</body>
</html>