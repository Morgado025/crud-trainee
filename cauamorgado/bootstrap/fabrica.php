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

    $nome = $_POST['fabrica_name'];
    $fabrica = (int)$_POST['fabrica_key'];
    
   
      if((strlen(($Error))==0) && ($fabrica == 0)){
        $sql_insert = "INSERT INTO fabrica(nome) values ('$nome')";
        $res = pg_query($con, $sql_insert);
        if(strlen(pg_last_error($con))>0){
            $Error = "Falha ao cadastrar dados";
        }else{
            $Suc = "Dados Cadastrados com Sucesso!";
            $nome = "";
        }

    }else{
        $sql_insert = "UPDATE fabrica SET nome = '$nome' WHERE fabrica = $fabrica";
        $Suc = "Dados atualizados com Sucesso!";    
        $nome = "";
        $res_insert = pg_query($con, $sql_insert);     
        unset($_POST['fabrica_key']);
    }      
         
        
}

    if(isset($_POST['del'])){
        $fabrica = (int)$_POST['fabrica_key'];
        $sql_delete = "DELETE FROM fabrica WHERE fabrica = $fabrica";
        $res_delete = pg_query($con, $sql_delete);
        unset($_POST['fabrica_key']);
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="css/menu.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Offdout - Cadastro</title>
    <script>
        
        function retornafabrica(nome, key){
            console.log("chegou aqui " +key)

            $(".fabrica_name").val(nome);
            $(".fabrica_key").val(key);
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
        <form action="fabrica.php" class="form-horizontal" method="POST">
            <br>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nome:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control fabrica_name" id="fabrica_name" name="fabrica_name" placeholder="Nome" maxlength="50">
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
                    <button type="submit" name="form_submit" id="bot3" value ="Enviar" class="btn btn-default">Registrar dados</button>
                </div>
            </div>
            <br>
        <div class=table>
            <center>
                    <h3> Fábricas Cadastradas <h3>
                        <br>
            </center>
        <?php
            
            $sql = "SELECT * FROM fabrica";
            $res = pg_query($con, $sql);
            if (pg_num_rows($res) == 0) {
                echo '<div class="alert alert-danger" role="alert">Nenhum Registro encontrado!</div>';
            } else {
        ?>

        <table class="table table-bordered table teste">
        <thead>
            <tr>
                <th>Nome</th>            
                <th>Edição</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $nome = pg_fetch_result($res, $i, 'nome');
                $key = pg_fetch_result($res, $i, 'fabrica');
    
            ?>
            <tr>
                <td><a id="table" href="#" onclick="retornafabrica('<?= $nome ?>', '<?= $key ?>');"><?= $nome ?></a></td>
                <td><button type="button" id="btnn" onclick="retornafabrica('<?= $nome ?>', '<?= $key ?>');"class="btn btn-default">Editar</button></td>
                <td> <button type="button" id="btnn2" onclick="retornafabrica('<?= $nome ?>', '<?= $key ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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