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
    <div id="linha" style="width: 70%;"> </div>


  <div class="container">
   <nav class="nav justify-content-center"> 
    <a class="nav-link titulo">CEPs Salvos</a>
  </nav>
      
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Logradouro</th>
                    <th scope="col">Horario de Funcionamento</th>                            
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
                    echo '<td>'. $row['logradouro'] . '</td>';
                    echo '<td width=250>';
                    echo '<a class="btn btn-secondary" href="read.php?id='.$row['id'].'">Info</a>';
                    echo ' ';
                    echo '<a class="btn btn-light" href="update.php?id='.$row['id'].'">Editar</a>';
                    echo ' ';
                    echo '<a class="btn btn-dark" href="delete.php?id='.$row['id'].'">Excluir</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                Banco::desconectar();
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    include ("rodape.php");
?>
