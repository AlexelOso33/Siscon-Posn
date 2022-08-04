<?php
    session_start();
    include_once('../../funciones/bd_admin.php');

    if($_POST['action'] == 'siguiente-paso'){
        $id = intval($_SESSION['id_user']);
        $step = intval($_POST['step']);
        try {
            $stmt = $conna->prepare("UPDATE `users_business` SET `first_steps` = ? WHERE `id_admin` = ?");
            $stmt->bind_param("ii", $step, $id);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'ok'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        } catch (\Throwable $th) {
            echo "Error: ".$th->getMessage();
        }
        die(json_encode($respuesta));
        $stmt->close();
    }

    if($_POST['action'] == 'omitir-paso'){
        $id = intval($_SESSION['id_user']);
        $step = 1;
        try {
            $stmt = $conna->prepare("UPDATE `users_business` SET `om_fs` = ? WHERE `id_admin` = ?");
            $stmt->bind_param("ii", $step, $id);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'ok'
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            // $stmt->close();
        } catch (\Throwable $th) {
            echo "Error: ".$th->getMessage();
        }
        die(json_encode($respuesta));
    }