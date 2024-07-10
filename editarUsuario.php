<?php include("header.php") ?>

<?php
    //Área para declaração das variáveis
    $fotoUsuario = $nomeUsuario = $cidadeUsuario = $telefoneUsuario = $emailUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";
    $erroPreenchimento = false; //Essa variável será responsável por verificar se os campos foram devidamente preenchidos;

    if($_SERVER["REQUEST_METHOD"] == "POST"){ //Verifica o método de envio do FORM
        if(empty($_POST["nomeUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo<strong>NOME</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $nomeUsuario = testar_entrada($_POST["nomeUsuario"]);
            //A função preg_match define uma regra para aceitar apenas caracteres deste conjunto
            if (!preg_match("/^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇºª\' \']*$/", $nomeUsuario)){
                echo "<div class='alert alert-warning text-center'>Atenção! No campo <strong>NOME</strong> somente letras são permitidas!</div>";
                $erroPreenchimento = true;
            }
        }

        //Validação do campo CIDADE
        if(empty($_POST["cidadeUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>CIDADE</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $cidadeUsuario = testar_entrada($_POST["cidadeUsuario"]);
        }

        //Validação do campo TELEFONE
        if(empty($_POST["telefoneUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $telefoneUsuario = testar_entrada($_POST["telefoneUsuario"]);
        }

        //Validação do campo EMAIL
        if(empty($_POST["emailUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $emailUsuario = testar_entrada($_POST["emailUsuario"]);
        }

        //Validação do campo SENHA
        if(empty($_POST["senhaUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            //Aplica a função md5 para criptografar a senha (e também a confirmação de senha)
            $senhaUsuario = md5(testar_entrada($_POST["senhaUsuario"]));
        }

        //Validação do campo CONFIRMAR SENHA
        if(empty($_POST["confirmarSenhaUsuario"])){
            echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        }
        else{
            $confirmarSenhaUsuario = md5(testar_entrada($_POST["confirmarSenhaUsuario"]));
            if($senhaUsuario != $confirmarSenhaUsuario){
                echo "<div class='alert alert-warning text-center'>Atenção! <strong>SENHAS DIFERENTES</strong>!</div>";
                $erroPreenchimento = true;
            }
        }

        $diretorio    = "img/"; //Define para qual diretório do sistema as imagens serão movidas
        $fotoUsuario  = $diretorio . basename($_FILES["fotoUsuario"]["name"]); //img/Usuario.png
        $erroUpload   = false; //Variável criada para verificar se houve sucesso no upload do arquivo
        $tipoDaImagem = strtolower(pathinfo($fotoUsuario, PATHINFO_EXTENSION)); //Pegar o tipo do arquivo

        //Validação da atualização da Foto. IMPORTANTE!
        if ($_FILES['fotoUsuario']['size'] != 0){ //Verifica se houve o upload de algum novo arquivo de foto
            //Verificar o tamanho do arquivo
            if($_FILES["fotoUsuario"]["size"] > 5000000) { //Verifica o tamanho em BYTES
                echo "<div class='alert alert-warning text-center'>Atenção! A foto ultrapassa o <strong>TAMANHO MÁXIMO</strong> permitido (5MB)!</div>";
                $erroUpload = true;
            }

            //Verificar o tipo do arquivo (Pela extensão)
            if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                echo "<div class='alert alert-warning text-center'>Atenção! A foto precisa estar nos formatos <strong>JPG, JPEG, PNG ou WEBP</strong>!</div>";
                $erroUpload = true;
            }

            if($erroUpload){
                echo "<div class='alert alert-warning text-center'>Erro ao tentar fazer o <strong>UPLOAD DA FOTO</strong> $fotoUsuario!</div>";
                $erroUpload = true;
            }
            else{
                //A função seguinte é responsável por mover o arquivo para o diretório definido
                if(!move_uploaded_file($_FILES["fotoUsuario"]["tmp_name"], $fotoUsuario)){
                    echo "<div class='alert alert-warning text-center'>Erro ao tentar mover 
                        <strong>A FOTO</strong> para o diretório $diretorio!</div>";
                    $erroUpload = true;
                }
            }
        }else {
            $fotoUsuario = $_POST["fotoAtual"];
            $erroUpload  = false;
        }

        //Se estiver tudo certo
        if(!$erroPreenchimento && !$erroUpload){

            //Cria uma Query responsável por realizar a inserção dos dados no BD
            $editarUsuario = "UPDATE Usuarios
                              SET
                                fotoUsuario           = '$fotoUsuario',
                                nomeUsuario           = '$nomeUsuario',
                                cidadeUsuario         = '$cidadeUsuario',
                                emailUsuario          = '$emailUsuario',
                                telefoneUsuario       = '$telefoneUsuario',
                                senhaUsuario          = '$senhaUsuario',
                                statusUsuario         = 'ativo'
                              WHERE idUsuario = $idUsuario";

            include("conexaoBD.php");

            //Função para executar QUERYs no Banco de Dados
            if(mysqli_query($conn, $editarUsuario)){

                echo "<div class='alert alert-success text-center'>Os dados foram editados com sucesso! <i class='bi bi-emoji-smile'></i></div></div>";

                echo "<div class='container mt-3'>
                        <div class='container mt-3 text-center'>
                            <img src='$fotoUsuario' width='150'>
                        </div>
                        <div class='table-responsive'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeUsuario</td>
                                </tr>
                                <tr>
                                    <th>CIDADE</th>
                                    <td>$cidadeUsuario</td>
                                </tr>
                                <tr>
                                    <th>TELEFONE</th>
                                    <td>$telefoneUsuario</td>
                                </tr>
                                <tr>
                                    <th>EMAIL</th>
                                    <td>$emailUsuario</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                ";
                //Atualiza a foto da sessão
                $_SESSION["fotoUsuario"] = $fotoUsuario;
            }
            else{
                echo "<div class='alert alert-danger'>Erro ao tentar editar dados de <strong>Usuário(a)</strong>!</div>" . mysqli_error($link);
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