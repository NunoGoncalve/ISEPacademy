<!DOCTYPE html>
<html data-theme="light" lang="pt">  

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registo</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function register(){
            
            var fileInput = document.getElementById("FileInput"); // Input file
            var reader = new FileReader();
            if (fileInput.files.length > 0) {
                reader.onload = function(event) {
                var imageBase64 = event.target.result;
                $.post("funcoes.php",{
                    Func:"register",
                    Name:document.getElementById("name").value,
                    Email:document.getElementById("email").value,
                    Pass:document.getElementById("password").value,
                    Img:imageBase64
                    
                },function(data, status){
                    if(data=="ok") { 
                        document.location="userpage.php";
                    }else if(data=="ErroMail"){
                        document.getElementById("erroMail").innerHTML="Email já registado";
                        document.getElementById("email").style="border-color:red";
                    }
                    },"text");	
                }
                reader.readAsDataURL(fileInput.files[0]); // Converte a imagem antes do envio
            }else{
                $.post("funcoes.php",{
                    Func:"register",
                    Name:document.getElementById("name").value,
                    Email:document.getElementById("email").value,
                    Pass:document.getElementById("password").value,
                    
                },function(data, status){
                    if(data=="ok") { 
                        document.location="userpage.php";
                    }else if(data=="ErroMail"){
                        document.getElementById("erroMail").innerHTML="Email já registado";
                        document.getElementById("email").style="border-color:red";
                    }
                    },"text");	
            }
            
            
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
                document.getElementById("erro").innerHTML="";
                if(password.value != confirm.value && confirm.value!="") {
                    document.getElementById("c-erro").innerHTML="Passwords não correspondem";
                    document.getElementById("c-password").style="border-color:red";
                }else{
                    document.getElementById("c-erro").innerHTML="";
                    document.getElementById("c-password").style="";
                    document.getElementById("password").style="";
                }
            }
            else {
                document.getElementById("erro").innerHTML="Password necessita de 8 caracteres!";
                document.getElementById("password").style="border-color:red";
            }

        }

        
   
    function file(){
        var fileInput = document.getElementById("FileInput");

        if (fileInput.files.length > 0) {
            var fileType = fileInput.files[0].type; // Obtém o tipo MIME

            if (fileType !== "image/png") {
                document.getElementById("FileError").innerHTML="Apenas .png são aceites";
                fileInput.value="";
            }else{
                document.getElementById("FileError").innerHTML="";
                document.getElementById("FileName").textContent = document.getElementById("FileInput").files[0].name;
            }
        }
    }
    
    </script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <section class="section is-fullheight is-flex is-justify-content-center is-align-items-center ">
        <form id="register" class="box custom-card-width" action="javascript:register()">
            <div class="field">
                <label class="label" for="name">Username</label>
                <div class="control has-icons-left">
                    <input required class="input" id="name" type="text" placeholder="username">
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>

            <!-- Inserir Email -->
            <div class="field">
                <label class="label" for="email">Email</label>    
                <div class="control has-icons-left">
                    <input required class="input" id="email" type="email" placeholder="example@example.com">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>
            <p class="erro" id="erroMail"></p>

            <!-- Inserir Password -->
            <div class="field">
                <label class="label" for="password">Password</label>
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
            <p class="erro" id="erro"></p>

            <!-- Comfirmar Password -->
            <div class="field">
                <label class="label" for="c-password">Confirmar Password</label>
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
            <p class="erro" id="c-erro"></p>

            <!-- Inserir Imagem -->
            <label class="label"> Imagem de perfil</label>
            <div id="file-js-example" class="file has-name">
                <label class="file-label">
                    <input class="file-input" id="FileInput" accept="image/png" onchange="file()" type="file" name="resume" />
                    <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label"> Escolha um ficheiro </span>
                    </span>
                    <span class="file-name" id="FileName"> Vazio </span>
                </label>
            </div>
            <p class="erro" id="FileError"></p>
            <button class="button is-success is-fullwidth GreyBtn">Registar</button>
            <p>Já tens conta? <a href="login.php">Fazer login!</a> </p>
        
        </form>
    </section>
   
    <?php include 'footer.php';?>
    </body>
</html>