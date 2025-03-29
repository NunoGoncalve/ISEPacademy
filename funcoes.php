<?php 
    session_start();

    if(isset($_POST["Func"])){
        
        Switch ($_POST["Func"]){

            case "login":
                $Email = $_POST["Email"];
                $Pass = $_POST["Pass"];
                
                $Query="Select ID, Email, Password, Role from User where Email like '$Email'";
                $info = exeDB($Query);

                if(empty($info)){
                    echo "ErroEmail";
                }else if($info["Password"]!=$Pass){
                    echo "ErroPass";
                }
                else{
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];
                    echo "ok";
                }
            break;
            case "register":
                $Name = $_POST["Name"]; 
                $Email = $_POST["Email"];
                $Pass = $_POST["Pass"];
                


                $Query="Select Count(Email) as ContMail from User where Email like '$Email'";
                $info = exeDB($Query);
                if($info["ContMail"]==0){
                    $Query="Insert INTO User (Name, Email, Password, RegisterDate) values ('".$Name."', '".$Email."', '".$Pass."', '".date("Y-m-d")."')";
                    exeDB($Query);
                    $Query="Select ID, Role from User where Email like '$Email'";
                    $info=exeDB($Query);
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];

                    if(isset($_POST["Img"])){
                        $imgData = $_POST['Img'];
                        list($type, $data) = explode(';', $imgData);
                        list(, $data) = explode(',', $data);
                        $decodedImage = base64_decode($data);
                        file_put_contents("img/users/".$info["ID"].".png", $decodedImage);
                    }
                     

                    echo "ok";
                }
                else{
                    echo "ErroMail";
                }
                
            break;

            case "logout":
                session_destroy();
                echo "ok";
            break;

            case "favourite":
                    if($_POST["Flag"]){
                        $Query = "Insert into Interaction (Favourite, UserID, CourseID) VALUES (".$_POST["Fav"].",".$_SESSION["UserID"].",".$_POST["CourseID"].")";
                    }else{
                        $Query = "Update Interaction SET Favourite=".$_POST["Fav"]." where UserID=".$_SESSION["UserID"]." AND CourseID=".$_POST["CourseID"];
                    }
                    
                    $info = exeDB($Query);
                    echo "ok";
            break;
    
            case "subscribe":
                if($_POST["Flag"]){
                    $Query = "Insert into Interaction (Status, UserID, CourseID) VALUES (1,".$_SESSION["UserID"].",".$_POST["CourseID"].")";
                }else{
                    $Query = "Update Interaction SET Status=1 where UserID=".$_SESSION["UserID"]." AND CourseID=".$_POST["CourseID"];
                }
                $info = exeDB($Query);
                echo "ok";
            break;

            // PARTE 1: ATUALIZAÇÃO DO BACKEND (PHP)
// Substitua o case "newCourse" pelo seguinte:

