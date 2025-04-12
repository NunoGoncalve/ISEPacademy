<?php 
    session_start();

    if(isset($_POST["Func"])){
        
        Switch ($_POST["Func"]){

            case "login":
                $Email = $_POST["Email"];
                $Pass = $_POST["Pass"];
                
                $Query="Select ID, Email, Password, Role from User where Email like '$Email' and Role>0";
                $info = exeDB($Query);

                if(empty($info)){
                    echo "ErroEmail";
                }else if(!password_verify( $Pass, $info["Password"])){
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
                
            
                $options = ['cost' => 12];
                $Pass = password_hash($_POST["Pass"], PASSWORD_ARGON2ID, $options);


                $Query="Select Count(Email) as ContMail from User where Email like '$Email'";
                $info = exeDB($Query);
                if($info["ContMail"]==0){
                    $Query="Insert INTO User (Name, Email, Password, RegisterDate) values ('".$Name."', '".$Email."', '".$Pass."', '".date("Y-m-d")."')";
                    exeDB($Query);
                    $Query="Select ID, Role from User where Email like '$Email'";
                    $info=exeDB($Query);
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];

                    if($_POST["Img"]!=""){
                        $imgData = $_POST['Img'];
                        list($type, $data) = explode(';', $imgData);
                        list(, $data) = explode(',', $data);
                        $decodedImage = base64_decode($data);
                        file_put_contents("img/users/".$info["ID"].".png", $decodedImage);
                    }
                    if($_POST["Curriculo"]!=""){
                        $curriculoData = $_POST['Curriculo'];
                        $base64Data = explode(',', $curriculoData, 2)[1];
                        $decodedFile = base64_decode($base64Data);
                        $filePath = "curriculos/curriculo" . $info["ID"] . ".pdf";
                        file_put_contents($filePath, $decodedFile);
                    }

                    if($_POST["Role"]=="true"){
                        RoleRequest($Email, $_SESSION["UserID"]);
                    }

                    echo "ok";
                }
                else{
                    echo "ErroMail";
                }
                
            break;

            case "updateProfile":
                if($_POST["Pass"]==""){
                    $Query = "Update User SET Name='".$_POST["Name"]."',Email='".$_POST["Email"]."' where ID=".$_SESSION["UserID"];
                }else{
                    $options = ['cost' => 12];
                    $Pass = password_hash($_POST["Pass"], PASSWORD_ARGON2ID, $options);

                    $Query = "Update User SET Name='".$_POST["Name"]."',Email='".$_POST["Email"]."',Password='".$Pass."' where ID=".$_SESSION["UserID"];
                }
                exeDB($Query);
                if(isset($_POST["Img"])){
                    $imgData = $_POST['Img'];
                    list($type, $data) = explode(';', $imgData);
                    list(, $data) = explode(',', $data);
                    $decodedImage = base64_decode($data);
                    file_put_contents("img/users/".$_SESSION["UserID"].".png", $decodedImage);
                }
                echo "ok";
                
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

            case "newCourse":
                $NameCourse = $_POST["Name"]; 
                $DescriptionCourse = nl2br($_POST["DescriptionCourse"]);
                $SecondDescription = $_POST["SecondDescription"];
                $CategoryCourse = $_POST["CategoryCourse"];
                $StartDate = $_POST["StartDate"];
                $EndDate = $_POST["EndDate"];
                $Price = $_POST["Price"];

                // Verifica se já existe um curso com o mesmo nome
                $Query = "SELECT COUNT(Name) as contCourse FROM Course WHERE Name like '".$NameCourse."'";
                $info = exeDB($Query);

                if ($info["contCourse"] == 0) {
                    // Inserir o curso na base de dados
                    $Query = "INSERT INTO Course (TeacherID, Name, PagDesc, CardDesc, Category, StartDate, EndDate, Price) 
                            VALUES (".$_SESSION["UserID"].",'$NameCourse', '$DescriptionCourse', '$SecondDescription', '$CategoryCourse', '$StartDate', '$EndDate', '$Price')";
                    exeDB($Query);

                    // Obter o ID do curso recém-criado
                    $Query = "SELECT ID FROM Course WHERE Name like '".$NameCourse."'";
                    $info = exeDB($Query);
                    $CourseID = $info["ID"];
                    // Processar módulos a partir do JSON recebido
                    if (isset($_POST["modules"])) {
                        $modules = json_decode($_POST["modules"], true);
                        foreach ($modules as $module) {
                            $ModuleID =$module["id"];
                            $ModuleName = $module["name"];
                            $ModuleDescription = nl2br($module["description"]);
                            // Inserir cada módulo associado ao curso
                            $Query = "INSERT INTO Steps (CourseID, ID, Name, Description) 
                                    VALUES ($CourseID, $ModuleID, '$ModuleName', '$ModuleDescription')";
                            exeDB($Query);

                            if (isset($module["arquivo"])) {
                                // Criar pasta para o curso se não existir
                                if (!file_exists("cursos/$CourseID")) {
                                    mkdir("cursos/$CourseID");
                                }
            
                                $fileData = $module["arquivo"];
                                list($type, $data) = explode(';', $fileData);
                                list(, $data) = explode(',', $data);
                                $decodedFile = base64_decode($data);
                                
                                file_put_contents("cursos/".$CourseID."/".$ModuleID.".pdf", $decodedFile);
                            }
                            

                        }
                    }

                    // Verifica se há uma imagem enviada
                    if (isset($_POST["Img"])) {
                        $imgData = $_POST['Img'];
                        list($type, $data) = explode(';', $imgData);
                        list(, $data) = explode(',', $data);
                        $decodedImage = base64_decode($data);
                        file_put_contents("img/layout/" . $CourseID . ".jpg", $decodedImage);
                    }

                    newCourse($NameCourse);

                    echo "ok";
                } else {
                    echo "Nome já existente";
                }
            break;
            case "updateCourse":
                $CourseID = $_POST["CourseID"];
                $NameCourse = $_POST["Name"]; 
                $DescriptionCourse = nl2br($_POST["DescriptionCourse"]);
                $SecondDescription = $_POST["SecondDescription"];
                $CategoryCourse = $_POST["CategoryCourse"];
                $StartDate = $_POST["StartDate"];
                $EndDate = $_POST["EndDate"];
                $Price = $_POST["Price"];
            
                // Verifica se já existe outro curso com o mesmo nome (exceto o próprio curso sendo atualizado)
                $Query = "SELECT COUNT(Name) as contCourse FROM Course WHERE Name like '$NameCourse' AND ID != '$CourseID'";
                $info = exeDB($Query);
            
                if ($info["contCourse"] == 0) {
                    // Atualiza os dados do curso na base de dados
                    $Query = "UPDATE Course SET 
                            Name = '$NameCourse', 
                            CardDesc = '$SecondDescription', 
                            PagDesc = '$DescriptionCourse', 
                            Category = '$CategoryCourse', 
                            StartDate = '$StartDate', 
                            EndDate = '$EndDate', 
                            Price = '$Price'
                            WHERE ID = '$CourseID'";
                    exeDB($Query);
            
                    // Processar módulos a partir do JSON recebido
                    if (isset($_POST["Modules"])) {
                        $modules = json_decode($_POST["Modules"], true);

                        $Query = "SELECT COUNT(ID) as contStep FROM Steps WHERE CourseID = $CourseID";
                        $info = exeDB($Query);

                        if (!file_exists("cursos/$CourseID")) {
                            mkdir("cursos/$CourseID", 0777, true);
                        }

                        // Verifica se o número de módulos foi alterado
                        for($i = 0; $i < sizeof($modules); $i++) {
                            if($i >= $info["contStep"]){
                                $Query = "INSERT INTO Steps (ID, CourseID, Name, Description) 
                                        VALUES (".$modules[$i]["ModuleId"].", $CourseID, '".$modules[$i]["ModuleName"]."', '".nl2br($modules[$i]["ModuleDescription"])."')";
                                exeDB($Query);
                            }
                            else{
                                $Query = "UPDATE Steps SET Name='".$modules[$i]["ModuleName"]."', Description='".nl2br($modules[$i]["ModuleDescription"])."' 
                                        WHERE CourseID=$CourseID AND ID=".$modules[$i]["ModuleId"];
                                exeDB($Query);
                            }
                            if (isset($modules[$i]["ModuleFile"]) && !empty($modules[$i]["ModuleFile"])) {
                                $fileData = $modules[$i]["ModuleFile"];
                                list($type, $data) = explode(';', $fileData);
                                list(, $data) = explode(',', $data);
                                $decodedFile = base64_decode($data);
                                
                                // Salva o arquivo do módulo
                                file_put_contents("cursos/".$CourseID."/".$modules[$i]["ModuleId"].".pdf", $decodedFile);
                            }
                        }
                    }
            
                    // Verifica se há uma imagem enviada
                    if (isset($_POST["Img"]) && !empty($_POST["Img"])) {
                        $imgData = $_POST['Img'];
                        list($type, $data) = explode(';', $imgData);
                        list(, $data) = explode(',', $data);
                        $decodedImage = base64_decode($data);
                        
                        // Salva a nova imagem
                        file_put_contents("img/layout/" . $CourseID . ".jpg", $decodedImage);
                    }
                    echo "ok";
                } else {
                    echo "Nome já existente";
                }
                
            break;
    
            case "Recpass":
                
                $Query="Select Count(Email) as ContMail from User where Email like '".$_POST["Email"]."'";
                $info = exeDB($Query);
                if($info["ContMail"]==0){
                    echo "ErroMail";
                }else{
                    //Configuração
                    include '../emailconfig.php';
                    
                    //Composição do email
                    $cod=rand(1,999999);
                    $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
                    $mail->addAddress($_POST["Email"]);
                                
                    $mail->isHTML(true);
                    $mail->Subject = "Código de verificação";
                    $mail->Body  = "Insira o seguinte código de verificação <h1>".$cod."</h1>"; 
                    $mail->send();
                    setcookie("Verfication", $cod, time() + (60 * 30), "/");
                    echo $cod;  
                }

            break;

            case "Chpass":
                $Query="Select ID from User where Email like '".$_POST["Email"]."'";
                $info = exeDB($Query);
                $options = ['cost' => 12];
                $Pass = password_hash($_POST["Pass"], PASSWORD_ARGON2ID, $options);

                $Query = "Update User SET Password='".$Pass."' where ID=".$info["ID"];
                exeDB($Query);
                echo "ok";
            break;

            case "Verify":
                if($_POST["Cod"]==$_COOKIE["Verfication"]){
                    setcookie("Verfication", "", time() - 3600);
                    echo "ok";
                }
                
            break;
            
            case "DelCourse":

                //Configuração
                include '../emailconfig.php';
                
                //Composição do email
                $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
                $mail->addAddress('isepacademy@gmail.com');
                            
                $mail->isHTML(true);
                $mail->Subject = "Pedido de eliminação";
                $mail->Body  = '<h2> Foi pedida a eliminação do Curso <b>ID -> '.$_POST["CourseID"].'</b><br>
                <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
                href="https://isepacademy.fixstuff.net/Master/funcoes.php?Func=DelCourse&CourseID='.$_POST["CourseID"].'">Aceitar</a>
                </h2>'; 
                $mail->send();
                $Query="Update Course Set Status=2 Where ID=".$_POST["CourseID"];
                $info = exeDB($Query);
                echo "ok";
        
            break;

            case "newPost":
                include 'conexao.php';
                $Query="Insert into Blog (UserID, Title, Description, Content, PublishDate) values (".$_SESSION["UserID"].",'".$_POST["Title"]."','".$_POST["Description"]."','".$_POST["Content"]."', ' ".date("Y-m-d"). "')";

                
                mysqli_query($conexao, $Query);
                $insertedId = mysqli_insert_id($conexao);

                // Verifica se há uma imagem enviada
                if (isset($_POST["Image"])) {
                    $imgData = $_POST['Image'];
                    list($type, $data) = explode(';', $imgData);
                    list(, $data) = explode(',', $data);
                    $decodedImage = base64_decode($data);
                    file_put_contents("img/blog/" . $insertedId . ".jpg", $decodedImage);
                }
                
                echo "ok";
            break;

            case "review":
                $Query="Update Interaction Set Rating=".$_POST["Rating"].", Review='".$_POST["Review"]."', ReviewDate='".date("Y-m-d")."' where UserID=".$_SESSION["UserID"]." and CourseID=".$_POST["CourseID"];
                $info = exeDB($Query);
                echo "ok";
            break;

            case "UserStep":
                
                $Query="Insert into UserSteps (UserID, CourseID, StepID, Done) values (".$_SESSION["UserID"].",".$_POST["CourseID"].",".$_POST["StepID"].", 1)";
                $info = exeDB($Query);

                $Query="Select Count(CourseID) from Steps where CourseID=".$_POST["CourseID"];
                $info = exeDB($Query);
                $Query="Select Count(CourseID) from UserSteps where CourseID=".$_POST["CourseID"]." and Done=1 and UserID=".$_SESSION["UserID"];
                $info2 = exeDB($Query);
                if($info["Count(CourseID)"]==$info2["Count(CourseID)"]){
                    $Query="Update Interaction Set Status=2 where CourseID=".$_POST["CourseID"]." and UserID=".$_SESSION["UserID"];
                    $info = exeDB($Query);
                    SendCertificate($_POST["CourseID"]);
                    echo "ok";
                }
                echo "ok";
            break;

            case "DelUser":
                $Query="Update User Set Role=0 where ID=".$_POST["UserID"];
                exeDB($Query);
                echo "ok";
            break;

            case "Stats":
                $Query="Select ID From Course where Name like '".$_POST["Name"]."'";
                $temp = exeDB($Query);
                $CourseID=$temp["ID"];

                $Query="Select Count(UserID) From Interaction where CourseID=".$CourseID." and Status=1";
                $temp = exeDB($Query);
                $Inscritos=$temp["Count(UserID)"];

                $Query="Select Count(UserID) From Interaction where CourseID=".$CourseID." and Status=2";
                $temp = exeDB($Query);
                $Concluidos=$temp["Count(UserID)"];

                $Query="Select Count(UserID) From Interaction where CourseID=".$CourseID." and Status>0";
                $temp = exeDB($Query);
                $Todos=$temp["Count(UserID)"];

                echo $Inscritos."|".$Concluidos."|".number_format(($Concluidos/$Todos)*100,0);
            break;

        }  
    }else if(isset($_GET["Func"])){     
        Switch ($_GET["Func"]){ 
            case "DelCourse":
                $Query="Update Course Set Status=3 Where ID=".$_GET["CourseID"];
                $info = exeDB($Query);
            break;
            case "Upgrade":
                $file = fopen("curriculos/curriculo".$_GET["ID"].".pdf","w");
                unlink("test.txt");
                $Query = "Update User set Role=2 where ID=".$_GET["ID"];
                exeDB($Query);
            break;
            case "Uprove":
                $Query="Update Course Set Status=1 Where Name like '".$_GET["Course"]."'";
                $info = exeDB($Query);
            break;
        }
        ?><!DOCTYPE html>
                <html>
                <head>
                </head>
                <body>
                <script>
                        setTimeout(function() {
                            
                            window.open('','_parent',''); 
                            window.close();

                        }, 5000);
                    </script>
                </body>
                </html>
            <?php
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
        $Query = "Select Name, Email, RegisterDate from User where ID=".$_SESSION["UserID"];
        return exeDB($Query);
    }
    
    function getUserFavs(){
        $Query = "Select C.* from Course C inner join Interaction I on C.ID=I.CourseID where UserID=".$_SESSION["UserID"]." and Favourite=1 and C.Status=1";
        return exeDBList($Query);
    }
    function getUserCreated(){
        $Query = "Select * from Course where TeacherID=".$_SESSION["UserID"]." AND Status<3";
        return exeDBList($Query);
    }

    function getUserSubs(){
        $Query = "Select C.* from Course C inner join Interaction I on C.ID=I.CourseID where UserID=".$_SESSION["UserID"]." and C.Status=1 and I.Status>=1";
        return exeDBList($Query);
    }

    function getAllCourses() {
        $Query = "SELECT * FROM Course";
        return $result = exeDBList($Query); 
    }
    function getCourseById($id) {
        $Query = "SELECT * FROM Course WHERE ID = '$id'";
        return exeDB($Query); // Supondo que exeDBList() retorna um mysqli_result
        
        /*if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // Obtém a primeira linha como array associativo
        }
    
        return false; // Retorna falso se não houver resultados*/
    }

    function getModulesByCourseId($id) {
        //$Query = "SELECT *, COUNT(CourseID) AS CID FROM Steps WHERE CourseID = $id";
        $Query = "SELECT * FROM Steps WHERE CourseID = $id";
        return $result = exeDBList($Query); // Supondo que exeDBList() retorna um mysqli_result
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // Obtém a primeira linha como array associativo
        }
        
    }

    function getUsers(){
        $Query = "SELECT * FROM User Where Role>0";
        return $result = exeDBList($Query); 
    }

    function getBlog() {
        $Query = "SELECT Blog.*, User.Name FROM Blog inner join User on Blog.UserID=User.ID";
        return $result = exeDBList($Query); 
        
    }

    function getBlogPosts() {
        
        $start_from = 0;

        $posts_per_page = 3;

        if(isset($_GET['page'])) {

            $page = $_GET['page'] - 1;

            $start_from = $page * $posts_per_page;
        }


        $Query = "SELECT *  FROM Blog ORDER BY PublishDate LIMIT $start_from, $posts_per_page";
       
        $result = exeDBList($Query); 
        
        $num_rows = mysqli_num_rows($result);

        $pages = ceil($num_rows / $posts_per_page);

        return $result;
    }

    function CountPages() {
        $Query = "SELECT COUNT(Title) FROM Blog";
        $result = exeDB($Query); 
        return ceil($result["COUNT(Title)"] / 3);
    }


    function RoleRequest($Email, $ID) {
        //Configuração
        include '../emailconfig.php';
                
        //Composição do email
        $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
        $mail->addAddress('isepacademy@gmail.com');
                    
        $mail->isHTML(true);
        $mail->Subject = "Pedido de cargo";
        $mail->Body  = '<h2> Foi pedido o cargo de professor para a conta com o <b>email -> '.$Email.'</b><br>
        <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
        href="https://isepacademy.fixstuff.net/Master/funcoes.php?Func=Upgrade&ID='.$ID.'">Aceitar</a>  <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
        href="https://isepacademy.fixstuff.net/Master/curriculos/curriculo'.$ID.'.pdf">Abrir curriculo</a></h2>'; 
        $mail->send();    
    }

    function newCourse($Course) {
        //Configuração
        include '../emailconfig.php';
                
        $Query="Select ID from Course where Name like '".$Course."'";
        $CourseID= exeDB($Query);

        //Composição do email
        $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
        $mail->addAddress('isepacademy@gmail.com');
                    
        $mail->isHTML(true);
        $mail->Subject = "Pedido de criação de curso";
        $mail->Body  = '<h2> Foi pedida a criação do <b>curso:<br> '.$Course.'</b><br>
        <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
        href="https://isepacademy.fixstuff.net/Master/funcoes.php?Func=Uprove&Course='.$Course.'">Aceitar</a>
        <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
        href="https://isepacademy.fixstuff.net/Master/curso.php?ID='.$CourseID["ID"].'">Visualizar</a></h2>'; 
        $mail->send();    
    }

    function SendCertificate($CourseID){
        //Configuração
        include '../emailconfig.php';
                
        $Query="Select Name, Category from Course where ID=".$CourseID;
        $temp= exeDB($Query);
        $Course = $temp["Name"];
        $Category= $temp["Category"];

        $Query="Select Name, Email from User where ID=".$_SESSION["UserID"];
        $temp= exeDB($Query);
        $User=$temp["Name"];
        $Email=$temp["Email"];

        //Composição do email
        $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
        $mail->addAddress($Email);
                    
        $mail->isHTML(true);
        $mail->Subject = "Certificado";
        $mail->Body  = '<h2> Foi emitido o certificado de do <b>curso: '.$Course.'</b><br>
        Clique para transferir o certificado
        <a style="display: inline-block; background-color: #444f5a; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;" 
        href="https://isepacademy.fixstuff.net/Master/certificado.php?Course='.$Course.'&User='.$User.'&Cat='.$Category.'">Download</a></h2>'; 
        $mail->send(); 
    }
?>