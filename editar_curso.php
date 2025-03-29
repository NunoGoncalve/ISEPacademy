<?php
session_start();
include 'funcoes.php';

// Verificar se o ID do curso foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: catalogo.php');
    exit;
}

$course_id = $_GET['id'];

// Obter os dados do curso
$course = getCourseById($course_id);

// Redirecionar se o curso não existir
if (!$course) {
    header('Location: catalogo.php');
    exit;
}

// Obter os módulos do curso
$modules = getModulesByCourseId($course_id);

// Garantir que $modules seja um array
if (!is_array($modules)) {
    $modules = [];
}

include 'navbar.php';
?>
<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Editar Curso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #3273dc;
            --secondary-color: #f14668;
        }

        body {
            background-color: #f9f9f9;
            font-size: 16px;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 1rem;
        }

        .card {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
        }

        .card-header-title {
            color: white !important;
            font-size: 1.2rem !important;
        }

        .module-card {
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .module-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .current-image {
            max-width: 100%;
            max-height: 150px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .is-invalid {
            border-color: var(--secondary-color) !important;
        }
    </style>
</head>

<body>
    <section class="section py-4">
        <div class="container">
            <div class="card">
                <div class="card-header py-3">
                    <h1 class="card-header-title title is-5 mb-0">Editar Curso</h1>
                </div>
                <div class="card-content py-4">
                    <form id="course-form" onsubmit="return submeterFormulario()">
                        <input type="hidden" id="course-id" value="<?php echo $course_id; ?>">
                        
                        <!-- Informações básicas do curso -->
                        <div class="field">
                            <label class="label">Título do Curso</label>
                            <div class="control">
                                <input class="input is-primary" type="text" id="course-title"
                                    value="<?php echo htmlspecialchars($course['Name']); ?>" required>
                                <p class="help is-danger" id="course-title-error"></p>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Descrição do card</label>
                            <div class="control">
                                <textarea class="textarea is-primary" id="course-card-description" 
                                    required><?php echo htmlspecialchars($course['CardDesc']); ?></textarea>
                                <p class="help is-danger" id="course-card-description-error"></p>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Descrição Principal</label>
                            <div class="control">
                                <textarea class="textarea is-primary" id="course-description" 
                                    required><?php echo htmlspecialchars($course['PagDesc']); ?></textarea>
                                <p class="help is-danger" id="course-description-error"></p>
                            </div>
                        </div>

                        <div class="columns is-multiline">
                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Categoria</label>
                                    <div class="control">
                                        <div class="select is-primary is-fullwidth">
                                            <select id="course-category" required>
                                                <option value="">Selecione uma categoria</option>
                                                <?php
                                                $categories = ['Tecnologia', 'Negócios', 'Design', 'Marketing', 'Desenvolvimento Pessoal'];
                                                foreach ($categories as $category) {
                                                    $selected = ($course['Category'] == $category) ? 'selected' : '';
                                                    echo "<option $selected>$category</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <p class="help is-danger" id="course-category-error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Imagem do Curso</label>
                                    <?php if (!empty($course['image'])): ?>
                                        <div class="mb-2">
                                            <p class="is-size-7 mb-1">Imagem Atual:</p>
                                            <img src="<?php echo $course['image']; ?>" alt="Imagem do curso"
                                                class="current-image">
                                        </div>
                                    <?php endif; ?>
                                    <div class="file is-primary is-fullwidth">
                                        <label class="file-label">
                                            <input class="file-input" type="file" id="course-image" accept="image/*">
                                            <span class="file-cta">
                                                <span class="file-icon">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label">
                                                    <?php echo !empty($course['image']) ? 'Alterar Imagem' : 'Escolher Imagem'; ?>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <p class="help">Deixe em branco para manter a imagem atual</p>
                                </div>
                            </div>
                        </div>

                        <!-- Módulos do curso -->
                        <div class="field mt-4">
                            <label class="label">Módulos do Curso</label>
                            <div id="modulos-container">
                                <?php if (!empty($modules)): ?>
                                    <?php foreach ($modules as $index => $module): ?>
                                        <?php if (is_array($module) && isset($module['ID'], $module['Name'], $module['Description'])): ?>
                                            <div class="card module-card" data-module-id="<?php echo $module['ID']; ?>">
                                                <header class="card-header">
                                                    <p class="card-header-title is-size-7">
                                                        Módulo <?php echo $index + 1; ?>
                                                    </p>
                                                    <button type="button" class="card-header-icon" onclick="removerModulo(this)">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                        </span>
                                                    </button>
                                                </header>
                                                <div class="card-content">
                                                    <div class="field">
                                                        <label class="label">Nome do Módulo</label>
                                                        <div class="control">
                                                            <input class="input is-primary module-name" type="text"
                                                                value="<?php echo htmlspecialchars($module['Name']); ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label">Descrição do Módulo</label>
                                                        <div class="control">
                                                            <textarea class="textarea module-description"
                                                                required><?php echo htmlspecialchars($module['Description']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="card module-card">
                                        <header class="card-header">
                                            <p class="card-header-title is-size-7">
                                                Módulo 1
                                            </p>
                                            <button type="button" class="card-header-icon" onclick="removerModulo(this)">
                                                <span class="icon is-small">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </span>
                                            </button>
                                        </header>
                                        <div class="card-content">
                                            <div class="field">
                                                <label class="label">Nome do Módulo</label>
                                                <div class="control">
                                                    <input class="input is-primary module-name" type="text" required>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label class="label">Descrição do Módulo</label>
                                                <div class="control">
                                                    <textarea class="textarea module-description" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="button is-primary" onclick="adicionarModulo()">
                                    <span class="icon is-small"><i class="fas fa-plus"></i></span>
                                    <span>Adicionar Módulo</span>
                                </button>
                            </div>
                        </div>

                        <!-- Datas e preço -->
                        <div class="columns">
                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Data de Início</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="start-date"
                                            value="<?php echo $course['StartDate']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6">
                                <div class="field">
                                    <label class="label">Data de Término</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="end-date"
                                            value="<?php echo $course['EndDate']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Preço</label>
                            <div class="control">
                                <input class="input is-primary" id="price"
                                    value="<?php echo $course['Price']; ?>" required>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="field is-grouped is-grouped-centered mt-5">
                            <div class="control">
                                <button class="button is-primary" type="submit">
                                    <span class="icon is-small"><i class="fas fa-save"></i></span>
                                    <span>Atualizar Curso</span>
                                </button>
                            </div>
                            <div class="control">
                                <a class="button is-light" href="userpage.php">
                                    <span class="icon is-small"><i class="fas fa-times"></i></span>
                                    <span>Cancelar</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    
    <script>
        let moduloCounter = <?php echo !empty($modules) && is_array(value: $modules) ? ($modules['CID']) : 1; ?>;

        // Adicionar novo módulo
        function adicionarModulo() {
            moduloCounter++;
            const container = document.getElementById('modulos-container');
            const novoModulo = document.createElement('div');
            novoModulo.className = 'card module-card';
            
            novoModulo.innerHTML = `
                <header class="card-header">
                    <p class="card-header-title is-size-7">
                        Módulo ${moduloCounter}
                    </p>
                    <button type="button" class="card-header-icon" onclick="removerModulo(this)">
                        <span class="icon is-small">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        </span>
                    </button>
                </header>
                <div class="card-content">
                    <div class="field">
                        <label class="label">Nome do Módulo</label>
                        <div class="control">
                            <input class="input is-primary module-name" type="text" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Descrição do Módulo</label>
                        <div class="control">
                            <textarea class="textarea module-description" required></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(novoModulo);
        }

        // Remover módulo
        function removerModulo(botao) {
            const modulo = botao.closest('.module-card');
            if (document.querySelectorAll('.module-card').length > 1) {
                modulo.remove();
            } else {
                alert('Deve haver pelo menos um módulo');
            }
        }

        // Validação do formulário
        function validarFormulario() {
            let isValid = true;
            
            // Validar título do curso
            const courseTitle = document.getElementById('course-title');
            if (courseTitle.value.trim().length < 5) {
                courseTitle.classList.add('is-invalid');
                document.getElementById('course-title-error').textContent = 'O título deve ter pelo menos 5 caracteres';
                isValid = false;
            } else {
                courseTitle.classList.remove('is-invalid');
                document.getElementById('course-title-error').textContent = '';
            }
            
            // Validar descrição do card
            const cardDescription = document.getElementById('course-card-description');
            if (cardDescription.value.trim().length < 10) {
                cardDescription.classList.add('is-invalid');
                document.getElementById('course-card-description-error').textContent = 'A descrição do card deve ter pelo menos 10 caracteres';
                isValid = false;
            } else {
                cardDescription.classList.remove('is-invalid');
                document.getElementById('course-card-description-error').textContent = '';
            }

            // Validar descrição principal
            const courseDescription = document.getElementById('course-description');
            if (courseDescription.value.trim().length < 20) {
                courseDescription.classList.add('is-invalid');
                document.getElementById('course-description-error').textContent = 'A descrição deve ter pelo menos 20 caracteres';
                isValid = false;
            } else {
                courseDescription.classList.remove('is-invalid');
                document.getElementById('course-description-error').textContent = '';
            }

            // Validar categoria
            const courseCategory = document.getElementById('course-category');
            if (courseCategory.value === '') {
                courseCategory.classList.add('is-invalid');
                document.getElementById('course-category-error').textContent = 'Selecione uma categoria';
                isValid = false;
            } else {
                courseCategory.classList.remove('is-invalid');
                document.getElementById('course-category-error').textContent = '';
            }

            // Validar módulos
            const moduleNames = document.querySelectorAll('.module-name');
            const moduleDescriptions = document.querySelectorAll('.module-description');

            moduleNames.forEach(name => {
                if (name.value.trim().length < 3) {
                    name.classList.add('is-invalid');
                    isValid = false;
                } else {
                    name.classList.remove('is-invalid');
                }
            });

            moduleDescriptions.forEach(description => {
                if (description.value.trim().length < 10) {
                    description.classList.add('is-invalid');
                    isValid = false;
                } else {
                    description.classList.remove('is-invalid');
                }
            });

            // Validar datas
            const startDate = document.getElementById('start-date');
            const endDate = document.getElementById('end-date');

            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (start >= end) {
                    startDate.classList.add('is-invalid');
                    endDate.classList.add('is-invalid');
                    alert('A data de término deve ser posterior à data de início');
                    isValid = false;
                } else {
                    startDate.classList.remove('is-invalid');
                    endDate.classList.remove('is-invalid');
                }
            }

            return isValid;
        }

        // Submeter formulário
        function submeterFormulario() {
            if (!validarFormulario()) {
                return false;
            }

            const courseId = document.getElementById("course-id").value;
            const fileInput = document.getElementById("course-image");
            let imageBase64 = null;

            // Coletar dados dos módulos
            const modules = [];
            document.querySelectorAll('.module-card').forEach((modulo) => {
                modules.push({
                    ModuleId: modulo.dataset.moduleId || null,
                    ModuleName: modulo.querySelector('.module-name').value,
                    ModuleDescription: modulo.querySelector('.module-description').value
                });
            });

            function processarAtualizacao() {
                $.ajax({
                    url: "funcoes.php",
                    type: "POST",
                    data: {
                        Func: "updateCourse",
                        CourseID: document.getElementById("course-id").value,
                        Name: document.getElementById("course-title").value,
                        DescriptionCourse: document.getElementById("course-description").value,
                        SecondDescription: document.getElementById("course-card-description").value,
                        CategoryCourse: document.getElementById("course-category").value,
                        StartDate: document.getElementById("start-date").value,
                        EndDate: document.getElementById("end-date").value,
                        Price: document.getElementById("price").value,
                        Img: imageBase64,
                        Modules: JSON.stringify(modules)
                    },
                    dataType: "text",
                    success: function (response) {
                        if (response == "ok") {
                            alert("Curso atualizado com sucesso!");
                            window.location.href = "catalogo.php";
                        } else {
                            alert("Erro ao atualizar curso: " + response);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Erro na requisição: " + error);
                        console.error(xhr.responseText);
                    }
                });
            }

            // Verificar se há uma nova imagem
            if (fileInput.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imageBase64 = e.target.result;
                    processarAtualizacao();
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                processarAtualizacao();
            }

            return false;
        }
    </script>
</body>
</html>