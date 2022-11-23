<?php
include ("cabecalho.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>BuscaCEP</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/Bootstrap/css/bootstrap.min.css">
</head>

<body>
    <img class="fachada" src="img/mapa-fachada.jpg">
    <div id="linha"></div>
    <div class="container">
        <nav class="nav justify-content-center"> 
            <a class="nav-link titulo">CEPs Salvos</a>
        </nav>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">CEP</th>
                    <th scope="col" style="width: 60%">Logradouro</th>
                    <th scope="col">Complemento</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Localidade</th>
                    <th scope="col">UF</th>
                    <th scope="col">IBGE</th>
                    <th scope="col">GIA</th>
                    <th scope="col">DDD</th>
                    <th scope="col">SIAFI</th>
                    <th scope="col"></th>                            
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'banco.php';
                $pdo = Banco::conectar();
                $sql = 'SELECT * FROM ceps ORDER BY id ASC';

                foreach($pdo->query($sql)as $row)
                {
                    echo '<tr>';
                    echo '<th scope="row">'. $row['id'] . '</th>';
                    echo '<th scope="row">'. $row['cep'] . '</th>';
                    echo '<td>'. $row['logradouro'] . '</td>';
                    echo '<td>'. $row['complemento'] . '</td>';
                    echo '<td>'. $row['bairro'] . '</td>';
                    echo '<td>'. $row['localidade'] . '</td>';
                    echo '<td>'. $row['uf'] . '</td>';
                    echo '<td>'. $row['ibge'] . '</td>';
                    echo '<td>'. $row['gia'] . '</td>';
                    echo '<td>'. $row['ddd'] . '</td>';
                    echo '<td>'. $row['siafi'] . '</td>';
                    echo '<td width=250>';
                    echo '<a class="btn btn-dark" href="delete.php?id='.$row['id'].'">Excluir</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                Banco::desconectar();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
include ("rodape.php");
?>
