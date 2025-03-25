<?php 
    session_start();

    if(isset($_POST["Func"])){
        
        Switch ($_POST["Func"]){

            case "login":
                $Email = $_POST["Email"];
                $Pass = $_POST["Pass"];
                
                $Query="Select ID, Email, Password, Role from User where Email like '$Email'";
                $info = exeDB($Query);

                if($info["Password"]==$Pass){
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];
                    echo "ok";
                }
                else{
                    echo "Erro";
                }
            break;
            case "register":
                $Name = $_POST["Name"]; 
                $Email = $_POST["Email"];
                $Pass = $_POST["Pass"];
                //$role = $_POST["role"];
                
                $Query="Select Count(Email) as ContMail from User where Email like '$Email'";
                $info = exeDB($Query);
                if($info["ContMail"]==0){
                    $Query="Insert INTO User (Name, Email, Password, RegisterDate) values ('".$Name."', '".$Email."', '".$Pass."', '".date("Y-m-d")."')";
                    exeDB($Query);
                    $Query="Select ID, Role from User where Email like '$Email'";
                    $info=exeDB($Query);
                    $_SESSION["UserID"]=$info["ID"];
                    $_SESSION["Role"]=$info["Role"];
                    echo "ok";
                }
                else{
                    echo "Erro2";
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