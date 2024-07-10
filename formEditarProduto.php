<?php include("validarSessao.php"); ?>
<?php include("header.php"); ?>

<div class="container-fluid text-center">

<?php

    if(isset($_GET["idProduto"])){
        $idProduto = $_GET["idProduto"];

        session_start();
        $nomeUsuario = $_SESSION['nomeUsuario'];
        $nomeCompleto = explode(' ', $nomeUsuario);
        $primeiroNome = $nomeCompleto[0];

        //Inclui o arquivo de conexão com o Banco de Dados
        include("conexaoBD.php");

        $buscarProduto = "SELECT * FROM Produtos WHERE idProduto = $idProduto AND statusProduto = 'disponivel' "; //Seleciona todos os campos da tabela Produtos
        $res = mysqli_query($conn, $buscarProduto); //Executa o comando de listagem
        $totalProdutos = mysqli_num_rows($res); //Função para retornar a quantidade de registros da tabela
        
        if($totalProdutos > 0){

            // Varre a tabela em busca de registros e armazena em um array
            //Enquanto houverem dados na linha da tabela, atribui o valor atual do array a uma variável
            if($registro = mysqli_fetch_assoc($res)){
                $idProduto        = $registro["idProduto"];
                $fotoProduto      = $registro["fotoProduto"];
                $nomeProduto      = $registro["nomeProduto"];
                $descricaoProduto = $registro["descricaoProduto"];
                $valorProduto     = $registro["valorProduto"];
                $vendedorProduto  = $registro["Usuarios_idUsuario"];
                $dataProduto      = $registro["dataProduto"];
                $horaProduto      = $registro["horaProduto"];

                /*
                $diaProduto  = substr($dataProduto, 8, 2);
                $mesProduto  = substr($dataProduto, 5, 2);
                $anoProduto  = substr($dataProduto, 0, 4);

                $dataProduto = ("$diaProduto/$mesProduto/$anoProduto");

                $valorProduto = str_replace('.', ',', $valorProduto); //Substitui os pontos por vírgulas para exibir o valor do Produto.        
                */
            }
        }
        else{
            echo "<div class='alert alert-warning text-center'>$nomeUsuario, infelizmente não foi possível carregar o Produto! =(</div>";
        }
    }
    else{
        die ("<div class='alert alert-danger text-center'><h3>$nomeUsuario, infelizmente não foi possível carregar o Produto! =(</h3></div>");
    }
        
?>

    <h2>Editar Produto:</h2>
    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <form action="editarProduto.php?pagina=formProduto" method="POST" class="was-validated" enctype="multipart/form-data">
                    <div class="form-floating mb-3 mt-3"> <!-- Exibe o ID do Produto apenas como leitura (Impossível Editar) -->
                        <input type="text" class="form-control" name="idProduto" value="<?php echo $idProduto; ?>" readonly>
                        <label for="idProduto" class="form-label">*ID:</label>
                    </div>
                    <div class="form-floating mb-3 mt-3"> <!-- Exibe a data do Produto apenas como leitura (Impossível Editar) -->
                        <input type="hidden" class="form-control" name="dataProduto" value="<?php echo $dataProduto; ?>" readonly>
                        <input type="hidden" class="form-control" name="horaProduto" value="<?php echo $horaProduto; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <img src="<?php echo $fotoProduto; ?>" width="100"> <!-- Exibe a FOTO ATUAL cadastrada -->
                        <input type="hidden" name="fotoAtual" value="<?php echo $fotoProduto; ?>"> <!-- Passa o local da FOTO ATUAL como parâmetro oculto com um NAME diferente-->
                        <input type="file" class="btn btn-link" name="fotoProduto"> <!-- Oferece a opção para alterar foto-->
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="nomeProduto" placeholder="Nome" name="nomeProduto" value="<?php echo $nomeProduto; ?>" required>
                        <label for="nomeProduto">Nome do Produto</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" id="descricaoProduto" placeholder="Informe uma breve descrição sobre o Produto" name="descricaoProduto" required><?php echo $descricaoProduto; ?></textarea>
                        <label for="nomeProduto">Descrição do Produto</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mt-3 mb-3">
                        <input type="text" class="form-control" id="valorProduto" placeholder="Valor do Produto" name="valorProduto" value="<?php echo floatval($valorProduto); //Converte para float ?>" required>
                        <label for="valorProduto">Valor do Produto (R$):</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
    <br>

</div>
                    
<?php include("footer.php"); ?>
                