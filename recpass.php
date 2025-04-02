<?php include 'funcoes.php';?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Recuperar password</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function recpass(){
            $.post("funcoes.php",{
                Func:"Recpass",
                Email:document.getElementById("Email").value
            },function(data, status){
				if(data!="ErroMail") { 
                    document.getElementById("form").action="javascript:verify()";
                    document.getElementById("btn").innerHTML="Verificar";

                    document.getElementById("Email").disabled="true";
                    document.getElementById("Email").style="";

                    document.getElementById("InputCod").hidden="";

                    document.getElementById("Erro").innerHTML="";
                    
                    alert("Foi enviado um código de verificação para o seu email!");
                }
				else{
                    document.getElementById("Erro").innerHTML="Email não registado!";
                    document.getElementById("Email").style="border-color: red";
                }
			},"text");	
        }

        function verify(){
            $.post("funcoes.php",{
                Func:"Verify",
                Cod:document.getElementById("Cod").value
            },function(data, status){
				if(data=="ok") { 
                    document.getElementById("form").action="javascript:chpass()";
                    document.getElementById("btn").innerHTML="Mudar password";
                    document.getElementById("Cod").disabled="true";
                    document.getElementById("Cod").style="";
                    document.getElementById("InputPass").hidden="";
                    document.getElementById("Password").disabled="";
                    document.getElementById("Erro").innerHTML="";
                }else{
                    document.getElementById("Erro").innerHTML="Código inválido";
                document.getElementById("Cod").style="border-color:red";
                }
			},"text");	
        }

        function chpass(){
            $.post("funcoes.php",{
                Func:"Chpass",
                Email:document.getElementById("Email").value,
                Pass:document.getElementById("Password").value
            },function(data, status){
				if(data=="ok") { 
                    alert("Password alterada com sucesso!")
                    document.location="login.php";
                }
			},"text");	
        }

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type == "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "Password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        
    </script>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <section class="section is-fullheight is-flex is-justify-content-center is-align-items-center">

        <form class="box custom-card-width" id="form" action="javascript:recpass()">
            
            <div class="field" id="InputEmail">
                <label class="label" id="labelEmail">Insira o seu Email</label>    
                <div class="control has-icons-left">
                    <input required class="input" id="Email" type="email" placeholder="example@example.com">
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                
                </div>
            </div>

            <div class="field" hidden="true" id="InputCod">
                <label class="label" id="labelPass" for="Password">Insira o código de verificação</label>
                <div class="control has-icons-left has-icons-right">
                    <input id="Cod" class="input" type="text"></input>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="field" hidden="true" id="InputPass">
                <label class="label" id="labelPass" for="Password">Insira a sua nova password</label>
                <div class="control has-icons-left has-icons-right">
                    <input id="Password" required class="input" minlength="10" pattern="^(?=.*[a-zA-Z])(?=.*[\W_]).+$" type="password" disabled="true">

                    <span class="icon is-small is-right is-clickable" onclick="togglePassword('Password', 'toggleIcon')">
                        <i id="toggleIcon" class="fas fa-eye"></i>
                    </span>

                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>
            <p class="erro" id="Erro"></p>
            
            <button class="button is-success is-fullwidth GreyBtn" id="btn" type="submit">Recuperar password</button>            

        </form>
    </section>
    <?php include 'footer.php';?>
</body>
</html>