case "newCourse":
    $NameCourse = $_POST["Name"]; 
    $DescriptionCourse = $_POST["DescriptionCourse"];
    $SecondDescription = $_POST["SecondDescription"];
    $CategoryCourse = $_POST["CategoryCourse"];
    $StartDate = $_POST["StartDate"];
    $EndDate = $_POST["EndDate"];
    $Price = $_POST["Price"];

    // Verifica se já existe um curso com o mesmo nome
    $Query = "SELECT COUNT(Name) as contCourse FROM Course WHERE Name = '$NameCourse'";
    $info = exeDB($Query);

    if ($info["contCourse"] == 0) {
        // Inserir o curso na base de dados
        $Query = "INSERT INTO Course (TeacherID, Name, CardDesc, PagDesc, Category, StartDate, EndDate, Price) 
                  VALUES (9,'$NameCourse', '$DescriptionCourse', '$SecondDescription', '$CategoryCourse', '$StartDate', '$EndDate', '$Price')";
        exeDB($Query);

        // Obter o ID do curso recém-criado
        $Query = "SELECT ID FROM Course WHERE Name = '$NameCourse' ORDER BY ID DESC LIMIT 1";
        $info = exeDB($Query);
        $CourseID = $info["ID"];

        // Processar módulos a partir do JSON recebido
        if (isset($_POST["Modules"])) {
            $modules = json_decode($_POST["Modules"], true);
            foreach ($modules as $module) {
                $ModuleName = $module["ModuleName"];
                $ModuleDescription = $module["ModuleDescription"];
                
                // Inserir cada módulo associado ao curso
                $Query = "INSERT INTO Steps (CourseID, Name, Description) 
                          VALUES ('$CourseID', '$ModuleName', '$ModuleDescription')";
                exeDB($Query);
            }
        }

        // Verifica se há uma imagem enviada
        if (isset($_POST["Img"])) {
            $imgData = $_POST['Img'];
            list($type, $data) = explode(';', $imgData);
            list(, $data) = explode(',', $data);
            $decodedImage = base64_decode($data);
            file_put_contents("img/layout/img" . $CourseID . ".jpg", $decodedImage);
        }

        echo "ok";
    } else {
        echo "ErroMail";
    }
    case "updateCourse":
        $CourseID = $_POST["CourseID"];
        $NameCourse = $_POST["Name"]; 
        $DescriptionCourse = $_POST["DescriptionCourse"];
        $SecondDescription = $_POST["SecondDescription"];
        $CategoryCourse = $_POST["CategoryCourse"];
        $StartDate = $_POST["StartDate"];
        $EndDate = $_POST["EndDate"];
        $Price = $_POST["Price"];
    
        // Verifica se já existe outro curso com o mesmo nome (exceto o próprio curso sendo atualizado)
        $Query = "SELECT COUNT(Name) as contCourse FROM Course WHERE Name = '$NameCourse' AND ID != '$CourseID'";
        $info = exeDB($Query);
    
        if ($info["contCourse"] == 0) {
            // Atualiza os dados do curso na base de dados
            $Query = "UPDATE Course SET 
                      Name = '$NameCourse', 
                      CardDesc = '$DescriptionCourse', 
                      PagDesc = '$SecondDescription', 
                      Category = '$CategoryCourse', 
                      StartDate = '$StartDate', 
                      EndDate = '$EndDate', 
                      Price = '$Price'
                      WHERE ID = '$CourseID'";
            exeDB($Query);
    
            // Processar módulos a partir do JSON recebido
            if (isset($_POST["Modules"])) {
                $modules = json_decode($_POST["Modules"], true);
                foreach ($modules as $module) {
                    $ModuleName = $module["ModuleName"];
                    $ModuleDescription = $module["ModuleDescription"];
                    
                    // Inserir cada módulo associado ao curso
                    $Query = "INSERT INTO Steps (CourseID, Name, Description) 
                              VALUES ('$CourseID', '$ModuleName', '$ModuleDescription')";
                    exeDB($Query);
                }
            }
    
            // Verifica se há uma imagem enviada
            if (isset($_POST["Img"]) && !empty($_POST["Img"])) {
                $imgData = $_POST['Img'];
                list($type, $data) = explode(';', $imgData);
                list(, $data) = explode(',', $data);
                $decodedImage = base64_decode($data);
                
                // Remove a imagem antiga se existir
                if (file_exists("img/layout/img" . $CourseID . ".jpg")) {
                    unlink("img/layout/img" . $CourseID . ".jpg");
                }
                
                // Salva a nova imagem
                file_put_contents("img/layout/img" . $CourseID . ".jpg", $decodedImage);
            }
    
            echo "ok";
        } else {
            echo "ErroMail";
        }
        break;
    
        }
    }
    function exeDB($Query)  {
        include 'conexao.php';
        $exe = mysqli_query($conexao, $Query);
        if(!is_bool($exe)){
            $row = mysqli_fetch_assoc($exe);
            return $row;
        }
    }

    function exeDBList($Query)  {
        include 'conexao.php';
        return mysqli_query($conexao, $Query);
    }

    function getUserInfo(){
        $Query = "Select Name, Email, Role, RegisterDate from User where ID=".$_SESSION["UserID"];
        return exeDB($Query);
    }
    
    function getUserFavs(){
        $Query = "Select C.Name from Course C inner join Interaction I on C.ID=I.CourseID where UserID=".$_SESSION["UserID"]." and Favourite=1";
        return exeDBList($Query);
    }

    function getUserSubs(){
        $Query = "Select C.Name from Course C inner join Interaction I on C.ID=I.CourseID where UserID=".$_SESSION["UserID"]." and Status=1";
        return exeDBList($Query);
    }

    function getCourseById($id) {
        $Query = "SELECT * FROM Course WHERE ID = '$id'";
        $result = exeDBList($Query); // Supondo que exeDBList() retorna um mysqli_result
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // Obtém a primeira linha como array associativo
        }
    
        return false; // Retorna falso se não houver resultados
    }

    function getModulesByCourseId($id) {
        $Query = "SELECT *, COUNT(CourseID) AS CID FROM Steps WHERE CourseID = '$id'";
        $result = exeDBList($Query); // Supondo que exeDBList() retorna um mysqli_result
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // Obtém a primeira linha como array associativo
        }
        
    }
?>