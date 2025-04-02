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
    </script>
    <style>
        .profile-card {
            position: relative;
        }
        
        .profile-pen-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .profile-pen-icon:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: rotate(360deg);
        }

        .menu-list li a {
            background-color: transparent;
        }

        .menu-list li a:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

    </style>
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
                    <p class="menu-label">General</p>
                    <ul class="menu-list">
                        <li><a>Dashboard</a></li>
                        <li><a>Customers</a></li>
                    </ul>
                    <p class="menu-label">Administracao</p>
                    <ul class="menu-list">
                        <li><a>Configurações</a></li>
                        <!--<li>
                            <a class="is-active">Configuracao</a>
                            <ul>
                                <li><a>Config</a></li>
                                <li><a>Config</a></li>
                                <li><a>Config</a></li>
                            </ul>
                        </li>
                        <li><a>Invitations</a></li>
                        <li><a>Cloud Storage Environment Settings</a></li>
                        <li><a>Authentication</a></li>-->
                    </ul>
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
                                <input class="file-input" type="file" name="profile_photo" accept="image/*">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Escolher arquivo
                                    </span>
                                </span>
                                <span class="file-name">
                                    Nenhum arquivo selecionado
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Nome</label>
                        <div class="control">
                            <input class="input" type="text" value="<?php echo $UserInfo['Name']; ?>">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" value="<?php echo $UserInfo['Email']; ?>">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Nova Palavra Passe</label>
                        <div class="control">
                            <input class="input" type="password" placeholder="Deixe em branco para manter a palavra passe atual">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Confirmar Nova Palavra Passe</label>
                        <div class="control">
                            <input class="input" type="password" placeholder="Confirme a nova palavra passe">
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-primary mr-3">Salvar Alterações</button>
                    <button class="button" onclick="toggleProfileModal()">Cancelar</button>
                </footer>
            </div>
        </div>
        
        <!-- Formulário -->
        <div class="container">
            <div class="box" style="width: 90%;">    
<?php           if ($_SESSION['Role'] == 1) { ?>
                    <label class="label">Cursos Inscritos:</label>
                    <div class="columns is-multiline">
<?php                       $courses = getUserSubs();
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
                    <label class="label">Cursos marcados como favoritos:</label>
                    <div class="columns is-multiline">
                        
<?php                       $courses = getUserFavs();
                            while ($CourseInfo = mysqli_fetch_assoc($courses)) {?>
                                <div class="column is-4-desktop is-4-tablet is-6-mobile <?php echo ($CourseInfo["Status"] == 2) ? 'unavailable-card' : '';?>" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">                            
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
<?php           }else if ($_SESSION["Role"] == 2) { ?>
                    <label class="label">Cursos criados: </label>
                    <div class="columns is-multiline">
<?php                   $courses = getUserCreated();
                        while ($CourseInfo = mysqli_fetch_assoc($courses)) { ?>
                            <div class="column is-4-desktop is-4-tablet is-6-mobile <?php echo ($CourseInfo["Status"] == 2) ? 'unavailable-card' : '';?>" onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID']?>'">                            
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
                                            <?php if($CourseInfo["Status"]!=2){?> 
                                                    <a href="editar_curso.php?ID=<?php echo $CourseInfo['ID']; ?>" class="button is-info is-outlined is-fullwidth">Editar Curso</a>
                                                    <button class="button is-primary is-fullwidth" onclick="DelCourse('<?php echo $CourseInfo['ID'] ?>')">Remover</button>
                                                <?php } else{?>
                                                    <button class="button is-primary is-fullwidth ">Em analise</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                                        
<?php                   }  ?> 
                    </div>
<?php               }else{ ?>
                        <label class="label">Cursos: </label>
                        <div class="columns is-multiline">
<?php                   $courses = getAllCourses();
                        while ($CourseInfo = mysqli_fetch_assoc($courses)) { ?>
                            <article class="column is-3-desktop is-4-tablet is-6-mobile">                            
                                <div class="card product-card small-card <?php echo ($CourseInfo["Status"] > 1) ? 'unavailable-card' : '';?>" style="max-height: fit-content" href="curso.php?ID=<?php echo $CourseInfo['ID']?>">               
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
                                                        <a href="curso.php?ID=<?php echo $CourseInfo['ID']; ?>" class="button is-info is-outlined is-fullwidth">Editar Curso</a>
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
<?php               }?>
            </div>
        </div>
    </div> 
    <?php include 'footer.php'; ?>
    
    <script>
        // Script to update file name when file is selected
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('.file-input');
            const fileName = document.querySelector('.file-name');
            
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    fileName.textContent = fileInput.files[0].name;
                } else {
                    fileName.textContent = 'Nenhum arquivo selecionado';
                }
            });
        });
    </script>
</body>
</html>