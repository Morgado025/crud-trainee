<?php 
include ('config/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<link rel="stylesheet" href="">
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
    <title>Offdout - Cadastro</title>
</head> 
<body>
    <?php
    $referencia = $_GET['referencia'];
    $descricao = $_GET['descricao']; 

    if (!empty($_GET["referencia"])) {
        $sql = "SELECT * FROM produto WHERE referencia LIKE '%$referencia%'";
    }

    if (!empty($_GET["descricao"])) {
        $sql = "SELECT * FROM produto WHERE descricao LIKE '%$descricao%'";
    }
    
    $res = pg_query($con, $sql);
    if(pg_num_rows($res) > 0){
    ?>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Descrição</th>            
            <th>Referência</th>
            <th>Garantia</th>
            <th>Status</th>
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
            <td><a onclick="window.parent.Shadowbox.close()"><?= $descricao ?></a></td>
            <form action="#" method="POST">
                <input type="hidden" name="produto_id" value="<?=$produto?>">
                <button type="submit" class="btn btn-danger" onclick="deleteProduto(event)">Deletar</button>
            </form>
            <td><?=$referencia?></td>
            <td><?=$garantia?></td>
            <td><?=$ativo?></td>
        </tr>

        <script>
        function deleteProduto(event) {
            event.preventDefault(); // Previne o comportamento padrão do botão (enviar o formulário)
            const form = event.target.parentElement; // Obtém o elemento form que contém o botão
            const produtoId = form.querySelector('input[name="produto_id"]').value; // Obtém o valor do input hidden com o nome "produto_id"

            // Faça a requisição para excluir o registro usando AJAX ou fetch
            // Exemplo com AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'produtos.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Se a exclusão foi bem-sucedida, fecha a segunda modal
                    window.parent.Shadowbox.close();
                    // Fecha a modal inicial
                    window.parent.parent.Shadowbox.close();

                }
            };
            xhr.send('produto_id=' + produtoId);
        }
        </script>



        <?php } ?>
    </tbody>
    <?php } ?>
    </table>
</body>
</html>
