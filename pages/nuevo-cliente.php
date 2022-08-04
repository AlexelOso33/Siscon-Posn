<?php 

    $dir = "https://siscon-system.com/";

    include_once $dir.'funciones/sesiones.php';
    include_once $dir.'/funciones/bd_conexion.php';
    include_once $dir.'/funciones/info_system.php';
    include_once $dir.'/templates/header.php'; 
    include_once $dir.'/templates/barra.php';
    include_once $dir.'/templates/navegacion.php';

    if($t_serv == 2){
        header('Location: '.$dir.'/auth.html');
    }
  
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ingrese un nuevo cliente
        <small></small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
          <!-- general form elements -->
          <div style="width:80%;margin: 0 auto;">
            <div class="box box-primary">
                <div class="box-header with-border orange-icon">
                    <h3 class="box-title col-md-6">Datos del cliente</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" id="registro-cliente" name="registro-cliente" action="../actions/modelo-cliente.php">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="name" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="name" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Dirección:</label>
                                <input type="name" class="form-control" id="direccion" name="direccion" placeholder="Dirección del cliente">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nro:</label>
                                <input type="name" class="form-control" id="numero" name="numero" placeholder="Ej: 106...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Barrio:</label>
                                <input type="name" class="form-control" id="barrio" name="barrio" placeholder="Ej: Bo San Pedro">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Ciudad:</label>
                                <select type="name"  class="form-control select2" style="width: 100%;" id="ciudad" name="ciudad">
                                    <?php
                                        try {
                                            $sql = "SELECT * FROM `ciudades` ORDER BY `ciudad` ASC";
                                            $consulta = mysqli_query($conn, $sql);
                                            while($ciudad = mysqli_fetch_assoc($consulta)){
                                                echo '<option value="'.$ciudad['id_ciudad'].'">'.$ciudad['ciudad'].'</option>';
                                            }
                                        } catch (\Throwable $th) {
                                            echo "Error: ".$th->getMessage();
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <!-- Date picker -->
                            <div class="form-group">
                                <label>F. de nac.:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                <input type="text" class="form-control pull-right datepicker" name="fecha_nac" autocomplete="off">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        </div>
                        <div class="col-md-3">
                            <!-- telefono + mask -->
                            <div class="form-group">
                                <label>Teléfono:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                    <input type="text" id="telefono" name="telefono" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-2 box-check">
                        <!-- checkbox Celular -->
                            <div class="form-group box-check">
                                <div class="label-radio">
                                    <label for="celu">Es celular</label>
                                </div>
                                <div class="label-select">
                                    <input type="radio" class="minimal" id="si-cel" name="celular" value="si" checked>
                                    Si
                                    <input type="radio" class="minimal" name="celular" value="no">
                                    No
                                </div>
                            </div>
                        </div>
                        <!-- textarea -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Comentarios:</label>
                                <textarea class="form-control" name="comentarios" rows="3" placeholder="Ingrese algún comentario si lo desea..."></textarea>
                            </div>
                        </div>
                    </div>  <!-- /.box-body -->
                    <div class="modal-footer">
                        <div class="box-footer" style="margin:0 auto;">
                        <input type="hidden" name="zonas-select" value="0">
                            <input type="hidden" name="registro-modelo" value="nuevo">
                            <button type="submit" name="agregar" id="agregar" class="btn btn-primary" style="width:250px;">
                            <?php
                                if(isset($_GET['mov'])){ ?>
                                Guardar y seleccionar
                            <?php } else { ?>
                                Guardar
                            <?php } ?>
                            </button>
                            <?php
                            if(isset($_GET['mov'])){ ?>
                                <a href="crear-venta.php" class="btn btn-warning" style="width:200px;">Volver</a>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include_once $dir.'/templates/footer.php'; ?>
