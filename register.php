<!DOCTYPE html>
<html data-theme="light" lang="pt">  

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISEP Academy - Registo</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function register() {  
            const fileInput = document.getElementById("FileInput");
            const curriculoInput = document.getElementById("Curriculo"); 
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const role = document.getElementById("checkbox").checked;

            let imageBase64 = null;
            let curriculoBase64 = null;

            function checkAndSend() {
                if (imageBase64 !== null && curriculoBase64 !== null) {
                    sendData(name, email, password, role, imageBase64, curriculoBase64);
                }
            }

            readFile(fileInput, (base64) => {
                imageBase64 = base64; 
                checkAndSend();
            });

            readFile(curriculoInput, (base64) => {
                curriculoBase64 = base64;
                checkAndSend();
            });
        }

       
        function readFile(input, callback) {
            if (input.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    callback(event.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                callback("");
            }
        }

        function sendData(name, email, password, role, imageBase64, curriculoBase64) {
            $.post("funcoes.php", {
                Func: "register",
                Name: name,
                Email: email,
                Pass: password,
                Role: role,
                Img: imageBase64, 
                Curriculo: curriculoBase64
            }, function (data) {
                if (data === "ok") {
                    document.location = "userpage.php";
                } else if (data === "ErroMail") {
                    document.getElementById("erroMail").innerHTML = "Email já registado";
                    document.getElementById("email").style.borderColor = "red";
                }
            }, "text");
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

            if(password.value != confirm.value && confirm.value!="") {
                document.getElementById("c-erro").innerHTML="Passwords não correspondem";
                document.getElementById("c-password").style="border-color:red";
            }else{
                document.getElementById("c-erro").innerHTML="";
                document.getElementById("c-password").style="";
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

             fileInput = document.getElementById("Curriculo");

            if (fileInput.files.length > 0) {
                var fileType = fileInput.files[0].type; // Obtém o tipo MIME

                if (fileType !== "application/pdf") {
                    document.getElementById("FileError").innerHTML="Apenas .png são aceites";
                    fileInput.value="";
                }else{
                    document.getElementById("FileError").innerHTML="";
                    document.getElementById("CurrName").textContent = document.getElementById("Curriculo").files[0].name;
                }
            }
        }

        function verification(){
            

            if (document.getElementById("checkbox").checked) {
                document.getElementById("verification").hidden=0;
                document.getElementById("Curriculo").disabled=0;
            }else{
                document.getElementById("verification").hidden=1;
                document.getElementById("Curriculo").disabled=1;
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
                    <input id="password" required class="input"  minlength="10" pattern="^(?=.*[a-zA-Z])(?=.*[\W_]).+$" type="password" placeholder="At least 10 chars, 1 letter & 1 special symbol" >

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
            <div class="field">
            <label class="checkbox">
                <input type="checkbox" id="checkbox" onchange="verification()"/>
                <span class="checkmark"></span>
                Pedir cargo de professor
            </label>
            </div>
            <div class="field" id="verification" hidden="true">
                <label class="label"> Curriculo</label>
                <div id="file-js-example" class="file has-name" >
                    <label class="file-label">
                        <input class="file-input" id="Curriculo" accept="application/pdf" onchange="file()" type="file" required/>
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label"> Escolha um ficheiro </span>
                        </span>
                        <span class="file-name" id="CurrName"> Vazio </span>
                    </label>
                </div>
            </div>
            
            <button class="button is-success is-fullwidth GreyBtn">Registar</button>
            <p>Já tens conta? <a href="login.php">Fazer login!</a> </p>
        
        </form>
    </section>
   
    <?php include 'footer.php';?>
    </body>
</html>