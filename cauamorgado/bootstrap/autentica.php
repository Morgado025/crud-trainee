<?php
session_start();

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
        
        $sql = "SELECT * FROM usuario WHERE email = '$usuario' and senha = '$senha' "; 
        $res = pg_query ($con, $sql);

        if(pg_num_rows($res) == 1){
            $_SESSION['logado'] = true;
            header ("location:menu.php");
        }else{
            $Error = "Login Inválido";
        }
    }
}
    
    // #realizando a autenticação:
    // if($usuario == 'offdout@gmail.com' && $senha == '12345'){
    //     $_SESSION['logado'] = true;

    //     #redirecionar o usuário para tela que precisa estar logado;
    //     header("location: menu.php");
    //     exit;

    // }else {
    //    header("location:index.php?msg=erro_login");
    // }



?>

