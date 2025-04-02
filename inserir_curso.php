<?php session_start(); include 'funcoes.php'; ?>

<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Criar Curso</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
</head>

<body>
    <?php include 'navbar.php'; ?>
    <section class="section py-4">
        <div class="container">
            <div class="card">
                <div class="card-header py-3">
                    <h1 class="card-header-title title is-5 mb-0">Adicionar Novo Curso</h1>
                </div>
                <div class="card-content py-4">
                    <form id="course-form" onsubmit="return submeter()">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Título do Curso</label>
                                    <div class="control">
                                        <input class="input is-primary" type="text" id="course-title"
                                            placeholder="Digite o título do curso" required>
                                        <p class="help is-danger" id="course-title-error"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Descrição do card</label>
                                    <div class="control">
                                        <textarea class="textarea is-primary" id="course-card-description"
                                            placeholder="Descrição detalhada do curso" required></textarea>
                                        <p class="help is-danger" id="course-description-error"></p>
                                    </div>
                                </div>
                            </div>


                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Descrição Principal</label>
                                    <div class="control">
                                        <textarea class="textarea is-primary" id="course-description"
                                            placeholder="Descrição detalhada do curso" required></textarea>
                                        <p class="help is-danger" id="course-description-error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Categoria</label>
                                    <div class="control">
                                        <div class="select is-primary is-fullwidth">
                                            <select id="course-category" required>
                                                <option value="">Selecione uma categoria</option>
                                                <option>Tecnologia</option>
                                                <option>Marketing</option>
                                                <option>Design</option>
                                                <option>Ciencias</option>
                                                <option>Informatica</option>
                                                <option>Mecanica</option>
                                                <option>Eletricidade</option>
                                                <option>Desporto</option>
                                            </select>
                                        </div>
                                        <p class="help is-danger" id="course-category-error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Imagem do Curso</label>
                                    <div id="file-js-example" class="file has-name">
                                            <label class="file-label">
                                                <input class="file-input" id="course-image" accept="image/jpeg" onchange="file()" type="file" name="curso-imagem" required/>
                                                <span class="file-cta">
                                                <span class="file-icon">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label"> Escolha um ficheiro </span>
                                                </span>
                                                <span class="file-name" id="FileName"> Vazio </span>
                                            </label>
                                        </div>
                                    <p class="help is-danger" id="course-image-error"></p>
                                </div>
                            </div>

                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Módulos do Curso</label>
                                    <div id="modulos-container">
                                        <div class="card module-card" id="modulo-1">
                                            <header class="card-header">
                                                <p class="card-header-title">
                                                    Módulo 1
                                                </p>
                                                <button type="button" class="card-header-icon"
                                                    aria-label="remove module" onclick="removerModulo(this)">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </span>
                                                </button>
                                            </header>
                                            <div class="card-content">
                                                <div class="module-details">
                                                    <div class="field">
                                                        <label class="label">Nome do Módulo</label>
                                                        <div class="control">
                                                            <input class="input is-primary module-name" type="text"
                                                                placeholder="Nome do módulo" required>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label">Descrição do Módulo</label>
                                                        <div class="control">
                                                            <textarea class="textarea module-description"
                                                                placeholder="Descrição detalhada do módulo"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control mt-3">
                                        <button type="button" class="button is-primary" onclick="adicionarModulo()">
                                            <span class="icon is-small"><i class="fas fa-plus"></i></span>
                                            <span>Adicionar Módulo</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Data de Início</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="start-date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Data de Término</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="end-date" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Preço</label>
                                    <div class="control">
                                        <input class="input is-primary" type="number" id="price" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-12">
                                <div class="field is-grouped is-grouped-centered">
                                    <div class="control">
                                        <button class="button is-primary" type="submit">
                                            <span class="icon is-small"><i class="fas fa-save"></i></span>
                                            <span>Cadastrar Curso</span>
                                        </button>
                                    </div>
                                    <div class="control">
                                        <button class="button is-light" type="reset">
                                            <span class="icon is-small"><i class="fas fa-undo"></i></span>
                                            <span>Limpar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    <script>
        let moduloCounter = 1;

        function adicionarModulo() {
            moduloCounter++;
            const container = document.getElementById('modulos-container');
            const novoModulo = document.createElement('div');
            novoModulo.className = 'card module-card';
            novoModulo.id = `modulo-${moduloCounter}`;
            novoModulo.innerHTML = `
                <header class="card-header">
                    <p class="card-header-title is-size-7">
                        Módulo ${moduloCounter}
                    </p>
                    <button type="button" class="card-header-icon" aria-label="remove module" onclick="removerModulo(this)">
                        <span class="icon is-small">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        </span>
                    </button>
                </header>
                <div class="card-content">
                    <div class="module-details">
                        <div class="field">
                            <label class="label">Nome do Módulo</label>
                            <div class="control">
                                <input class="input is-primary module-name" type="text" placeholder="Nome do módulo" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Descrição do Módulo</label>
                            <div class="control">
                                <textarea class="textarea module-description" placeholder="Descrição detalhada do módulo" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(novoModulo);
        }

        function removerModulo(botao) {
            const modulo = botao.closest('.module-card');
            if (document.querySelectorAll('.module-card').length > 1) {
                modulo.remove();
            } else {
                alert('Deve haver pelo menos um módulo');
            }
        }

        function file(){
            var fileInput = document.getElementById("course-image");

            if (fileInput.files.length > 0) {
                var fileType = fileInput.files[0].type; // Obtém o tipo MIME

                if (fileType !== "image/jpeg") {
                    document.getElementById("FileError").innerHTML="Apenas .jpg são aceites";
                    fileInput.value="";
                }else{
                    document.getElementById("course-image-error").innerHTML="";
                    document.getElementById("FileName").textContent = document.getElementById("course-image").files[0].name;
                }
            }
        }   

        function validateForm() {
            let isValid = true;

            // Course title validation
            const courseTitle = document.getElementById('course-title');
            const courseTitleError = document.getElementById('course-title-error');
            if (courseTitle.value.trim().length < 5) {
                courseTitle.classList.add('is-invalid');
                courseTitleError.textContent = 'O título deve ter pelo menos 5 caracteres';
                isValid = false;
            } else {
                courseTitle.classList.remove('is-invalid');
                courseTitleError.textContent = '';
            }

            // Course description validation
            const courseDescription = document.getElementById('course-description');
            const courseDescriptionError = document.getElementById('course-description-error');
            if (courseDescription.value.trim().length < 20) {
                courseDescription.classList.add('is-invalid');
                courseDescriptionError.textContent = 'A descrição deve ter pelo menos 20 caracteres';
                isValid = false;
            } else {
                courseDescription.classList.remove('is-invalid');
                courseDescriptionError.textContent = '';
            }

            // Category validation
            const courseCategory = document.getElementById('course-category');
            const courseCategoryError = document.getElementById('course-category-error');
            if (courseCategory.value === '') {
                courseCategory.classList.add('is-invalid');
                courseCategoryError.textContent = 'Selecione uma categoria';
                isValid = false;
            } else {
                courseCategory.classList.remove('is-invalid');
                courseCategoryError.textContent = '';
            }

            // Image validation
            const courseImage = document.getElementById('course-image');
            const courseImageError = document.getElementById('course-image-error');
            if (courseImage.files.length === 0) {
                courseImage.classList.add('is-invalid');
                courseImageError.textContent = 'Selecione uma imagem para o curso';
                isValid = false;
            } else {
                courseImage.classList.remove('is-invalid');
                courseImageError.textContent = '';
            }

            // Module validations
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

            // Date validations
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

        function submeter() {
            // Validar o formulário antes de prosseguir
            if (!validateForm()) {
                return false;
            }
            
            var fileInput = document.getElementById("course-image");
            
            // Verificar se uma imagem foi selecionada
            if (fileInput.files.length === 0) {
                document.getElementById('course-image-error').textContent = 'Selecione uma imagem para o curso';
                return false;
            }
            
            var reader = new FileReader();

            reader.onload = function (event) {
                var imageBase64 = event.target.result;

                // Coletar módulos
                var modules = [];
                document.querySelectorAll('.module-card').forEach((modulo, index) => {
                    var modName = modulo.querySelector('.module-name').value;
                    var modDesc = modulo.querySelector('.module-description').value;

                    modules.push({
                        ModuleName: modName,
                        ModuleDescription: modDesc
                    });
                });

                // Enviar dados via AJAX com tratamento de erro
                $.ajax({
                    url: "funcoes.php",
                    type: "POST",
                    data: {
                        Func: "newCourse",
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
                    success: function(data) {
                        if (data == "ok") {
                            document.location = "userpage.php";
                        } else {
                            alert("Erro ao cadastrar curso: " + data);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Erro na requisição AJAX: " + error);
                        console.error(xhr.responseText);
                    }
                });
            };

            reader.readAsDataURL(fileInput.files[0]);
            return false; // Impedir o envio normal do formulário
        }
    </script>
</body>

</html>