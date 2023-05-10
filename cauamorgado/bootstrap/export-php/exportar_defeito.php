<?php
include ('/home/usuario/cauamorgado/bootstrap/config/conexao.php');
include ('/home/usuario/cauamorgado/bootstrap/autentica.php');

$fabrica = $_SESSION['fabrica'];

$tabela = 'defeito';

$diretorio = '/home/usuario/cauamorgado/bootstrap/export-php/export';

$caminho = $diretorio . '/export.csv';

$arquivo = fopen($caminho, 'w');

if ($arquivo !== false) {

  $header = array('Descrição', 'Código');
  fputcsv($arquivo, $header);

  $sql = "SELECT * FROM $tabela where fabrica = $fabrica";
  $res = pg_query($con, $sql);
  while ($row = pg_fetch_array($res)) {
    $line = array($row['descricao'], $row['codigo']);
    fputcsv($arquivo, $line);
  }

  fclose($arquivo);

  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="' . $caminho . '"');

  readfile($caminho);

  unlink($caminho);
} else {
  echo "Erro ao abrir o arquivo";
}
?>
