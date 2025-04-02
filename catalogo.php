<?php session_start();
include 'funcoes.php'; ?>

<!DOCTYPE html>
<html data-theme="light" lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEP Academy - Cursos</title>
    <!-- Importar CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    /* Estilos para o dropdown personalizado */
.dropdown-checkbox-item {
  padding: 0.5rem 1rem;
}

.dropdown-checkbox-item:hover {
  background-color: #f5f5f5;
}

/* Certificar que o dropdown fica sobre outros elementos */
.dropdown.is-active .dropdown-menu {
  display: block;
  z-index: 100;
}

/* Estilo para cards filtrados */
.column[style*="display: none"] {
  transition: opacity 0.3s;
}   
</style>
<body>

    <?php include 'navbar.php'; ?>

    <!-- Contenido principal -->
    <article class="section">
        <div class="container">
            <!-- Filtros de Pesquisa -->
            <div class="container mt-5">
                <div class="columns">

                <div class="heart" id="heart"></div>
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Categoria</label>
                            <div class="control">
                                <div class="dropdown" id="category-dropdown">
                                    <div class="dropdown-trigger">
                                        <button class="button is-fullwidth" id="dropdown-button" aria-haspopup="true"
                                            aria-controls="dropdown-menu">
                                            <span>Selecionar Categoria</span>
                                            <span class="icon is-small">
                                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="dropdown-menu" role="menu">
                                        <div class="dropdown-content">
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="informatica"> Informática
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="mecanica"> Mecânica
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="marketing"> Marketing
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="design"> Design
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="tecnologia"> Tecnologia
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="eletricidade"> Eletricidade
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="ciencias"> Ciencias
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="dropdown-checkbox-item">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="desporto"> Desporto
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <hr class="dropdown-divider">
                                            <div class="dropdown-item">
                                                <div class="buttons is-justify-content-space-between">
                                                    <button class="button is-success is-small">✔ Aplicar</button>
                                                    <button class="button is-light is-small" id="clear-button">✖
                                                        Limpar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Buscar</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="Buscar...">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <!-- Catálogo de cursos -->
            <div class="columns is-multiline" id="cards">
                <?php
                switch ($_SESSION["Role"]) {
                    case 2:
                        $Query = "Select * from Course where TeacherID=" . $_SESSION["UserID"] . " AND Status<3";
                        break;
                    case 3:
                        $Query = "Select * from Course";
                        break;
                    default:
                        $Query = "Select * from Course where Status=1";
                        break;
                }
                $exe = exeDBList($Query);
                $i=0;
                while ($CourseInfo = mysqli_fetch_assoc($exe)) {
                    ?>
                    <!-- Inicio do bloco de curso que se repetirá -->
                    <article
                        class="column is-3-desktop is-4-tablet is-6-mobile <?php echo ($CourseInfo["Status"] > 1) ? 'unavailable-card' : ''; ?> "
                        onclick="document.location='curso.php?ID=<?php echo $CourseInfo['ID'] ?>'">
                        <div class="card product-card ">
                            <div class="card-image">
                                <div class="product-image">
                                    <img src="<?php echo "img/layout/" . $CourseInfo['ID'] . ".jpg"; ?>"
                                        alt="<?php echo $CourseInfo['Name']; ?>">
                                </div>
                            </div>
                            <div class="card-content product-content">
                                <p class="subtitle is-6"><?php echo $CourseInfo['Category']; ?></p>
                                <p class="title is-5"><?php echo $CourseInfo['Name']; ?></p>
                                <p class="content" id="cardText"><?php echo $CourseInfo['CardDesc']; ?></p>
                                <div class="product-actions">
                                    <div class="buttons">
                                        <?php if ($_SESSION["Role"] > 1) {
                                            switch ($CourseInfo["Status"]) {
                                                case 1:
                                                    echo '<a href="editar_curso.php?ID=' . $CourseInfo['ID'] . '" class="button is-info is-outlined is-fullwidth">Editar Curso</a>
                                                    <button class="button is-primary is-fullwidth is-red" onclick="DelCourse("' . $CourseInfo['ID'] . '")">Remover</button>';
                                                    break;
                                                case 2:
                                                    echo '<a class=" is-fullwidth"></a>
                                                    <button class="button is-primary is-fullwidth ">Em analise</button>';
                                                    break;
                                                case 3:
                                                    echo '<a class=" is-fullwidth"></a>
                                                    <button class="button is-primary is-fullwidth ">Desativado</button>';
                                                    break;
                                            }
                                        } else {
                                            echo '<a href="curso.php?ID=' . $CourseInfo["ID"] . '"
                                                class="button is-primary is-fullwidth">Ver detalhes</a>';
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php } ?>
                
                <!-- Fim do bloco de curso -->
            </div>

            <!-- Paginación en caso de necesidad 
                <div class="pagination is-centered mt-6">
                    <ul class="pagination-list">
                        <li><a class="pagination-link is-current" aria-label="Ir a página 1" aria-current="page">1</a></li>
                        <li><a class="pagination-link" aria-label="Ir a página 2">2</a></li>
                        <li><a class="pagination-link" aria-label="Página 3">3</a></li>
                        <li><a class="pagination-link" aria-label="Ir a página 4">4</a></li>
                    </ul>
                </div>-->
        </div>
    </article>
    <?php include 'footer.php'; ?>
    <script>

document.addEventListener('DOMContentLoaded', function() {
  // Variáveis para controlar o dropdown e as checkboxes
  const dropdownButton = document.getElementById('dropdown-button');
  const dropdown = document.getElementById('category-dropdown');
  const dropdownButtonText = dropdownButton.querySelector('span');
  const applyButton = document.querySelector('.button.is-success');
  const clearButton = document.getElementById('clear-button');
  const searchInput = document.querySelector('input[type="text"]');
  const checkboxes = document.querySelectorAll('.dropdown-checkbox-item input[type="checkbox"]');
  
  // Console logs para depuração
  console.log('Dropdown button:', dropdownButton);
  console.log('Apply button:', applyButton);
  console.log('Clear button:', clearButton);
  console.log('Checkboxes:', checkboxes);
  
  // Controle de exibição do dropdown
  dropdownButton.addEventListener('click', function(event) {
    console.log('Dropdown button clicked');
    dropdown.classList.toggle('is-active');
    event.stopPropagation();
  });
  
  // Fechar dropdown quando clicar fora dele
  document.addEventListener('click', function(event) {
    const isClickInside = dropdown.contains(event.target);
    if (!isClickInside && dropdown.classList.contains('is-active')) {
      dropdown.classList.remove('is-active');
    }
  });
  
  // Prevenir propagação do clique dentro do dropdown
  const dropdownContent = document.querySelector('.dropdown-content');
  if (dropdownContent) {
    dropdownContent.addEventListener('click', function(event) {
      event.stopPropagation();
    });
  }
  
  // Verificar cada checkbox
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      console.log(`Checkbox ${this.value} changed:`, this.checked);
    });
  });
  
  // Aplicar filtros selecionados
  if (applyButton) {
    applyButton.addEventListener('click', function(event) {
      console.log('Apply button clicked');
      event.preventDefault();
      event.stopPropagation();
      
      const selectedCategories = [];
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          selectedCategories.push(checkbox.value);
        }
      });
      
      console.log('Selected categories:', selectedCategories);
      
      // Atualizar texto do botão
      if (selectedCategories.length > 0) {
        dropdownButtonText.textContent = `${selectedCategories.length} categorias selecionadas`;
      } else {
        dropdownButtonText.textContent = 'Selecionar Categoria';
      }
      
      // Filtrar cursos
      filterCourses(selectedCategories, searchInput.value);
      
      // Fechar dropdown
      dropdown.classList.remove('is-active');
    });
  }
  
  // Limpar checkboxes
  if (clearButton) {
    clearButton.addEventListener('click', function(event) {
      console.log('Clear button clicked');
      event.preventDefault();
      event.stopPropagation();
      
      checkboxes.forEach(checkbox => {
        checkbox.checked = false;
      });
      dropdownButtonText.textContent = 'Selecionar Categoria';
      
      // Resetar filtros
      filterCourses([], searchInput.value);
    });
  }
  
  // Filtrar ao digitar na caixa de busca
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      console.log('Search input:', this.value);
      
      const selectedCategories = [];
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          selectedCategories.push(checkbox.value);
        }
      });
      
      filterCourses(selectedCategories, this.value);
    });
  }
  
  // Função para filtrar os cursos
  function filterCourses(categories, searchText) {
  console.log('Filtering courses with categories:', categories, 'and search text:', searchText);
  
  const courseCards = document.querySelectorAll('.column .product-card');
  console.log('Found course cards:', courseCards.length);
  
  let visibleCount = 0;
  
  // Remover mensagem de "nenhum resultado" existente
  const existingNoResults = document.getElementById('no-results-message');
  if (existingNoResults) {
    existingNoResults.remove();
  }
  
  courseCards.forEach(card => {
    const cardParent = card.closest('.column');
    const categoryText = card.querySelector('.subtitle')?.textContent.toLowerCase() || '';
    const titleText = card.querySelector('.title')?.textContent.toLowerCase() || '';
    const descriptionText = card.querySelector('.content')?.textContent.toLowerCase() || '';
    
    // Verificar se o curso está na categoria selecionada (ou se nenhuma categoria foi selecionada)
    const categoryMatch = categories.length === 0 || categories.some(cat => categoryText.includes(cat));
    
    // Verificar se o curso corresponde à pesquisa de texto
    const searchMatch = searchText === '' || 
                      titleText.includes(searchText.toLowerCase()) || 
                      descriptionText.includes(searchText.toLowerCase()) ||
                      categoryText.includes(searchText.toLowerCase());
    
    console.log('Card:', titleText, 'Category match:', categoryMatch, 'Search match:', searchMatch);
    
    // Mostrar ou esconder o curso com base nos filtros
    if (categoryMatch && searchMatch) {
      cardParent.style.display = '';
      visibleCount++;
    } else {
      cardParent.style.display = 'none';
    }
  });
  
  // Verificar se não há cursos visíveis e mostrar mensagem
  if (visibleCount === 0) {
    const coursesContainer = document.querySelector('.columns.is-multiline');
    
    // Criar elemento de mensagem
    const noResultsMessage = document.createElement('div');
    noResultsMessage.id = 'no-results-message';
    noResultsMessage.className = 'column is-12 has-text-centered';
    noResultsMessage.innerHTML = `
      <div class="notification is-transparent">
        <p class="title is-5">Nenhum curso encontrado</p>
        <p>Não foram encontrados cursos com os filtros selecionados.</p>
        <button class="button is-primary mt-3" id="reset-all-filters">
          <span class="icon">
            <i class="fas fa-sync-alt"></i>
          </span>
          <span>Limpar todos os filtros</span>
        </button>
      </div>
    `;
    
    // Adicionar ao container de cursos
    coursesContainer.appendChild(noResultsMessage);
    
    // Adicionar event listener ao botão de reset
    document.getElementById('reset-all-filters').addEventListener('click', function() {
      // Limpar checkboxes
      const checkboxes = document.querySelectorAll('.dropdown-checkbox-item input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        checkbox.checked = false;
      });
      
      // Limpar campo de busca
      const searchInput = document.querySelector('input[type="text"]');
      if (searchInput) {
        searchInput.value = '';
      }
      
      // Resetar texto do botão dropdown
      const dropdownButtonText = document.querySelector('#dropdown-button span');
      if (dropdownButtonText) {
        dropdownButtonText.textContent = 'Selecionar Categoria';
      }
      
      // Mostrar todos os cursos
      filterCourses([], '');
    });
  }
  
  return visibleCount;
}
});
    </script>
</body>

</html>