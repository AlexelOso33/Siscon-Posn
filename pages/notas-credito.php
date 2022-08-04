<?php 
  include_once '../funciones/sesiones.php';
  include_once '../funciones/bd_conexion.php';
  include_once '../templates/header.php'; 
  include_once '../templates/barra.php';
  include_once '../templates/navegacion.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de notas de crédito
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border orange-icon">
              <h3 class="box-title">Administrar las notas de crédito en esta lista</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="l-ventas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Núm.</th>
                  <th>Número factura</th>
                  <th>Nota Cred. Int.</th>
                  <th>Cliente</th>
                  <th>Productos</th>
                  <th>Total</th>
                  <th>Vendedor</th>
                  <th>Facturación</th>
                  <th>Fecha NCI</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $cont = 1;
                    try {
                        $sql = "SELECT * FROM ncreditos ";
                        $sql .= " INNER JOIN ventas ON ncreditos.venta_id=ventas.id_venta ";
                        $sql .= " INNER JOIN clientes ON ventas.cliente_id=clientes.id_cliente ";
                        $sql .= " INNER JOIN vendedores ON ventas.id_vend_venta=vendedores.id_vendedor ";
                        $sql .= " ORDER BY id_venta ASC";
                        $resultado = $conn->query($sql);
                    } catch (\Throwable $th) {
                        echo "Error al intentar conectar con la base de datos. Recargue la página.";
                    }
                    while($venta = $resultado->fetch_assoc() ){ ?>
                        <tr>
                            <td class="cent-text" style="font-weight:bold;"><?php echo $cont; ?></td>
                            <td class="cent-text"><?php echo str_pad($venta['n_venta'], 7, "0", STR_PAD_LEFT); ?></td>
                            <td class="cent-text"><b><?php echo str_pad($venta['id_ncred'],7, "0", STR_PAD_LEFT); ?></b></td>
                            <td><?php echo $venta['nombre']. " " .$venta['apellido']; ?></td>
                            <td class="cent-text">
                                <a href="#" data-prod="<?php echo $venta['productos']; ?>" class="btn btn-flat btn-default info-nci" value="...">
                            </td>
                            <td class="text-red right-text"><b><?php echo "$".$venta['total']; ?></b></td>
                            <td><?php echo $venta['nombre_vendedor']; ?></td>
                            <?php
                                if($venta['facturacion'] == 0){
                                  $fecfac = "S/F";
                                } else {
                                  $f = $venta['facturacion'];
                                  $f = explode(" ", $f);
                                  $fe = $f[0];
                                  $fec = explode("-", $fe);
                                  $fecfac = $fec[2]."-".$fec[1]."-".$fec[0];
                                }
                            ?>
                            <td><?php echo "<i>".$fecfac."</i>"; ?></td>
                            <td><?php
                              $f = explode(" ", $venta['fec_includ']);
                              $fecha = $f[0];
                              $h = $f[1];
                              $fecha = explode("-", $fecha);
                              $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                              echo $fecha." ".$h;
                            ?>
                            </td>
                        </tr>
                    <?php 
                        $cont = $cont+1;    
                    }
                    ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Núm.</th>
                  <th>Número factura</th>
                  <th>Nota Cred. Int.</th>
                  <th>Cliente</th>
                  <th>Productos</th>
                  <th>Total</th>
                  <th>Vendedor</th>
                  <th>Facturación</th>
                  <th>Fecha NCI</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once '../templates/footer.php'; ?>