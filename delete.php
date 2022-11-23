<?php
include "cabecalho.php";
require_once 'banco.php';

$id = null;
if(!empty($_GET['id']))
{
    $id = $_GET['id'];
}
if(!empty($_POST))
{
    $id = $_POST['id'];
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `ceps` WHERE `id` = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Banco::desconectar();
    header("Location: buscar_ceps");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/Bootstrap/css/bootstrap.min.css">
    <title>Deletar CEP</title>
</head>

<body>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3 class="well">Excluir CEP</h3>
            </div>
            <form class="form-horizontal" action="delete." method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <div class="alert alert-danger"> Tem certeza que deseja excluir o cep?<br> Após a deleção não será possível recuperar os dados.
                </div>
                <div class="form actions">
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <a href="buscar_ceps" type="btn" class="btn btn-light">Não</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>