<?php
   session_start();
   unset($_SESSION['utilizador']);
   unset($_SESSION['id_user']);
   //$_SESSION = array();
   //session_destroy();
   header("Location: index.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

