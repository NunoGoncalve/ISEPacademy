<nav class="navbar has-shadow">  
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
            <a class="navbar-item" href="blog.php">Blog</a>
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
