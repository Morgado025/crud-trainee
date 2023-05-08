<?php
include('valida.php');

include('nav.php');

include('config/conexao.php');
?>

<?php
$Error = "";
$Suc = ""; 

if(isset($_POST['form_submit'])) {
    $databertura = $_POST['databertura'];
    $notafiscal = $_POST['notafiscal'];
    $datacompra = $_POST['datacompra'];
    $aparencia = $_POST['aparencia'];
    $acessorios = $_POST['acessorios'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $numero_serie = $_POST['numero_serie'];
    $referencia = $_POST['referencia'];
    $descricao = $_POST['descricao'];
    $selectdefeito = $_POST['selectdefeito'];
    $produto = $_POST['produto'];
    $ativo = ($_POST['check'] == "t") ? 'true' : 'false';
    $tipo_atendimento = (int)$_POST['tipo_atendimento'];
    $select_tipoatendimento = $_POST['select_tipoatendimento'];
    $datafechamento = $_POST['datafechamento'];
    $datadigitacao = $_POST['datadigitacao'];
    $tipo_data = $_POST['data'];
    $databertura = $_POST['databertura'];
    $datacompra = $_POST['datacompra'];
    $data_inicio = $_POST['datainicio'];
    $data_fim = $_POST['datafim'];
    $fabrica = $_SESSION['fabrica'];
    
    $dataInicio = isset($_POST['datainicio']) ? DateTime::createFromFormat('d/m/Y', $_POST['datainicio']) : '';
    $dataInicio = $dataInicio instanceof DateTime ? $dataInicio->format('Y-m-d') : '';
    
    $dataFim = isset($_POST['datafim']) ? DateTime::createFromFormat('d/m/Y', $_POST['datafim']) : '';
    $dataFim = $dataFim instanceof DateTime ? $dataFim->format('Y-m-d') : '';
    
    $databertura = preg_replace('/[^0-9\/-]/', '', $databertura );
    $databertura  = str_replace('-', '', $databertura ); 
        if (!empty($_POST["databertura"])){
            $cond .= "and os.data_abertura = '$databertura'";
        }

    
    $datacompra = preg_replace('/[^0-9\/-]/', '', $datacompra );
    $datacompra  = str_replace('-', '', $datacompra ); 
        if (!empty($_POST["datadigitacao"])) {
            $cond .= "and os.data_compra = '$datacompra'";
        }

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (!empty($cpf)) {
        $cond .= "and os.cpf_cnpj = '$cpf'";
            } else if (!filter_var($cpf, FILTER_VALIDATE_INT)) {
    

        } if (!empty($_POST["numero_serie"])) {
            $cond .= "and os.numero_serie = '$numero_serie'";
        }
        
        if (!empty($_POST["referencia"])) {
            $cond .= "and produto.referencia = '$referencia'";

        }

        if (!empty($_POST["descricao"])) {
            $cond .= "and produto.descricao = '$descricao'";

        }
        if (isset($_POST['datainicio']) && isset($_POST['datafim']) && !empty($_POST['datainicio']) && !empty($_POST['datafim'])) {
            $dataInicio = $_POST['datainicio'];
            $dataFim = $_POST['datafim'];
            $tipo_data = $_POST['data']; 
            $cond = " AND os.$tipo_data BETWEEN '$dataInicio' AND '$dataFim'";
        } else {
            $Error = "Defina o período a ser pesquisado";
        }
        
        if ((strlen(trim($Error)) == 0)) {
            $sql = "SELECT os.*, produto.descricao, produto.referencia
                    FROM OS
                    JOIN produto ON os.produto = produto.produto
                    WHERE os.fabrica = '$fabrica'$cond";
        }
           
        $res = pg_query($con, $sql);
        
        if((strlen(pg_last_error($con)) >= 0) && (pg_num_rows($res) == 0 )) {
            $Error = "Nenhum Registro Encontrado!";
        } else {
            $Suc = "Dados Encontrados com Sucesso!";
        }
    }


if(isset($_POST['del'])) {
    $id = $_POST['id']; 
    $sql = "DELETE FROM os WHERE os = $id";
    $res = pg_query($con, $sql);
  
  }
        
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="cadastroos.css">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js">
    </script>

    <title>Offdout - Cadastro</title>
    <script>

        $(function () {
            Shadowbox.init();
            $(".abrir").click(function(){

                var referencia = $(".referencia").val(); 
                var descricao = $(".descricao").val(); 
              
                console.log("referencia", referencia, "descricao", descricao);

                Shadowbox.open({
                    content: "search.php?referencia=" + referencia + "&descricao=" + descricao,
                    player: "iframe",
                    title: "",
                    width: 1300,
                    height: 600
                });
            });
        });

        function retornaProduto(produto,referencia,descricao, ativo){
            console.log("chegou aqui " +produto)

            $(".produto").val(produto);
            $(".referencia").val(referencia);
            $(".descricao").val(descricao);           
        }

        function retornaOS(id,produto,referencia,descricao, ativo){
            console.log("chegou aqui " +produto)

            $(".id").val(id);
            $(".produto").val(produto);
            $(".referencia").val(referencia);
            $(".descricao").val(descricao);           
        }

    
        $(function () {
            Shadowbox.init();
            $(".abrir2").click(function(){

                var referencia = $(".referencia").val(); 
                var descricao = $(".descricao").val(); 
                var data_abertura = $(".databertura").val(); 
                var aparencia = $(".aparencia").val(); 
              
                console.log("referencia", referencia, "descricao", descricao);

                Shadowbox.open({
                    content: "pesquisaos.php?referencia=" + referencia + "&descricao=" + descricao,
                    player: "iframe",
                    title: "",
                    width: 1300,
                    height: 600
                });
            });
        });
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-horizontal" method="POST">
            <br>
            <div class="form-group">
                
                <center>
                    <h3> Pesquisa dos Cadastros de OS <h3>
                        <br>
                </center>
                <br>
                <div class="form-group form-group-inline ">
                    <label for="radioData" class="col-sm-2 control-label" id="datee"> Tipos de Datas:</label>
                      <br>
                    <div class="teste">
                    <div class="col-sm-2">
                        <div class="form-check">
                        <input type="radio" name="data" id="databertura" value="data_abertura" class="form-check-input" checked>
                        <label for="radioAbertura" class="form-check-label">Data de Abertura</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-check">
                        <input type="radio" name="data" id="datafechamento" value="data_fechamento" class="form-check-input" >
                        <label for="radioFechamento" class="form-check-label">Data de Fechamento</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-check">
                        <input type="radio" name="data" id="datadigitacao" value="data_digitacao" class="form-check-input">
                        <label for="radioDigitacao" class="form-check-label">Data de Digitação</label> 
                        </div>
                    </div>
                    </div>
                    </div>

                
                <div class="col-sm-10">
                <?php
                $data = $_POST['databertura'];

                if (!empty($data)) {
                    $data = explode("/", $data);
                    $anoTempo = explode(" ", $data[2]);
                    $ano = $anoTempo[0];
                    $tempo = $anoTempo[1];
                    $date_conv1 = $ano . "-" . $data[1] . "-" . $data[0] . " " . $tempo;
                }
                ?>
                    <!-- </div> -->
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Data de Início:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="datainicio" id="datainicio" placeholder="Data de Início" value="<?php echo isset($_POST['datainicio']) ? $_POST['datainicio'] : ''; ?>">
                    <script>
                        $(document).ready(function () {
                            $('#datainicio').inputmask('99/99/9999', { placeholder: '__/__/____' });
                        });
                    </script>
                    
                   
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Data de Fim:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="datafim" id="datafim" placeholder="Data de Fim" value="<?php echo isset($_POST['datafim']) ? $_POST['datafim'] : ''; ?>">
                    <script>
                        $(document).ready(function () {
                            $('#datafim').inputmask('99/99/9999', { placeholder: '__/__/____' });
                        });
                    </script>
                </div>
            </div>
            <br>
   
            <center>
                    <h3> Dados do Produto <h3>
                        <br>
                </center>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Número de série:</label>
                <div class="col-sm-10">
                    <input type="text" id="nms" class="form-control numero_serie" name="numero_serie" placeholder="Número de série" value="<?php echo isset($_POST['numero_serie']) ? $_POST['numero_serie'] : ''; ?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Referência:</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control referencia" id="esp" name="referencia" placeholder="Referência" value="<?= $referencia ?>" maxlength="50"> 
                        <span class="input-group-btn">
                            <button class="btn btn-default abrir" id="search1" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Descrição:</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control descricao" name="descricao" placeholder="Descrição" value="<?= $descricao ?>" maxlength="50">
                        <span class="input-group-btn">
                            <button class="btn btn-default abrir" id="search1" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control produto" name="produto" placeholder="Produto" value="<?php echo isset($_POST['produto']) ? $_POST['produto'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control id" name="id" placeholder="os" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" class="btn btn-default bot1" id="bot1">Pesquisar Dados de OS</button>
                </div>
            </div>
            <br>
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
            <br>
   <?php
   if(pg_num_rows($res) > 0){
   ?>
        <div class="table-responsive">
        <table class="table table-bordered table table-responsive">
        <thead>
            <tr>
               <th> Data de Abertura  </th>
               <th> Tipo Atendimento  </th>
               <th> Nota Fiscal  </th>
               <th> Data de Compra </th>
               <th> Aparência </th>
               <th> Acessórios </th>
               <th> Nome </th>
               <th> CPF </th>
               <th> CEP </th>
               <th> Estado </th>
               <th> Cidade </th>
               <th> Bairro  </th>
               <th> Endereço </th>
               <th> Número </th>
               <th> Telefone </th>
               <th> Complemento </th>
               <th> Celular </th>
               <th> Email </th>
               <th> Número de Série </th>
               <th> Referência </th>
               <th> Descrição </th>
               <th> Defeito </th>
               <th> Produto </th>
            </tr>
        </thead>
        <tbody>
            <?php

            for($i = 0; $i < pg_num_rows($res); $i++) {
                $databertura = pg_fetch_result($res, $i, 'data_abertura');
                $notafiscal = pg_fetch_result($res, $i, 'nota_fiscal');
                $datacompra = pg_fetch_result($res, $i, 'data_compra');
                $aparencia = pg_fetch_result($res, $i, 'aparencia');
                $acessorios = pg_fetch_result($res, $i, 'acessorio');
                $nome = pg_fetch_result($res, $i, 'nome_consumidor');
                $cpf =pg_fetch_result($res, $i, 'cpf_cnpj');
                $cep = pg_fetch_result($res, $i, 'cep_consumidor');
                $estado = pg_fetch_result($res, $i, 'estado_consumidor');
                $cidade = pg_fetch_result($res, $i, 'cidade_consumidor');
                $bairro = pg_fetch_result($res, $i, 'bairro_consumidor');
                $endereco = pg_fetch_result($res, $i, 'endereco_consumidor');
                $numero = pg_fetch_result($res, $i, 'numero_consumidor');
                $telefone = pg_fetch_result($res, $i, 'telefone_consumidor');
                $celular = pg_fetch_result($res, $i, 'celular_consumidor');
                $email = pg_fetch_result($res, $i, 'email_consumidor');    
                $produto = pg_fetch_result($res, $i, 'produto');            
                $numero_serie = pg_fetch_result($res, $i, 'numero_serie');
                $referencia = pg_fetch_result($res, $i, 'referencia');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $selectdefeito = pg_fetch_result($res, $i, 'defeito');
                $complemento = pg_fetch_result($res, $i, 'complemento');
                $produto = pg_fetch_result($res, $i, 'produto');
                $id = pg_fetch_result($res, $i, 'os');
                $tipo_atendimento = pg_fetch_result($res, $i, 'tipo_atendimento');
                $select_tipoatendimento = pg_fetch_result($res, $i, 'tipo_atendimento');

                
            ?>
         
            <tr>
                <td><?= $databertura = date('d/m/Y', strtotime($databertura)) ?></td>
                <td><?= $tipo_atendimento ?></td>
                <td><?= $notafiscal ?></td>
                <td><?= $datacompra = date('d/m/Y', strtotime($datacompra)) ?></td>
                <td><?= $aparencia ?></td>
                <td><?= $acessorios ?></td>
                <td><?= $nome ?></td>
                <td><?= $cpf ?></td>
                <td><?= $cep ?></td>
                <td><?= $estado ?></td>
                <td><?= $cidade ?></td>
                <td><?= $bairro?></td>
                <td><?= $endereco ?></td>
                <td><?= $numero ?></td>
                <td><?= $telefone ?></td>
                <td><?= $complemento ?></td>
                <td><?= $celular ?></td>
                <td><?= $email ?></td>
                <td><?= $numero_serie ?></td>
                <td><?= $referencia ?></td>
                <td><?= $descricao ?></td>
                <td><?= $selectdefeito ?></td>
                <td><?= $produto ?></td>

                <td><a type="submit" href="cadastroos.php?id=<?=$id?>" class="btn btn-default" id=btnn>Editar</a></td>
                <td><a type="submit" href="exportar_os.php" class="btn btn-default" id=bot6>Exportar</a></td>
                
                   <td> <button type="button" id="btnn2" onclick="retornaOS('<?= $id ?>', '<?= $produto ?>' ,'<?= $referencia ?>', '<?= $descricao ?>', '<?= $garantia ?>', '<?= $ativo ?>');" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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
                  
            </div>
        </form>
    </div>
</body>
</html>