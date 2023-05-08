<?php
include('valida.php');

include('nav.php');

include ('config/conexao.php');
?>

<?php
$titulo = "Peças Cadastradas";
if ($_POST['form_submit'] == 'Enviar') {

    $Error = "";

    $referencia = $_POST['referencia'];
    $descricao = $_POST['descricao'];
    $peca = (int)$_POST['peca'];
    $fabrica = $_SESSION['fabrica'];

        if (empty($_POST["referencia"])) {
            $Error = "Referência é um Campo Obrigatório";
        }   $referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_SPECIAL_CHARS);

    
        if (empty($_POST["descricao"])) {
            $Error = "Descrição é um Campo Obrigatório";
        }   $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

        if((strlen(trim($Error))==0) && ($peca == 0)){
            $sql_insert = "INSERT INTO peca(referencia, descricao, fabrica) values ('$referencia', '$descricao', '$fabrica')";
            $res = pg_query($con, $sql_insert_);
            if(strlen(pg_last_error($con))>0){
                $Error = "Falha ao cadastrar dados";
            }else{
                $Suc = "Dados Cadastrados com Sucesso!";
                $referencia = "";
                $descricao = "";
            }
        }else{
        $sql_insert = "UPDATE peca SET referencia = '$referencia', descricao ='$descricao' WHERE peca = $peca";
        $Suc = "Dados atualizados com Sucesso!";  
        $referencia = "";
        $descricao = "";
        unset($_POST['peca']);   
    }      
    $res_insert = pg_query($con, $sql_insert); 
       
}

if (isset($_POST['del'])) {
    $peca_id = $_POST['peca'];
    $sql_delete = "DELETE FROM peca WHERE peca = $peca_id";
    $res_delete = pg_query($con, $sql_delete);
    unset($_POST['peca']);

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
        
        function retornaPeca(peca, referencia, descricao){
            console.log("chegou aqui " +peca)

            $(".peca").val(peca);
            $(".referencia").val(referencia);
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
        <form action="peça.php" class="form-horizontal" method="POST">
            <br>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Referência:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control referencia" id="referencia" name="referencia" placeholder="Referência" maxlength="10">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Descrição:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control descricao"  id="descricao" name="descricao" placeholder="Descrição" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" id="bot3" name="form_submit" value ="Enviar" class="btn btn-default">Registrar dados</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control peca" name="peca" placeholder="Peça" value="<?php echo isset($_POST['peca']) ? $_POST['peca'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <br>
        <div class=table>
            <center>
                    <h3> <?php echo $titulo ?> <h3>
                        <br>
            </center>
        <?php
            $fabrica = $_SESSION['fabrica'];
            $sql = "SELECT * FROM peca where fabrica = $fabrica";
            $res = pg_query($con, $sql);
            if (pg_num_rows($res) == 0) {
                echo '<div class="alert alert-danger" role="alert">Nenhum Registro encontrado!</div>';
            } else {
        ?>

        <table class="table table-bordered table">
        <thead>
            <tr>
                <th>Descrição</th>            
                <th>Referência</th>
                <th>Edição</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $peca = pg_fetch_result($res, $i, 'peca');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $referencia = pg_fetch_result($res, $i, 'referencia');
            ?>
            <tr>
                <td><a id="table" href="#" onclick="retornaPeca('<?= $peca ?>', '<?= $referencia ?>', '<?= $descricao ?>');">
                    <?= $descricao ?>
                </a></td>
                <td><?= $referencia ?></td>
                <td><button type="button" id="btnn" onclick="retornaPeca('<?= $peca ?>', '<?= $referencia ?>', '<?= $descricao ?>');" class="btn btn-default">Editar</button></td>
                <td> <button type="button" id="btnn2" onclick="retornaPeca('<?= $peca ?>', '<?= $referencia ?>', '<?= $descricao ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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
                    <a type="submit" href="exportar_peca.php" class="btn btn-default" id=bot6>Exportar</a>
                </div>
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