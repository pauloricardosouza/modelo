<?php include("header.php");

    if(isset($_GET["idUsuario"])){
        $idUsuario = $_GET["idUsuario"];
        
        //Inclui o arquivo de conexão com o Banco de Dados
        include("conexaoBD.php");

        $exibirUsuario = "SELECT * FROM Usuarios WHERE idUsuario = $idUsuario "; //Seleciona todos os campos da tabela Usuarios
        $res = mysqli_query($conn, $exibirUsuario); //Executa o comando de listagem
        $totalUsuarios = mysqli_num_rows($res); //Função para retornar a quantidade de registros da tabela

        if($totalUsuarios > 0){
            
            //Monta a tabela para exibir os registros encontrados
            echo "
            <div class='row text-center'>";

                // Varre a tabela em busca de registros e armazena em um array
                //Enquanto houverem dados na linha da tabela, atribui o valor atual do array a uma variável
                if($registro = mysqli_fetch_assoc($res)){
                    $idUsuario        = $registro["idUsuario"];
                    $tipoUsuario      = $registro["tipoUsuario"];
                    $fotoUsuario      = $registro["fotoUsuario"];
                    $nomeUsuario      = $registro["nomeUsuario"];
                    $cidadeUsuario    = $registro["cidadeUsuario"];
                    $telefoneUsuario  = $registro["telefoneUsuario"];
                    $emailUsuario     = $registro["emailUsuario"];
                    /*$dataUsuario      = $registro["dataUsuario"];
                    $horaUsuario      = $registro["horaUsuario"];

                    $diaUsuario  = substr($dataUsuario, 8, 2);
                    $mesUsuario  = substr($dataUsuario, 5, 2);
                    $anoUsuario  = substr($dataUsuario, 0, 4);

                    $dataUsuario = ("$diaUsuario/$mesUsuario/$anoUsuario");

                    $valorUsuario = str_replace('.', ',', $valorUsuario); //Substitui ponto por vírgula*/

                    ?>
                    <div class="d-flex justify-content-center mb-3">

                        <div class="card" style="width:40%; border-style:none;">
                            
                            <!-- Carousel -->
                            <div id="Usuario" class="container text-center">

                                <!-- The slideshow/carousel -->
                                <div class="container text-center">
                                    <img src="<?php echo $fotoUsuario; ?>" alt="<?php echo $nomeUsuario; ?>" class="d-block img-thumbnail" style="width:50%; margin: auto;">
                                </div>

                            </div>

                            <div class="card-body">
                                <h4 class="card-title"><b><?php echo $nomeUsuario; ?></b></h4>
                                <p class='card-text'>Tipo: <b><?php echo $tipoUsuario; ?></b></p>
                                <p class='card-text'>Cidade: <b><?php echo $cidadeUsuario; ?></b></p>
                                <p class='card-text'>Telefone: <b><?php echo $telefoneUsuario; ?></b></p>
                                <p class='card-text'>Email: <b><?php echo $emailUsuario; ?></b></p>
                                <?php
                                    session_start();
                                    $tipoUsuario = $_SESSION['tipoUsuario'];
                                    if($tipoUsuario == "administrador"){
                                        echo"
                                            <div class='card bg-light'>
                                                <div class='card-body'>
                                                    <p>Este usuário é você! =)</p>
                                                    <a href='formEditarUsuario.php?idUsuario=$idUsuario' title='Editar Dados'>
                                                        <button class='btn btn-outline-primary'>
                                                            <i class='bi bi-gear' style='font-size:16pt;'></i>
                                                            <p>Editar Dados</p>
                                                        </button>
                                                    </a>
                                                    <a href='#desativarUsuario.php?pagina=formUsuario&idUsuario=$idUsuario' title='Desativar Conta'>
                                                        <button class='btn btn-outline-danger'>
                                                            <i class='bi bi-emoji-frown' style='font-size:16pt;'></i>
                                                            <p>Desativar Conta</p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>";
                                       
                                    } else{
                                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                            echo "
                                            <div class='card bg-light'>
                                                <div class='card-body'>
                                                    <a href='#meusPedidos.php' title='Visualizar Pedidos'>
                                                        <button class='btn btn-outline-success'>
                                                            <i class='bi bi-eye' style='font-size:16pt;'></i>
                                                            <p>Visualizar Pedidos</p>
                                                        </button>
                                                    </a>
                                                    <a href='formEditarUsuario.php?idUsuario=$idUsuario' title='Editar Dados'>
                                                        <button class='btn btn-outline-primary'>
                                                            <i class='bi bi-gear' style='font-size:16pt;'></i>
                                                            <p>Editar Dados</p>
                                                        </button>
                                                    </a>
                                                    <a href='#desativarUsuario.php?pagina=formUsuario&idUsuario=$idUsuario' title='Desativar Conta'>
                                                        <button class='btn btn-outline-danger'>
                                                            <i class='bi bi-emoji-frown' style='font-size:16pt;'></i>
                                                            <p>Desativar Conta</p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>";
                                        } else{
                                            echo "<a href='formLogin.php' class='btn btn-danger text-center'>Faça Login para realizar o seu Pedido</a>";
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
        die ("<div class='alert alert-danger text-center'><h3>Não foi possível carregar o <strong>$totalUsuarios</strong> Usuario!</h3></div>");
    }

?>


<?php include("footer.php")?>