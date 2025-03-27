<?php session_start(); include 'funcoes.php';?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        function logout(){
            $.post("funcoes.php",{Func:"logout"},function(data, status){
				if(data=="ok") { 
                    document.location="login.php";
                }
			},"text");	
        }
    </script>
</head>

<body>
    <?php $UserInfo=getUserInfo(); include 'navbar.php'; ?>

    <div class="columns is-centered">
        <!-- Coluna lateral com informações do usuário -->
        <div class="column is-3">
            <div class="card">
                <div class="card-image">
                    <figure class="ProfileImg" >
                        <img src="<?php
                            if(file_exists("img/users/".$_SESSION['UserID'].".png")){
                                echo "img/users/".$_SESSION['UserID'].".png";
                            } else{
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
                        Switch($UserInfo['Role']){
                            case 1: echo "Aluno"; break;                       
                            case 2: echo "Professor"; break;
                            case 3: echo "Admin"; break;
                        }?></p>
                        <p><strong>Membro desde:</strong> <?php echo $UserInfo['RegisterDate']; ?></p>
                        <button class="button is-danger" onclick="logout()">Logout</button>
                    </div>
                </div>
            </div>
            <aside class="menu mt-4">
                <p class="menu-label">General</p>
                <ul class="menu-list">
                    <li><a>Dashboard</a></li>
                    <li><a>Customers</a></li>
                </ul>
                <p class="menu-label">Administracao</p>
                <ul class="menu-list">
                    <li><a>Configurações</li>
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
                <p class="menu-label">Transactions</p>
                <ul class="menu-list">
                    <li><a>Config</a></li>
                    <li><a>Config</a></li>
                    <li><a>Config</a></li>
                </ul>
            </aside>
        </div>

        <!-- Formulário -->
        <div class="column is-6">
            <div class="box">
                <div class="field">
                    <label class="label">Cursos aos que está inscrito:<br>
                    <ul><?php 
                        $cursos=getUserSubs();
                        while($curso = mysqli_fetch_assoc($cursos)){
                            echo '<li style="list-style: inside">'.$curso["Name"].'</li>';
                        }
                        
                    ?></ul>
                    </label>
                </div>

                <div class="field">
                    <label class="label">Cursos marcados como favoritos:<br>
                    <ul><?php 
                        $cursos=getUserFavs();
                        while($curso = mysqli_fetch_assoc($cursos)){
                            echo '<li style="list-style: inside">'.$curso["Name"].'</li>';
                        }  
                    ?></ul>
                    </label>
                </div>
                <br>
                <div class="field">
                    <button class="button GreyBtn">Change Email</button>
                   <!-- <p class="help is-danger">Este email é inválido</p>-->
                </div>
                <div class="field">
                    <button class="button GreyBtn">Change Password</button>
                    <!--<p class="help is-success">Este username está disponível</p>-->
                </div>
                <div class="field">
                    <button class="button GreyBtn">Change Username</button>
                    <!--<p class="help is-success">Este username está disponível</p>-->
                </div>

                

                <!--<div class="field">
                    <label class="label">Assunto</label>
                    <div class="control">
                        <div class="select">
                            <select>
                                <option>Selecione</option>
                                <option>Opção 1</option>
                                <option>Opção 2</option>
                            </select>
                        </div>
                    </div>
                </div>>-->

                <!--<div class="field">
                    <label class="label">Fala comigo!</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="Digite sua mensagem"></textarea>
                    </div>
                </div>


                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Enviar</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light">Cancelar</button>
                    </div>
                </div>-->
                

            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>
</html>