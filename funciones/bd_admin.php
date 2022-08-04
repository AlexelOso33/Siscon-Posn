<?php

    $user = 'sisconsy_pol_onl_admin';
    $password = 'polietileno25@33';
    $db = 'sisconsy_admin_data';
    $host = 'localhost';

    $conna = mysqli_connect($host, $user, $password, $db);
    $conna->set_charset('utf8');

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
    }

?>