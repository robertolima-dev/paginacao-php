<?php 

include 'header.php'; 
include 'controller/Paginacao.php'; 

?>

<body>
	<div class="container">

		<?php echo $paginacao->paginacaoAlunos( (!empty($_GET['pag'])) ? $_GET['pag'] : 1 ) ?>

	</div>
</body>

<?php include 'footer.php'; ?>