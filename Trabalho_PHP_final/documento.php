<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        $op_lang = "";
        if (isset($_SESSION['lingua'])) {$op_lang = $_SESSION['lingua'];}
        else {$op_lang = "pt";} 
        $xml = simplexml_load_file("res/values/$op_lang/strings.xml") or die("Error: Cannot create object");
        if (isset($_POST['lang_opcao'])) {
            $op_lang = $_POST['lang_opcao'];
            $_SESSION['lingua'] = $op_lang;
            $xml = simplexml_load_file("res/values/$op_lang/strings.xml") or die("Error: Cannot create object");
        }
        $nomes = $xml->children();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else{
            $nomeuser = "";
			$emailuser = "";
			$fotouser = "images/sem-imagem.jpg";
			$telefoneuser = "";
			$moradauser = "";
			$paisuser = "";
			
			$nometeam = "N/A";
			$id_equipa = "N/A";
			$emailteam = "N/A";
			$fototeam = "images/sem-imagem.jpg";
			$telefoneteam = "N/A";
			$instituicaoteam = "N/A";
			$datateam = "N/A";
			$id_categoria = "N/A";
			$id_edicao = "N/A";
			$categoriateam = "N/A";
			$edition = "N/A";
			$dataedition = "N/A";
			$moradaedition = "N/A";
			$paisedition = "N/A";
			
                $sql = "select nome, email, foto, telefone, morada, pais from trabalho_php_rb.utilizador where id_utilizador = '".$_SESSION['id_user']."'";
                $result = $conn->query($sql);
                if ($result != null) {
                    if ($result->num_rows == 1) {
                        $registo = mysqli_fetch_array($result);
                        $nomeuser = utf8_encode($registo['nome']);
						$emailuser = utf8_encode($registo['email']);
						$telefoneuser = utf8_encode($registo['telefone']);
						$moradauser = utf8_encode($registo['morada']);
						$paisuser = utf8_encode($registo['pais']);
						(!empty($registo['foto'])) ? $fotouser = "data:".$registo['nome'].";base64,".base64_encode($registo['foto']): $fotouser = "images/sem-imagem.jpg";
                    }
                } else {
                echo "0 results";   
                }
				$sql = "select id_equipa from trabalho_php_rb.equipa_utilizador where id_utilizador = '".$_SESSION['id_user']."'";
				$result = $conn->query($sql);
				$registo = mysqli_fetch_array($result);
				$id_equipa = utf8_encode($registo['id_equipa']);
				//$id_equipa = mysqli_fetch_row($result)[0];
				
				$sql = "select nome, telefone_principal, email_principal, data_inscricao, instituicao, foto, id_categoria, id_edicao from trabalho_php_rb.equipa where id_equipa = '".$id_equipa."'";
				$result = $conn->query($sql);
				if ($result != null) {
                        $registo = mysqli_fetch_array($result);
                        $nometeam = utf8_encode($registo['nome']);
						$emailteam = utf8_encode($registo['email_principal']);
						$telefoneteam = utf8_encode($registo['telefone_principal']);
						$instituicaoteam = utf8_encode($registo['instituicao']);
						$datateam = utf8_encode($registo['data_inscricao']);
						$id_categoria = utf8_encode($registo['id_categoria']);
						$id_edicao = utf8_encode($registo['id_edicao']);
						(!empty($registo['foto'])) ? $fototeam = "data:".$registo['nome'].";base64,".base64_encode($registo['foto']): $fototeam = "images/sem-imagem.jpg";
				}
				$sql = "select nome from trabalho_php_rb.categoria_equipa where id_categoria = '".$id_categoria."'";
				$result = $conn->query($sql);
				if ($result != null) {
                        $registo = mysqli_fetch_array($result);
                        $categoriateam = utf8_encode($registo['nome']);
				}
				$sql = "select edicao, data_edicao, morada, pais from trabalho_php_rb.edicao where id_edicao = '".$id_edicao."'";
				$result = $conn->query($sql);
				if ($result != null) {
                        $registo = mysqli_fetch_array($result);
                        $edition = utf8_encode($registo['edicao']);
						$dataedition = utf8_encode($registo['data_edicao']);
						$moradaedition = utf8_encode($registo['morada']);
						$paisedition = utf8_encode($registo['pais']);
				}

            $conn->close();
        }
	require_once('mpdf60/mpdf.php');
	$mpdf = new mPDF();
        date_default_timezone_set('Europe/Lisbon');
        $data = date("d/m/Y");
        $mpdf->SVGcolors = "black";
        $html = '<body style="background-color:#eeeeff">';
        $html .= '<div style="width:100%;height:20px"></div>';
        $html .= '<div style="width:100%;height:10px"></div>';
        $html .= '<div style="width:100%;height:10px"></div>';
        $html .= '<div style="color:#000000; padding-top:-20px;"><h1 align="center">'.ucfirst($nomes->provainscricao).'</h1></div>';
        $html .= '<div style="line-height: 30px; text-align:justify; width:100%; padding-left:40px; padding-right:40px; margin-top:160px">';
        
		$html .= '<table align="center" style="margin-top:-50px">';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->fotoutilizador).':';
		$html .= '</td>';
		$html .= '<td align="center"><img width="100px" height="100px" style="border-style: outset; border-width: 4px" src="'.$fotouser.'"/>'/*.$fotouser*/;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->utilizador).':';
		$html .= '</td>';
		$html .= '<td align="center">'.$nomeuser;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->emailutilizador).':';
		$html .= '</td>';
		$html .= '<td align="center">'.$emailuser;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->telefoneutilizador).':';
		$html .= '</td>';
		$html .= '<td align="center">'.$telefoneuser;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->moradautilizador).':';
		$html .= '</td>';
		$html .= '<td align="center">'.$moradauser;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->pais).':';
		$html .= '</td>';
		$html .= '<td align="center">'.$paisuser;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td style="border-top:solid 1px black" align="center">'.ucfirst($nomes->equipaemqueestaregistado);
		$html .= '</td>';
		$html .= '<td style="border-top:solid 1px black" align="center">'.$nometeam;
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= '</td>';
		$html .= '<td align="center"><img width="100px" height="100px" style="border-style: outset; border-width: 4px" src="'.$fototeam.'"/>'/*.$fotouser*/;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->emailequipa);
		$html .= '</td>';
		$html .= '<td align="center">'.$emailteam;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->telefoneequipa);
		$html .= '</td>';
		$html .= '<td align="center">'.$telefoneteam;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->instituicao);
		$html .= '</td>';
		$html .= '<td align="center">'.$instituicaoteam;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->dataequipa);
		$html .= '</td>';
		$html .= '<td align="center">'.$datateam;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->categoriaequipa);
		$html .= '</td>';
		$html .= '<td align="center">'.$categoriateam;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td style="border-top:solid 1px black" align="center">'.ucfirst($nomes->edicao);
		$html .= '</td>';
		$html .= '<td style="border-top:solid 1px black" align="center">'.$edition;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->dataedicao);
		$html .= '</td>';
		$html .= '<td align="center">'.$dataedition;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->localedicao);
		$html .= '</td>';
		$html .= '<td align="center">'.$moradaedition;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td align="center">'.ucfirst($nomes->paisedicao);
		$html .= '</td>';
		$html .= '<td align="center">'.$paisedition;
		$html .= '</td>';
		$html .= '</tr>';
		
		$html .= '</table>';
        
		$html .= '</div>';
        $html.= '<div align="center" style="margin-top:80px"> '.ucfirst($nomes->certificadoRobo).': '.$nomes->certificado.'. </div>';
		$html.= '<div align="center"> '.ucfirst($nomes->datacertificado).': '.ucfirst($data).'. </div>';
        $html .= '</body>'; 
        $mpdf->WriteHTML($html);
	$mpdf->Output();
        ?>
    </body>
	<?php
		
	?>
</html>
