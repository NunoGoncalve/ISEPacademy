<?php 
    function exeDB($Query)  {
        include 'conexao.php';
        $exe = mysqli_query($conexao, $Query);
        if(!is_bool($exe)){
            $row = mysqli_fetch_assoc($exe);
            return $row;
        }
    }

    if(isset($_POST["Func"])){
        Switch ($_POST["Func"]){
            case "login":
                $email = $_POST["email"];
                $pass = $_POST["pass"];
                
                $Sel="Select ID, Email, Password, Role from User where Email like '$email'";
                $info = exeDB($Sel);
                if($info["Password"]==$_POST["pass"]){
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];
            
                }
                else{
                    echo "Erro";
                }
            break;
            case "register":
                $nome = $_POST["nome"]; 
                $email = $_POST["email"];
                $pass = $_POST["pass"];
                $role = $_POST["role"];
                
                $Sel="Select Count(Email) as ContMail from User where Email like '$email'";
                $info = exeDB($Sel);
                if($row["ContMail"]==0){
                    $Sel="Insert INTO User (Name, Email, Password, Role) values ('$nome', '$email', '$pass', '$role')";
                    $exe = mysqli_query($conexao, $Sel);
                    echo "ok";
                }
                else{
                    echo "Erro2";
                }
               
                break;
            case "favourite":
                    if($_POST["Flag"]){
                        $Query = "Insert into Interaction (Favourite, UserID, CourseID) VALUES (".$_POST["Fav"].",".$_POST["UserID"].",".$_POST["CourseID"].")";
                    }else{
                        $Query = "Update Interaction SET Favourite=".$_POST["Fav"]." where UserID=".$_POST["UserID"]." AND CourseID=".$_POST["CourseID"];
                    }
                    
                    $info = exeDB($Query);
                    echo "ok";
            break;
    
            case "subscribe":
                if($_POST["Flag"]){
                    $Query = "Insert into Interaction (Status, UserID, CourseID) VALUES (1,".$_POST["UserID"].",".$_POST["CourseID"].")";
                }else{
                    $Query = "Update Interaction SET Status=1 where UserID=".$_POST["UserID"]." AND CourseID=".$_POST["UserID"];
                }
                $info = exeDB($Query);
                echo "ok";
            break;
        }
    }
    
?>