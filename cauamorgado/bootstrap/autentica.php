<?php
session_start();

$Error = "";

if(isset($_POST['usuario']) && isset($_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    if (empty($_POST["senha"])) {
        $Error = "Senha é um Campo Obrigatório";
    }  

    elseif(strlen(trim($senha)) <= 6){
        $Error = "Login Inválido";
    }   

    if (empty($_POST["usuario"])) {
        $Error = "Email é um Campo Obrigatório";
    }   

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $Error = "Login Inválido";
    }

    if(strlen(trim($Error))==0){
        $sql = "SELECT fabrica FROM usuario WHERE email = '$usuario' and senha = '$senha'"; 
        $res = pg_query($con, $sql);

        if(pg_num_rows($res) == 1){
            $fabrica = pg_fetch_result($res, 0, 'fabrica');
            $_SESSION['logado'] = true;
            $_SESSION['fabrica'] = $fabrica;
            header("location:menu.php");
            exit();
        }else{
            $Error = "Login Inválido";
        }
    }
}
