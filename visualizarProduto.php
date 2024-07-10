<?php include("header.php");

    if(isset($_GET["idProduto"])){
        $idProduto = $_GET["idProduto"];
        
        //Inclui o arquivo de conexão com o Banco de Dados
        include("conexaoBD.php");

        $exibirProduto = "SELECT * FROM Produtos WHERE idProduto = $idProduto "; //Seleciona todos os campos da tabela Produtos
        $res = mysqli_query($conn, $exibirProduto); //Executa o comando de listagem
        $totalProdutos = mysqli_num_rows($res); //Função para retornar a quantidade de registros da tabela

        if($totalProdutos > 0){
            
            //Monta a tabela para exibir os registros encontrados
            echo "
            <div class='row text-center'>";

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

                    $diaProduto  = substr($dataProduto, 8, 2);
                    $mesProduto  = substr($dataProduto, 5, 2);
                    $anoProduto  = substr($dataProduto, 0, 4);

                    $dataProduto = ("$diaProduto/$mesProduto/$anoProduto");

                    $valorProduto = str_replace('.', ',', $valorProduto); //Substitui ponto por vírgula

                    ?>
                    <div class="d-flex justify-content-center mb-3">

                        <div class="card" style="width:40%; border-style:none;">
                            
                            <!-- Carousel -->
                            <div id="Produto" class="carousel slide" data-bs-ride="carousel" >

                                <!-- Indicators/dots -->
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#Produto" data-bs-slide-to="0" class="active"></button>
                                    <button type="button" data-bs-target="#Produto" data-bs-slide-to="1"></button>
                                    <button type="button" data-bs-target="#Produto" data-bs-slide-to="2"></button>
                                </div>

                                <!-- The slideshow/carousel -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo $fotoProduto; ?>" alt="<?php echo $nomeProduto; ?>" class="d-block" style="width:100%">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fotoProduto; ?>" alt="<?php echo $nomeProduto; ?>" class="d-block" style="width:100%">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?php echo $fotoProduto; ?>" alt="<?php echo $nomeProduto; ?>" class="d-block" style="width:100%">
                                    </div>
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#Produto" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#Produto" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><b><?php echo $nomeProduto; ?></b></h4>
                                <p class="card-text"><?php echo $descricaoProduto; ?></p>
                                <p class='card-text'>Valor: <b>R$ <?php echo $valorProduto; ?></b></p>
                                <?php
                                    session_start();
                                    $tipoUsuario = $_SESSION['tipoUsuario'];
                                    if($tipoUsuario == "administrador"){
                                        echo"
                                            <div class='card bg-light'>
                                                <div class='card-body'>
                                                    <p>Este anúncio foi cadastrado por você! =)</p>
                                                    <a href='formEditarProduto.php?idProduto=$idProduto' title='Editar Produto'>
                                                        <button class='btn btn-outline-primary'>
                                                            <i class='bi bi-gear' style='font-size:16pt;'></i>
                                                            <p>Editar Produto</p>
                                                        </button>
                                                    </a>
                                                    <a href='registrarVenda.php?pagina=formProduto&idProduto=$idProduto' title='Marcar como Vendido'>
                                                        <button class='btn btn-outline-success'>
                                                            <i class='bi bi-check-circle' style='font-size:16pt;'></i>
                                                            <p>Marcar como Vendido</p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>";
                                       
                                    } else{
                                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                            echo "
                                                <a href='#' title='Realizar Pedido'>
                                                    <button class='btn btn-outline-success'>
                                                        <i class='bi bi-clipboard-plus' style='font-size:16pt;'></i>
                                                        <p>Realizar Pedido</p>
                                                    </button>
                                                </a>";
                                        } else{
                                            echo "<a href='formLogin.php' class='btn btn-danger'>Faça Login para realizar o seu Pedido <i class='bi bi-emoji-smile'></i></a>";
                                        }
                                        
                                    }
                                ?>
                            </div>
                        </div>
                        <br>
                    </div>
                <?php }
            echo"</div>";
        }
    }
    else{
        die ("<div class='alert alert-danger text-center'><h3>Não foi possível carregar o <strong>$totalProdutos</strong> Produto!</h3></div>");
    }

?>


<?php include("footer.php")?>