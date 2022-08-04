<?php

    include_once '../funciones/bd_conexion.php';
    include_once '../funciones/bd_admin.php';
        
    // Variables para nuevo y editar clientes. //
    $categoria_nueva = $_POST['valor1'];
    $sub_cat_nueva = $_POST['valor2'];
    $id_registro = $_POST['id_registro'];
    $cod_auto = $_POST['codauto-nuevo'];
    $estado = intval($_POST['estado']);
    $cod_bar = $_POST['cod-bar'];
    $cod_prod = $_POST['codigo-prod'];
    $desc = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $sub_categ = $_POST['sub-categ'];
    $precio_cost = $_POST['precio-costo'];
    $precio_venta = $_POST['precio-venta'];
    $ganancia = $_POST['ganancia'];
    $stock = $_POST['stock-actual'];
    $sin_stock = $_POST['s-stock'];
    $proveedor = $_POST['n-proveedor'];
    $comentarios = $_POST['comentarios'];
    $productos_promo = $_POST['prods-promo'];
    $desc_promo = $_POST['total-perc-acum'];
    $date= date('Y-m-d H:i:s'); 
    $hoy = strtotime('-3 hour', strtotime($date));
    $hoy = date('Y-m-d H:i:s', $hoy);

    //Acción para seleccionar producto para DOM preventa
    if($_POST['tipo-accionar'] == 'buscar-productos') {
        $id_producto = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];
        try {
            $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
            $resultado = $conn->query($sql);
            $p = $resultado->fetch_assoc();
            $cant_bd = $p['stock'];
            $cuenta = $cant_bd-$cantidad;
            if($p['sin_stock'] == 'no' && $cuenta < 0){
                $respuesta = array(
                    'res' => 'no',
                    'cant' => $p['stock'],
                    'cod' => $p['descripcion']
                );
            } else {
                $sitem = 0;
                if($p['categoria_id'] == 18){
                    $p_promo = $p['prods_promo'];
                    $p_promo = explode(" ", $p_promo);
                    for($i = 0; $i < count($p_promo); $i++) {
                        $sitem += 1;
                    }
                }
                $cod_auto_re = str_pad($p['cod_auto'], 6, "0", STR_PAD_LEFT);
                $codigo_prod = $p['codigo_prod'];
                $desc_re = $p['descripcion'];
                $precio_venta_re = $p['precio_venta'];
                $costo = $p['precio_costo'];
                $ganancia = $precio_venta_re-$costo;
                $mult_precio = $cantidad * $precio_venta_re;
                $string = "<td class='hide-mobile'>".$cod_auto_re."</td>";
                $string.= "<td class='hide-mobile'>".$codigo_prod."</td>";
                $string.= "<td>".$desc_re."</td>";
                $string.= "<td class='right-text'>$".floatval($precio_venta_re)."</td>";
                $string.= "<td class='right-text total-prev' style='font-weight:bold;'>$".floatval($mult_precio)."</td>";
                $respuesta = array(
                    'res' => 'ok',
                    'string' => $string,
                    'producto' => $cod_auto_re,
                    'total' => $mult_precio,
                    'cod' => $p['descripcion'],
                    'ganancia' => $ganancia,
                    'item' => 1,
                    'sitem' => $sitem
                );
            }
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
        die(json_encode($respuesta));
    }

    // Función universal para corroborar que la caja esté abierta
    if($_POST['tipo-accionar'] == 'tomar-caja-abierta'){
        try {
            $sql = "SELECT * FROM cajas ORDER BY id_mov_caja DESC LIMIT 1";
            $result = $conn->query($sql);
            $cajAB = $result->fetch_assoc();
            if($cajAB['estado_caja'] == 1){
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
    }

    // Cambiar total en table producto x cantidad
    if($_POST['action'] == 'cant-producto'){
        $prod = $_POST['producto'];
        $cant = $_POST['cant'];
        try {
            $sql = "SELECT * FROM `productos` WHERE `id_producto` = $prod";
            $cons = $conn->query($sql);
            $p = $cons->fetch_assoc();
            $pVenta = $p['precio_venta'];
            $pCosto = $p['precio_costo'];
            $cant_bd = $p['stock'];
            $cuenta = $cant_bd-$cant;
            if($p['sin_stock'] == 'no' && $cuenta < 0){
                $respuesta = array(
                    'res' => 'no',
                    'cant' => $p['stock'],
                    'cod' => $p['descripcion'],
                    'cantBd' => $cant_bd
                );
            } else {
                $tot = floatval($cant) * $pVenta;
                $respuesta = array(
                    'res' => 'ok',
                    'cant' => $cant,
                    'pVenta' => $pVenta,
                    'pCosto' => $pCosto,
                    'total' => $tot
                );
            }
        } catch(\Throwable $th){
            echo "Error: ".$th->getMessage();
        }
        die(json_encode($respuesta));
    }

    //Acción para agregar preventa
    if($_POST['registro-modelo'] == 'crear-venta') {
        // die(json_encode($_POST));
        // Variables tomadas de siscon original
        $id_cliente = $_POST['cliente-preventa'];
        // $id_venta = $_POST['id'];
        $comprobante = !isset($_POST['comprobante']) ? 'x' : $_POST['comprobante'];
        $productos_prev = $_POST['productos-contenido'];
        $id_vend = $_POST['vendedor-id'];
        $valor = $_POST['valor-total'];
        $ganancia = $_POST['ganancia_prev'];
        $id_bonificacion = $_POST['id-bonif'];
        $monto_bonificacion = $_POST['monto-bonif'];
        $det_bonificacion = $_POST['detalle-bonif'];
        $comentarios = $_POST['comentarios'];
        $credito = $_POST['id-credito'];
        $usa_cred = $_POST['usa-credito'];
        $medio_pago = $_POST['medio-pago'];
        $fecha_ent = 0;
        $medio_creacion = 1;
        $presupuesto = 0;

        $fecha_modif = $hoy;

        try {
            $sqluno = "SELECT * FROM ventas ORDER BY n_venta DESC LIMIT 1";
            $result = $conn->query($sqluno);
            $ult_venta = $result->fetch_assoc();
            $n_venta = $ult_venta['n_venta'];
            $n_venta = $n_venta+1;
        } catch (\Throwable $th) {
            echo "Error: ".$th->getMessage();
        }

        try {
            $stmt = $conn->prepare("INSERT INTO ventas (n_venta, comprobante, n_presupuesto, cliente_id, id_vend_venta, productos, total, ganancias_venta, id_bonif, bonificacion, detalle_bonif, id_credito, usa_credito, medio_pago, estado, facturacion, coment_estado, fecha_entrega, estado_entrega, coment_venta, refacturacion, medio_creacion, fec_modif_venta, fec_includ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 4, ?, '', ?, 1, ?, 0, ?, ?, ?)");
            $stmt->bind_param("isiiisssissiissssiss", $n_venta, $comprobante, $presupuesto, $id_cliente, $id_vend, $productos_prev, $valor, $ganancia, $id_bonificacion, $monto_bonificacion, $det_bonificacion, $credito, $usa_cred, $medio_pago, $hoy, $fecha_ent, $comentarios, $medio_creacion, $fecha_modif, $hoy); 
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if($id_registro > 0){

                // Hash venta
                $opciones = array('cost' => 12);
                $venta_hashed = password_hash($id_registro, PASSWORD_BCRYPT, $opciones);
                $bdCookie = $_COOKIE['bd'];

                // Tomo business
                try {
                    $sqlBusi = "SELECT `number_business` FROM `business_data` WHERE `bd_business_d` = '$bdCookie'";
                    $consBusi = $conna->query($sqlBusi);
                    $busi = $consBusi->fetch_assoc();
                    $busi = $busi['number_business'];
                } catch (\Throwable $th) {
                    echo "Error: ".$th->getMessage();
                }

                //************* Impacto en caja *************//
                try {
                    $sql = "SELECT * FROM cajas ORDER BY id_mov_caja DESC LIMIT 1";
                    $resultado = $conn->query($sql);
                    $caja_select = $resultado->fetch_assoc();
                    $caja_actual = $caja_select['caja'];
                    $caja_ult = floatval($caja_select['valor']);
                } catch (\Throwable $th) {
                    echo "Error: " . $th->getMessage();
                }
                $id_venta = $id_registro;
                $estado_caja = 1;
                $comentarios = "Finalización correcta.";
                $valor_diferencia = floatval($valor);
                $id_tipo_mov = 3;
                $estado_venta = 4;
                $valor_ins = $caja_ult+$valor_diferencia;
                $valor_diferencia = "+".$valor_diferencia;
                try {
                    $stmt = $conn->prepare("INSERT INTO cajas (caja, estado_caja, id_tipo_mov, desc_mov, venta_id, valor, ajuste_mov, fec_includ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("iiisisss", $caja_actual, $estado_caja, $id_tipo_mov, $comentarios, $id_venta, $valor_ins, $valor_diferencia, $hoy);
                    $stmt->execute();
                    $id_reg = $stmt->insert_id;
                    if($id_reg > 0) {
                        // Sigue con los productos
                        $n_prod = explode(" ", $productos_prev);
                        $lg = count($n_prod);
                        $lg= $lg-1;
                        for($i = 0; $i < $lg; $i++){
                            $n_prod1 = explode("-", $n_prod[$i]);
                            $nc = $n_prod1[0];
                            $np = $n_prod1[1];
                            if($np !== 'DEUDA'){
                                try {
                                    $sql = "SELECT * FROM productos WHERE cod_auto = $np";
                                    $resultado = $conn->query($sql);
                                    $res_p = $resultado->fetch_assoc();
                                    $es_st = $res_p['sin_stock'];
                                    $s = $res_p['stock'];
                                    if($es_st == 'no'){
                                        $ts = floatval($res_p['stock'])-floatval($nc);
                                        $ts = round($ts, 2);
                                        try {
                                            $stmt1 = $conn->prepare("UPDATE productos SET stock = ? WHERE cod_auto = ?");
                                            $stmt1->bind_param("si", $ts, $np);
                                            $stmt1->execute();
                                            if($stmt1->affected_rows) {

                                                // Descuenta saldo cliente //
                                                if($usa_cred == '1'){
                                                    $com = "Descuento de crédito por NVI ".$id_registro;
                                                    try {
                                                        $stmt = $conn->prepare("INSERT INTO credeudas (cliente_id, credito, deuda, comentarios, fecha) VALUES (?, 0, 0, ?, ?)");
                                                        $stmt->bind_param("iss", $id_cliente, $com, $hoy);
                                                        $stmt->execute();
                                                        if($stmt->insert_id > 0){
                                                            $respuesta = array(
                                                                'respuesta'=> 'exitoso',
                                                                'id_venta' => $id_registro,
                                                                'busi' => $busi,
                                                                'venta_hashed' => $venta_hashed
                                                                );
                                                        } else {
                                                            $respuesta = array(
                                                                'respuesta'=> 'error'
                                                            );
                                                        }
                                                    } catch (\Throwable $th) {
                                                        echo "Error: ".$th->getMessage();
                                                    }
                                                } else {
                                                    $respuesta = array(
                                                    'respuesta'=> 'exitoso',
                                                    'id_venta' => $id_registro,
                                                    'busi' => $busi,
                                                    'venta_hashed' => $venta_hashed
                                                    );
                                                }
                                            } else {
                                                $respuesta = array(
                                                    'respuesta'=> 'error'
                                                );
                                            }
                                        } catch (\Throwable $th) {
                                            echo "Error: ".$th->getMessage();
                                        }
                                    } else {
                                        $respuesta = array(
                                        'respuesta'=> 'exitoso',
                                        'id_venta' => $id_registro,
                                        'busi' => $busi,
                                        'venta_hashed' => $venta_hashed
                                        );
                                    }
                                } catch (\Throwable $th) {
                                    echo "Error: ".$th->getMessage();
                                }
                            } else {
                                $respuesta = array(
                                'respuesta'=> 'exitoso',
                                'id_venta' => $id_registro,
                                'busi' => $busi,
                                'venta_hashed' => $venta_hashed
                                );
                            }
                        }
                    
                    } else {
                        $respuesta = array(
                            'respuesta' => 'error'
                        );
                    }
                } catch (\Throwable $th) {
                    echo "Error: " . $th->getMessage();
                }

                
            } else {
                $respuesta = array(
                    'respuesta'=> 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
        die(json_encode($respuesta));
    }

?>