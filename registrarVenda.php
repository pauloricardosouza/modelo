<?php include("validarSessao.php"); ?>
<?php include("header.php"); ?>

<?php
    // Verificar se há algum parâmetro sendo recebido por GET
    if(isset($_GET["idProduto"])){
        $idProduto = $_GET["idProduto"];

        include("conexaoBD.php");

        $registrarVenda = "UPDATE Produtos
                               SET statusProduto = 'vendido'
                               WHERE idProduto = $idProduto";

        if (mysqli_query($conn, $registrarVenda)){
            echo "<div class='alert alert-success text-center'>O <strong>Produto</strong> foi marcado como vendido!</div>";
        }
        else{
            echo "<div class='alert alert-danger text-center'>Ocorreu um erro ao tentar marcar <strong>Produto</strong>! como vendido! =(</div>" . mysqli_error($conn);
        }
    }
?>

<?php include("footer.php"); ?>