<?php
include('valida.php');
?>

<?php
include('nav.php');
?>

<?php
$Error = "";

if ($_POST['form_submit'] == 'Enviar') {

    $Error = "";

    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao']; 
    $defeito = (int)$_POST['defeito'];  
    $fabrica = $_SESSION['fabrica'];

        if (empty($_POST["codigo"])) {
            $Error = "Código é um Campo Obrigatório";
        } $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($_POST["descricao"])) {
            $Error = "Descrição é um Campo Obrigatório";
        }$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

      if((strlen(trim($Error))==0) && ($defeito == 0)){
        $sql_insert = "INSERT INTO defeito(codigo, descricao, fabrica) values ('$codigo', '$descricao', '$fabrica')";
        $res = pg_query($con, $sql_insert);
        if(strlen(pg_last_error($con))>0){
            $Error = "Falha ao cadastrar dados";
        }else{
            $Suc = "Dados Cadastrados com Sucesso!";
            $codigo = "";
            $descricao = "";
        }

    }else{
        $sql_insert = "UPDATE defeito SET codigo = '$codigo', descricao ='$descricao' WHERE defeito = $defeito";
        $Suc = "Dados atualizados com Sucesso!";    
        $codigo = "";
        $descricao = "";
        $res_insert = pg_query($con, $sql_insert);      
        unset($_POST['defeito']);
    }      
       
        
}

    if(isset($_POST['del'])){

        $defeito_id = $_POST['defeito'];
        $sql_delete = "DELETE FROM defeito WHERE defeito = $defeito_id";
        $res_delete = pg_query($con, $sql_delete);
        unset($_POST['defeito']);
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="menu.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Offdout - Cadastro</title>
    <script>
        
        function retornadefeito(defeito, codigo, descricao){
            console.log("chegou aqui " +defeito)

            $(".defeito").val(defeito);
            $(".codigo").val(codigo);
            $(".descricao").val(descricao);
        }

    </script>
</head>
<body>
    <div class="container">
        <main class="principal">
            <style>
                .form-horizontal{
                margin-top: 100px;
                } 
            .principal{
                height: 100%;
                margin-top:26px;
            }
            </style>
        <div class="panel-body"> 
        <form action="defeito.php" class="form-horizontal" method="POST">
            <br>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Código:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control codigo" id="codigo" name="codigo" placeholder="Código" maxlength="10">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label ">Descrição:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control descricao" id="descricao" name="descricao" placeholder="Descrição" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" id="bot3" value ="Enviar" class="btn btn-default">Registrar dados</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control defeito" name="defeito" placeholder="defeito" value="<?php echo isset($_POST['defeito']) ? $_POST['defeito'] : ''; ?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <br>
        <div class=table>
            <center>
                    <h3> Defeitos Cadastrados <h3>
                        <br>
            </center>
        <?php
            $fabrica = $_SESSION['fabrica'];
            $sql = "SELECT * FROM defeito where fabrica = '$fabrica'";
            $res = pg_query($con, $sql);
            if (pg_num_rows($res) == 0) {
                echo '<div class="alert alert-danger" role="alert">Nenhum Registro encontrado!</div>';
            } else {
        ?>

        <table class="table table-bordered table">
        <thead>
            <tr>
                <th>Descrição</th>            
                <th>Código</th>
                <th>Edição</th>
                <th>Export</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $defeito = pg_fetch_result($res, $i, 'defeito');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $codigo = pg_fetch_result($res, $i, 'codigo');
    
            ?>
            <tr>
                <td><a id="table" href="#" onclick="retornadefeito('<?= $defeito ?>', '<?= $codigo ?>', '<?= $descricao ?>');"><?= $descricao ?></a></td>
                <td><?= $codigo ?></td>
                <td><button type="button" id="btnn" onclick="retornadefeito('<?= $defeito ?>', '<?= $codigo ?>', '<?= $descricao ?>');" class="btn btn-default">Editar</button></td>
                <td><a type="submit" href="exportar_defeito.php" class="btn btn-default">Exportar</a></td>
                <td> <button type="button" id="btnn2" onclick="retornadefeito('<?= $defeito ?>', '<?= $codigo ?>', '<?= $descricao ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Excluir
                </button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="myModalLabel">Tem certeza da exclusão desse item? </h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        <button type="submit" name="del" id="btnn3" class="btn btn-primary">Sim</button>
                    </div>
                    </div>
                </div>
                </div></td>
            </tr>
            <?php } ?>
        </tbody>
        <?php } ?>
        </table>
        </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a type="submit" href="menu.php" class="btn btn-default" id=bot>Voltar</a>
                </div>
                <div class="panel-footer" id="mud">
            <?php if(isset($_POST['form_submit'])): ?>
                <?php if(strlen(trim($Error)) == 0): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $Suc; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $Error; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>
                </div>    
            </div>
        </form>
    </div>
</body>
</html>