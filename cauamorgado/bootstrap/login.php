<?php
include "config/conexao.php";
?>

<?php
$Error = "";

if(isset($_POST['form_submit'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmarsenha = $_POST['confirmarsenha'];
    $fabrica = (int)$_POST['fabrica_key'];
        
        if (empty($_POST["nome"])) {
        $Error = "Nome é um Campo Obrigatório";
        }   
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_INT);
        if(filter_var($nome, FILTER_VALIDATE_INT)) {  
                $Error = "O Campo nome não aceita esse tipo de valor";
           } 
    
        if (empty($_POST["email"])) {
            $Error = "Email é um Campo Obrigatório";
        }
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $Error = "Email inválido";
                }
            
            if (empty($_POST["senha"])) {   
                $Error = "Senha é um Campo Obrigatório";
            }   
                elseif(strlen(trim($senha)) <= 6){
                    $Error = "A senha deve ter, no mínimo, 6 caracteres.";
                }   
                elseif (empty($_POST["confirmarsenha"])) {
                    $Error = "Confirmar senha é um Campo Obrigatório";
                }
                elseif($senha != $confirmarsenha){
                    $Error = "As senhas não são iguais";
                }      
                
            if(strlen(trim($Error))==0){
                $sql = "INSERT INTO usuario(nome, email, senha, fabrica) VALUES ('$nome', '$email', '$senha', '$fabrica')";
                $res = pg_query($con, $sql);
                if(strlen(pg_last_error($con)) > 0){
                    $Error = "Falha ao cadastrar";
                }
                else{
                    $Suc = "Usuário Cadastrado com Sucesso!";
                }
            
            }
        }
?> 

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Login - Criar</title>
</head>
<body>
    <div class="container">
        <header class="inicio">
            <h1> Sistema de Registro <h1>
            <h3> Crie seu Login! <h3>
        </header>
        <main class="principal">
        <div class="panel-body"> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="POST">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nome:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome" placeholder="Nome">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Senha:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="senha" placeholder="Senha">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Confirmar Senha:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="confirmarsenha" placeholder="Confirme sua senha">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo isset($_POST['fabrica_key']) ? $_POST['fabrica_key'] : ''; ?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="fabrica_key" class="col-sm-2 control-label">Fábrica:</label>
                <div class="col-sm-10">
                <select class="form-control" id="fabrica_key" name="fabrica_key">
                        <option value=''>Selecione a Fábrica</option>
                        <?php
                        $sql = "SELECT * FROM fabrica";

                        $res = pg_query($con, $sql);

                        for($i = 0; $i < pg_num_rows($res); $i++) {
                            $nome = pg_fetch_result($res, $i, 'nome');
                            $key = pg_fetch_result($res, $i, 'fabrica');
                           
                            echo "<option value='$key'";
                            if (isset($_GET['id']) && $tipo_atendimento == $select_tipoatendimento) {
                                echo " selected";
                            }
                            echo ">$nome - $key </option>";
                            $teste = $_POST['tipo_atendimento2'];
                        }                       
                        ?>
                    </select>

                    </div>
                </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" class="btn btn-default">Criar sua conta</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a type="submit" href="index.php" class="btn btn-default" id=bot>Voltar</a>
                </div>
                <div class="panel-footer" id="mud">
                    <?php 
                        if(isset($_POST['form_submit'])){
                    ?>
                    <i id ="alert" class="glyphicon glyphicon-warning-sign"> </i> 
                    <?php 
                    if(strlen(trim($Error))==0){
                        echo $Suc;
                    }else{
                        echo $Error;
                    }
                    ?> 
                    <?php   
                        }
                    ?>  
                </div>      
            </div>
        </form>
            <footer class="rodape">
                Morgado & Offdout <?= date('Y'); ?>
            </footer>
    </div>
</body>
</html>