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
	
    ?>
<body>
	<div style="width:595px; height:600px; border:solid 2px #000000; margin-left:auto; margin-right:auto">
    	<div style="float:left">
        	<table style="width: 100%;min-width: 500px">
                <tr>
                    <td style="">
                        <img width="24px" height="24px" src="images/<?php echo $op_lang;?>/bandeira.png"/>
                    </td>
                    <td id=" tlingua" style="padding-right: 300px">
                        <form name="linguaform" action="estatistica.php" method="POST">
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
					<li>
					<a href="equipa.php"><?php echo $nomes->equipa;?></a>
					</li>
                    <li class="active">
                        <a href="estatistica.php" style="background-color: #aaa; outline: none; cursor: pointer"><?php echo $nomes->estatistica; ?></a>
                    </li>
                </ul>
        </div>
		<div style="border-radius: 5px; height: 100%; margin-left:-540px; margin-top:10px;">
				<div style="margin-top:-20px; margin-bottom:20px" align="center">
					<?php 
						echo $nomes->estatistica;
					?>
				</div>
				<table style="width:100%; padding-top: 50px;">
					<tr>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $conn = new mysqli($servername, $username, $password);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } else{
                        $bd = "trabalho_php_rb";
                        $rd = mysqli_select_db($conn,$bd);
                        $sql = "select categoria_equipa.nome Categoria,count(equipa.id_categoria) equipas from equipa,categoria_equipa where equipa.id_categoria = categoria_equipa.id_categoria group by(equipa.id_categoria)";
						$result = $conn->query($sql);
                        $eixo = array();
                        $valor = array();
                        if ($result != null) {
                            while($row = $result->fetch_assoc()){
                                //$categoria = utf8_encode(ucfirst($f['categoria_equipa.nome']));
                                $countCategoria = utf8_encode(ucfirst($row['equipas']));
                                $valor[$countCategoria] = $row['Categoria'];
                                $eixo[$countCategoria] = $countCategoria;
                            }
                            
                            $cor = 217;
                            $graf = "grafico1.png";
                            $situa = $nomes->porcategoria;
                            //grafico($eixo, $valor, $cor,$graf, $situa, $nomes->numeroequipas);
							grafico2($eixo, $valor, $graf);
                        }
                    }
                    ?> 
					<td align="center">
                        <?php echo $nomes -> porcategoria ?>
                    </td>
                </tr>
				<tr>
					<td align="center">
                        <img src="images/grafico1.png" style="width:591px; margin-left:15px">
                    </td>
				</tr>
				</table>
		</div>
    </div>
</body>
    <?php 
                function grafico($dados, $eixo, $cor1, $grafico, $situacao, $legenda){
                    include_once ("pChart/pChart/pData.class");
                    include_once ("pChart/pChart/pChart.class");
                    $DataSet = new pData;
                    $DataSet->AddPoint($dados,"Serie1");
                    $DataSet->AddPoint($eixo,"Serie2");
                    $DataSet->AddAllSeries();
                    $DataSet->RemoveSerie("Serie2");
                    $DataSet->SetAbsciseLabelSerie("Serie2");
                    $DataSet->SetSerieName($legenda,"Serie1");
                    $Test = new pChart(720,430);
                    $Test->drawGraphAreaGradient($cor1,173,131,50,TARGET_BACKGROUND);
                    $Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
                    $Test->setGraphArea(50,80,675,390);
                    $Test->drawGraphArea(217,217,211,FALSE);
                    $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_ADDALL,213,217,221,TRUE,0,2,TRUE);
                    $Test->drawGraphAreaGradient(163,203,167,50);
                    $Test->drawGrid(4,TRUE,230,230,230,20);
                    $Test->drawStackedBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),70);
                    $Title = "$situacao";
                    $Test->setFontProperties("pChart/Fonts/tahoma.ttf",14);
                    $Test->drawTextBox(0,0,700,60,$Title,0,255,255,255,ALIGN_CENTER,TRUE,30,0,0,30);
                    $Test->setFontProperties("pChart/Fonts/tahoma.ttf",9);
                    $Test->drawLegend(520,70,$DataSet->GetDataDescription(),236,238,240,52,58,82);
                    $Test->addBorder(2);
                    $Test->Render("images/".$grafico);
                }
				
				function grafico2($dados, $eixo, $grafico) {
                    include_once("pChart/pChart/pData.class");
                    include_once("pChart/pChart/pChart.class");
                    $DataSet = new pData;
                    $DataSet->AddPoint($dados,"Serie1");
                    $DataSet->AddPoint($eixo,"Serie2");
                    $DataSet->AddAllSeries();
                    $DataSet->SetAbsciseLabelSerie("Serie2");
                    $Test = new pChart(700,400);
                    $Test->drawFilledRoundedRectangle(7,7,700,430,5,180,216,216);
                    $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);
                    $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),270,210,210,PIE_PERCENTAGE,TRUE,50,20,5);
                    $Test->drawPieLegend(520,70,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
                    $Test->Render("images/".$grafico);
                }
    
    ?>
</html>