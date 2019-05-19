<?php

class Paginacao
{
	public function paginacaoAlunos($paginacao) {

		try {

			include 'conexao.php';

			$query = "SELECT COUNT(id_aluno) FROM tb_alunos";

			$stmt = $conexao->query($query);
			$AlunosCount = $stmt->FetchAll(PDO::FETCH_ASSOC);

			$totalAlunos = $AlunosCount[0]['COUNT(id_aluno)'];

			$html = '';
			$limite = 10;
			$inicio = ($limite * $paginacao) - $limite;
			$ultimaPagina = ceil($totalAlunos / $limite);
			$adjacente = 2;

			$html .= '<div class="painel-body col-12 mt-5 mb-5">';

			$html .= '<table class="table table-striped">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>Nome</th>';
			$html .= '<th>Idade</th>';
			$html .= '<th>Interesse</th>';
			$html .= '<th>E-mail</th>';
			$html .= '<th>Estado</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			$query = "SELECT * FROM tb_alunos LIMIT :inicio, :limite";

			$stmt = $conexao->prepare($query);
			$alunosLimite = $stmt;
			$alunosLimite->bindParam(':inicio', $inicio, PDO::PARAM_INT);
			$alunosLimite->bindParam(':limite', $limite, PDO::PARAM_INT);
			$alunosLimite->execute();

			foreach($alunosLimite as $alunoLimite) {

				$nome = $alunoLimite['nome'];
				$idade = $alunoLimite['idade'];
				$interesse = $alunoLimite['interesse'];
				$email = $alunoLimite['email'];
				$estado = $alunoLimite['estado'];

				$html .= '<tr>';
				$html .= '<td>'.$nome.'</td>';
				$html .= '<td>'.$idade.'</td>';
				$html .= '<td>'.$interesse.'</td>';
				$html .= '<td>'.$email.'</td>';
				$html .= '<td>'.$estado.'</td>';
				$html .= '</tr>';

				
			}
			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '</div>';


			$html .= '<div class="painel-footer altr col-12  mb-5>';

			$html .= '<div style="z-index:0;">';

			$a = null;

			if($ultimaPagina <= 5) {
				$html .= '<ul class="pagination" style="justify-content: center;>';
				for($a = 1; $a < $ultimaPagina + 1; $a++) {
					if($a == $paginacao){
						$html .= '<li class="page-item active"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
					} else {
						$html .= '<li class="page-item"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
					}
				}
				$html .= '</ul>';

			} else {

				if($paginacao < 1 + (2 * $adjacente)) {
					$html .= '<ul class="pagination" style="justify-content: center;>';
					for($a = 1; $a < 2 + (2 * $adjacente); $a++) {
						if($a == $paginacao){
							$html .= '<li class="page-item active"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						} else {
							$html .= '<li class="page-item"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						}
					}
					$html .= '</ul>';

				} else if($paginacao > (2 * $adjacente) && $paginacao < $ultimaPagina - 3) {
					$html .= '<ul class="pagination" style="justify-content: center;>';
					for($a = $paginacao - $adjacente; $a <= $paginacao + $adjacente; $a++) {
						if($a == $paginacao){
							$html .= '<li class="page-item active"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						} else {
							$html .= '<li class="page-item"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						}
					}
					$html .= '</ul>';

				} else {
					$html .= '<ul class="pagination" style="justify-content: center;>';
					for($a = $ultimaPagina - (2 + $adjacente); $a <= $ultimaPagina; $a++) {
						if($a == $paginacao){
							$html .= '<li class="page-item active"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						} else {
							$html .= '<li class="page-item"><a class="page-link" href="index?pag='.$a.'">'.$a.'</a></li>';
						}
					}
					$html .= '</ul>';
				}

			}

			$html .= '</div>';

			return $html;

		} catch(PDOExcetion $ex) {
			return 'Error: '.$ex->getMessage();
		}
	}
}

$paginacao = new Paginacao();