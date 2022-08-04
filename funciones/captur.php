<?php
    $bd = $_COOKIE['bd'];
    if(is_null($bd) || $bd == ''){
        header('Location: https://posn.siscon-system.com');
    }
?>