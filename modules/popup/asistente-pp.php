<?php

    session_start();
    include_once('../funciones/bd_admin.php');

    $id = $_SESSION['id_user'];

    try {
        $sql = "SELECT * FROM users_business WHERE id_admin = $id";
        $cons = $conna->query($sql);
        $us = $cons->fetch_assoc();
        $fs = intval($us['first_steps']);
        $om = intval($us['om_fs']);
    } catch (\Throwable $th) {
        echo "Error: ".$th->getMessage();
    }
?>
<div class="cont-popup <?php if($fs > 0 || $om > 0){ echo 'hide-popup'; } else { echo "msg-pop"; } ?>">
    <div class="cont-msg-popup">
        <div class="carousel-popup" id="step1">
            <div class="head-popup">
                <h1 class="h1-popup"><span id="title-popup">¡Bienvenido/a a SISCON!</span></h1>
            </div>
            <div class="body-popup">
                <div class="img-body"></div>
                <div class="text-body">
                    <p class="title-body">
                        Este es el <strong>Asistente de Primeros Pasos</strong> de SISCON.<br>Te vamos a ayudar a configurar tu empresa y a conocer el funcionamiento del sistema.<br>
                        Este tutorial está dividido en <strong>4 sencillos pasos</strong> muy importantes.
                    </p><br>
                    <div class="continue-popup">
                        <button class="btn-popup" id="btn-sig-popup">Comencemos</button>
                    </div> 
                </div>
            </div>
        </div>
        <div class="carousel-popup carousel-pre" id="step2">
            <div class="head-popup" id="tt1">
                <h1>Paso 1</h1>
                <h2>Completa la información de tu empresa</h2>
            </div>
            <div class="head-popup carousel-pre" id="tt2">
                <h1>Paso 2</h1>
                <h2>Añade tu primer producto</h2>
            </div>
            <div class="head-popup carousel-pre" id="tt3">
                <h1>Paso 3</h1>
                <h2>Añade tu primer cliente</h2>
            </div>
            <div class="head-popup carousel-pre" id="tt4">
                <h1>Paso 4</h1>
                <h2>Comienza a facturar</h2>
            </div>
            <div class="head-popup carousel-pre" id="tt5">
                <h1>¡Todo listo!</h1>
            </div>
            <div class="body-popup">
                <div class="img-body"></div>
                <div class="text-body tit-h" id="txt1">
                    <p class="title-body">
                    En primer lugar ve dentro de <strong>NAVEGACIÓN PRINCIPAL <i class="fa fa-arrow-right"></i>&nbsp;CONFIGURACIONES</strong>, selecciona <span class="info-inline"><i class="fa fa-gears"></i>&nbsp;Config. Sistema</span> y luego <span class="info-inline"><i class="fa fa-gears"></i> Editar información</span>.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt2">
                    <p class="title-body">
                    Por defecto la imágen mostrada es la de <strong>SISCON</strong>, por lo que tendrás que cambiarla apretando el <strong>botón de la imágen</strong>, luego <strong>selecciona la de tu empresa</strong> y por último aprieta el botón <span class="info-inline">Subir y elegir imágen</span>.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt3">
                    <p class="title-body">
                    En la sección <strong>Información de la empresa</strong> vas a encontrar ingresados los datos que aportaste en la contratación.<br>Para poder <strong>editar</strong> o <strong>agregar</strong> la información tienes que apretar el botón <span class="info-inline"><i class="fa fa-edit"></i></span>, agregar o editar los datos que quieras y luego presionar el botón <span class="info-inline"><i class="fa fa-check"></i></span>.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt4">
                    <span class="title-body">
                        Has terminado el primer paso.<br><br>
                        <div class="cont-a" style="text-align:center;">
                            <strong>Recuerda realizar este paso antes de realizar tu primer venta.</strong><br>
                            <!-- <p><em>Recuerda que este paso es importante ya que al facturar sale la información de tu empresa.<em></p> -->
                            <!-- <a href="../pages/edit-config.php" class="btn-pp">Si, configurar ahora</a> -->
                        </div>
                    </span>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt5">
                    <p class="title-body">
                        Ten en cuenta que para poder añadir tu <strong>primer producto</strong> necesitas seguir estos pasos previos:
                        <ul class="list-popup">
                            <li>Añadir al menos un <strong>Proveedor</strong>.</li>
                            <li>Añadir al menos una <strong>Categoría</strong>.</li>
                            <li>Añadir al menos una <strong>Sub-categoría</strong>.</li>
                        </ul>
                        <p>En los siguientes pasos te explicamos cómo debes ingresar cada uno de estos.</p>
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt6">
                    <p class="title-body">
                        Para añadir un <strong>Proveedor</strong> ve a <span class="info-inline"><i class="fa fa-inbox"></i>&nbsp;Productos</span> y luego a <span class="info-inline"><i class="fa fa-truck"></i>&nbsp;Proveedores</span>.
                        En la sección <strong>Nuevos Proveedores</strong> ingresa el <strong>NOMBRE DEL PROVEEDOR</strong>, la <strong>DIRECCIÓN DEL PROVEEDOR</strong> (opcional) y un <strong>COMENTARIO</strong> (opcional).
                        Guarda los cambios en <span class="info-iniline">Ingresar proveedor</span>.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt7">
                    <p class="title-body">
                        Para añadir una <strong>Categoría</strong> ve a <span class="info-inline"><i class="fa fa-inbox"></i>&nbsp;Productos</span> y luego a <span class="info-inline"><i class="fa fa-cloud"></i>&nbsp;Administrar categorías</span>.
                        Ve a la sección <strong>Creación de categorías y sub-categorías</strong>. Añade el nombre de la primer <strong>Categoría</strong>. Guarda los cambios.<br>
                        Luego añade una <strong>Sub-categoría</strong> seleccionando la categoría que creaste y vuelve a guardar los cambios.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt8">
                    <span class="title-body">
                        Has terminado el segundo paso.<br><br>
                        <div class="cont-a" style="text-align:center;">
                            <strong>Recuerda realizar este paso antes de añadir un nuevo producto.</strong><br>
                            <!-- <p><em>Recuerda que este paso es importante ya que al facturar sale la información de tu empresa.<em></p> -->
                            <!-- <a href="../pages/crear-producto.php" class="btn-pp">Si, configurar ahora</a> -->
                        </div>
                    </span>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt9">
                    <p class="title-body">
                        Ahora puedes añadir tu <strong>primer cliente</strong>, pero debes realizar este paso previamente:
                        <ul class="list-popup">
                            <li>Añadir al menos una <strong>Ciudad</strong>.</li>
                        </ul>
                        <p>En el siguiente paso te vamos a mostrar como configurar y añadir tus clientes.</p>
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt10">
                    <p class="title-body">
                        Para añadir una <strong>Ciudad</strong> ve a <span class="info-inline"><i class="fa fa-address-book"></i>&nbsp;Clientes</span> y luego <span class="info-inline"><i class="fa fa-cloud"></i>&nbsp;Administrar ciudades</span>.
                        En la sección <strong>Administrar ciudades</strong> añade una ciudad dentro de <strong>Agregar ciudad</strong> y guarda.<br><br>
                        <em><strong>NOTA:</strong>&nbsp;Si presionas en el botón <span class="info-inline">Ver</span> podrás ver la ciudad que ingresaste.</em>
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt11">
                    <p class="title-body">
                        Ahora si ya puedes <strong>añadir tu primer cliente</strong>.<br>
                        Ve a <span class="info-inline"><i class="fa fa-address-book"></i>&nbsp;Clientes</span> y luego <span class="info-inline"><i class="fa fa-plus-circle"></i>&nbsp;Nuevo cliente</span> y completa los datos de tu cliente.<br><br>
                        <em><strong>NOTA:</strong>&nbsp;Puedes ingresar un cliente con el nombre <strong> Consumidor final</strong> para generalizar una factura.</em>
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt12">
                    <span class="title-body">
                        Has terminado el tercer paso.<br><br>
                        <div class="cont-a" style="text-align:center;">
                            <strong>Asegúrate de haber realizado este paso antes de hacer tu primer venta, de lo contrario no vas a poder hacerla.</strong><br>
                            <!-- <p><em>Recuerda que este paso es importante ya que al facturar sale la información de tu empresa.<em></p> -->
                            <!-- <a href="../pages/nuevo-cliente.php" class="btn-pp">Si, configurar ahora</a> -->
                        </div>
                    </span>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt13">
                    <p class="title-body">
                        Con los pasos previos realizados ya puedes comenzar a realizar tu <strong>primera venta</strong>.<br>
                        Para ello ve a <span class="info-inline"><i class="fa fa-shopping-bag"></i>&nbsp;Ventas</span> y luego <span class="info-inline"><i class="fa fa-plus-circle"></i>&nbsp;Nueva venta</span>.
                    </p>
                </div>
                <div class="text-body tit-h carousel-pre" id="txt14">
                        Ya tienes todo listo para poder utilizar <strong>SISCON</strong>.<br><br>
                        Recuerda que si quieres volver a ver este tutorial lo puedes hacer presionando <span class="info-inline"><i class="fa fa-question"></i>&nbsp;Ayuda</span> y luego <span class="info-inline"><i class="fa fa-gears"></i>&nbsp;Tutorial</span>.
                    </p><br>
                    <div class="continue-popup">
                        <button class="btn-pp btn-sec" id="btn-ok-popup">Listo</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-popup">
            <div class="foot-popup">
                <div class="actions-popup hide">
                    <!-- <a href="../pages/edit-config.php" class="btn-pp btn-sec" id="sig-step1">Ir a la configuración</a> -->
                    <button id="atras" class="btn-pp btn-sig hide">Atras</button>
                    <button id="siguiente" class="btn-pp btn-sec">Siguiente</button>
                </div>
            </div>
            <div class="foot-popup-info">
                <div class="p-footer">
                    <a href="#" class="a-popup" id="omitir-fs"><strong>Omitir</strong></a>
                </div>
                <!-- <div class="p-footer hide">
                    <p>Paso 1 de 4</p>
                </div> -->
            </div>
            
        </div>
    </div>
</div>