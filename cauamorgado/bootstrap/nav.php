<?php
include "config/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="nav.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="css/shadowbox.css" >
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="js/shadowbox.js"></script>
    <link rel="stylesheet" href="js/bootstrap.min.js">
    <title>Offdout -Home</title>
</head>
<body>
    <div class="container">
        <header class = "inicio">
            <h1>Offdout - Sistema de Gestão</h1>
            <h3>Gerenciamento de Cadastros</h3>
        </header>
        <div class="collapse navbar-collapse" id="menu-crud">
                <ul class="nav navbar-nav navbar-right">
                    <a type="submit" href="logout.php" id ="exit" class="glyphicon glyphicon-log-out">  </a> <?php echo $_SESSION['usuario']; ?>  
                </ul>
        </div>
        <main class="principal">
            <div class="conteudo col-md-12">
                <nav id="navvv" class="navbar navbar-expand-md navbar-light bg-light">
                    <ul>
                        <a id="produtos" class="navbar-brand" href="produtos.php">Produtos</a>
                    </ul>
                    <ul>
                        <a id="peça" class="navbar-brand" href="peça.php">Peças</a>
                    </ul>
                    <ul>
                        <a id="tipoatendimento" class="navbar-brand" href="tipoatendimento.php">Tipo de Atendimento</a>
                    </ul>
                    <ul>
                        <a id="defeito" class="navbar-brand" href="defeito.php">Defeito</a>
                    </ul>
                    <ul>
                        <a id="cadastroos" class="navbar-brand" href="cadastroos.php">Cadastro de OS</a>
                    </ul>
                    <ul>
                        <a id="contatos" class="navbar-brand" href="pesquisaos.php">Pesquisa de OS</a>
                    </ul>
                     <ul>
                        <a id="search" class="glyphicon glyphicon-search" href="search.php"></a>
                    </ul>
            </div>
                </nav>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
    </div>
    </main>
</body>
</html>
