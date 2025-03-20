<?php 
if(isset($POST_["email"])){
    include 'conexao.php';
    $email = $_POST["email"];
	$pass = $_POST["pass"];
	
    $Sel="Select ID, Email, Password, Role from User where Email like '$email'";
	$exe = mysqli_query($conexao, $Sel);
    $row = mysqli_fetch_assoc($exe);
    if($row["Password"]==$_POST["pass"]){
        $_SESSION["UserID"]=$row["ID"];
        $_SESSION["Role"]=$row["Role"];

    }
    else{
        echo "Erro";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>