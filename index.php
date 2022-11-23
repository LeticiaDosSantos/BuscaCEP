<?php
include ("cabecalho.php");
require_once 'banco.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>BuscaCEP</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="assets/Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body style="background-image: url(img/mapa-fachada.jpg); background-size: 100%; background-repeat: no-repeat; 
background-attachment: relative;">
 
<div class="container conteudo-busca" style="width: 50%; opacity: 0.92">
	<div clas="span10 offset1">
		<div class="card buscar-cep">
			<div class="card-header">
				<nav class="nav justify-content-center"> 
					<a class="nav-link txt-buscar-cep">Informe o CEP desejado</a>
				</nav>
				
				<form  id="form" class="form-horizontal" method="post">
					<div class="input-group mb-3">
						<input type="text" minlength="8" maxlength="8" class="form-control" placeholder="01001000" id="cep" name="cep" >
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" id="buscar" onclick = "buscarCEP()" type="button">Buscar</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="alert alert-warning" id="retorno-false" hidden="true" role="alert">
			O CEP informado não possui ocorrências.
		</div>
		<div class="alert alert-danger" id="mensagem" hidden="true" role="alert">
			Formato de CEP inválido. Insira 8 números.
		</div>

		<div class="card" id="retorno-true" hidden="true">   
			<div class="card-body">
				<form class="form-horizontal" action="index" enctype="multipart/form-data" method="post">
					<div class="control-group input">
						<label class="control-label">CEP</label>
						<div class="controls">
							<input class="form-control" readonly="true" id="cep-form" name="cep-form" type="text">
						</div>
					</div>

					<div class="control-group input">
						<label class="control-label">Logradouro</label>
						<div class="controls">
							<input class="form-control" readonly="true" id="logradouro" name="logradouro" type="text" placeholder="Praça da Sé">
						</div>
					</div>

					<div class="input-group input">
						<label>Complemento</label>
						<label class="titulo-localidade" style="margin-left: 36%">Bairro</label>
					</div>
					<div class="input-group input">
						<input type="text" class="form-control" placeholder="lado ímpar" readonly="true" id="complemento" name="complemento">
						<input type="text" class="form-control" placeholder="Sé" readonly="true" id="bairro" name="bairro">
					</div>

					<div class="input-group input">
						<label>Localidade</label>
						<label class="titulo-localidade" style="margin-left: 40%">UF</label>
					</div>
					<div class="input-group input">
						<input type="text" class="form-control" placeholder="São Paulo" readonly="true" id="localidade" name="localidade">
						<input type="text" class="form-control" placeholder="SP" readonly="true" id="uf" name="uf">
					</div>

					<div class="input-group input">
						<label>IBGE</label>
						<label class="titulo-localidade" style="margin-left: 46%">GIA</label>
					</div>
					<div class="input-group input">
						<input type="text" class="form-control" placeholder="3550308" readonly="true" id="ibge" name="ibge">
						<input type="text" class="form-control" placeholder="1004" readonly="true" id="gia" name="gia">
					</div>

					<div class="input-group input">
						<label>DDD</label>
						<label class="titulo-localidade" style="margin-left: 46%">SIAFI</label>
					</div>
					<div class="input-group input">
						<input type="text" class="form-control" placeholder="11" readonly="true" id="ddd" name="ddd">
						<input type="text" class="form-control" placeholder="7107" readonly="true" id="siafi" name="siafi">
					</div>

					<div class="form-actions">
						<a href="index" type="btn" class="btn btn-light">Voltar</a>
						<button type="submit" class="btn btn-success">Cadastrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<footer>
	<?php 
	include('rodape.php');
	?>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</footer>

</body>
</html>

<?php

	if(!empty($_POST)) {
		$cep =  preg_replace('/[^0-9]/', '', $_POST['cep-form']);
		$logradouro = $_POST['logradouro'];
		$complemento = $_POST['complemento'];
		$bairro = $_POST['bairro'];
		$localidade = $_POST['localidade'];
		$uf = $_POST['uf'];
		$ibge = $_POST['ibge'];
		$gia = $_POST['gia'];
		$ddd = $_POST['ddd'];
		$siafi = $_POST['siafi'];

		$pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql="SELECT COUNT(id) AS total, id FROM ceps WHERE cep='".$cep."'";
		foreach($pdo->query($sql)as $row) {
			$cadastrado = $row['total'] > 0 ? true : false;
			if($cadastrado)
				$id = $row['id'];
		}

		if($cadastrado)
			  $sql = "UPDATE ceps set cep=?, logradouro=?, complemento = ?, bairro = ?, localidade = ?, uf = ?, ibge = ?, gia = ?, ddd = ?, siafi = ? WHERE id = '".$id."'";
		else
			$sql = "INSERT INTO ceps (cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi) VALUES(?,?,?,?,?,?,?,?,?,?)";

		$q = $pdo->prepare($sql);

		$q->execute(array($cep, $logradouro, $complemento, $bairro, $localidade, $uf, $ibge, $gia, $ddd, $siafi));
		$last_id = $pdo->lastInsertId();

		if($last_id){
			echo '<div class="alert alert-success alerta" role="alert" style="position: fixed; right: 1%; top: 15%; margin-top: -2.5em;">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>CEP salvo com sucesso!</strong> As informações do endereço foram armazenadas!
						</div>';
			
		} else {
			echo '<div class="alert alert-warning alerta" role="alert" style="position: fixed; right: 1%; top: 15%; margin-top: -2.5em;">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>CEP já cadastrado!</strong> As informações do endereço foram atualizadas!
					</div>';
		}
		
		exit;
		Banco::desconectar();
		exit;
		header("Location: index");

	}
?>

<script type="text/javascript">

	var input = document.getElementById("cep");
	input.addEventListener("keypress", function(event) {
	  if (event.key === "Enter") {
	    event.preventDefault();
	    document.getElementById("buscar").click();
	  }
	});

	function buscarCEP() {
		var cep = document.getElementById('cep').value;
		if((cep.replace(/[^0-9]/g,'')).length != 8){
			document.getElementById("mensagem").hidden = false;
			document.getElementById("retorno-true").hidden = true;
			document.getElementById("retorno-false").hidden = true;
		} else {
			$.get( "https://viacep.com.br/ws/"+cep+"/json/", function( data ) {				
				if(data.erro == true){
					document.getElementById("mensagem").hidden = true;
					document.getElementById("retorno-true").hidden = true;
					document.getElementById("retorno-false").hidden = false;
				} else{
					document.getElementById("mensagem").hidden = true;
					document.getElementById("retorno-true").hidden = false;
					document.getElementById("retorno-false").hidden = true;

					document.getElementById('cep-form').value = data.cep;
					document.getElementById('logradouro').value = data.logradouro;
					document.getElementById('complemento').value = data.complemento;
					document.getElementById('bairro').value = data.bairro;
					document.getElementById('localidade').value = data.localidade;
					document.getElementById('uf').value = data.uf;
					document.getElementById('ibge').value = data.ibge;
					document.getElementById('gia').value = data.gia;
					document.getElementById('ddd').value = data.ddd;
					document.getElementById('siafi').value = data.siafi;
				}
			});
		}
		return;
	}

	window.setTimeout(function() {
	    $(".alerta").fadeTo(500, 0).slideUp(500, function(){
	        $(this).remove(); 
	    });
	}, 4000);

</script>
