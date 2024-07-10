<?php include("validarSessao.php"); ?>
<?php include("header.php"); ?>

<div class="container-fluid text-center">

<?php

    if(isset($_GET["idUsuario"])){
        $idUsuario = $_GET["idUsuario"];

        session_start();
        $nomeUsuario = $_SESSION['nomeUsuario'];
        $nomeCompleto = explode(' ', $nomeUsuario);
        $primeiroNome = $nomeCompleto[0];

        //Inclui o arquivo de conexão com o Banco de Dados
        include("conexaoBD.php");

        $buscarUsuario = "SELECT * FROM Usuarios WHERE idUsuario = $idUsuario AND statusUsuario = 'ativo' "; //Seleciona todos os campos da tabela Usuarios
        $res = mysqli_query($conn, $buscarUsuario); //Executa o comando de listagem
        $totalUsuarios = mysqli_num_rows($res); //Função para retornar a quantidade de registros da tabela
        
        if($totalUsuarios > 0){

            // Varre a tabela em busca de registros e armazena em um array
            //Enquanto houverem dados na linha da tabela, atribui o valor atual do array a uma variável
            if($registro = mysqli_fetch_assoc($res)){
                $idUsuario        = $registro["idUsuario"];
                $fotoUsuario      = $registro["fotoUsuario"];
                $nomeUsuario      = $registro["nomeUsuario"];
                $cidadeUsuario    = $registro["cidadeUsuario"];
                $telefoneUsuario  = $registro["telefoneUsuario"];
                $emailUsuario     = $registro["emailUsuario"];
                /*
                $diaUsuario  = substr($dataUsuario, 8, 2);
                $mesUsuario  = substr($dataUsuario, 5, 2);
                $anoUsuario  = substr($dataUsuario, 0, 4);

                $dataUsuario = ("$diaUsuario/$mesUsuario/$anoUsuario");

                $valorUsuario = str_replace('.', ',', $valorUsuario); //Substitui os pontos por vírgulas para exibir o valor do Usuário.        
                */
            }
        }
        else{
            die ("<div class='alert alert-danger text-center'>$nomeUsuario, infelizmente não foi possível carregar os seus dados de usuário(a)! =(</div>");
        }
    }
    else{
        die ("<div class='alert alert-danger text-center'><h3>$nomeUsuario, infelizmente não foi possível carregar os seus dados de usuário(a)! =(</h3></div>");
    }
        
?>

    <h2>Editar seus dados de Usuário:</h2>
    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <form action="editarUsuario.php?pagina=formUsuario" method="POST" class="was-validated" enctype="multipart/form-data">
                    <div class="form-floating mb-3 mt-3"> <!-- Exibe o ID do Usuario apenas como leitura (Impossível Editar) -->
                        <input type="text" class="form-control" name="idUsuario" value="<?php echo $idUsuario; ?>" readonly>
                        <label for="idUsuario" class="form-label">*ID:</label>
                    </div>
                    <div class="form-group">
                        <img src="<?php echo $fotoUsuario; ?>" width="100"> <!-- Exibe a FOTO ATUAL cadastrada -->
                        <input type="hidden" name="fotoAtual" value="<?php echo $fotoUsuario; ?>"> <!-- Passa o local da FOTO ATUAL como parâmetro oculto com um NAME diferente-->
                        <input type="file" class="btn btn-link" name="fotoUsuario"> <!-- Oferece a opção para alterar foto-->
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="nomeUsuario" placeholder="Nome" name="nomeUsuario" value="<?php echo $nomeUsuario; ?>" required>
                        <label for="nomeUsuario">Nome Completo</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="cidadeUsuario" name="cidadeUsuario" required>
                            <option value="curiuva" <?php if($cidadeUsuario == 'curiuva'){echo " selected";} ?>>Curiúva</option>
                            <option value="imbau" <?php if($cidadeUsuario == 'imbau'){echo " selected";} ?>>Imbaú</option>
                            <option value="ortigueira" <?php if($cidadeUsuario == 'ortigueira'){echo " selected";} ?>>Ortigueira</option>
                            <option value="reserva" <?php if($cidadeUsuario == 'reserva'){echo " selected";} ?>>Reserva</option>
                            <option value="telemacoBorba"  <?php if($cidadeUsuario == 'telemacoBorba'){echo " selected";} ?>>Telêmaco Borba</option>
                            <option value="tibagi" <?php if($cidadeUsuario == 'tibagi'){echo " selected";} ?>>Tibagi</option>
                        </select>
                        <label for="cidadeUsuario">Cidade</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="telefoneUsuario" placeholder="Telefone" name="telefoneUsuario" value="<?php echo $telefoneUsuario; ?>" required>
                        <label for="telefoneUsuario">Telefone</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <input type="email" class="form-control" id="emailUsuario" placeholder="Email" name="emailUsuario" value="<?php echo $emailUsuario; ?>" readonly>
                        <label for="emailUsuario">Email</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mt-3 mb-3">
                        <input type="password" class="form-control" id="senhaUsuario" placeholder="Senha" name="senhaUsuario" required>
                        <label for="senhaUsuario">Senha</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-floating mt-3 mb-3">
                        <input type="password" class="form-control" id="confirmarSenhaUsuario" placeholder="Confirme a Senha" name="confirmarSenhaUsuario" required>
                        <label for="confirmarSenhaUsuario">Confirme a Senha</label>
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
                