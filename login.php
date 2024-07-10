<?php
    
    include("conexaoBD.php");
    session_start(); //Iniciar uma sessão

    $emailUsuario = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
    $senhaUsuario = mysqli_real_escape_string($conn, $_POST['senhaUsuario']);

    $buscarLogin = "SELECT *
                    FROM Usuarios
                    WHERE emailUsuario = '{$emailUsuario}'
                    AND senhaUsuario = md5('{$senhaUsuario}') ";

    $efetuarLogin = mysqli_query($conn, $buscarLogin);

    if($registro = mysqli_fetch_assoc($efetuarLogin)){
        $quantidadeLogin = mysqli_num_rows($efetuarLogin);
        $idUsuario       = $registro['idUsuario']; 
        $tipoUsuario     = $registro['tipoUsuario'];
        $fotoUsuario     = $registro['fotoUsuario'];  
        $emailUsuario    = $registro['emailUsuario']; 
        $nomeUsuario     = $registro['nomeUsuario'];

        $_SESSION['idUsuario']    = $idUsuario;
        $_SESSION['tipoUsuario']  = $tipoUsuario;
        $_SESSION['fotoUsuario']  = $fotoUsuario;
        $_SESSION['emailUsuario'] = $emailUsuario;
        $_SESSION['nomeUsuario']  = $nomeUsuario;

        $_SESSION['logado']       = true;
        $_SESSION['ultimoAcesso'] = time();

        header('location:index.php?pagina=index'); //Redireciona para a página formUsuario
    }
    elseif(empty($_POST['emailUsuario']) || empty($_POST['senhaUsuario']) || $quantidadeLogin == 0){
        header('location:formLogin.php?pagina=formLogin&erroLogin=dadosInvalidos');
    }

?>