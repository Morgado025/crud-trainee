<?php
  $texto = "Olá, mundo! Este é um exemplo de texto com caracteres especiais.";

  // Aplica a codificação URL segura
  $texto_codificado = filter_var($texto, FILTER_SANITIZE_ENCODED);

  echo $texto_codificado; // Saída: Ol%C3%A1%2C%20mundo%21%20Este%20%C3%A9%20um%20exemplo%20de%20texto%20com%20caracteres%20especiais.
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Functions</title>
</head>
<body>
    <div class="container">
        <header class="inicio">
            <h1> Funções de Sanatização e Validação <h1>
        </header>  
    </div>
        <main class="principal">
            <div class="panel-body">
            <h3>FILTER_SANITIZE_ENCODED<h3>
                <div class="string">
                    <p1>É uma constante pré-definida no PHP usada para filtrar e sanitizar dados de uma string codificada para URL. <br>
                    </p1>
                    <br>
                    <p2>Essa constante aplica uma codificação URL segura, que remove ou codifica caracteres que não são seguros em uma URL, como espaços, caracteres especiais e acentos, transformando-os em seus equivalentes de escape.</p2> <br>
                    <br> 
                    <p3>Essa função é útil para garantir que os dados de entrada, como os enviados por meio de formulários da web, estejam em um formato seguro e adequado antes de serem usados em uma URL.</p3> <br> 
                    <br>
                    <br>
                </div>

                <form action ="functions" class="encoded" method="POST">
                    <label for="url-teste" class="col-sm-2 control-label">Url</label>
                    <input name="url-name" type="text" class="form-control" placeholder="Url"><br>
                    <br>
                    <label for="url-teste" class="col-sm-2 control-label">Url</label>
                    <input name="url-name" type="text" class="form-control" placeholder="Url"><br>
                    <br>
                    <label for="url-teste" class="col-sm-2 control-label">Url</label>
                    <input name="url-name" type="text" class="form-control" placeholder="Url"><br>
                    <br>
                    <label for="url-teste" class="col-sm-2 control-label">Url</label>
                    <input name="url-name" type="text" class="form-control" placeholder="Url"><br>
                    <br>
                    <button type="submit" name="coded" class="btn btn-default">Enviar</button>
                </form>
            </h3>
        
</body>
</html>