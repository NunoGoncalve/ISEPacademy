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
    <script src="vendor/jquery/jquery.min.js"></script>
 
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
                    <form id="course-form">
                        <div class="columns is-multiline is-mobile">
                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Título do Curso*</label>
                                    <div class="control">
                                        <input class="input is-primary" type="text" id="course-title"
                                            placeholder="Digite o título do curso" required>
                                        <p class="help is-danger" id="course-title-error"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Descrição do card*</label>
                                    <div class="control">
                                        <textarea class="textarea is-primary" id="course-card-description"
                                            placeholder="Descrição detalhada do curso" required></textarea>
                                        <p class="help is-danger" id="course-description-error"></p>
                                    </div>
                                </div>
                            </div>


                            <div class="column is-12">
                                <div class="field">
                                    <label class="label">Descrição Principal*</label>
                                    <div class="control">
                                        <textarea class="textarea is-primary" id="course-description"
                                            placeholder="Descrição detalhada do curso" required></textarea>
                                        <p class="help is-danger" id="course-description-error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Categoria*</label>
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
                                    <label class="label">Imagem do Curso*</label>
                                    <div id="file-js-example" class="file has-name">
                                            <label class="file-label">
                                                <input class="file-input" id="course-image" accept="image/jpeg" onchange="image()" type="file" name="curso-imagem" required/>
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
                                        <div class="card module-card" id="modulo-1" data-module-id=1>
                                            <header class="card-header">
                                                <p class="card-header-title">
                                                    Módulo 1*
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
                                                        <label class="label">Nome do Módulo*</label>
                                                        <div class="control">
                                                            <input class="input is-primary module-name" type="text"
                                                                placeholder="Nome do módulo" required>
                                                                <input class="module-id" type="text" value="1" hidden>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label">Descrição do Módulo*</label>
                                                        <div class="control">
                                                            <textarea class="textarea module-description"
                                                                placeholder="Descrição detalhada do módulo"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label class="label">ficheiro do módulo</label>
                                                    <div id="file-js-example" class="file has-name">
                                                            <label class="file-label">
                                                                <input class="file-input module-file" accept="application/pdf" onchange="file(this,1)" type="file" name="ModFile1"/>
                                                                <span class="file-cta">
                                                                <span class="file-icon">
                                                                    <i class="fas fa-upload"></i>
                                                                </span>
                                                                <span class="file-label"> Escolha um ficheiro </span>
                                                                </span>
                                                                <span class="file-name" id="ModFileName1"> Vazio </span>
                                                            </label>
                                                        </div>
                                                    <p class="help is-danger" id="ModFileError"></p>
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
                                    <label class="label">Data de Início*</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="start-date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Data de Término*</label>
                                    <div class="control">
                                        <input class="input is-primary" type="date" id="end-date" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="column is-6-desktop is-12-mobile">
                                <div class="field">
                                    <label class="label">Preço*</label>
                                    <div class="control">
                                        <input class="input is-primary" type="number" id="price" required>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-12">
                                <div class="field is-grouped is-grouped-centered">
                                    <div class="control">
                                        <button class="button is-primary" type="submit" onclick="submeter()">
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
                    <p class="card-header-title">
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
                                <input class="module-id" type="text" value="${moduloCounter}" hidden>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Descrição do Módulo</label>
                            <div class="control">
                                <textarea class="textarea module-description" placeholder="Descrição detalhada do módulo" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">ficheiro do módulo</label>
                        <div id="file-js-example" class="file has-name">
                                <label class="file-label">
                                    <input class="file-input module-file" accept="application/pdf" onchange="file(this, ${moduloCounter})" type="file" name="ModFile${moduloCounter}" required/>
                                    <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label"> Escolha um ficheiro </span>
                                    </span>
                                    <span class="file-name" id="ModFileName${moduloCounter}"> Vazio </span>
                                </label>
                            </div>
                        <p class="help is-danger" id="ModFileError"></p>
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

        function image(){
            var imageInput = document.getElementById("course-image");

            if (imageInput.files.length > 0) {
                var fileType = imageInput.files[0].type; // Obtém o tipo MIME

                if (fileType !== "image/jpeg") {
                    document.getElementById("course-image-error").innerHTML="Apenas .jpg são aceites";
                    imageInput.value="";
                }else{
                    document.getElementById("course-image-error").innerHTML="";
                    document.getElementById("FileName").textContent = document.getElementById("course-image").files[0].name;
                }
            }

            
        }   

        function file(fileInput, id){
            if (fileInput.files.length > 0) {
                var fileType = fileInput.files[0].type; // Obtém o tipo MIME

                if (fileType !== "application/pdf") {
                    document.getElementById("ModFileError").innerHTML="Apenas .pdf são aceites";
                    fileInput.value="";
                }else{
                    document.getElementById("ModFileError").innerHTML="";
                    document.getElementById("ModFileName"+id).textContent = fileInput.files[0].name;
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
    // Prevenir o comportamento padrão do formulário
    event.preventDefault();
    
    // Validar o formulário antes de prosseguir
    if (!validateForm()) {
        return false;
    }
    
    // Coletar os dados do curso
    var cursoData = {
        nome: document.getElementById("course-title").value,
        descricao: document.getElementById("course-description").value,
        descricaoCard: document.getElementById("course-card-description").value,
        categoria: document.getElementById("course-category").value,
        dataInicio: document.getElementById("start-date").value,
        dataFim: document.getElementById("end-date").value,
        preco: document.getElementById("price").value
    };
    
    // Coletar dados dos módulos
    var modules = [];
    document.querySelectorAll('.module-card').forEach((modulo) => {
        modules.push({
            id: modulo.querySelector('.module-id').value,
            name: modulo.querySelector('.module-name').value,
            description: modulo.querySelector('.module-description').value
        });
    });
    
    // Converter a imagem do curso para base64
    var imageInput = document.getElementById("course-image");
    if (imageInput.files.length > 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            cursoData.imagem = e.target.result; // Imagem em base64
            
            // Processar os arquivos dos módulos
            processarArquivosDosModulos(0, modules, cursoData);
        };
        reader.readAsDataURL(imageInput.files[0]);
    } else {
        alert("Selecione uma imagem para o curso");
    }
    
    return false;
}

// Função para processar os arquivos dos módulos sequencialmente
function processarArquivosDosModulos(index, modules, cursoData) {
    if (index >= document.querySelectorAll('.module-card').length) {
        // Todos os módulos foram processados, enviar dados
        enviarDadosDoCurso(cursoData, modules);
        return;
    }
    
    var modulo = document.querySelectorAll('.module-card')[index];
    var fileInput = modulo.querySelector('.module-file');
    
    if (fileInput && fileInput.files.length > 0) {
        var reader = new FileReader();
        reader.onload = function(e) {
            modules[index].arquivo = e.target.result; // Arquivo em base64
            
            // Processar o próximo módulo
            processarArquivosDosModulos(index + 1, modules, cursoData);
        };
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        // Sem arquivo, continuar com o próximo módulo
        processarArquivosDosModulos(index + 1, modules, cursoData);
    }
}

// Função para enviar os dados via AJAX
function enviarDadosDoCurso(cursoData, modules) {
    // Criar o objeto para envio
    var dadosParaEnvio = {
        Func: "newCourse",
        Name: cursoData.nome,
        DescriptionCourse: cursoData.descricao,
        SecondDescription: cursoData.descricaoCard,
        CategoryCourse: cursoData.categoria,
        StartDate: cursoData.dataInicio,
        EndDate: cursoData.dataFim,
        Price: cursoData.preco,
        Img: cursoData.imagem,
        modules: JSON.stringify(modules)
    };
    
    // Mostrar dados antes do envio (para debug)
    console.log("Enviando dados:", JSON.stringify(dadosParaEnvio).substring(0, 100) + "...");
    
    // Enviar via AJAX
    $.ajax({
        url: "funcoes.php",
        type: "POST",
        data: dadosParaEnvio,
        success: function(data) {
            console.log("Resposta:", data);
            if (data == "ok") {
                alert("Curso cadastrado com sucesso!");
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
}
    
    </script>
</body>

</html>