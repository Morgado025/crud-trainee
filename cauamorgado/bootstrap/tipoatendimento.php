<?php
include('valida.php');

include('nav.php');

include ('config/conexao.php');
?>

<?php


if ($_POST['form_submit'] == 'Enviar') {

    $Error = "";

    $codido = $_POST['codido'];
    $descricao = $_POST['descricao']; 
    $tipo_atendimento = (int)$_POST['tipo_atendimento'];  
    $ativo = (int)($_POST['check'] == "t") ? 'true' : 'false';
    $fabrica = $_SESSION['fabrica'];

        if (empty($_POST["codido"])) {
            $Error = "Código é um Campo Obrigatório";
        }   $codido = filter_input(INPUT_POST, 'codido', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($_POST["descricao"])) {
            $Error = "Descrição é um Campo Obrigatório";
        }   $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

        
       if((strlen(trim($Error))==0) && ($tipo_atendimento == 0)){
        $sql_insert = "INSERT INTO tipo_atendimento(codido, descricao, ativo, fabrica) values ('$codido', '$descricao', '$ativo', '$fabrica')";
        $res = pg_query($con, $sql_insert_);
        if(strlen(pg_last_error($con))>0){
            $Error = "Falha ao cadastrar dados";
        }else{
            $Suc = "Dados Cadastrados com Sucesso!";
            $codido = "";
            $descricao = "";
            $ativo ="";
        }

    }else{
        $sql_insert = "UPDATE tipo_atendimento SET codido = '$codido', descricao ='$descricao', ativo =$ativo WHERE tipo_atendimento = $tipo_atendimento";
        $Suc = "Dados atualizados com Sucesso!";    
        $codido = "";
        $descricao = "";
        $ativo = "";
        unset($_POST['tipo_atendimento']);
    }      
        $res_insert = pg_query($con, $sql_insert);      
        
}

if(isset($_POST['del'])){

    $tipo_atendimento_id = $_POST['tipo_atendimento'];

    $sql_delete = "DELETE FROM tipo_atendimento WHERE tipo_atendimento = $tipo_atendimento_id";
    $res_delete = pg_query($con, $sql_delete);
    unset($_POST['tipo_atendimento']);
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
        
        function retornatipo_atendimento(tipo_atendimento, codido, descricao, ativo){
            console.log("chegou aqui " +tipo_atendimento)

            $(".tipo_atendimento").val(tipo_atendimento);
            $(".codido").val(codido);
            $(".descricao").val(descricao);
            if (ativo === "Ativo") {
                $(".ativo").prop("checked", true);
            } else {
                $(".ativo").prop("checked", false);
            }
    
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
        <form action ="tipoatendimento.php" class="form-horizontal" method="POST">
            <br>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Código:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control codido" id="codido" name="codido" placeholder="Código" maxlength="10">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Descrição:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control descricao" id="descricao" name="descricao" placeholder="Descrição" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input name="check" class="ativo" id="ativo" type="checkbox" value="t"> Ativo
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" id="bot3" class="btn btn-default" value="Enviar" >Registrar dados</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control tipo_atendimento" name="tipo_atendimento" placeholder="tipo_atendimento" value="<?php echo isset($_POST['tipo_atendimento']) ? $_POST['tipo_atendimento'] : ''; ?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value=""<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <br>
        <div class=table>
            <center>
                    <h3> Tipos de Atendimentos Cadastrados <h3>
                        <br>
            </center>
        <?php
            $fabrica = $_SESSION['fabrica'];
            $sql = "SELECT * FROM tipo_atendimento where fabrica = $fabrica";
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
                <th>Status</th>
                <th>Edição</th>
                <th>Export</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $tipo_atendimento = pg_fetch_result($res, $i, 'tipo_atendimento');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $codido = pg_fetch_result($res, $i, 'codido');
                $ativo = pg_fetch_result($res, $i, 'ativo');  
                
                if ($ativo == "f"){
                    $ativo = "Inativo";
                }else{
                    $ativo = "Ativo";
                }   
        
    
            ?>
            <tr>
                <td><a id="table" href="#" onclick="retornatipo_atendimento('<?= $tipo_atendimento ?>', '<?= $codido ?>', '<?= $descricao ?>' , '<?= $ativo ?>');">
                <?= $descricao ?> 
                </a></td>
                <td><?= $codido ?></td>
                <td><?= $ativo ?></td>
                <td><button type="button" id="btnn" onclick="retornatipo_atendimento('<?= $tipo_atendimento ?>', '<?= $codido ?>', '<?= $descricao ?>', '<?= $ativo ?>');" class="btn btn-default">Editar</button></td>
                <td>  <a type="submit" href="export-php/exportar_tipoatendimento.php" class="btn btn-default">Exportar</a></td>
                <td> <button type="button" id="btnn2" onclick="retornatipo_atendimento('<?= $tipo_atendimento ?>', '<?= $codido ?>', '<?= $descricao ?>' , '<?= $ativo ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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