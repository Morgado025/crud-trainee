<?php
include ('/home/usuario/cauamorgado/bootstrap/config/conexao.php');
include ('/home/usuario/cauamorgado/bootstrap/autentica.php');

$fabrica = $_SESSION['fabrica'];

$tabela = 'tipo_atendimento';

$diretorio = '/home/usuario/cauamorgado/bootstrap/export-php/export';

$caminho = $diretorio . '/export.csv';

$arquivo = fopen($caminho, 'w');

if ($arquivo !== false) {

  $header = array('Descrição', 'Código', 'Status');
  fputcsv($arquivo, $header);

  $sql = "SELECT * FROM $tabela where fabrica = $fabrica";
  $res = pg_query($con, $sql);
  while ($row = pg_fetch_array($res)) {
    $status = ($row['ativo'] === 't') ? 'Ativo' : 'Inativo';
    $line = array($row['descricao'], $row['codido'], $status);
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
