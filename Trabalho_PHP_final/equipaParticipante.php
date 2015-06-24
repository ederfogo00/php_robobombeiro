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
                        <form name="linguaform" action="equipaParticipante.php" method="POST">
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
                echo $nomes->equipa;
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
                            <li><a href="participante.php"><?php echo $nomes->participante;?></a></li>
							<li class="active"><a href="equipaParticipante.php"><?php echo $nomes->equipaParticipante;?></a></li>
                            <li><a href="documento.php" target="_blank"><?php echo $nomes->documentos;?></a></li> 
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
		
		<div style="border-radius: 5px; height: 100%; margin-left:-540px; margin-top:50px;">
			<table style="margin-top: 5%" align="center"> 
                <form action="avisos.php" method="POST" enctype="multipart/form-data">
                     <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->nomeequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
							<?php				
								$servername = "localhost";
								$username = "root";
								$password = "";
								$conn = new mysqli($servername, $username, $password);
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}else{
									//$sql_id = "select id_categoria from trabalho_php_rb.categoria_equipa where nome = '".$categoria."'";
									//$stmt = $conn->query($sql_id);
									//$id_categoria = $stmt->fetch_row()[0];
									//echo $id_categoria;
									$sql = "select nome from trabalho_php_rb.equipa";
									$result = $conn->query($sql);
									echo '<select name="formEquipa" style="width:300px">';
									while ($row = $result->fetch_array()) {
										echo '<option value="'.$row['nome'].'">'.$row['nome'].'</option>';
									}
									echo '</select>';
								}
							?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                    
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 15px">
                            <button type="submit" name="local" value="inscreverequipaParticipante"  style="width: 300px"> <?php echo $nomes->confirmar;?> </button>
                        </td>
                    </tr>
                </form>
                <tr>
                    <td style="padding-bottom: 15px">
                            
                    </td>
                    <td style="padding-left: 20px;padding-bottom: 15px">
                        <form action="index.php" method="POST">
                            <button align="center" style="width: 300px"> <?php echo $nomes->cancelar;?> </button>
                        </form>
                    </td>
                </tr>
            </table>
		</div>
		<div style="border-top:solid 2px black; margin-top:70px; width:591px; margin-left:-522px">
			<div>
				<?php
					echo $nomes -> equipaemqueestaregistado;
					$sql = "select estado, id_equipa from trabalho_php_rb.equipa_utilizador where id_utilizador = '".$_SESSION['id_user']."'";
					$result = $conn->query($sql);
					$result1 = $conn->query($sql);
					$id_equipa = $result1->fetch_row()[1];
					$sql_id = "select nome from trabalho_php_rb.equipa where id_equipa = '".$id_equipa."'";
					$stmt = $conn->query($sql_id);
					$equipa = $stmt->fetch_row()[0];
                    if (!empty($result)) {
                        $registo = mysqli_fetch_array($result);
				?>
			</div>
			<table style="margin-top: 5%" align="center">
				<form action="avisos.php" method="POST" enctype="multipart/form-data">
				<?php
					if(!empty($equipa)){
				?>
					<tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->nomeequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
							<?php
								$sql = "select nome from trabalho_php_rb.equipa";
								$result = $conn->query($sql);
								echo '<select hidden name="formEquipaEdita" id="formEquipaEdita" style="width:300px">';
								while ($row = $result->fetch_array()) {
									echo '<option value="'.$row['nome'].'">'.$row['nome'].'</option>';
								}
								echo '</select>';
							?>
                            <input disabled="true" value="<?php echo utf8_encode($equipa);?>" required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="nomeequipa" id="equipa">  </input>
                        </td>
                    </tr>
					<tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->estadoequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
							<select hidden name="formEstado" id="formEstado">
								<option value="Inscrita">Inscrita</option>
								<option value="Não Inscrita">Não Inscrita</option>
							</select>
                            <input disabled="true" value="<?php echo utf8_encode($registo['estado']);?>" required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="estadoequipa" id="estado">  </input>
                        </td>
                    </tr>
					<?php
					}else{?>
					<tr>
						<td style="padding-bottom: 15px">
							<?php echo $nomes -> naoinscritoequipa?>
                        </td>
					</tr>
					<?php
					}?>
					<tr>
                        <td style="padding-bottom: 15px">
                    
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 15px">
                            <button type="submit" id='btedita' name="local" value="editarinscricao"  style="width: 300px; display: none"> <?php echo $nomes->confirmar;?> </button>
                        </td>
                    </tr>
					<tr>
                        <td style="padding-bottom: 15px">
                    
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 15px">
                            <button type="submit" id='btelimina' name="local" value="eliminarinscricao"  style="width: 300px; display: none"> <?php echo $nomes->eliminar;?> </button>
                        </td>
                    </tr>
                </form>
				<tr>
                    <td style="padding-bottom: 15px">
                            
                    </td>
                    <script>
                        function mostra(){
                            var f = document.getElementById('btedita').style.display;
                            if (f === 'none'){
                                document.getElementById('btedita').style.display = "block";
								document.getElementById('btelimina').style.display = "block";
                                document.getElementById('btmostracancela').innerHTML = "<?php echo $nomes->cancelar;?> ";
								document.getElementById('formEquipaEdita').style.display = "block";
								document.getElementById('formEstado').style.display = "block";
                                var tab = document.getElementsByClassName('edita');
                                for(var i=0;i<tab.length;i++){
                                    tab[i].disabled = false;
                                    tab[i].style.backgroundColor = "white";
                                }
                            } else {
                               document.getElementById('btedita').style.display = "none"; 
							   document.getElementById('btelimina').style.display = "none";
                               document.getElementById('btmostracancela').innerHTML = "<?php echo $nomes->editar;?> ";
							   document.getElementById('formEquipaEdita').style.display = "none";
							   document.getElementById('formEstado').style.display = "none";
                               var tab = document.getElementsByClassName('edita');
                               for(var i=0;i<tab.length;i++){
                                    tab[i].disabled = true;
                                    tab[i].style.backgroundColor = "#ffffbb";
                               }
                            }
                        }
                    </script>
                    <td style="padding-left: 20px;padding-bottom: 15px">
						<?php
						if(!empty($equipa)){
						?>
							<button onclick="mostra();" id='btmostracancela' align="center" style="width: 300px"><?php echo $nomes->editar;?> </button>
						<?php
						}?>
					</td>
                </tr>
			</table>
			<?php 
            }?>
		</div>
    </div>
</body>
</html>