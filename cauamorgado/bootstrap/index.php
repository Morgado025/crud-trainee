<?php
include "config/conexao.php";

include "autentica.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>offdout - Acesso </title>
</head>
<body>
    <div class="container">
        <header class="inicio">
            <h1> Sistema Offdout <h1>
            <h3> Acesso restrito ao cliente <h3>
        </header>
        <main class="principal">
        <div class="panel-body"> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal">
            <div class="form-group">
                <label type="email" for="inputEmail3" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-10">
                    <span class="input-group-addon">
                        <i id="teste" class="glyphicon glyphicon-user"> </i>
                    </span>
                    <input name="usuario" type="text" class="form-control" id="inputEmail3" placeholder="Email" maxlength="50">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Senha:</label>
                <div class="col-sm-10">
                    <span class="input-group-addon">
                        <i id="teste" class="glyphicon glyphicon-lock"> </i>
                    </span>
                    <input name="senha" type="password" class="form-control" id="inputPassword3" placeholder="Password" maxlength="50">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input name="check" type="checkbox"> Manter conectado
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo isset($_POST['fabrica_key']) ? $_POST['fabrica_key'] : ''; ?>">
                </div>
            </div>
            <br>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="form_submit" class="btn btn-default">Entrar</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <a type="submit" href="login.php" class="btn btn-default" id=bot>Criar Conta</a>
        </div>
            <div class="panel-footer" id="mud">
            <?php 
                    if(isset($_POST['form_submit'])){
                    ?>
                    <i id ="alert" class="glyphicon glyphicon-warning-sign"> </i> <?php echo $Error;?> 
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
