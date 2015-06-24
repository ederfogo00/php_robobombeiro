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
                        <form name="linguaform" action="login.php" method="POST">
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
        	echo $nomes->login;
        	?>
        </div>
		<?php
            if ((isset($_REQUEST['utilizador']))&&(isset($_REQUEST['senha']))){
                $utilizador = $_REQUEST['utilizador'];
                $senha = $_REQUEST['senha'];
                echo $utilizador;
                $servername = "localhost";
                $username = "root";
                $password = "";
                $conn = new mysqli($servername, $username, $password);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else{
                    $sql = "SELECT nome,id_utilizador FROM trabalho_php_rb.utilizador WHERE username='".$utilizador."' AND password='".$senha."';";
                    $result = $conn->query($sql);
                    if ($result != null) {
                        if ($result->num_rows == 1) {
                            $registo = mysqli_fetch_array($result);
                            $nome = utf8_encode($registo['nome']);
                            $id_user = $registo['id_utilizador'];
                            $_SESSION['utilizador'] = $nome;
                            $_SESSION['id_user'] = $id_user;
                        }
                    } else {
                        echo "0 results";      
                    }
                    $conn->close();
                }
                header("Location: index.php"); /* Redirect browser */
            } else {
        ?> 
        <div style="border-radius: 5px; height: 100%; margin-left:-550px; margin-top:150px;">
            <table align="center"> 
                <form name="form1" id="form1" action="" method="POST">
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->utilizador.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px">
                            <input required="true" style="background-color:#ffffbb; text-align: center; width: 300px;border-radius: 5px; box-shadow:2px 2px 2px 1px black;" name="utilizador" id="utilizador" placeholder="<?php echo $nomes->pass_placeholder;?>">  </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px">
                            <?php echo "<b>".$nomes->pass.":</b>";?>
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 20px" >
                            <input required="true"  style="background-color:#ffffbb ;text-align: center; width: 300px;border-radius: 5px;  box-shadow:2px 2px 2px 1px black;" name="senha" type="password" id="senha" placeholder="<?php echo $nomes->pass_placeholder2;?>"> </input>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px">
                    
                        </td>
                        <td style="padding-left: 20px;padding-bottom: 15px">
                            <button style="width: 300px"> <?php echo $nomes->confirmar;?> </button>
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
        <?php } ?>
    </div>
</body>
</html>