<?php 
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

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

            case "Recpass":
                
                $Query="Select Count(Email) as ContMail from User where Email like '".$_POST["Email"]."'";
                $info = exeDB($Query);
                if($info["ContMail"]==0){
                    echo "ErroMail";
                }else{
                    require 'vendor/phpmailer/src/Exception.php';
                    require 'vendor/phpmailer/src/PHPMailer.php';
                    require 'vendor/phpmailer/src/SMTP.php';

                    //Configuração
                    $cod=rand(1,999999);
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->CharSet = "UTF-8";
                    //$mail->SMTPDebug = 4;
                    $mail->Host = 'vmcus31960.claranet.pt';
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Username = 'no_reply@IsepAcademy.fixstuff.net';
                    $mail->Password = '54%27qLvj';
                    $mail->Port = '465';
                    
                    //Composição do email
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
                $Query = "Update User SET Password=".$_POST["Pass"]." where ID=".$info["ID"];
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
                require 'vendor/phpmailer/src/Exception.php';
                require 'vendor/phpmailer/src/PHPMailer.php';
                require 'vendor/phpmailer/src/SMTP.php';

                //Configuração
                $cod=rand(1,999999);
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->CharSet = "UTF-8";
                //$mail->SMTPDebug = 4;
                $mail->Host = 'vmcus31960.claranet.pt';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Username = 'no_reply@IsepAcademy.fixstuff.net';
                $mail->Password = '54%27qLvj';
                $mail->Port = '465';
                
                //Composição do email
                $mail->setFrom('no_reply@IsepAcademy.fixstuff.net');
                $mail->addAddress('nunotmg@gmail.com');
                            
                $mail->isHTML(true);
                $mail->Subject = "Pedido de eliminação";
                $mail->Body  = "<h2> Foi pedida a eliminação do curso <b>ID -> ".$_POST["CourseID"]."</b></h2>"; 
                $mail->send();
                $Query="Update Course Set StartDate='0000-00-00', EndDate='0000-00-00' Where ID=".$_POST["CourseID"];
                $info = exeDB($Query);
                echo "ok";
        
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
?>