<?php
    include_once '../templates/header.php';
    include_once '../funciones/bd_conexion.php';
    
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Actualización
            <small>de productos</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title orange-icon">Actualización masiva de productos</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" id="update-prods" name="update-prods" action="../actions/modelo-productos.php">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Seleccionar por proveedor:</label>
                        <select class="form-control select2"  id="sel-mult-prov" multiple="multiple" data-placeholder="Buscar proveedores..."
                        style="width: 100%;">
                            <?php
                                try {
                                    $sql2 = "SELECT * FROM proveedores ORDER BY nombre_proveedor ASC";
                                    $res2 = $conn->query($sql2);
                                    while($prov = $res2->fetch_assoc()){
                                        echo "<option value='".$prov['id_proveedor']."'>".$prov['nombre_proveedor']."</option>";
                                    }
                                } catch (\Throwable $th) {
                                    echo "Error al intentar conectar con la BD.";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Seleccione el producto:</label>
                            <select name="sel-prod" id="sel-prod" class="form-control select2" style="width:100%;">
                                <option value="0">- Seleccione -</option>
                                <?php
                                    $sql = "SELECT * FROM productos WHERE estado = 1 AND NOT categoria_id = 18 ORDER BY descripcion ASC";
                                    $resultado = $conn->query($sql);
                                    while($p = $resultado->fetch_assoc()){ ?>
                                        <option value="<?php echo $p['id_producto']; ?>"><?php echo $p['codigo_prod']." - ".$p['descripcion']; ?></option>
                                    <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Precio costo:</label>
                            <input type="number" class="form-control text-right solo-numero-cero" id="precio-costo" name="precio-costo-act" value="0" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Precio venta:</label>
                            <input type="number" class="form-control text-right text-red solo-numero-cero" id="precio-venta" name="precio-venta-act" value="0" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- ganancia -->
                        <div class="form-group">
                            <label>Porc. (%):</label>
                            <input type="number" class="form-control cent-text text-green solo-numero-cero" id="ganancia" name="ganancia-act" value="0" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="button" class="btn btn-flat btn-default btn-margin" id="btn-access-act" value="Ingresar" style="width:100%;" disabled>
                    </div>
                </div>
                <div class="col-md-12" style="overflow:auto;">
                    <table id="ing-act-prods" class="table table-hover" style="margin-top:20px;border:1px solid gray;overflow:auto;">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <th>Producto</th>
                                <th>Cód. prod.</th>
                                <th>Costo</th>
                                <th>Venta</th>
                                <th>Ganancia</th>
                            </tr>
                        </thead>
                        <tbody id="app-tb-act">

                        </tbody>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
                </div>
                <div class="box-footer" style="width:100%;">
                    <input type="hidden" id="registro-modelo" value="actualizar-mprods">
                    <input type="hidden" id="pc" value="0">
                    <input type="hidden" id="pv" value="0">
                    <input type="hidden" id="ga" value="0">
                    <input type="submit" class="btn btn-primary" id="act-products" value="Actualizar" style="margin:0 auto;width:500px;display:block;margin:auto;"></input>
                </div>
            </div> <!-- /.box-body -->
            </form>
            <div class="box-body">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> ¡Importante!</h4>
                    Recuerde que en caso de actualizar algún producto que esté afectado a alguna promoción debe ingresar a la <strong><a href="../pages/lista-productos.php">lista de productos</a></strong>, buscar la <b>promoción afectada</b>, <b>borrar el producto</b> y <b>volver a incorporarlo</b>.
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>


<?php include_once '../templates/footer.php'; ?>