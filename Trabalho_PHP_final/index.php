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
        die("Ligação falhada: " . $conn->connect_error);
    } else{
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
                        <form name="linguaform" action="index.php" method="POST">
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
        
		
        <div style="border-radius: 5px; height: 100%; margin-left:-500px; margin-top:100px;">
            <ul class="nav nav-tabs" style="font-size:13px">
                    <li class="active">
                        <a href="index.php" style="background-color: #aaa; outline: none; cursor: pointer"><?php echo $nomes->paginainicial?></a>
                    </li>
                    <?php
                    if ($op1 != "") { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php if (isset($_SESSION['utilizador'])) {echo "<b>".$nomes->opcoes. ":&nbsp;</b>".$utilizador; } else { }?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="width: 99%">
                            <?php if (isset($_SESSION['id_user'])){ 
                            ?>
                            <li><a href="participante.php"><?php echo $nomes->participante;?></a></li>
							<li><a href="equipaParticipante.php"><?php echo $nomes->equipaParticipante;?></a></li>
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
		<div style="border-radius: 5px; height: 100%; margin-left:-540px; margin-top:10px;">
				<div style="margin-left:50px; margin-top:-20px; margin-bottom:20px" align="center">
					<?php 
						echo $nomes->proximaedicao;
					?>
				</div>
			<?php 
                $sql = "select edicao, data_edicao, morada, pais, foto from trabalho_php_rb.edicao where id_edicao = 1";
                $result = $conn->query($sql);
                    if (!empty($result)) {
                        $registo = mysqli_fetch_array($result);
                        (!empty($registo['foto'])) ? $imagem = "data:".$registo['edicao'].";base64,".base64_encode($registo['foto']): $imagem = "images/sem-imagem.jpg";
                 
            ?>
            <div align='center'>
                <img width="400px" height="300px" style='border-style: outset; border-width: 4px' src="<?php echo $imagem;?>">
            </div>
			<table style="margin-top: 5%" align="center">
				<form action="avisos.php" method="POST" enctype="multipart/form-data">
                     <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->nomeedicao.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input class='edita' disabled="true" value="<?php echo utf8_encode($registo['edicao']);?>" required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="nomeutilizador" id="utilizador" placeholder="<?php echo $nomes->pass_placeholder3;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->dataedicao.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input class='edita' disabled="true" value="<?php echo $registo['data_edicao'];?>" required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="emailutilizador" id="utilizador" placeholder="<?php echo $nomes->pass_placeholder4;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->localedicao.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input class='edita' disabled="true" value="<?php echo utf8_encode($registo['morada']);?>" required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="telefoneutilizador" id="utilizador" placeholder="<?php echo $nomes->pass_placeholder5;?>">  </input>
                        </td>
                    </tr>
					<tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->pais.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input class='edita' disabled="true" value="<?php echo utf8_encode($registo['pais']);?>"  required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="moradautilizador" id="utilizador" placeholder="<?php echo $nomes->pass_placeholder6;?>">  </input>
                        </td>
                    </tr>
                </form>				
			</table>
			<?php 
                } 
            ?>
		</div>
    </div>
	<?php }
    ?>
</body>
</html>