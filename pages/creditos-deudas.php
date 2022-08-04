<?php 
  include_once '../funciones/sesiones.php';
  include_once '../funciones/bd_conexion.php';
  include_once '../templates/header.php'; 
  include_once '../templates/barra.php';
  include_once '../templates/navegacion.php';

  if(isset($_GET['sel-cliente-cd'])){
    $cliente = $_GET['sel-cliente-cd'];
  }
 
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Créditos y deudas
        <small></small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <div class="box-header with-border orange-icon">
          <h3 class="box-title">Información total de créditos y deudas</h3>
        </div>
        <div class="row" style="padding: 0 10px;">
          <div class="col-lg-3 col-xs-3">
            <!-- small box -->
            <div class="small-box t-shadow bg-olive">
              <?php
              try {
                $sql = "SELECT DISTINCT cliente_id FROM credeudas ORDER BY cliente_id";
                $resultado = $conn->query($sql);
                $cred = 0;
                $deud = 0;
                while($cd = $resultado->fetch_assoc()){
                  $nc = $cd['cliente_id'];
                  if($nc !== $nc1){
                    try {
                      $sql = "SELECT * FROM credeudas WHERE cliente_id = $nc ORDER BY fecha DESC LIMIT 1";
                      $result = $conn->query($sql);
                      $nresult = $result->fetch_assoc();
                      $c = $nresult['credito'];
                      $d = $nresult['deuda'];
                      $cred = $cred+$c;
                      $deud = $deud+$d;
                    } catch (\Throwable $th) {
                      echo "Error: ".$th->getMessage();
                    }
                  }
                }
              } catch (\Throwable $th) {
                echo "Error: ".$th->getMessage();
              }
              ?>
              <div class="inner cent-text">
                <h3><sup style="font-size: 20px">$</sup><span id="tot-credito"><?php echo $cred; ?></span></h3>
                <p>Total actual en créditos</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-3">
            <!-- small box -->
            <div class="small-box t-shadow bg-yellow">
              <div class="inner cent-text">
                <h3><sup style="font-size: 20px">$</sup><span id="tot-deuda"><?php echo $deud; ?></span></h3>
                <p>Total actual en deudas</p>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <label>Clientes con mov.:</label>
            <select class="form-control select2" id="select-cliente-cd" style="width:100%;">
              <option value="0">- Seleccione -</option>
              <?php
              try {
                $sql = "SELECT * FROM clientes WHERE id_creditos > 0";
                $result = $conn->query($sql);
                while($cliente = $result->fetch_assoc()){
                  $cl = $cliente['id_cliente'];
                  if(is_null($cl)){ ?>
                    <option value="" disabled="disabled">No hay clientes con créditos o deudas</option>
                  <?php } else { ?>
                    <?php try {
                      $sql = "SELECT * FROM credeudas WHERE cliente_id = $cl ORDER BY fecha DESC LIMIT 1";
                      $resultado = $conn->query($sql);
                      $nr = $resultado->fetch_assoc();
                      $nc = $nr['credito'];
                      $nd = $nr['deuda'];
                      if($nc > 0 || $nd > 0){ ?>
                    <option value="<?php echo $cl; ?>"><?php echo $cliente['nombre']." ".$cliente['apellido']; ?></option>
                  <?php } 
                    } catch (\Throwable $th) {
                      echo "Error: ".$th->getMessage();
                    }
                  }
                }
              } catch (\Throwable $th) {
                echo "Error: ".$th->getMessage();
              }
              ?>              
            </select>
          </div>
          <div class="col-md-2">
            <label>Crédito:</label>
            <input type="text" class="form-control text-olive cent-text" id="cred-cliente-uno" value="$0" style="width:100%;font-weight:bold;" readonly>
          </div>
          <div class="col-md-2">
            <label>Deuda:</label>
            <input type="text" class="form-control text-yellow cent-text" id="deud-cliente-uno" value="$0" style="width:100%;font-weight:bold;" readonly>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="box-header with-border orange-icon">
          <h3 class="orange-icon box-title">Administrar créditos y deudas por cliente</h3>
        </div>
        <div class="box-body">
          <form action="../actions/modelo-cliente.php" type="POST" name="ingreso-credeuda" id="ingreso-credeuda">
            <div class="row">
              <div class="col-md-3">
                <label>Seleccione cliente:</label>
                <select class="form-control select2" name="sel-cliente-cd" id="sel-cliente-cd" style="width:100%;">
                  <option value="0">- Seleccione -</option>
                  <?php
                  try {
                    $sql = "SELECT * FROM clientes ORDER BY nombre";
                    $result = $conn->query($sql);
                  } catch (\Throwable $th) {
                    echo "Error: ".$th->getMessage();
                  }
                    while($cliente = $result->fetch_assoc()){ ?>
                  <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre']." ".$cliente['apellido']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-5">
                <label for="fact-afect">Factura a afectar:</label>
                <select class="select2 form-control" name="fact-afect" id="fact-afect" style="width:100%;" disabled>
                    <option value="0"> - Seleccionar venta -</option>
                </select>
              </div>
              <div class="col-md-2">
                <label style="width:100%;">Tipo crédito:</label>
                <div class="form-group cent-text">
                  <select class="form-control select2" name="sel-tipo-cd" id="sel-tipo-cd" style="width:100%;" disabled>
                      <option value="1">Crédito</option>
                      <option value="2">Deuda</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <label>Ingreso ($):</label>
                <input type="number" class="form-control solo-numero-cero cent-text" name="ingreso-cd" id="ingreso-cd" value="0" size="6" required disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <label>Observación:</label>
                <textarea class="form-control" id="coment-cd" name="coment-cd" rows="1" maxlength="150" placeholder="Ej: Saldo a favor por venta Nºx-xxxxxxx..." disabled></textarea>
              </div>
              <div class="col-md-2">
                <input type="hidden" name="tipo-accionar" value='ing-credeuda'>
                <input type="submit" id="btn-ing-cd" class="btn btn-success btn-flat" value="Ingresar"
                style="margin-top:25px;width:100%;" disabled>
              </div>
            </div>
          </form>
          <div style="margin:20px 0;">
            <table id="registro-cd" class="table table-bordered table-striped" id="table-credeuda" style="margin: 10px 0;">
              <thead>
                <th>Núm</th>
                <th>Crédito</th>
                <th>Deuda</th>
                <th>Venta afectada</th>
                <th>Comentarios</th>
                <th>Fecha</th>
                <th>Hora</th>
              </thead>
              <tbody id="tb-credeuda">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php include_once '../templates/footer.php'; ?>