<?php session_start(); include 'funcoes.php';
if (!isset($_SESSION['UserID'])) {
    echo '<script type="text/javascript">document.location.href="login.php"</script>'; 
}
?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Conta</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function logout() {
            $.post("funcoes.php", { Func: "logout" }, function (data, status) {
                if (data == "ok") {
                    document.location = "login.php";
                }
            }, "text");
        }

        function DelCourse(CourseID){ 
            if (confirm("Tem a certeza que deseja remover o curso?")) {
                $.post("funcoes.php",{
                Func:"DelCourse",
                CourseID:CourseID
                },function(data, status){
                    if(data=="ok") {   
                        alert("Pedido de remoção enviado");
                        document.location.reload();
                    }
                    else{}
                },"text");	
            }
        }
        
        function toggleProfileModal() {
            document.getElementById('profileModal').classList.toggle('is-active');
        }

        function toggleUserModal(){
            document.getElementById('usersModal').classList.toggle('is-active');
        }


        function validatePassword() {
            
            let password = document.getElementById("password");
            let confirm = document.getElementById("c-password");

            if(password.value != confirm.value && confirm.value!="") {
                document.getElementById("erro").innerHTML="Passwords não correspondem";
                document.getElementById("c-password").style="border-color:red";
            }else{
                document.getElementById("erro").innerHTML="";
                document.getElementById("c-password").style="";
            }

        }

        function save() {
            const fileInput = document.getElementById("FileInput");
            let imageBase64 = "";

            function checkAndSend() {
                sendData(imageBase64);
            }

            if (fileInput.files.length > 0) {
                readFile(fileInput, (base64) => {
                    imageBase64 = base64;
                    checkAndSend();
                });
            } else {
                checkAndSend();
            }
        }

        function readFile(input, callback) {
            const reader = new FileReader();
            reader.onload = function (event) {
                callback(event.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }

        function sendData(imageBase64) {
            $.post("funcoes.php", {
                Func: "updateProfile",
                Name: document.getElementById("name").value,
                Email: document.getElementById("email").value,
                Pass: document.getElementById("password").value,
                Img: imageBase64
            }, function (data) {
                if (data === "ok") {
                    alert("Dados atualizados com sucesso")
                    document.location.reload();
                }
            }, "text");
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

        function DelUser(UserID){
            if (confirm("Eliminar utilizador?")) {
                $.post("funcoes.php",{
                Func:"DelUser",
                UserID:UserID
                },function(data, status){
                    if(data=="ok") {   
                        document.location.reload();
                    }
                    else{}
                },"text");	
            }
        }

    </script>

</head>

<body>
    <?php $UserInfo = getUserInfo(); include 'navbar.php'; ?><br>

    <div class="columns">
        <div class="column is-3" style="margin-left: 2%;width: 22%;">
            <div class="card profile-card">
                <div class="profile-pen-icon" onclick="toggleProfileModal()">
                    <i class="fa-solid fa-pencil"></i>
                </div>
                
                <div class="card-image">
                    <figure class="ProfileImg">
                        <img src="<?php
                        if (file_exists("img/users/" . $_SESSION['UserID'] . ".png")) {
                            echo "img/users/" . $_SESSION['UserID'] . ".png";
                        } else {
                            echo "img/users/default.png";
                        }
                        ?>" alt="Foto de perfil" style="max-height:256px;max-width:256px">
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?php echo $UserInfo['Name']; ?></p>
                            <p class="subtitle is-6"><?php echo $UserInfo['Email']; ?></p>
                        </div>
                    </div>
                    <div class="content">
                        <p><strong>Tipo:</strong> <?php
                        switch ($_SESSION['Role']) {
                            case 1:
                                echo "Aluno";
                                break;
                            case 2:
                                echo "Professor";
                                break;
                            case 3:
                                echo "Admin";
                                break;
                        } ?></p>
                        <p><strong>Membro desde:</strong> <?php echo $UserInfo['RegisterDate']; ?></p>
                        <button class="button is-red" onclick="logout()">Logout</button>
                    </div>
                </div>
                <aside class="menu mt-4 ml-3 mb-2">
                   
<?php               if($_SESSION["Role"]>1){?>
                        <p class="menu-label">Administracao</p>
                        <ul class="menu-list">
                            <li><a href="inserir_curso.php">Novo curso</a></li>
                            <li><a onclick="toggleUserModal()">Utilizadores</a></li>
                            <li><a href="metricas.php">Metricas</a></li>
                        </ul>
<?php               } ?>
                    
                </aside>
            </div>
        </div>
        
        <!-- Modal para editar a conta -->
        <div id="profileModal" class="modal">
            <div class="modal-background" onclick="toggleProfileModal()"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Editar Conta:</p>
                    <button class="delete" aria-label="close" onclick="toggleProfileModal()"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
                        <label class="label">Alterar foto de perfil</label>
                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input class="file-input" type="file" id="FileInput" name="profile_photo" accept="image/png" onchange="file()">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label"> Escolher arquivo </span>
                                </span>
                                <span class="file-name" id="FileName"> Nenhum arquivo selecionado </span>
                            </label>
                        </div>
                        <p class="erro" id="FileError"></p>
                    </div>  
                    <div class="field">
                        <label class="label">Nome</label>
                        <div class="control">
                            <input class="input" type="text" id="name" value="<?php echo $UserInfo['Name']; ?>">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" id="email" value="<?php echo $UserInfo['Email']; ?>">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Nova Palavra Passe</label>
                        <div class="control">
                            <input class="input" type="password" id="password" minlength="10" pattern="^(?=.*[a-zA-Z])(?=.*[\W_]).+$" placeholder="Deixe em branco para manter a palavra passe atual">
                            <p>Pelo menos 10 caracteres, 1 letra e um simbolo</p>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Confirmar Nova Palavra Passe</label>
                        <div class="control">
                            <input class="input" type="password" id="c-password" onchange="validatePassword()" placeholder="Confirme a nova palavra passe">
                            <p class="erro" id="erro"></p>
                        </div>
                        
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-primary mr-3" onclick="save()">Salvar Alterações</button>
                    <button class="button" onclick="toggleProfileModal()">Cancelar</button>
                </footer>
            </div>
        </div>

        <!-- Modal para Admin vizualizar os utilizadores -->
        <div id="usersModal" class="modal">
            <div class="modal-background" onclick="toggleUserModal()"></div>
            <div class="modal-card" style="width: 80%; max-width: 800px;">
                <header class="modal-card-head">
                    <p class="modal-card-title">Gestão de Utilizadores</p>
                    <button class="delete" aria-label="close" onclick="toggleUserModal()"></button>
                </header>
                <section class="modal-card-body">
                    <div class="table-container">
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo</th>
                                    <th>Data Registo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $users=getUsers();
                                while ($user = mysqli_fetch_assoc($users)){?>
                                <tr>
                                    <th><?php echo $user["ID"];?></th>
                                    <th><?php echo $user["Name"];?></th>
                                    <th><?php echo $user["Email"];?></th>
                                    <th><?php echo $user["Role"];?></th>
                                    <th><?php echo $user["RegisterDate"];?></th>
                                    <th>
                                        <div class="buttons">
                                         
                                            <button class="button is-small is-danger is-outlined is-fullwidth" onclick="DelUser(<?php echo $user["ID"];?>)">
                                                <span class="icon">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <!-- Formulário -->
        <div class="container">
            <div class="box" style="width: 90%;">    
<?php           if ($_SESSION['Role'] == 1) { ?>
                    <label class="label">Cursos Inscritos/concluidos:</label>
                    <div class="columns is-multiline">
<?php                       $courses = getUserSubs();
                            while ($CourseInfo = mysqli_fetch_assoc($courses)) {?>
                                <div class="column is-4-desktop is-4-tablet is-6-mobile" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">                            
                                <div class="card product-card small-card ">               
                                    <div class="card-image">
                                        <div class="product-image">
                                            <img src="<?php echo "img/layout/".$CourseInfo['ID'].".jpg"; ?>"
                                                alt="<?php echo $CourseInfo['Name']; ?>">
                                        </div>
                                    </div>
                                    <div class="card-content product-content" >
                                        <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                                        <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                                        
                                        <div class="product-actions">
                                            <div class="buttons">                   
                                                <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>" class="button is-primary is-fullwidth">Ver detalhes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>             
<?php                       }?>

                    </div>
                    <label class="label">Cursos marcados como favoritos:</label>
                    <div class="columns is-multiline">
                        
<?php                       $courses = getUserFavs();
                            while ($CourseInfo = mysqli_fetch_assoc($courses)) {?>
                                <div class="column is-4-desktop is-4-tablet is-6-mobile" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">                            
                                <div class="card product-card small-card " style="max-height: fit-content">               
                                    <div class="card-image">
                                        <div class="product-image">
                                            <img src="<?php echo "img/layout/".$CourseInfo['ID'].".jpg"; ?>"
                                                alt="<?php echo $CourseInfo['Name']; ?>">
                                        </div>
                                    </div>
                                    <div class="card-content product-content" style="height: 60%;">
                                        <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                                        <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                                        
                                        <div class="product-actions">
                                            <div class="buttons">
                                                <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>" class="button is-primary is-fullwidth">Ver detalhes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>             
<?php                       }?>
                        
                    </div>                     
<?php           }else { 
                    if($_SESSION['Role']==2){  
                        echo '<label class="label">Cursos criados: </label>';
                        $courses = getUserCreated();
                    }
                    else{ 
                        echo '<label class="label">Cursos: </label>'; 
                        $courses = getAllCourses();
                    }?>
                    <div class="columns is-multiline">
<?php                   
                        while ($CourseInfo = mysqli_fetch_assoc($courses)) { ?>
                            <article class="column is-4-desktop is-4-tablet is-6-mobile <?php echo ($CourseInfo["Status"] > 1) ? 'unavailable-card' : '';?>" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">                            
                                <div class="card product-card small-card" style="max-height: fit-content">               
                                    <div class="card-image">
                                        <div class="product-image">
                                            <img src="<?php echo "img/layout/".$CourseInfo['ID'].".jpg"; ?>"
                                                alt="<?php echo $CourseInfo['Name']; ?>">
                                        </div>
                                    </div>
                                    <div class="card-content product-content" style="height: 60%;">
                                        <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                                        <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                                        
                                        <div class="product-actions">
                                            <div class="buttons">
<?php                                           Switch ($CourseInfo["Status"]){
                                                    case 1: ?>
                                                        <a href="editar_curso.php?ID=<?php echo $CourseInfo['ID']; ?>" class="button is-info is-outlined is-fullwidth">Editar Curso</a>
                                                        <button class="button is-primary is-fullwidth is-red" onclick="DelCourse('<?php echo $CourseInfo['ID'] ?>')">Remover</button>
<?php                                               break;
                                                    case 2: ?>
                                                        <button class="button is-primary is-fullwidth ">Em analise</button>
<?php                                               break;
                                                    case 3: ?>
                                                        <button class="button is-primary is-fullwidth ">Desativado</button>
<?php                                               break;                                                                                                                                                       
                                                }  ?>                                                   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>                                                                     
<?php                   }  ?> 
                    </div>
<?php           }?>
            </div>
        </div>
    </div>
    <div class="spacing"></div>
    <?php include 'footer.php'; ?>
</body>
</html>