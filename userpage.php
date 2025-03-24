<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <?php
    // Simulação de dados do usuário (normalmente viriam de um banco de dados)
    $user = [
        'nome' => 'Nuno Gonçalves',
        'email' => 'nuno@gmail.com',
        'cargo' => 'Desenvolvedor Web',
        'foto' => 'img/fausto.jpeg',
        'data_registro' => '10/03/02'
    ];

    $cursos=[
        'idCurso' => 1,
        'NomeCurso' => 'PHP Coding',
        'NomeCurso2' => 'PHP2',
        'NomeCurso2' => 'PHPHPHP'
    ]
    ?>

    <div class="columns is-centered">
        <!-- Coluna lateral com informações do usuário -->
        <div class="column is-3">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-1by1">
                        <img src="<?php echo $user['foto']; ?>" alt="Foto de perfil">
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?php echo $user['nome']; ?></p>
                            <p class="subtitle is-6"><?php echo $user['email']; ?></p>
                        </div>
                    </div>
                    <div class="content">
                        <p><strong>Cargo:</strong> <?php echo $user['cargo']; ?></p>
                        <p><strong>Membro desde:</strong> <?php echo $user['data_registro']; ?></p>
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
                    <li><a>Config/a></li>
                    <li>
                        <a class="is-active">Configuracao</a>
                        <ul>
                            <li><a>Config</a></li>
                            <li><a>Config</a></li>
                            <li><a>Config</a></li>
                        </ul>
                    </li>
                    <li><a>Invitations</a></li>
                    <li><a>Cloud Storage Environment Settings</a></li>
                    <li><a>Authentication</a></li>
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
                    <label class="label">Cursos aos que está inscrito: <?php echo $cursos['NomeCurso'];?></label>
                </div>

                <div class="field">
                    <label class="label">Username: <?php echo $user['nome'];?></label>
                    <!--<p class="help is-success">Este username está disponível</p>-->
                </div>

                <div class="field">
                    <label class="label">Email: <?php echo $user['email'];?></label>
                   <!-- <p class="help is-danger">Este email é inválido</p>-->
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

                <div class="field">
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>