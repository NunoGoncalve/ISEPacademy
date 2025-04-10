<nav class="navbar has-shadow p-3">  
    <div class="navbar-brand">
        <a class="navbar-item no-hover" href="index.php">
            <img src="img/ISEPacademy-logo.svg" alt="">
        </a>
    
        <a id="navbar-burger" class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
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



<div id="custom-sidebar" class="custom-sidebar has-background-white">

        <nav class="navbar p-6">
            <a class="navbar-item is-size-4" href="index.php">Inicio</a>
            <a class="navbar-item is-size-4" href="catalogo.php">Cursos</a>
            <a class="navbar-item is-size-4" href="blog.php">Blog</a>
            <a class="navbar-item is-size-4" href="#">Forum</a>
        </nav>

</div>

<script>
    var hamburguer = document.getElementById("navbar-burger");
    var sidebar = document.getElementById("custom-sidebar");
        
    hamburguer.addEventListener('click', function() {
        
        if(hamburguer.classList.contains("is-active")) {
            sidebar.style.display = "none";
        } else {
            sidebar.style.display = "flex";
        }
         
        hamburguer.classList.toggle("is-active");
        document.documentElement.classList.toggle("lock")
    });
    
</script>

