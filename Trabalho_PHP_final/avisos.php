<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="visual/visual.css">
    <link rel="stylesheet" type="text/css" href="visual/bootstrap.min.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
	<title></title>
</head>
 	<?php
    $op1 = "";
    $login = "";  
    $op_lang = "";
    $servername = "localhost";
    $username = "root";
    $password = "";
    if (isset($_SESSION['lingua'])) {$op_lang = $_SESSION['lingua'];}
    else {$op_lang = "pt";} 
    $xml = simplexml_load_file("res/values/$op_lang/strings.xml") or die("Error: Cannot create object");
    if (isset($_SESSION['utilizador'])){
        $utilizador = $_SESSION['utilizador'];
        $login = 'Logout';
        $loginp = 'logout.php';
        $op1 = 'loginrealizado';
    } else {
        $utilizador = "";
        $login = 'Login';
        $loginp = 'login.php';
        $registo = 'Registar';
        $registop = 'registo.php';
        $op1 = "";
    }
    if (isset($_SESSION['lingua'])) {$op_lang = $_SESSION['lingua'];}
    else {$op_lang = "pt";} 
    $xml = simplexml_load_file("res/values/$op_lang/strings.xml") or die("Error: Cannot create object");
    if (isset($_POST['lang_opcao'])) {
        $op_lang = $_POST['lang_opcao'];
        $_SESSION['lingua'] = $op_lang;
        $xml = simplexml_load_file("res/values/$op_lang/strings.xml") or die("Error: Cannot create object");
    }
    $nomes = $xml->children();
    ?>
