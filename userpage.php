<?php session_start();
include 'funcoes.php';

ini_set('display_errors', 1);
error_reporting(E_ALL); ?>
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
        function logout() {
            $.post("funcoes.php", { Func: "logout" }, function (data, status) {
                if (data == "ok") {
                    document.location = "login.php";
                }
            }, "text");
        }
    </script>
</head>

<body>
    <?php $UserInfo = getUserInfo();
    include 'navbar.php'; ?>

    <div class="columns is-centered">
        <!-- Coluna lateral com informações do usuário -->
        <div class="column is-3">
            <div class="card">
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
                        switch ($UserInfo['Role']) {
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
                        <button class="button is-danger" onclick="logout()">Logout</button>
                    </div>
                </div>
            </div><a href="editar_curso.php?id=2" class="btn btn-primary">Editar Curso</a>

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
			<?php if ($_SESSION['Role'] == 1) { ?>
                <div class="field">
                   
					<label class="label">Cursos aos que está inscrito:<br>
                        <ul><?php
                        $cursos = getUserSubs();
                        while ($curso = mysqli_fetch_assoc($cursos)) {
                            echo '<li style="list-style: inside">' . $curso["Name"] . '</li>';
						}
					?></ul>
                    </label>
                </div>

                <div class="field">
                    <label class="label">Cursos marcados como favoritos:<br>
                        <ul><?php
                        $cursos = getUserFavs();
                        while ($curso = mysqli_fetch_assoc($cursos)) {
                            echo '<li style="list-style: inside">' . $curso["Name"] . '</li>';
                        }
                        ?></ul>
                    </label>
                </div>
				
                <?php }else if ($_SESSION['Role'] == 2) { ?>
                    <div class="field">
                        <label class="label">Cursos criados: <br>
                            <ul><?php
                            $cursos = getUserCreated();
                            while ($curso = mysqli_fetch_assoc($cursos)) { ?>
                                    <div class="card product-card small-card" a href="curso.php?ID=<? echo $curso['ID']; ?>">
                                        <div class="card-image">
                                            <div class="product-image">
                                                <img src="<?php echo "img/layout/img" . $curso['ID'] . ".jpg"; ?>"
                                                    alt="<?php echo $curso['Name']; ?>">
                                            </div>
                                        </div>
                                        <div class="card-content product-content">
                                            <p class="subtitle is-6"><?php echo $curso['Category']; ?></p>
                                            <p class="title is-5"><?php echo $curso['Name']; ?></p>
                                            <p class="content" id="cardText"><?php echo $curso['CardDesc']; ?></p>
                                            <div class="product-actions">
                                                <div class="buttons">
                                                    <a href="editar_curso.php?ID=<?php echo $curso['ID']; ?>"
                                                        class="button is-info is-outlined is-fullwidth">Editar Curso</a>
                                                    <button class="button is-primary is-fullwidth">Remover</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
						<?php }} ?>
			</div>
        </div>
    </div>
    </div><?php include 'footer.php'; ?>
    </div>

</body>

</html>