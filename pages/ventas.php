<?php

    $dir = "https://siscon-system.com/";

    include_once '../templates/header.php'; 
    include_once '../funciones/captur.php';
    include_once '../funciones/bd_conexion.php';
    include_once '../templates/barra.php';
    // include_once $dir.'/templates/navegacion.php';

    $date= date('Y-m-j H:i:s');
    $hoy = strtotime('-3 hour', strtotime($date));
    $hoy = date('Y-m-j H:i:s', $hoy);
    $una_s = strtotime("- 1 week", strtotime($hoy));
    $dos_s = strtotime("- 2 week", strtotime($hoy));
    $una_s = $una_s." 00:00:00";
    $dos_s = $dos_s." 00:00:00";
  
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper cw2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Terminal de facturación
            <small></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <form role="form" method="post" id="crear-preventa-form" name="crear-preventa-form" action="../actions/modelo-ventas.php">
            <div class="box box-primary">
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4 with-border">
                                <!-- select cliente -->
                                <div class="form-group">
                                <label>F3 - Cliente </label>
                                <select id="buscar-cliente" name="buscar-cliente" class="form-control select2 buscar-cliente" max-value="1" style="width: 100%;">
                                    <!-- // Llamado a los elementos dentro de la BD -->
                                    <?php
                                        try {
                                            $sql = "SELECT * FROM clientes WHERE estado_cliente = 1 ORDER BY nombre";
                                            $resultado = $conn->query($sql);
                                        } catch (\Throwable $th) {
                                            echo "Error: " . $th->getMessage();
                                        }
                                        while($cliente = $resultado->fetch_assoc() ){ ?>
                                            <option value="<?php echo $cliente['id_cliente']; ?>"><b><?php echo $cliente['nombre']. ' ' .$cliente['apellido']. '</b>'; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-2 with-border">
                                <label for="comprobante">Comprobante</label>
                                <select name="comprobante" id="comprobante" class="form-control select2" style="width:100%;text-align:center;" >
                                    <!-- <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option> -->
                                    <option value="x" selected>X</option>
                                </select>
                            </div>
                            <div class="col-md-3 with-border">
                                <label for="vendedor">Vendedor</label>
                                <select name="vendedor-prev" id="vendedor-prev" class="form-control select2" style="width:100%;">
                                    <?php
                                    try {
                                        $sql = "SELECT * FROM vendedores WHERE estado_vendedor = 1 ORDER BY nombre_vendedor";
                                        $resultado = $conn->query($sql);
                                    } catch (\Throwable $th) {
                                        echo "Error: " . $th->getMessage();
                                    }
                                    while($vendedor = $resultado->fetch_assoc()){

                                        if($vendedor['usuario'] == $usuario){ 
                                            $sel = 'selected';
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="'.$vendedor['id_vendedor'].'" '.$sel.'>'.$vendedor['nombre_vendedor'].'</option>';

                                    }
                                    ?>
                                </select>
                                </div>
                            <div class="btns">
                                <a href="#" class="btn btn-warning btn-margin" style="width:100%;">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                            </div>
                        </div> <!-- End row -->
                        <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 with-border">
                            <!-- select cliente -->
                            <div class="form-group">
                                <label>F8 - Seleccionar producto </label>
                                <select id="buscar-producto" name="buscar-producto" class="form-control select2" style="width: 100%;" >        
                                <option value="0">- Seleccione -</option>
                                <!-- // Llamado a los elementos dentro de la BD -->
                                <?php
                                    try {
                                        $sql = "SELECT * FROM productos WHERE estado = 1 ORDER BY codigo_prod";
                                        $resultado = $conn->query($sql);
                                    } catch (\Throwable $th) {
                                        echo "Error: " . $th->getMessage();
                                    }
                                    while($producto = $resultado->fetch_assoc() ){ ?>
                                        <option value="<?php echo $producto['id_producto']; ?>"><?php echo $producto['codigo_prod']. " - ".$producto['codigo_barra']." - ".$producto['descripcion']; ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div> <!-- /.col-md-9 -->
                        </div> <!-- End row -->
                        <div class="col-md-12 bg-12">
                            <div class="box-body">
                                <table id="ing-prods" class="table table-hover" style="white-space:normal;">
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th class="cent-text">Cant.</th>
                                        <th class="hide-mobile">Item.</th>
                                        <th class="hide-mobile">Cód. prod.</th>
                                        <th>Descripción</th>
                                        <th>Precio Un.</th>
                                        <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <th class="hide-mobile"></th>
                                        <th class="hide-mobile"></th>
                                        <th></th>
                                        <th></th>
                                        <th>Descuento: <b><span id="descuento-preventa" name="descuento-valor" style="padding: 0 5px;"></span></b></th>
                                        <th class="text-right">Sub-total:</th>
                                        <th id="subtotal-preventa" class="bg-gray-light text-right bg-th"></th>
                                    </tfoot>
                                </table>
                            </div> <!-- /.box-body -->
                        
                        </div>
                    </div>
                </div>

                <!-- Segundo cuadro -->
                <div class="col-md-4 total-box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="form-group cent-text" style="margin-top:10px">
                                <label style="font-size:30px"> Total: </label>
                                <input type="text" id="total-valor" name="total-valor" class="input-total text-right text-red" style="font-weight:bold;width:100%;" style="font-weight:bold" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Items:</label>
                            <input type="number" class="form-control text-right" id="cant-items" value="0" readonly>
                        </div>
                        <div class="col-md-2" style="display:none;">
                            <label>Sub-items:</label>
                            <input type="number" class="form-control text-right" id="cant-sub-items" value="0" readonly>
                        </div>
                        <div class="col-md-10">
                            <label>Medio de pago:</label>
                            <select name="medio-pago" class="select2 form-control" id="medio-pago" style="width:100%;" >
                            <!-- <option value="1.1">1.1 - Tarjeta crédito: Visa</option>
                            <option value="1.2">1.2 - Tarjeta crédito: Mastercard</option>
                            <option value="1.3">1.3 - Tarjeta crédito: Naranja</option>
                            <option value="1.4">1.4 - Tarjeta crédito: American Express</option>
                            <option value="1.5">1.5 - Tarjeta crédito: Nativa</option>
                            <option value="1.6">1.6 - Tarjeta crédito: Cabal</option>
                            <option value="1.10">1.10 - Tarjeta débito: Visa débito</option>
                            <option value="1.11">1.11 - Tarjeta crédito: Maestro</option>
                            <option value="1.12">1.12 - Tarjeta crédito: Cabal débito</option>
                            <option value="2.1">2.1 - Efectivo U$D</option> -->
                            <option value="2.2" selected>2.2 - Efectivo $</option>
                            </select>
                        </div>
                        <div class="col-md-12 btn-margin">
                            <input type="button" id="btn-bonif" class="btn btn-block btn-default" value="F4 - Bonificación" disabled>
                        </div>
                        <div class="col-md-2 ocultar hide-all">
                            <label>Tipo bonif.:</label>
                            <select id="tipo-bonif" name="tipo-bonif" class="form-control select2 ocultar hide-all" style="width: 100%;">        
                            <option value="1">Descuento</option>
                            <option value="2">Prod. fallado</option>
                            <option value="3">Prod. no reconocido</option>
                            <option value="4">A favor cliente</option>
                            </select>
                        </div>
                        <div class="col-md-2 ocultar hide-all">
                            <label>%: </label>
                            <input type="number" class="form-control text-right solo-numero ocultar hide-all" id="monto-bonif" name="monto-bonif">
                        </div>
                        <div class="col-md-7 ocultar hide-all">
                            <label>Detalle</label>
                            <input type="text" class="form-control ocultar hide-all" id="detalle-bonif" name="detalle-bonif" readonly>
                        </div>
                        <div class="col-md-1 btn-margin hide-all">
                            <input type="button" id="btn-canc-bonif" class="btn btn-block btn-danger ocultar hide-all" value="X">
                        </div>
                        <div class="col-md-12 btn-margin" style="margin-bottom:15px">
                            <label for="comentarios">Comentarios:</label>
                            <textarea class="form-control" name="comentarios" id="coment_preventa" rows="3" ></textarea>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <input type="hidden" id="registro-modelo" value="crear-venta">
                        <input type="hidden" id="ganancia-prev" name="ganancia-prev" value="0">
                        <input type="hidden" id="id-cred" value="0">
                        <input type="hidden" name="user" value="<?php echo $user; ?>">
                        <input type="hidden" name="bd" value="<?php echo $bd; ?>">
                        <input type="hidden" name="avatar" value="<?php echo $avatar; ?>">
                        <input type="hidden" name="idb" value="<?php echo $idb; ?>">
                        <div class="col-md-12" style="margin-bottom:15px;">
                        <input type="submit" class="btn btn-primary" id="crear-venta" style="width:100%;" value="F2 - Generar venta" >
                        </div>
                        <div class="col-md-12">
                        <input type="reset" class="btn btn-danger" id="cancelar-preventa"  style="width:100%;" value="F4 - Borrar" >
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once '../templates/footer.php'; ?>
