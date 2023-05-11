<?php
include('autentica.php');

include('nav.php');

include('config/conexao.php');
?>

<?php

$Error = "";

if(isset($_POST['form_submit'])) {
    $dataabertura = $_POST['dataabertura'];
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
    $produto = (int)$_POST['produto'];
    $ativo = (int)($_POST['check'] == "t") ? 'true' : 'false';
    $os = (int)$_POST['os'];
    $defeito = (int)$_POST['defeito'];
    $tipo_atendimento = (int)$_POST['tipo_atendimento'];
    $select_tipoatendimento = $_POST['select_tipoatendimento'];
    $fabrica = $_SESSION['fabrica'];

    $dataabertura = preg_replace('/[^0-9\/-]/', '', $dataabertura );
    $dataabertura  = str_replace('-', '', $dataabertura ); 
        if (empty($_POST["dataabertura"])) {
            $Error = "Data de abertura é um Campo Obrigatório";
        }
        
        if (empty($_POST["notafiscal"])) {
            $Error = "Nota Fiscal é um Campo Obrigatório";
        }

    $datacompra = preg_replace('/[^0-9\/-]/', '', $datacompra );
    $datacompra  = str_replace('-', '', $datacompra ); 
        if (empty($_POST["datacompra"])) {
            $Error = "Data de Compra é um Campo Obrigatório";
        }

        if (empty($_POST["aparencia"])) {
            $Error = "Aparência é um Campo Obrigatório";
        }

        if (empty($_POST["acessorios"])) {
            $Error = "Acessórios é um Campo Obrigatório";
        }


        if (empty($_POST["nome"])) {
            $Error = "Nome é um Campo Obrigatório";
            }
                $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_INT);
                if(filter_var($nome, FILTER_VALIDATE_INT)) {  
                    $Error = "Campo nome Inválido";
            }

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (empty($cpf)) {
        $Error = "CPF é um Campo Obrigatório";
            } else if (!filter_var($cpf, FILTER_VALIDATE_INT)) {
        $Error = "Campo CPF Inválido"; 
            } else if(strlen(trim($cpf)) < 11) {
                $Error = "Campo CPF Inválido"; 
                    }

        $cep = preg_replace('/[^0-9-]/', '', $cep);
        if (empty($cep)) {
            $Error = "CEP é um Campo Obrigatório";
        }
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT);
            $cep = str_replace('-', '', $cep); 
                if (!filter_var($cep, FILTER_VALIDATE_INT)) {
                $Error = "Campo CEP Inválido";   
            }
             
        if (empty($_POST["estado"])) {
            $Error = "Estado é um Campo Obrigatório";
        }

        if (empty($_POST["cidade"])) {
            $Error = "Cidade é um Campo Obrigatório";
        }

        if (empty($_POST["bairro"])) {
            $Error = "Bairro é um Campo Obrigatório";
        }

        if (empty($_POST["endereco"])) {
            $Error = "Endereço é um Campo Obrigatório";
        }

        if (empty($_POST["numero"])) {
            $Error = "Número é um Campo Obrigatório";
        }
            $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
            if (!filter_var($numero, FILTER_VALIDATE_INT)) {
                $Error = "Campo Número Inválido"; 
            }
        
        if (empty($_POST["complemento"])) {
            $Error = "Complemento é um Campo Obrigatório";
        }

        if (empty($_POST["telefone"])) {
            $Error = "Telefone é um Campo Obrigatório";
        }
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
            $telefone = str_replace('-', '', $telefone); 
            if (!filter_var($telefone, FILTER_VALIDATE_INT)) {
                $Error = "Campo Telefone Inválido";    
        }
            
           
        
        $celular = preg_replace('/[^0-9-])/', '', $celular);
        if (empty("celular")) {
            $Error = "Celular é um Campo Obrigatório";
        }
            $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
            $celular = str_replace('-', '', $celular); 
                if (!filter_var($celular, FILTER_VALIDATE_INT)) {
                    $Error = "Campo Celular Inválido";    
            }

        
    
        if (empty($_POST["email"])) {
            $Error = "Email é um Campo Obrigatório";
        }
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $Error = "Email Inválido";
            }
        
        if (empty($_POST["numero_serie"])) {
            $Error = "Número de série é um Campo Obrigatório";
        }
        
        if (empty($_POST["referencia"])) {
            $Error = "Referência é um Campo Obrigatório";
        }

        if (empty($_POST["descricao"])) {
            $Error = "Descrição é um Campo Obrigatório";
        }

        if (empty($_POST["selectdefeito"])) {
            $Error = "Defeito é um Campo Obrigatório";
        }
        
     
        if((strlen(trim($Error))==0) && ($os == 0)){
            $sql_insert = "insert into os(data_abertura, nota_fiscal, data_compra, aparencia, acessorio, nome_consumidor, cpf_cnpj, cep_consumidor, estado_consumidor, cidade_consumidor, bairro_consumidor, endereco_consumidor, numero_consumidor, telefone_consumidor, celular_consumidor, email_consumidor, produto, numero_serie, defeito, complemento, tipo_atendimento, fabrica) values ('$dataabertura', '$notafiscal', '$datacompra', '$aparencia', '$acessorios', '$nome', '$cpf', '$cep', '$estado', '$cidade', '$bairro', '$endereco', '$numero','$telefone', '$celular', '$email', '$produto', '$numero_serie', '$selectdefeito', '$complemento', '$select_tipoatendimento', '$fabrica')";
            $res = pg_query($con, $sql_insert);
            if(strlen(pg_last_error($con))>0){
                $Error = "Falha ao cadastrar dados";
            }else{
                $Suc = "Dados Cadastrados com Sucesso!";
                $dataabertura = "";
                $notafiscal = "";
                $datacompra = "";
                $aparencia = "";
                $acessorios = "";
                $nome = "";
                $cpf = "";
                $cep = "";
                $estado = "";
                $cidade = "";
                $bairro = "";
                $endereco = "";
                $numero = "";
                $complemento = "";
                $telefone = "";
                $celular = "";
                $email = "";
                $numero_serie = ""; 
                $referencia = "";
                $descricao = "";
                $defeito = "";
                $produto = "";
                $ativo = "";
                $selectdefeito ="";
                $complemento ="";
                $tipo_atendimento ="";
            }

        } if((strlen(trim($Error))==0) && ($os != 0)){
            $sql_insert = "UPDATE os SET 
            data_abertura = '$dataabertura', 
            nota_fiscal = '$notafiscal', 
            data_compra = '$datacompra', 
            aparencia = '$aparencia', 
            acessorio = '$acessorios', 
            nome_consumidor = '$nome', 
            cpf_cnpj = '$cpf', 
            cep_consumidor = '$cep', 
            estado_consumidor = '$estado', 
            cidade_consumidor = '$cidade', 
            bairro_consumidor = '$bairro', 
            endereco_consumidor = '$endereco', 
            numero_consumidor = '$numero', 
            telefone_consumidor = '$telefone', 
            celular_consumidor = '$celular', 
            email_consumidor = '$email', 
            produto = '$produto', 
            numero_serie = '$numero_serie', 
            defeito = '$selectdefeito',
            complemento = '$complemento',
            tipo_atendimento = '$select_tipoatendimento'
            where os = $os";
            $Suc = "Dados Atualizados com Sucesso!";
            $dataabertura = "";
            $notafiscal = "";
            $datacompra = "";
            $aparencia = "";
            $acessorios = "";
            $nome = "";
            $cpf = "";
            $cep = "";
            $estado = "";
            $cidade = "";
            $bairro = "";
            $endereco = "";
            $numero = "";
            $complemento = "";
            $telefone = "";
            $celular = "";
            $email = "";
            $numero_serie = ""; 
            $referencia = "";
            $descricao = "";
            $defeito = "";
            $produto = "";
            $ativo = "";
            $selectdefeito ="";
            $complemento ="";
            $tipo_atendimento ="";
            unset($os);
            $res_insert = pg_query($con, $sql_insert);   
        }     
          
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];


      $sql2 =  "SELECT * FROM os WHERE os = $id";
      $res = pg_query($con, $sql2);

      if ($res){
        $row = pg_fetch_assoc($res);
      
        if($row) {

        $dataabertura = $row['data_abertura'];
        $notafiscal = $row['nota_fiscal'];
        $datacompra = $row['data_compra'];
        $aparencia = $row['aparencia'];
        $acessorios = $row['acessorio'];
        $nome = $row['nome_consumidor'];
        $cpf =$row['cpf_cnpj'];
        $cep = $row['cep_consumidor'];
        $estado = $row['estado_consumidor'];
        $cidade = $row['cidade_consumidor'];
        $bairro = $row['bairro_consumidor'];
        $endereco = $row['endereco_consumidor'];
        $numero = $row['numero_consumidor'];
        $telefone = $row['telefone_consumidor'];
        $celular = $row['celular_consumidor'];
        $email = $row['email_consumidor'];    
        $produto = $row['produto'];            
        $defeito = $row['defeito'];            
        $numero_serie = $row['numero_serie'];
        $selectdefeito = $row['defeito'];
        $complemento = $row['complemento'];
        $tipo_atendimento = $row['tipo_atendimento'];
        $select_tipoatendimento = $row['tipo_atendimento'];
        }
      }
      function organizar_data($data) {
        $partes = explode('-', $data);
        $nova_data = $partes[2] . '/' . $partes[1] . '/' . $partes[0];            
        return $nova_data;        
    }
    $dataabertura = organizar_data($dataabertura);
    $datacompra = organizar_data($datacompra);

     
      $sql3 = "SELECT * FROM produto WHERE produto = $produto";
      $res = pg_query($con, $sql3);

      for($i = 0; $i < pg_num_rows($res); $i++) {
        
      $referencia = pg_fetch_result($res, $i, 'referencia');    
      $descricao = pg_fetch_result($res, $i, 'descricao');    
              
      }
    }


