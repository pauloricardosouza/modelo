<?php include("validarSessao.php"); ?>
<?php include("header.php") ?>

<?php
    
    //Área para declaração das variáveis
    $fotoProduto = $nomeProduto = $descricaoProduto = $valorProduto = $vendedorProduto = $dataProduto = $horaProduto = "";
    $erroPreenchimento = false; //Essa variável será responsável por verificar se os campos foram devidamente preenchidos;

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Verifica o método de envio do FORM

        $idProduto   = testar_entrada($_POST["idProduto"]); //Recebe o ID do Produto para sabermos de quem são os dados que deverão ser atualizados
        $dataProduto = testar_entrada($_POST["dataProduto"]); //Recebe a data da criação do Produto

        //Validação do campo NOME
        if(empty($_POST["nomeProduto"])){
            echo "<div class='alert alert-warning'>O campo<strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $nomeProduto = testar_entrada($_POST["nomeProduto"]);
        }

        //Validação do campo DESCRIÇÃO
        if(empty($_POST["descricaoProduto"])){
            echo "<div class='alert alert-warning'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else{
            $descricaoProduto = testar_entrada($_POST["descricaoProduto"]);
        }

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
        $diaProduto  = substr($dataProduto, 8, 2);
        $mesProduto  = substr($dataProduto, 5, 2);
        $anoProduto  = substr($dataProduto, 0, 4);

        //Validação da atualização da Foto. IMPORTANTE!
        if ($_FILES['fotoProduto']['size'] != 0){ //Verifica se houve o upload de algum novo arquivo de foto
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
            } else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar mover <strong>A FOTO</strong> para o diretório $diretorio!</div>";
                $erroUpload = true;
            }
        } else {
            $fotoProduto = $_POST["fotoAtual"];
            $erroUpload = false;
        }


        //Se estiver tudo certo
        if(!$erroPreenchimento && !$erroUpload){

            //Cria a Query Responsável por realizar a alteraçoes dos dados do(a) Produto na Base de Dados
            $editarProduto = "UPDATE Produtos
                        SET
                            fotoProduto           = '$fotoProduto',
                            nomeProduto           = '$nomeProduto',
                            descricaoProduto      = '$descricaoProduto',
                            valorProduto          = '$valorProduto',
                            Usuarios_idUsuario    = '$vendedorProduto',
                            dataProduto           = '$dataProduto',
                            horaProduto           = '$horaProduto',
                            statusProduto         = 'disponivel'
                        WHERE idProduto = $idProduto";

            include("conexaoBD.php");

            //Função para executar QUERYs no Banco de Dados
            if(mysqli_query($conn, $editarProduto)){
                $valorProduto = str_replace('.', ',', $valorProduto); //Substitui os pontos por vírgulas para exibir o valor do Produto.
                echo "<div class='alert alert-success text-center'>As alterações do <strong>Produto</strong> foram salvas com sucesso!</div>";

                echo "<div class='container mt-3'>
                        <div class='container mt-3 text-center'>
                            <a href='visualizarProduto.php?pagina=formProduto&idProduto=$idProduto' style='text-decoration:none;' title='Visualizar Produto de $nomeProduto'>
                                <img src='$fotoProduto' width='300' alt='Foto de $nomeProduto'>
                            </a>
                        </div>
                            
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
                                    <th>DATA DA PUBLICAÇÃO DO Produto</th>
                                    <td>$diaProduto/$mesProduto/$anoProduto</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                ";
            }
            else{
                echo "<div class='alert alert-danger text-center'>Erro ao tentar salvar as alterações do <strong>Produto</strong>!</div>" . mysqli_error($conn) . "<p>$editarProduto</p>";
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