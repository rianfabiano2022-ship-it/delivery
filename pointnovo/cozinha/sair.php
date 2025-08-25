<?php
session_start();
if(isset($_COOKIE['pdvx'])){
unset($_COOKIE['pdvx']);
setcookie('pdvx', null, -1, '/');
}
session_destroy();
session_write_close();
header('location: index.php');
?>