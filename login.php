<?php 
session_start();
if(isset($_SESSION["UserID"])){
    echo '<script type="text/javascript">document.location.href="userpage.php"</script>'; 
}
?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
    
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        function login() {
            $.post("funcoes.php",{
                Func:"login",
                Email:document.getElementById("email").value,
                Pass:document.getElementById("password").value
            },function(data, status){
				if(data=="ok") { 
                    document.location="userpage.php";
                }
				else if(data=="ErroPass"){
                    document.getElementById("erro").innerHTML='<a style="color:black; text-decoration:underline" href="recpass.php">Recuperar password</a>';
                    document.getElementById("erro").style="padding:3px";
                    document.getElementById("password").style="border-color: red";
                }
                else{
                    document.getElementById("erro").innerHTML="Email não registado!";
                    document.getElementById("email").style="border-color: red";
                }
			},"text");	
        }
    </script>
</head>

<body>

    <?php
        include 'navbar.php';
    ?>

    
    <section class="section is-fullheight is-flex is-justify-content-center is-align-items-center">

        <form class="box custom-card-width" action="javascript:login()">
            
            <div class="field">
                <label class="label" for="">Email</label>    

                <div class="control has-icons-left">


                    <input required class="input" id="email" type="email" placeholder="example@example.com">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                
                </div>
                
            </div>

            <div class="field">
                <label class="label" for="">Password</label>

                <div class="control has-icons-left has-icons-right">
                    <input id="password" required class="input" type="password" >
                    <span class="icon is-small is-right is-clickable" onclick="togglePassword('password', 'toggleIcon')">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>
            <p class="erro" id="erro"></p>
            
            <button class="button is-success is-fullwidth GreyBtn" type="submit">Login</button>

            <p>Não tens conta? <a href="register.php">Cria aqui!</a> </p>

        </form>
    </section>
    <?php include 'footer.php';?>
</body>
</html>