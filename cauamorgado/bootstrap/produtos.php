<?php
include('valida.php');

include('nav.php');

include('conexao.php');
?>

<?php

if ($_POST['form_submit'] == 'Enviar') {
    
    $Error = "";
    $Suc = "";
    $referencia = $_POST["referencia"];
    $descricao = $_POST["descricao"];
    $garantia = $_POST["garantia"];
    $ativo = (int)($_POST['check'] == "t") ? 'true' : 'false';
    $produto = (int)$_POST["produto"];
    $alertClass = strlen(trim($Error)) == 0 ? 'alert-success' : 'alert-warning';
    $fabrica = $_SESSION['fabrica'];
    
        if (empty($_POST["referencia"])) {
            $Error = "Referência é um Campo Obrigatório";
        }$referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($_POST["descricao"])) {
            $Error = "Descrição é um Campo Obrigatório";
        }$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($_POST["garantia"])) {
            $Error = "Tempo de Garantia é um Campo Obrigatório";
        }

        if((strlen(trim($Error))==0) && ($produto == 0)){
            $sql_insert = "INSERT INTO produto(referencia, descricao, garantia, ativo, fabrica) values ('$referencia', '$descricao', '$garantia', $ativo, '$fabrica')";
            $res = pg_query($con, $sql_insert);
            if(strlen(pg_last_error($con))>0){
                $Error = "Falha ao Encontrar dados!";
            } else {
                $Suc = "Dados Encontrados com Sucesso!";
                $referencia = "";
                $descricao = "";
                $garantia = "";
                $ativo = "";
            }

        } else {
            $sql_insert = "UPDATE produto SET referencia = '$referencia', descricao ='$descricao', garantia = '$garantia', ativo =$ativo WHERE produto = $produto";
            $Suc = "Dados atualizados com Sucesso!";
            $referencia = "";
            $descricao = "";
            $garantia = "";
            $ativo = "";
            unset($_POST['produto']);
            $res_insert = pg_query($con, $sql_insert);
        }
    }

    if (isset($_POST['del'])) {
        $produto_id = $_POST['produto'];
        $sql_delete = "DELETE FROM produto WHERE produto = $produto_id";
        $res_delete = pg_query($con, $sql_delete);
        unset($_POST['produto']);
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

        
        function retornaProduto(produto, referencia, descricao, garantia, ativo){
            console.log("chegou aqui " +produto)

            $(".produto").val(produto);
            $(".referencia").val(referencia);
            $(".descricao").val(descricao);
            $(".garantia").val(garantia);
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
        <form action="produtos.php" class="form-horizontal" method="POST"><br>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label referencia">Referência:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control referencia"  id="produto" name="referencia" placeholder="Referência" maxlength="10" value="<?=$referencia?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Descrição:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control descricao" id="descricao" name="descricao" placeholder="Descrição" maxlength="50" value="<?=$descricao?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Tempo de Garantia: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control garantia" id="garantia" name="garantia" placeholder="Tempo em meses" value="<?=$garantia?>">
                </div>
            </div>
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
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" id="bot3" class="btn btn-default" value="Enviar">Registrar dados</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control produto" name="produto" placeholder="Produto" value="<?php echo isset($_POST['produto']) ? $_POST['produto'] : ''; ?>">
                </div>
            </div>
            <br>
        <div class=table>
            <center>
                    <h3> Produtos Cadastrados <h3>
                        <br>
            </center>
        <?php
            $fabrica = $_SESSION['fabrica'];
            $sql = "SELECT * FROM produto where fabrica = $fabrica";
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
                <th>Garantia</th>
                <th>Status</th>
                <th>Edição</th>
                <th>Export</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $produto = pg_fetch_result($res, $i, 'produto');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $referencia = pg_fetch_result($res, $i, 'referencia');
                $garantia = pg_fetch_result($res, $i, 'garantia');
                $ativo = pg_fetch_result($res, $i, 'ativo');  
                
                if ($ativo == "f"){
                    $ativo = "Inativo";
                }else{
                    $ativo = "Ativo";
                }   
        
            ?>
            <tr>
                <td><a id="table" href="#" onclick="retornaProduto('<?= $produto ?>', '<?= $referencia ?>', '<?= $descricao ?>', '<?= $garantia ?>', '<?= $ativo ?>');">
                    <?= $descricao ?>
                </a></td>
                <td><?= $referencia ?></td>
                <td><?= $garantia ?></td>
                <td><?= $ativo ?></td>
                <td><button type="button" id="btnn" onclick="retornaProduto('<?= $produto ?>', '<?= $referencia ?>', '<?= $descricao ?>', '<?= $garantia ?>', '<?= $ativo ?>');" class="btn btn-default">Editar</button></td>
                <td><a type="submit" href="export-php/exportar_produto.php" class="btn btn-default">Exportar</a></td>
                <td> <button type="button" id="btnn2" onclick="retornaProduto('<?= $produto ?>', '<?= $referencia ?>', '<?= $descricao ?>', '<?= $garantia ?>', '<?= $ativo ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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