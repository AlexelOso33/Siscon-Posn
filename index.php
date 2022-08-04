<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    
<?php
    if(isset($_GET['auth'])){
        $auth= $_GET['auth'];
        $hash = $_GET['hash'];
        $id = $_GET['id'];
        $bd = $_GET['bd'];
        if(password_verify($auth, $hash)){
            // header('Location: https://posn.siscon-system.com/pages/ventas.php?ia='.$auth.'&ih='.$hash.'&us='.$id.'&bd='.$bd);
            ?>
            <script>
                // Almacena la info en LocalStorage
                var ia = '<?php echo $auth; ?>';
                var ih = '<?php echo $hash; ?>';
                var id = '<?php echo $id; ?>';
                var bd = '<?php echo $bd; ?>';
                localStorage.setItem('ia', ia);
                localStorage.setItem('ih', ih);
                localStorage.setItem('us', id);
                localStorage.setItem('bd', bd);
                var bd = localStorage.getItem('bd');
                if(bd !== ''){ 
                    // SCRIPT PARA TOMAR COOKIE
                    var us = localStorage.getItem("us");
                    var d = new Date();
                    d.setTime(d.getTime() + (1*24*60*60*1000));
                    var expires = "expires="+ d.toUTCString();
                    document.cookie = 'bd' + "=" + bd+ ";" + expires + ";path=/";
                    document.cookie = 'us' + "=" + us+ ";" + expires + ";path=/";
                    window.location.href = 'https://posn.siscon-system.com/pages/ventas.php';
                } else {
                    window.location.href = 'https://siscon-system.com/index.php?redir=posn';
                }
            </script>
        <?php
        } else {
            header('Location: https://siscon-system.com/index.php?redir=posn&fail=verify');
        }
    } else {
        $cokBD = $_COOKIE['bd'];
        if($cokBD !== null){
            header('Location: https://posn.siscon-system.com/pages/ventas.php');
        } else {
?>
        <script>
            var bd = localStorage.getItem("bd");
            var d = new Date();
            d.setTime(d.getTime() + (1*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = 'bd' + "=" + bd+ ";" + expires + ";path=/";
        </script>
<?php
        $cokBD = $_COOKIE['bd'];
        if($cokBD == null){
            // Eliminamos la COOKIE de BD
            $arr_cookie_options = array (
                'expires' => time() - 60*60*24*30
            );
            setcookie('bd', $arr_cookie_options);
            header('Location: https://siscon-system.com/index.php?redir=posn&fail=noterm');
        } else {
            header('Location: https://posn.siscon-system.com/pages/ventas.php');
        }
            // Comprobar que existe la IP insertada
            /* include_once 'funciones/bd_admin.php';
            include_once 'funciones/bd_conexion.php';

            $ipTerm = tomarIP();
            try {
                $sql = "SELECT * FROM `terminales` WHERE `term_ip` = '$ipTerm' ORDER BY `term_fecinc` DESC LIMIT 1";
                $cons = mysqli_query($conna, $sql);
                if($cons === true){
                    // $ip = mysqli_fetch_assoc($cons);
                    // $user = $ip['term_user'];
                    header('Location: https://siscon-system.com/index.php?redir=posn&fail=termagain');
                    try {
                        $sql = "SELECT * FROM "
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                } else {
                    header('Location: https://siscon-system.com/index.php?redir=posn&fail=noterm');
                }
            } catch (\Throwable $th) {
                die("Error: ".$th->getMessage());
            } */
        }
    }

    // FUNCIONES
    function tomarIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }
?>

</body>
</html>