<?php 
if(isset($POST_["nome"])){
    include 'conexao.php';
    $nome = $_POST["nome"]; 
    $email = $_POST["email"];
	$pass = $_POST["pass"];
	$role = $_POST["role"];
	

    $Sel="Select Count(Email) from User where Email like '$email'";
	$exe = mysqli_query($conexao, $Sel);
    $row = mysqli_fetch_assoc($exe);
    if($row["Count(Email)"]==0){
        $Sel="Insert INTO User (Name, Email, Password, Role) values ('$nome', '$email', '$pass', '$role')";
        $exe = mysqli_query($conexao, $Sel);
        echo "ok";
    }
    else{
        echo "Erro2";
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