<!DOCTYPE html>
<html data-theme="light" lang="pt">  

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function register(){
            $.post("funcoes.php",{
                Func:"register",
                Name:document.getElementById("name").value,
                Email:document.getElementById("email").value,
                Pass:document.getElementById("password").value

            },function(data, status){
                if(data=="ok") { 
                    document.location="userpage.php";
                }
            },"text");	
        }

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

        function validatePassword() {
            
            let password = document.getElementById("password");
            let confirm = document.getElementById("c-password");

            if (password.value.length >= 8) {

                if(password.value != confirm.value && confirm.value!="") {
                    alert("passwords dont match");
                }
            }
            else {
                alert("password must be 8 characters");
            }

        }

        function showErrorMessage() {

        }
    </script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <section class="section is-fullheight is-flex is-justify-content-center is-align-items-center ">
        <form id="register" class="box custom-card-width" action="javascript:register()">
            <div class="field">
                <label class="label" for="">Username</label>
                <div class="control has-icons-left">
                    <input required class="input" id="name" type="text" placeholder="username">
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>

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
                    <input id="password" required class="input" onchange="validatePassword()"type="password" >

                    <span class="icon is-small is-right is-clickable" onclick="togglePassword('password', 'toggleIcon')">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>

                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label" for="">Confirm Password</label>
                <div class="control has-icons-left has-icons-right">
                    <input id="c-password" required class="input" onchange="validatePassword()" type="password">
                    <span class="icon is-small is-right is-clickable" onclick="togglePassword('c-password', 'c-toggleIcon')">
                        <i id="c-toggleIcon" class="fas fa-eye"></i>
                    </span>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>
            <button class="button is-success is-fullwidth" id="GreyBtn">Register</button>
            <p>Já tens conta? <a href="login.php">Fazer login!</a> </p>
        </form>
    </section>
   
    <?php include 'footer.php';?>
    </body>
</html>