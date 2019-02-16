<?php
session_start();
@session_destroy();
//$host= "http://localhost/TenauiCRM/";
unset($_COOKIE["i_am2309384384304302349438933"]);
setcookie("i_am2309384384304302349438933",'',time() - (8640000 * 10),"/");
include("data/DBConfig.php");
 header('location:'.$host);

?>