?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <link rel="stylesheet" href="css/cadastroos.css">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="js/shadowbox.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="css/shadowbox.css" >

   
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
            <div class="panel-body"> 
                
                <center>
                    <h3> Cadastro de OS <h3>
                        <br>
                </center>
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" >Data de Abertura:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dataabertura" id="dataabertura" placeholder="Data de Abertura"  value="<?= $dataabertura ?>">
                    <script>
                        $(document).ready(function () {
                            $('#dataabertura').inputmask('99/99/9999', { placeholder: '__/__/____' });
                        });
                    </script>
                    
                    <?php
                    $data = $_POST['dataabertura'];

                if (!empty($data)) {
                    $data = explode("/", $data);
                    $anoTempo = explode(" ", $data[2]);
                    $ano = $anoTempo[0];
                    $tempo = $anoTempo[1];
                    $date_conv1 = $ano . "-" . $data[1] . "-" . $data[0] . " " . $tempo;
            
                }
                ?>
                
                    <!-- < ?php
                    $data = $_POST['dataabertura'];
                    $data2 = $_POST['dataabertura'];

                    $data = explode("/", $data); 
                    $data2 = list($ano, $tempo) = explode(" ", $data[2]);
                
                    if(!empty($_POST["dataabertura"])) {
                        $date_conv1 = ($data2[0]."-".$data[ 1]."-".$data[ 0]." ".$data2[1]);
                    }
                 
            
                    ?> -->
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Tipo Atendimento:</label>
                <div class="col-sm-10">
                <select class="form-control" name="select_tipoatendimento" id="select_tipoatendimento">
                        <option value=''>Selecione o Atendimento</option>
                        <?php
                        $fabrica = $_SESSION['fabrica'];
                        $sql = "SELECT * FROM tipo_atendimento WHERE ativo = true and fabrica = $fabrica";

                        $res = pg_query($con, $sql);

                        for($i = 0; $i < pg_num_rows($res); $i++) {
                            $tipo_atendimento = pg_fetch_Result($res, $i, 'tipo_atendimento');
                            $codido = pg_fetch_Result($res, $i, 'codido');
                            $descricao2 = pg_fetch_Result($res, $i, 'descricao');
                           
                            echo "<option value='$tipo_atendimento'";
                            if (isset($_GET['id']) && $tipo_atendimento == $select_tipoatendimento) {
                                echo " selected";
                            }
                            echo ">$codido - $descricao2 </option>";
                          
                        }                       
                        ?>
                    </select>

                    </div>
                </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Nota Fiscal:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="notafiscal" placeholder="Nota Fiscal" value="<?= $notafiscal ?>" maxlength="10">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Data da compra:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="datacompra" id="datacompra" placeholder="Data da compra" value="<?= $datacompra ?>">
                    <script>
                        $(document).ready(function () {
                            $('#datacompra').inputmask('99/99/9999', { placeholder: '__/__/____' });
                        });
                    </script>
                    
                    <?php
                    $data = $_POST['datacompra'];

                if (!empty($data)) {
                    $data = explode("/", $data);
                    $anoTempo = explode(" ", $data[2]);
                    $ano = $anoTempo[0];
                    $tempo = $anoTempo[1];
                    $date_conv2 = $ano . "-" . $data[1] . "-" . $data[0] . " " . $tempo;
            
                }
                ?>
                    <!-- < ?php
                    $data = $_POST['datacompra'];
                    $data2 = $_POST['datacompra'];

                        $data = explode("/", $data); 
                        $data2 = list($ano, $tempo) = explode(" ", $data[2]);
                    
                        if(!empty($_POST["datacompra"])) {
                            $date_conv2 = ($data2[0]."-".$data[ 1]."-".$data[ 0]." ".$data2[1]);
                        }
                
                    ?> -->
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Aparência:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control aparencia" name="aparencia" placeholder="Aparência" value="<?= $aparencia?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Acessórios:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="acessorios" placeholder="Acessórios" value="<?= $acessorios?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <center>
                    <h3> Dados do Consumidor <h3>
                        <br>
                </center>
                <label for="inputEmail3" class="col-sm-2 control-label">Nome:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?= $nome?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">CPF-CNPJ:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cpf" id="cpf" placeholder="CPF-CNPJ" value="<?= $cpf?>"maxlength="14">
                    <script>
                        $(document).ready(function () {
                            $('#cpf').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
                        });
                    </script>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">CEP:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP"
                    value="<?= $cep ?>" maxlength="10">
                    <script> 
                    
                    $("#cep").blur(function(){
                        var cep = $(this).val(); 

                        $.ajax({
                        url: "http://viacep.com.br/ws/" + cep + "/json/",
                        type: "GET",
                        beforeSend: function() {
                            $(this).text("Carregando Dados...");
                        },
                        async: false,
                        timeout: 10000,
                        success: function(dados) {

                            $("#estado").val(dados.uf);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);   
                            $("#endereco").val(dados.logradouro);   
                        }
                    })
                });

                $(document).ready(function () {
                            $('#cep').inputmask('99999-999', { placeholder: '_____-___' });
                });

                </script>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Estado:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="estado" placeholder="Estado" id="estado" value="<?= $estado?>" maxlength="2">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Cidade:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cidade" placeholder="Cidade" id="cidade" 
                    value="<?= $cidade ?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bairro:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="bairro" placeholder="Bairro" id="bairro"  value="<?= $bairro ?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Endereço:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço" value="<?= $endereco ?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Número:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="numero" placeholder="Número" value="<?= $numero?>" maxlength="10">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Complemento:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="complemento" placeholder="Complemento" value="<?= $complemento ?>" maxlength="40">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Telefone:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" value="<?= $telefone ?>" maxlength="10">
                    <script>
                        $(document).ready(function () {
                            $('#telefone').inputmask('9999-9999', { placeholder: '____-____' });
                        });
                    </script>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Celular:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular" value="<?= $celular?>" maxlength="11">
                    <script>
                        $(document).ready(function () {
                            $('#celular').inputmask('9 9999-9999', { placeholder: '_ ____-____' });
                        });
                    </script>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $email?>" maxlength="50">
                </div>
            </div>
            <br>
            <div class="form-group">
                <center>
                    <h3> Dados do Produto <h3>
                        <br>
                </center>
                <label for="inputEmail3" class="col-sm-2 control-label">Número de série:</label>
                <div class="col-sm-10">
                    <input type="text" id="nms" class="form-control numero_serie" name="numero_serie" placeholder="Número de série" value="<?= $numero_serie ?>" maxlength="50">
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
            <br>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Defeito:</label>
                <div class="col-sm-10">
                <select class="form-control" name="selectdefeito" id="selectdefeito">
                        <option value=''>Selecione o Defeito</option>
                        <?php
                        $fabrica = $_SESSION['fabrica'];
                        $sql = "SELECT * FROM defeito where fabrica = $fabrica";
                        $res = pg_query($con, $sql);

                        for($i = 0; $i < pg_num_rows($res); $i++) {
                            $defeito = pg_fetch_Result($res, $i, 'defeito');
                            $codigo = pg_fetch_Result($res, $i, 'codigo');
                            $descricao = pg_fetch_Result($res, $i, 'descricao');
                           
                            echo "<option value='$defeito'";
                            if (isset($_GET['id']) && $defeito == $selectdefeito) {
                                echo " selected";
                            }
                            echo ">$codigo - $descricao </option>";
                        }                     
                        ?>
                    </select>

                    </div>
                </div>
            </div>
            <br>    
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control produto" name="produto" placeholder="Produto" value="<?= $produto?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control os" name="os" placeholder="os" value="<?= $id?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control fabrica_key" id="fabrica_key" name="fabrica_key" placeholder="Fábrica Key" value="<?php echo $_SESSION['fabrica']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="form_submit" class="btn btn-default" value="Enviar" id="bot1">Cadastrar Dados de OS</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a type="submit" href="menu.php" class="btn btn-default" id="bot">Voltar</a>
                </div>
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
                <script src="js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
                </div>     
            </div>
        </form>
    </div>
</body>
</html>