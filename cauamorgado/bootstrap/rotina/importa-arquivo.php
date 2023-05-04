<?php 
include ('/home/usuario/cauamorgado/bootstrap/config/conexao.php');

$dir = dirname(__FILE__);

$arquivo = $dir . "/pecas_black.csv";

$conteudo = file_get_contents($arquivo);

$linhas = explode("\n", $conteudo);

foreach ($linhas as $linha) {
    $substrings = explode(";", $linha);
    $referencia = $substrings[0];
    $descricao = $substrings[1];
   
    echo "Referência: " . $referencia . "<br>";
    echo "Descricão: " . $descricao . "<br>";
    
    $sql_insert = "INSERT INTO peca(referencia, descricao, fabrica) values ('$referencia', '$descricao', '1')";
    echo nl2br($sql_insert);
    $res = pg_query($con, $sql_insert);

}
?>









