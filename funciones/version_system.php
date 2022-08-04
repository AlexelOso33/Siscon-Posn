<?php

    include_once 'bd_admin.php';
    
    try {
        $sql = "SELECT `num_version` FROM `versions_system` ORDER BY `id_version` DESC LIMIT 1";
        $cons = mysqli_query($conna, $sql);
        $ver = mysqli_fetch_assoc($cons);
        $version = $ver['num_version'];
    } catch (\Throwable $th) {
        die("Error: ".$th->getMessage());
    }

?>