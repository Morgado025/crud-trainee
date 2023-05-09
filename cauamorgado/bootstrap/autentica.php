<?php
session_start();
include "config/conexao.php";

$Error = "";

if(isset($_POST['usuario']) && isset($_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    if (empty($senha)) {
        $Error = "Senha é um Campo Obrigatório";
    }  

    elseif(strlen(trim($senha)) <= 6){
        $Error = "Login Inválido";
    }   

    if (empty($usuario)) {
        $Error = "Usuário é um Campo Obrigatório";
    }   

    $usuario = pg_escape_string($con, $usuario);
    $senha = pg_escape_string($con, $senha);
    $sql = "SELECT * FROM usuario WHERE email = '$usuario' and senha = '$senha'"; 
    $res = pg_query($con, $sql);
        
    if(pg_num_rows($res) == 1){
        $row = pg_fetch_assoc($res);
        $_SESSION['logado'] = true;
        $_SESSION['fabrica'] = $row['fabrica'];
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['usuario'] = $row['usuario'];
          
        header("location:menu.php");
        exit();
    }else{
        $Error = "Login Inválido";
    }
}
