<?php
include ('/home/usuario/cauamorgado/bootstrap/config/conexao.php');
include ('/home/usuario/cauamorgado/bootstrap/autentica.php');

$id = $_GET['id'];

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $cond .= " AND os = '$id'";
}


$fabrica = $_SESSION['fabrica'];

$tabela = 'os';

$diretorio = '/home/usuario/cauamorgado/bootstrap/export-php/export';

$caminho = $diretorio . '/export.csv';

$arquivo = fopen($caminho, 'w');

if ($arquivo !== false) {

  $header = array('Data de Abertura', 'Tipo Atendimento', 'Nota Fiscal', 'Data de Compra', 'Aparência', 'Acessórios', 'Nome', 'CPF', 'CEP', 'Estado', 'Cidade', 'Bairro', 'Endereço', 'Número', 'Telefone', 'Complemento', 'Celular', 'Email', 'Número de Série', 'Referência', 'Descrição', 'Defeito', 'Produto');
  fputcsv($arquivo, $header);

  $sql = "SELECT $tabela.*, produto.descricao, produto.referencia
  FROM $tabela
  JOIN produto ON $tabela.produto = produto.produto
  WHERE $tabela.fabrica = '$fabrica' $cond";

$res = pg_query($con, $sql);
while ($row = pg_fetch_array($res)) {
$data_abertura = ($row['data_abertura'] == 'YYYY/MM/DD') ? '' : date('d/m/Y', strtotime($row['data_abertura']));
$data_compra = ($row['data_compra'] == 'YYYY/MM/DD') ? '' : date('d/m/Y', strtotime($row['data_compra']));
$line = array($data_abertura, $row['tipo_atendimento'], $row['nota_fiscal'], $data_compra, $row['aparencia'], $row['acessorio'], $row['nome_consumidor'], $row['cpf_cnpj'], $row['cep_consumidor'], $row['estado_consumidor'], $row['cidade_consumidor'], $row['bairro_consumidor'], $row['endereco_consumidor'], $row['numero_consumidor'], $row['telefone_consumidor'], $row['complemento'], $row['celular_consumidor'], $row['email_consumidor'], $row['numero_serie'], $row['referencia'], $row['descricao'], $row['defeito'], $row['produto']);
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
