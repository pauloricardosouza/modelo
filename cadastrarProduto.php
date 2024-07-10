<?php include("validarSessao.php"); ?>
<?php include("header.php") ?>

<?php

    //Área para declaração das variáveis
    $fotoProduto = $nomeProduto = $descricaoProduto = $valorProduto = $vendedorProduto = $dataProduto = $horaProduto = "";
    $erroPreenchimento = false; //Essa variável será responsável por verificar se os campos foram devidamente preenchidos;

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Verifica o método de envio do FORM

        //Validação do campo NOME
        if(empty($_POST["nomeProduto"])){
            echo "<div class='alert alert-warning'>O campo<strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $nomeProduto = testar_entrada($_POST["nomeProduto"]);
        }

        //Validação do campo DESCRIÇÃO
        if(empty($_POST["descricaoProduto"])){
            echo "<div class='alert alert-warning'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $descricaoProduto = testar_entrada($_POST["descricaoProduto"]);
        }

        //Validação do campo CIDADE
        /*if(empty($_POST["cidadeProduto"])){
            echo "<div class='alert alert-warning'>O campo <strong>CIDADE</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $cidadeProduto = testar_entrada($_POST["cidadeProduto"]);
        }*/

        //Validação do campo VALOR
        if(empty($_POST["valorProduto"])){
            echo "<div class='alert alert-warning'>O campo <strong>VALOR</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $valorProduto  = testar_entrada($_POST["valorProduto"]); //Pega o valor com o formato exigido pela máscara no form
            $valorProduto = str_replace('.', '', $valorProduto); //Remove os Pontos.
            $valorProduto = str_replace(',', '.', $valorProduto); //Substitui as vírgulas por Pontos.
        }

        //Definição do campo VENDEDOR
        $vendedorProduto = $_SESSION["idUsuario"];

        //Definição do campo DATA DO Produto
        $dataProduto = date("Y-m-d");
        $diaProduto  = substr($dataProduto, 8, 2);
        $mesProduto  = substr($dataProduto, 5, 2);
        $anoProduto  = substr($dataProduto, 0, 4);
        $horaProduto = date("H:i:s");

        $diretorio    = "img/"; //Define para qual diretório do sistema as imagens serão movidas
        $fotoProduto  = $diretorio . basename($_FILES["fotoProduto"]["name"]); //img/Produto.png
        $erroUpload   = false; //Variável criada para verificar se houve sucesso no upload do arquivo
        $tipoDaImagem = strtolower(pathinfo($fotoProduto, PATHINFO_EXTENSION)); //Pegar o tipo do arquivo


        if (isset($_FILES["fotoProduto"])){
            //Verificar o tamanho do arquivo
            if($_FILES["fotoProduto"]["size"] > 5000000) { //Verifica o tamanho em BYTES
                echo "<div class='alert alert-warning text-center'>Atenção! A foto ultrapassa o <strong>TAMANHO MÁXIMO</strong> permitido (5MB)!</div>";
                $erroUpload = true;
            }

            //Verificar o tipo do arquivo (Pela extensão)
            if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                echo "<div class='alert alert-warning text-center'>Atenção! A foto precisa estar nos formatos <strong>JPG, JPEG, PNG ou WEBP</strong>!</div>";
                $erroUpload = true;
            }

            if($erroUpload){
                echo "<div class='alert alert-danger text-center'>Erro ao tentar fazer o <strong>UPLOAD DA FOTO</strong> $fotoProduto!</div>";
                $erroUpload = true;
            } else{
                //A função seguinte é responsável por mover o arquivo para o diretório definido
                if(!move_uploaded_file($_FILES["fotoProduto"]["tmp_name"], $fotoProduto)){
                    echo "<div class='alert alert-warning'>Erro ao tentar mover 
                        <strong>A FOTO</strong> para o diretório $diretorio!</div>";
                    $erroUpload = true;
                }
            }
        }else{
            echo "<div class='alert alert-danger text-center'>Erro ao tentar mover <strong>A FOTO</strong> para o diretório $diretorio!</div>";
            $erroUpload = true;
        }

        //Se estiver tudo certo
        if(!$erroPreenchimento && !$erroUpload){

            //Cria uma Query responsável por realizar a inserção dos dados no BD
            $inserirProduto = "INSERT INTO Produtos (fotoProduto, nomeProduto, descricaoProduto, valorProduto, Usuarios_idUsuario, dataProduto, horaProduto, statusProduto)
                                VALUES ('$fotoProduto', '$nomeProduto', '$descricaoProduto', '$valorProduto', '$vendedorProduto', '$dataProduto', '$horaProduto', 'disponivel')";

            include("conexaoBD.php");

            //Função para executar QUERYs no Banco de Dados
            if(mysqli_query($conn, $inserirProduto)){
                $valorProduto = str_replace('.', ',', $valorProduto); //Substitui os pontos por vírgulas para exibir o valor do Produto.
                echo "<div class='alert alert-success text-center'><strong>Produto</strong> cadastrado(a) com sucesso! <i class='bi bi-emoji-smile'></i></div>";

                echo "<div class='container mt-3'>
                        <div class='container mt-3 text-center'>
                            <img src='$fotoProduto' width='150'>
                        </div>
                        <div class='table-responsive'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeProduto</td>
                                </tr>
                                <tr>
                                    <th>DESCRIÇÃO</th>
                                    <td>$descricaoProduto</td>
                                </tr>
                                <tr>
                                    <th>VALOR</th>
                                    <td>R$ $valorProduto</td>
                                </tr>
                                <tr>
                                    <th>VENDEDOR</th>
                                    <td>$vendedorProduto</td>
                                </tr>
                                <tr>
                                    <th>DATA DA CRIAÇÃO DO Produto</th>
                                    <td>$diaProduto/$mesProduto/$anoProduto</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                ";
            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>Produto</strong>!  <i class='bi bi-emoji-frown'></i></div>" . mysqli_error($conn);
            }
        }
    }

    //Função para testar as entradas de dados e evitar SQL Injection
    function testar_entrada($dado){
        $dado = trim($dado); //TRIM - Remove caracteres desnecessários (TABS, espaços, etc)
        $dado = stripslashes($dado); //Remove barras invertidas
        $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML
        return($dado);
    }

?>

<?php include("footer.php") ?>