<body>
	<div style="width:595px; height:842px; border:solid 2px #000000; margin-left:auto; margin-right:auto">
    	<div style="float:left">
        	<table style="width: 100%;min-width: 500px">
                <tr>
                    <td style="">
                        <img width="24px" height="24px" src="images/<?php echo $op_lang;?>/bandeira.png"/>
                    </td>
                    <td id=" tlingua" style="padding-right: 300px">
                        <form name="linguaform" action="avisos.php" method="POST">
                            <select name = "lang_opcao" id="lang_opcao" onchange="linguaform.submit()">
                                <?php 
                                    $valores = array('pt','en');
                                    $tamanho = count($valores);
                                    if ( $_SESSION['lingua'] != null) {
                                        for ($i = 0; $i < $tamanho; $i++){
                                            if ($valores[$i] === $op_lang) {
                                                ?>
                                                <option value="<?php echo $valores[$i];?>" > <?php echo $valores[$i];?> </option>
                                                <?php
                                            } 
                                        }
                                        for ($i = 0; $i < $tamanho; $i++){
                                            if ($valores[$i] != $op_lang) {
                                                ?>
                                                <option value="<?php echo $valores[$i];?>" > <?php echo $valores[$i];?> </option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        for ($i = 0; $i < $tamanho; $i++){
                                                ?>
                                                <option value="<?php echo $valores[$i];?>" > <?php echo $valores[$i];?> </option>
                                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    	<div style="background-image:url(images/robo_bomb.png); height:61px; width:488px; float:left"/>
        <div style="background-image:url(images/ipg.png); height:67px; width:66px; float:right; margin-right:-100px;"/>
        <div style="float:left; margin-left:-520px;margin-top:70px">
        	<?php 
				echo $nomes -> informacao;
            ?>
        </div>
		
        <div style="border-radius: 5px; height: 100%; margin-left:-500px; margin-top:100px;">
            <ul class="nav nav-tabs" style="font-size:13px">
                    <li>
                        <a href="index.php"><?php echo $nomes->paginainicial?></a>
                    </li>
                    <?php
                    if ($op1 != "") { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="background-color: #aaa; outline: none; cursor: pointer"><?php if (isset($_SESSION['utilizador'])) {echo "<b>".$nomes->opcoes. ":&nbsp;</b>".$utilizador; } else { }?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="width: 99%">
                            <?php if (isset($_SESSION['id_user'])){ 
                            ?>
                            <li class="active"><a href="participante.php"><?php echo $nomes->participante;?></a></li>
							<li><a href="equipaParticipante.php"><?php echo $nomes->equipaParticipante;?></a></li>
                            <li><a href="#"><?php echo $nomes->documentos;?></a></li> 
                            <?php } else {
                            header("Location: logout.php");
                            } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $loginp; ?>"><?php echo $login; ?></a>
                    </li>
                    <?php
                    if ($op1 == "") {
                        $registo = $nomes->registo;
                        echo "<li><a href='$registop'> $registo</a></li>";
                    }
                    ?>
					<li>
					<a href="equipa.php"><?php echo $nomes->equipa;?></a>
					</li>
                    <li>
                        <a href="estatistica.php"><?php echo $nomes->estatistica; ?></a>
                    </li>
                </ul>
        </div>
		
		<div style="border-radius: 5px; height: 100%; margin-left:-400px; margin-top:50px;">
			<?php
				$servername = "localhost";
				$username = "root";
				$password = "";
				$conn = new mysqli($servername, $username, $password);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} else{
					$opcao = "";
					$nome = "";
					$email = "";
					$telefone = "";
					$morada = "";
					$foto;
					$utilizador = "";
					$pass = "";
					$pais = "";
					$categoria = "";
					$id_categoria = "";
					$data = date('y-m-d');
					$equipa = "";
					$id_equipa = "";
					$estado = "";
					if (isset($_REQUEST['local'])) {
					$opcao = $_REQUEST['local'];
					if ($opcao === "registoutilizador") {
						if (isset($_REQUEST["nomeutilizador"])) $nome = $_REQUEST["nomeutilizador"];
						if (isset($_REQUEST["emailutilizador"])) $email = $_REQUEST["emailutilizador"];
						if (isset($_REQUEST["telefoneutilizador"])) $telefone = $_REQUEST["telefoneutilizador"];
						if (isset($_REQUEST["moradautilizador"])) $morada = $_REQUEST["moradautilizador"];
						if (isset($_REQUEST["utilizador"])) $utilizador = $_REQUEST["utilizador"];
						if (isset($_REQUEST["senha"])) $pass = $_REQUEST["senha"];
						if (isset($_REQUEST["pais"])) $pais = $_REQUEST["pais"];
                    
					if (isset($_FILES["foto"])) {
                        $foto = $_FILES["foto"];
                        $fotoname = $_FILES["foto"]["name"];
                        $fototype = $_FILES["foto"]["type"];
                        $fotosize = $_FILES["foto"]["size"] / 1024;
                    }
					$sql = "select id_utilizador from trabalho_php_rb.utilizador where username = '".$utilizador."'";
                    $result = $conn->query($sql);
					if ($result->num_rows == 0) {
                        if (!empty($foto)and($fotoname != "")) {
                            $error = false;
                            if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fototype)){
                                $error = true;
                            } 
                            if ($fotosize > 2048) {
                                $error = true;
                            }
                            if (!$error) {
                                $sql2 = mysqli_query($conn,"INSERT INTO trabalho_php_rb.utilizador (nome, email, foto, password, telefone, morada, username, pais) values ('".utf8_decode($nome)."', '".$email."', '".addslashes(file_get_contents($_FILES['foto']['tmp_name']))."','".$pass."','".$telefone."','".utf8_decode($morada)."','".$utilizador."','".$pais."')");
                            }
                            if (!empty($sql2))  { 
                                echo $nomes->registocorreto;
                                require_once("PHPMailer/PHPMailerAutoload.php");
                                $mail = new PHPMailer();
                                $mail->isSMTP();
                                $mail->Host = "smtp.live.com";
                                $mail->SMTPAuth = true;
                                $mail->Username = "pinpanpufu@hotmail.com";
                                $mail->Password = 'Mosquitub1';
                                $mail->From = "pinpanpufu@hotmail.com";
                                $mail->FromName = utf8_decode("Pufu em PHP");
                                $mail->addAddress($email);
                                //$mail->isHTML(true);
                                $mail->Subject = utf8_decode($nomes->subjectregisto);
                                $mail->Body = utf8_decode("$nomes->messageemailregisto\n$nomes->utilizador: $utilizador\n$nomes->pass: $pass");
                                $enviado = $mail->send();
								$nome = $xml->registocorreto;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "index.php";';
								echo '</script>';
                            } else {
                                echo $nomes->registoincorretoimagem;
                                //$situa = "registo.php";
								$nome = $xml->registoincorretoimagem;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "registo.php";';
								echo '</script>';
                            }
                        } else { 
                            if (!empty($nome) and !empty($email) and !empty($telefone) and !empty($morada)and !empty($pass) and !empty($utilizador)) {
                                $sql2 = mysqli_query($conn,"INSERT INTO trabalho_php_rb.utilizador (nome, email, password, telefone, morada, username, pais) values ('". utf8_decode($nome)."', '".$email."','".$pass."','".$telefone."','".utf8_decode($morada)."','".$utilizador."','".$pais."')");
                            }
                            if (!empty($sql2))  { 
                                echo $nomes->registocorreto;
                                require_once("PHPMailer/PHPMailerAutoload.php");
                                $mail = new PHPMailer();
                                $mail->isSMTP();
                                //$mail->Port = "578";
                                $mail->Host = "smtp.live.com";
                                $mail->SMTPAuth = true;
                                $mail->Username = "pinpanpufu@hotmail.com";
                                $mail->Password = 'Mosquitub1';
                                $mail->From = "pinpanpufu@hotmail.com";
                                $mail->FromName = utf8_decode("Pufu em PHP");
                                $mail->addAddress($email);
                                //$mail->isHTML(true);
                                $mail->Subject = $nomes->subjectregisto;
                                $mail->Body = "$nomes->messageemailregisto\n$nomes->utilizador: $utilizador\n$nomes->pass: $pass";
                                $enviado = $mail->send();
								$nome = $xml->registocorreto;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "index.php";';
								echo '</script>';
                            } else {
                                echo $nomes->registoincorreto;
                                //$situa = "registo.php";
								$nome = $xml->registoincorreto;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "registo.php";';
								echo '</script>';
                            }
                        }
                    } else {
                        echo $nomes->utilizadorrepetido;
                        //$situa = "registo.php";
						$nome = $xml->utilizadorrepetido;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "registo.php";';
						echo '</script>';
						}
					} elseif ($opcao === "editarutilizador") {
						if (isset($_REQUEST["nomeutilizador"])) $nome = $_REQUEST["nomeutilizador"];
						if (isset($_REQUEST["emailutilizador"])) $email = $_REQUEST["emailutilizador"];
						if (isset($_REQUEST["telefoneutilizador"])) $telefone = $_REQUEST["telefoneutilizador"];
						if (isset($_REQUEST["moradautilizador"])) $morada = $_REQUEST["moradautilizador"];
						if (isset($_REQUEST["utilizador"])) $utilizador = $_REQUEST["utilizador"];
						if (isset($_REQUEST["senha"])) $pass = $_REQUEST["senha"];
						if (isset($_FILES["foto"])) {
							$foto = $_FILES["foto"];
							$fotoname = $_FILES["foto"]["name"];
							$fototype = $_FILES["foto"]["type"];
							$fotosize = $_FILES["foto"]["size"] / 1024;
                    }
					$sql = "select id_utilizador from trabalho_php_rb.utilizador where username = '".$utilizador."'";
                    $result = $conn->query($sql);
                    $f = mysqli_fetch_array($result);
					if (($result->num_rows === 0) || ($f['id_utilizador'] === $_SESSION['id_user'])) {
                        if (!($fotoname === "")) {
                            $error = false;
                            if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fototype)){
                                $error = true;
                            } 
                            if ($fotosize > 2048) {
                                $error = true;
                            }
                            if (!$error) {
                                $sql2 = mysqli_query($conn,"update trabalho_php_rb.utilizador set nome ='".utf8_decode($nome)."', email = '".$email."', foto = '".addslashes(file_get_contents($_FILES['foto']['tmp_name']))."', password = '".$pass."', telefone = '".$telefone."', morada = '".utf8_decode($morada)."', username = '".$utilizador."' where id_utilizador = '".$_SESSION['id_user']."'");
                            }
                            if (!empty($sql2))  { 
                                echo $nomes->atualizacaocorreta;
								$nome = $xml->atualizacaocorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "participante.php";';
								echo '</script>';
                            } else {
                                echo $nomes->atualizaoincorretaimagem;
								$nome = $xml->atualizaoincorretaimagem;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "participante.php";';
								echo '</script>';
                            }
                        } else { 
                            if (!empty($nome) and !empty($email) and !empty($telefone) and !empty($morada)and !empty($pass) and !empty($utilizador)) {
                                $sql2 = mysqli_query($conn,"update trabalho_php_rb.utilizador set nome ='".utf8_decode($nome)."', email = '".$email."', password = '".$pass."', telefone = '".$telefone."', morada = '".utf8_decode($morada)."', username = '".$utilizador."' where id_utilizador = '".$_SESSION['id_user']."'");
                            }
                            if (!empty($sql2))  { 
                                echo $nomes->atualizacaocorreta;
                                $_SESSION['utilizador'] = $nome;
								$nome = $xml->atualizacaocorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "participante.php";';
								echo '</script>';
                            } else {
                                echo $nomes->atualizacaoincorreta;
                                $nome = $xml->atualizacaoincorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "participante.php";';
								echo '</script>';
                            }
                        }
					} else {
                        echo $nomes->repetido;
                        $nome = $xml->repetido;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "participante.php";';
						echo '</script>';
                    }				
				
				} elseif ($opcao === "eliminarutilizador") {
				
					if (isset($_REQUEST["utilizador"])) $utilizador = $_REQUEST["utilizador"];
					
					$sql = "delete from trabalho_php_rb.utilizador where username = '".$utilizador."'";
					if ($conn->query($sql) === TRUE) {
						//echo $nomes->utilizadoreliminado;
						$conn->close();
						$nome = $xml->utilizadoreliminado;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "index.php";';
						echo '</script>';
						unset($_SESSION['utilizador']);
						unset($_SESSION['id_user']);
						//header("Location: index.php");
					} else {
						$nome = $xml->utilizadornaoeliminado;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "participante.php";';
						echo '</script>';
					}
					
				}
				
				/*Registo de nova equipa********************************************************************/
				
				elseif ($opcao === "registoequipa") {
						if (isset($_REQUEST["nomeequipa"])) $nome = $_REQUEST["nomeequipa"];
						if (isset($_REQUEST["emailequipa"])) $email = $_REQUEST["emailequipa"];
						if (isset($_REQUEST["telefoneequipa"])) $telefone = $_REQUEST["telefoneequipa"];
						if (isset($_REQUEST["instituicao"])) $morada = $_REQUEST["instituicao"];
						if (isset($_POST['formCat'])) $categoria = $_POST['formCat'];

                    
					if (isset($_FILES["foto"])) {
                        $foto = $_FILES["foto"];
                        $fotoname = $_FILES["foto"]["name"];
                        $fototype = $_FILES["foto"]["type"];
                        $fotosize = $_FILES["foto"]["size"] / 1024;
                    }
					
					$sql = "select id_equipa from trabalho_php_rb.equipa where nome = '".$nome."'";
					$sql_id = "select id_categoria from trabalho_php_rb.categoria_equipa where nome = '".utf8_decode($categoria)."'";
                    $result = $conn->query($sql);
					$stmt = $conn->query($sql_id);
					$id_categoria = $stmt->fetch_row()[0];
					if ($result->num_rows == 0) {
                        if (!empty($foto)and($fotoname != "")) {
                            $error = false;
                            if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fototype)){
                                $error = true;
                            } 
                            if ($fotosize > 2048) {
                                $error = true;
                            }
                            if (!$error) {
                                $sql2 = mysqli_query($conn,
								"INSERT INTO trabalho_php_rb.equipa (nome, telefone_principal, email_principal, data_inscricao, instituicao, foto, id_categoria, id_edicao) 
								values ('".utf8_decode($nome)."', '".$telefone."', '".$email."', '".$data."', '".$morada."', '".addslashes(file_get_contents($_FILES['foto']['tmp_name']))."','".$id_categoria."', 1)");
                            }
                            if (!empty($sql2))  { 
                                echo $nomes->registocorretoequipa;
								$nome = $xml->registocorretoequipa;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "index.php";';
								echo '</script>';
                            } else {
                                echo $nomes->registoincorretoimagem;
								$nome = $xml->registoincorretoimagem;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipa.php";';
								echo '</script>';
                            }
                        }else{
							if (!empty($nome) and !empty($email) and !empty($telefone) and !empty($morada)and !empty($id_categoria)) {
                                $sql2 = mysqli_query($conn,
								"INSERT INTO trabalho_php_rb.equipa (nome, telefone_principal, email_principal, data_inscricao, instituicao, id_categoria, id_edicao) 
								values ('".utf8_decode($nome)."', '".$telefone."', '".$email."', '".$data."', '".$morada."','".$id_categoria."', 1)");
                             }
							 if (!empty($sql2))  { 
                                echo $nomes->registocorretoequipa;
								$nome = $xml->registocorretoequipa;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "index.php";';
								echo '</script>';
                            } else {
                                echo $nomes->registoincorretoimagem;
								$nome = $xml->registoincorretoimagem;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipa.php";';
								echo '</script>';
                            }
						}
                    } else {
                        echo $nomes->equiparepetida;
                        $nome = $xml->equiparepetida;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "equipa.php";';
						echo '</script>';
						}
						
					/*Inscrever participantes em equipas************************************************************************/
					
					}elseif ($opcao === "inscreverequipaParticipante") {
						
						if (isset($_POST['formEquipa'])) $equipa = $_POST['formEquipa'];
						$estado = "Inscrita";
					
					$sql = "select id_utilizador from trabalho_php_rb.equipa_utilizador where id_utilizador = '".$_SESSION['id_user']."'";
					$sql_id = "select id_equipa from trabalho_php_rb.equipa where nome = '".$equipa."'";
                    $result = $conn->query($sql);
					$stmt = $conn->query($sql_id);
					$id_equipa = $stmt->fetch_row()[0];
					if ($result->num_rows == 0) {
                            $sql2 = mysqli_query($conn,
								"INSERT INTO trabalho_php_rb.equipa_utilizador (estado, id_equipa, id_utilizador) 
								values ('".utf8_decode($estado)."', '".$id_equipa."','".$_SESSION['id_user']."')");
                            if (!empty($sql2))  { 
                                echo $nomes->inscricaoequipacorreta;
								$nome = $xml->inscricaoequipacorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            } else {
                                echo $nomes->inscricaoequipaincorreta;
								$nome = $xml->inscricaoequipaincorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            }
						} else {
                        echo $nomes->inscricaoequiparepetida;
                        $nome = $xml->inscricaoequiparepetida;
						echo '<script language="javascript">';
						echo 'window.alert("'.$nome.'");';
						echo 'window.location.href = "equipaParticipante.php";';
						echo '</script>';
						}
                    } elseif ($opcao === "editarinscricao") {
						
						if (isset($_POST['formEquipaEdita'])) $equipa = $_POST['formEquipaEdita'];
						if (isset($_POST['formEstado'])) $estado = $_POST['formEstado'];
					
					$sql_id = "select id_equipa from trabalho_php_rb.equipa where nome = '".$equipa."'";
					$stmt = $conn->query($sql_id);
					$id_equipa = $stmt->fetch_row()[0];
					
                            $sql2 = mysqli_query($conn,
								"update trabalho_php_rb.equipa_utilizador set estado = '".utf8_decode($estado)."', id_equipa = '".$id_equipa."' where id_utilizador = '".$_SESSION['id_user']."'");
                            if (!empty($sql2))  { 
                                echo $nomes->edicaoequipacorreta;
								$nome = $xml->edicaoequipacorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            } else {
                                echo $nomes->edicaoequipaincorreta;
								$nome = $xml->edicaoequipaincorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            }
						
                    }elseif ($opcao === "eliminarinscricao") {
					
                            $sql2 = mysqli_query($conn,
								"delete from trabalho_php_rb.equipa_utilizador where id_utilizador = '".$_SESSION['id_user']."'");
                            if (!empty($sql2))  { 
                                echo $nomes->eliminacaoequipacorreta;
								$nome = $xml->eliminacaoequipacorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            } else {
                                echo $nomes->eliminacaoequipaincorreta;
								$nome = $xml->eliminacaoequipaincorreta;
								echo '<script language="javascript">';
								echo 'window.alert("'.$nome.'");';
								echo 'window.location.href = "equipaParticipante.php";';
								echo '</script>';
                            }
						
                    }
					}
			}
		
			?>
		</div>
		
    </div>
</body>
</html>