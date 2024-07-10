<?php include("header.php"); ?>

<div class="container-fluid text-center">

    <?php
        if (isset($_GET["erroLogin"])){
            $erroLogin = $_GET["erroLogin"];
            if ($erroLogin == "dadosInvalidos"){
                echo "<div class='alert alert-danger text-center' style='text-align:center';><strong>USUÁRIO</strong> ou <strong>SENHA</strong> inválidos!</div>";
            }
            if ($erroLogin == "naoLogado"){
                echo "<div class='alert alert-danger text-center' style='text-align:center';><strong>USUÁRIO</strong> não logado!</div>";
            }
            if ($erroLogin == "acessoProibido"){
                echo "<div class='alert alert-danger text-center' style='text-align:center';>Você precisa logar como <strong>administrador</strong> para acessar essa página!</div>";
            }
            if ($erroLogin == "timeOut"){
                echo "<div class='alert alert-danger text-center' style='text-align:center';>Você ficou inativo por mais de 5 minutos e foi <strong>desconectado</strong> do sistema!</div>";
            }
        }
    ?>

    <h2>Acessar o Sistema:</h2>
    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <form action="login.php" method="POST" class="was-validated">
                    <div class="form-floating mb-3 mt-3">
                        <input type="email" class="form-control" id="emailUsuario" placeholder="Email" name="emailUsuario" required>
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
                    <button type="submit" class="btn btn-success">Login</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <p>
    Ainda não possui cadastro? <a href="formUsuario.php?pagina=formUsuario" title="Cadastrar-se">Clique aqui!</a>&nbsp<i class="bi bi-emoji-smile"></i>
    </p>

</div>
                    
<?php include("footer.php"); ?>
                