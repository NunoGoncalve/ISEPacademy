<?php session_start(); 
    if (!isset($_SESSION['UserID'])) {
        echo '<script type="text/javascript">document.location.href="login.php"</script>'; 
    }
?>


<!DOCTYPE html>
<html data-theme="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>ISEP Academy - Cursos</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="vendor/jquery/jquery.min.js"></script>
</head>
<body>
    
    <?php include 'navbar.php'; ?>

    <div class="section">
        <div class="card">
            <div class="card-header">
                <h1 class="card-header-title">Novo Post</h1>
            </div>

            <div class="card-content">
                    <form id="new-post-form" action="javascript:save()">
                        <div class="columns is-multiline is-mobile">
                                <div id="fields" class="column is-12">
                                    <div class="field">
                                        <label class="label">Título</label>
                                        <div class="control">
                                            <input id="title" class="input is-primary" type="text"
                                                placeholder="Título..." required>
                                            <p class="help is-danger" id="course-title-error"></p>
                                        </div>
                                    </div>


                                    <div class="field">
                                        <label class="label">Descrição</label>
                                        <div class="control">
                                            <input id="description" class="input is-primary" type="text"
                                                placeholder="Pequena Descrição..." required>
                                            <p class="help is-danger" id=""></p>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Image</label>
                                            <div class="file has-name">
                                                <label class="file-label">
                                                    <input id="FileInput" class="file-input" accept="image/jpeg" type="file" name="resume" onchange="file()" required/>
                                                    <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                    <span class="file-label"> Escolha um ficheiro… </span>
                                                    </span>
                                                    <span class="file-name" id="FileName"> Vazio </span>
                                                </label>
                                            </div>
                                            <p id="FileError"></p>
                                    </div>
                                    
                                    <div id="post-content" class="field">

                                        <div class="card post-block">

                                            <div class="card-header">
                                                <h1 class="card-header-title">Secção</h1>
                                            </div>
                                            <div class="card-content">
                                                <div class="field">
                                                    <label class="label">Título/Topico</label>
                                                    <div class="control">
                                                        <input class="input is-primary" type="text" placeholder="Título/Topico" name="titles[]" required>
                                                        <p class="help is-danger" id=""></p>
                                                    </div>
                                                </div>

                                                <div class="field teste">
                                                    <div class="field">
                                                        <label class="label">Parágrafo</label>
                                                        <div class="control">
                                                            <textarea class="textarea" name="paragraphs[]"] placeholder="Insira o parágrafo aqui..."></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="column">
                                                    <div class="control">
                                                        <button type="button" class="button is-primary new-paragraph">Novo Parágrafo</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>



                                    <div class="field" style="display: flex; justify-content: space-between;">
                                        <div class="field">
                                            <div class="control">
                                                <button type="button" onclick="addPostBlock()" class="button is-primary">Novo Bloco</button>
                                            </div>
                                        </div>

                                        <div class="field">
                                            <div class="control">
                                                <button type="sumbmit" class="button is-primary">Submeter</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                                            
                                </div>
                        </div>


                    </form>
            </div>
        </div>
    </div>

    <script>
        
        function save() {
            const fileInput = document.getElementById("FileInput");
            let imageBase64 = "";
            
            // colete todos os post-blocks
            const blocks = document.querySelectorAll('.post-block');
            const result = [];

            blocks.forEach(block => {
                const title = block.querySelector('input[name="titles[]"]').value.trim();

                const paragraphElements = block.querySelectorAll('textarea[name="paragraphs[]"]');
                const paragraphs = Array.from(paragraphElements).map(p => p.value.trim())
                    .filter(p => p !== "");

                if (title || paragraphs.length > 0) {
                    result.push({ title, paragraphs });
                }
            });

            function checkAndSend() {
                sendData(imageBase64, result);
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

        function file(){
            var fileInput = document.getElementById("FileInput");

            if (fileInput.files.length > 0) {
                var fileType = fileInput.files[0].type; // Obtém o tipo MIME

                if (fileType !== "image/jpeg") {
                    document.getElementById("FileError").innerHTML="Apenas .png são aceites";
                    fileInput.value="";
                }else{
                    document.getElementById("FileError").innerHTML="";
                    document.getElementById("FileName").textContent = document.getElementById("FileInput").files[0].name;
                }
            }
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            // Event delegation to handle button click
            const fieldsContainer = document.getElementById('fields');

            fieldsContainer.addEventListener('click', function(event) {
            // If the clicked element is the "Add Paragraph" button
            if (event.target.classList.contains('new-paragraph')) {
                // Find the post-block that the button is inside
                const postBlock = event.target.closest('.post-block');
      
                // Find the paragraphs container inside this specific post-block
                const paragraphsContainer = postBlock.querySelector('.teste');
      
                // Create a new paragraph (textarea) element
                const newParagraph = document.createElement('div');
                newParagraph.classList.add('control');
                newParagraph.innerHTML = `
                    <div class="field">
                        <div style="display: flex; justify-content: space-between;">
                            <label class="label">Paragraph</label>
                            <span class="icon" onclick="this.closest('.field').remove()">
                                <i class="fas fa-trash"></i>
                            </span>
                        </div>

                        <div class="control">
                            <textarea class="textarea" name="paragraphs[]" placeholder="Your paragraph goes here..."></textarea>
                        </div>
                    </div>
                `;
      
                // Append the new paragraph to the paragraphs container
                paragraphsContainer.appendChild(newParagraph);
            }
        });
    });


   
        function sendData(image, result) {
            $.post("funcoes.php", {
                Func: "newPost",
                Title: document.getElementById('title').value,
                Description: document.getElementById('description').value,
                Content: JSON.stringify(result),
                Image: image
            
            }, function (data) {
                if (data === "ok") {
                    document.location = "blog.php";
                }
                  
            }, "text");;
        }
                
        function addPostBlock() {
            const postBlock = document.createElement('div');
            postBlock.classList.add('card', 'post-block');

            postBlock.innerHTML = `

                <div class="card-header">
                    <p class="card-header-title">Card header</p>
                    <button class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-trash" aria-hidden="true" onclick="this.closest('.card').remove()"></i>
                    </span>
                    </button>
                </div>
                <div class="card-content"> 
                    <div class="field">
                        <label class="label">Title/Topic</label>
                        <div class="control">
                            <input class="input is-primary" type="text" name="titles[]" placeholder="Title/Topic" required>
                            <p class="help is-danger" id=""></p>
                        </div>
                    </div>

                <div class="field teste">
                    <div class="field">
                        <label class="label">Paragraph</label>
                        <div class="control">
                            <textarea class="textarea" name="paragraphs[]" placeholder="Your paragraph goes here..."></textarea>
                        </div>
                    </div>
                                            
                </div>

                <div class="column">
                    <div class="control">
                        <button type="button" class="button is-primary new-paragraph">New Paragraph</button>
                    </div>
                </div>
                </div>
            `;

            document.getElementById('post-content').appendChild(postBlock);
        }

    </script>
</body>
</html>