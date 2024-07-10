<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>
            <?php
                //Código para deixar o title da página dinâmico

                if(isset($_GET["pagina"])){
                    $pagina = $_GET['pagina']; //Pega o nome da página via GET

                    switch($pagina){
                        case "index"                 : echo "Produtos"; break;
                        case "formUsuario"           : echo "Cadastrar Usuário"; break;
                        case "formProduto"           : echo "Cadastrar Produto"; break;
                        case "formLogin"             : echo "Login"; break;

                        default                      : echo "Genérico - Sistema de Vendas para Lojas"; break;
                    }
                }
                else{
                    $pagina = "index";
                    echo "Genérico - Sistema de Vendas para Lojas";
                }
            ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Adicionar esta versão de compilado css do w3schools -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <!-- CDN para importar os ícones Google Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- CDN para importar os ícones do Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

        <!-- CDNs para importar JQUERY e Máscaras -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        
        <!-- CDN para valores em Dinheiro -->
        <script src="https://cdn.jsdelivr.net/gh/plentz/jquery-maskmoney@master/dist/jquery.maskMoney.min.js"></script>

        <!-- Script para Máscaras do Formulário -->
        <script>
            $(document).ready(function(){
                $("#cpfUsuario").mask("000.000.000-00");
                $("#telefoneUsuario").mask("(00) 00000-0000");
                $("#valorProduto").maskMoney({
                    //prefix: "R$ ",
                    decimal: ",",
                    thousands: "."
                });
            });
        </script>

        <?php
            date_default_timezone_set('America/Sao_Paulo');
        ?>

        <style>
            .max-height {
                max-height: 37px; /* Defina a altura máxima desejada */
                width: auto; /* Para manter a proporção original da imagem */
                display: block; /* Para centralizar a imagem horizontalmente na div */
                margin: 0 auto; /* Para centralizar a imagem horizontalmente na div */
            }
        </style>
    </head>
    <body>

        <div class="p-5 bg-warning text-white text-center">
            <a href="index.php?pagina=index">
                <img src="img/ifpr_logo.png" class="img-fluid" width="50" title="Retornar para Página Inicial">
            </a>
            <h1>Genérico - Sistema de Vendas para Lojas</h1>
        </div>

        <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <?php
                            //Habilitar reportagem de erros de execução simples
                            error_reporting(0);
                            session_start();
                            $idUsuario    = $_SESSION["idUsuario"];
                            $tipoUsuario  = $_SESSION["tipoUsuario"];
                            $fotoUsuario  = $_SESSION["fotoUsuario"];
                            $nomeUsuario  = $_SESSION["nomeUsuario"];

                            $nomeCompleto = explode(' ', $nomeUsuario);
                            $primeiroNome = $nomeCompleto[0];

                            $emailUsuario = $_SESSION["emailUsuario"];
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($pagina == 'index'){echo 'active';} ?>" href="index.php?pagina=index">Home</a>
                        </li>
                        <?php
                            //Se o usuário for administrador, exibe o link para cadastrar produto.
                            if($tipoUsuario == 'administrador'){
                                echo"
                                <li class='nav-item'>
                                    <a class='nav-link "; if($pagina == 'formProduto'){echo 'active';} echo"' href='formProduto.php?pagina=formProduto'>Cadastrar Produto</a>
                                </li>";
                            }
                        ?>
                    </ul>
                </div>
                <?php
                    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){ //Verifica de há sessão iniciada
                        echo "
                        <ul class='navbar-nav'>
                            <li>
                                <div class='container'>
                                    <img src='$fotoUsuario' class='img-fluid max-height rounded' title='Esta é a sua foto de perfil, $primeiroNome!'>
                                </div>
                            </li>
                            <li class='nav-item dropdown'>
                                <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' style='color: "; if($tipoUsuario == "administrador"){ echo "red'";} else{ echo "yellow'";} echo "><strong>$emailUsuario</strong></a>
                                <ul class='dropdown-menu'>
                                    <li><a class='dropdown-item' href='visualizarPerfil.php?pagina=formLogin&idUsuario=$idUsuario' title='Visualizar Perfil'>Meu Perfil</a></li>";
                                    if ($tipoUsuario == 'administrador'){ echo"
                                        <li><a class='dropdown-item' href='meusProdutos.php?pagina=formProduto&idUsuario=$idUsuario'>Meus Produtos</a></li>";
                                    }else{
                                        echo"
                                        <li><a class='dropdown-item' href='meusPedidos.php?pagina=formProduto&idUsuario=$idUsuario'>Meus Pedidos</a></li>";
                                    }
                                    echo
                                    "<li><a class='dropdown-item' href='logout.php?pagina=formLogin' title='Sair do Sistema'>Logout</a></li>
                                </ul>
                            </li>
                        </ul>";
                    }else{
                        echo "
                        <ul class='navbar-nav'>";
                            if(($pagina == 'formLogin') || ($pagina == 'formUsuario')){
                                echo"<a class='nav-link active' href='formLogin.php?pagina=formLogin' title='Acessar o Sistema'>Login</a>";
                            }
                            else{
                                echo"<a class='nav-link' href='formLogin.php?pagina=formLogin' title='Acessar o Sistema'>Login</a>";
                            }
                        echo "</ul>";
                    }
                ?>
            </div>
        </nav>

        <div class="container mt-5">
            <div class="row">
                <div class="col-12">