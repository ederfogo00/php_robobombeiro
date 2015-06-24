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
                        <form name="linguaform" action="equipa.php" method="POST">
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
					<li class="active">
					<a href="equipa.php"style="background-color: #aaa; outline: none; cursor: pointer"><?php echo $nomes->equipa;?></a>
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
                            <input required="true" style="text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="nomeequipa" id="equipa" placeholder="<?php echo $nomes->pass_placeholderNomeEquipa;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->emailequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input required="true" style="text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="emailequipa" id="equipa" placeholder="<?php echo $nomes->pass_placeholderEmailEquipa;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->telefoneequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input required="true" style="text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="telefoneequipa" id="equipa" placeholder="<?php echo $nomes->pass_placeholderTelefoneEquipa;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->instituicao.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input required="true" style="text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="instituicao" id="equipa" placeholder="<?php echo $nomes->pass_placeholderInstituicaoEquipa;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->fotoutilizador.":</b>";?>
                        </td>
                        <script>
                           function clica(){
                               var g = document.getElementById("inputfoto");
                               g.click();
                           } 
                           
                           function adicionaTexto(){
                               var t = document.getElementById("inputfoto").value;
                               var h = document.getElementById("docfoto");
                               var i;
                               var final = t.split("\\");
                               var finalo;
                               for (i = 0; i < final.length; i++ ){
                                   finalo = final[i];
                               } 
                               h.innerHTML = finalo;
                           }
                        </script>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <a id="afoto" onclick="clica()" style="cursor:pointer" ><?php echo $nomes->textfotoupload;?></a>
                            <input onchange="adicionaTexto()" id="inputfoto" type="file" style="display:none" name="foto"/> <span id="docfoto" style="padding-left:20px"></span> 
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->categoriaequipa.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
							<select name="formCat">
								<option value="Standard">Standard</option>
								<option value="Sénior">Sénior</option>
								<option value="Walking">Walking</option>
							</select>
							<?php
								if(!isset($_POST['formCat'])){
									echo $nomes->erroEscolhaCat;
								}
							?>
						</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                    
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 15px">
                            <button type="submit" name="local" value="registoequipa"  style="width: 300px"> <?php echo $nomes->confirmar;?> </button>
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
		
    </div>
</body>
</html>