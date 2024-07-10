<?php

    session_start(); //Inicia uma sessão

    // Definir o tempo limite da sessão para 10 minutos (em segundos)
    $inatividade = 600; // 10 minutos

    if(!isset($_SESSION['logado']) || $_SESSION['logado'] === false){ //Verifica de há sessão iniciada
        header('location:formLogin.php?pagina=formLogin&erroLogin=naoLogado');
    }else{
        $tipoUsuario = $_SESSION['tipoUsuario'];
        if(($_SESSION['tipoUsuario'] != "administrador")){
            header('location:formLogin.php?pagina=formLogin&erroLogin=acessoProibido');
        }
    }

    // Verificar se a última atividade da sessão está definida
   /* if(isset($_SESSION['ultimoAcesso']) && (time() - $_SESSION['ultimoAcesso'] > $inactive)) {
        // A sessão expirou, destruir a sessão e redirecionar para a página de login
        session_unset();     // unset $_SESSION
        session_destroy();   // destruir a sessão
        header("Location: formlogin.php?pagina=formLogin&erroLogin=timeOut"); // Redireciona para a página de login
        exit;
    }*/

    // Atualize o tempo de último acesso
    $_SESSION['ultimoAcesso'] = time();

?>
