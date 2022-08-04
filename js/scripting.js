$(document).ready(function(){
    var disp_num;
    var submit_btn = false;

    setInterval(function(){
        disp_num = '';
    }, 1000);

     // Funciones adicionales (botones)
     $(document).on('keypress', '.solo-numero, .solo-numero-cero', function (e){
        //this.value = (this.value + '').replace(/[^0-9.]/g, '');
        if (e.which > 57 || e.which < 46) {
            if(e.which == 47) {
                e.preventDefault();
            }
            e.preventDefault();
        }
        let esto = $(this).val();
        if(e.which == 46 && esto.indexOf(".") >= 0) { // Reemplazo . por ,
            e.preventDefault();
        }
        
        /* // Cambia . por ,
        if(esto.indexOf(".") >= 0){
            esto.replace(".", ",");
        } */
    });
    $(document).on('keypress', '.solo-numero-popup', function (e){
        if (e.which > 57 || e.which < 46) {
            if(e.which == 47) {
                e.preventDefault();
            }
            e.preventDefault();
        }
    });
    $(document).on('focus', '.solo-numero-cero, .solo-numero', function(){
        $(this).select();
    });
    $(document).on('blur', '.solo-numero', function(){
        var esto = parseFloat($(this).val());
        esto = esto.toFixed(2);
        console.log(esto);
        if(esto <= 0.01 || ""){
            $(this).val(0.01);
        } else {
            $(this).val(esto);
        }
        if(!parseFloat(esto)){$(this).val(0.01);}
    });
    $(document).on('blur', '.solo-numero-cero', function(){
        var esto = parseFloat($(this).val());
        esto = esto.toFixed(2);
        if(esto === ""){
            $(this).val("0");
        } else {
            $(this).val(esto);
        }
        if(!parseFloat(esto)){$(this).val(0);}
    });

    $(document).on('keydown', 'body', function(e){

        if(e.keyCode == 119){
            e.preventDefault();
            $('select').select2('close');
            $('#buscar-producto').select2('open');
        }

        if(e.keyCode == 113){
            e.preventDefault();
            if(submit_btn === false){
                console.log('submitted');
                submit_btn = true;
                $('#crear-preventa-form').trigger('submit');
            }
        }

        if(e.keyCode == 114){
            e.preventDefault();
            $('select').select2('close');
            $('#buscar-cliente').select2('open');
        }

        if(e.keyCode == 115 || e.which == 115){
            e.preventDefault();
            console.log('reseted');
            $('#crear-preventa-form').trigger('reset');
            resetFormVenta();
        }
    })

    // Disparador de generación de venta
    $('#crear-preventa-form').on('submit', function(e){
        e.preventDefault();

        var cliente = parseInt($('#buscar-cliente, #buscar-cliente-prev').select2('val'));
        console.log(cliente);
        if(cliente > 0){
            // Comprobación de caja
            $.ajax({
                type: 'POST',
                data: {
                    'tipo-accionar' : 'tomar-caja-abierta'
                },
                url: '../funciones/modelos.php',
                success: function(data){
                    var d = JSON.parse(data);
                    if(d.respuesta !== 'ok'){
                        swal.fire(
                            '¡Atención!',
                            'Debe abrir primero caja para poder generar la venta.',
                            'error'
                        )
                        $('#crear-venta, #guardar-venta, #enviar-venta').attr('disabled', false);
                        submit_btn = false;
                        return false;
                    } else if(d.respuesta == 'ok') {
                        var tipo_form = 'crear-venta';
                        var total = $('#total-valor').val();
                        if(total == "") {
                            Swal.fire(
                                'Formulario vacío!',
                                'Revise el contenido.',
                                'warning'
                                )
                                submit_btn = false;
                        } else {

                            // Variables
                            var comprobante = $('#comprobante').val();
                            var productos = "";
                            var vendedor_select = $('#vendedor-prev').val();
                            var longe = $('tbody tr').length;
                            var comentarios = $('textarea#coment_preventa').val();
                            var usa_cred = $('#credito').html();
                            usa_cred = 0;
                            var ganancia_prev = $('#ganancia-prev').val();
                            var id = $('#id-venta').val();
                            var credito = $('#id-cred').val();
                            for(var i = 0; i < longe; i++) {
                                productos += $('tbody').find('tr:eq('+i+')').find('td:eq(1)').children('input').val();
                                productos += "-"+$('tbody').find('tr:eq('+i+')').find('td:eq(2)').html()+" ";
                            }
                            total = total.split('$');
                            total = parseFloat(total[1]);
                            var select = $('.ocultar');
                            if(!select.hasClass('hide-all')) {
                                var tipo_bonif = $('#tipo-bonif').val();
                                var monto_bonif = $('#monto-bonif').val();
                                var detalle_bonif = $('#detalle-bonif').val();
                            } else {
                                var tipo_bonif = 0;
                                var monto_bonif = 0;
                                var detalle_bonif = "";
                            }
                            var medio_p = $('#medio-pago').val();
                            
                            var fecha_ent = $('.datepicker').val();
                            var usuario = $('#usuario').val();

                            Swal.fire({
                                text: 'Guardando la venta. Por favor, espere...',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                },
                            })

                            $.ajax({
                                type: 'post',
                                data: {
                                    'cliente-preventa' : cliente,
                                    'vendedor-id' : vendedor_select,
                                    'comprobante' : comprobante,
                                    'productos-contenido' : productos,
                                    'id-bonif' : tipo_bonif,
                                    'ganancia_prev' : ganancia_prev,
                                    'monto-bonif' : monto_bonif,
                                    'detalle-bonif' : detalle_bonif,
                                    'id-credito' : credito,
                                    'usa-credito' : usa_cred,
                                    'valor-total' : total,
                                    'comentarios' : comentarios,
                                    'medio-pago' : medio_p,
                                    'fecha-ent' : fecha_ent,
                                    'id' : id,
                                    'registro-modelo' : tipo_form
                                },
                                url: '../funciones/modelos.php',
                                success: function(d) {
                                    var data = JSON.parse(d);
                                    swal.close();
                                    if(data.respuesta == 'exitoso') {
                                        var idVenta = data.id_venta;
                                        var passHash = data.venta_hashed;
                                        var busi = data.busi;
                                        swal.fire({
                                            title: 'Opciones de venta',
                                            html: 'La venta se ha generado con éxito. <br>¿Qué deseas hacer ahora?<br><br>'+
                                            '<div class="cent-text" style="width:100%;margin: 2rem 0;">'+
                                                '<input type="button" class="btn btn-warning" data-id-venta="'+idVenta+'" data-pass-hash="'+ passHash +'" data-id-cliente="'+ cliente +'" data-business="'+ busi +'" id="enviar-venta" style="background-color: #00af9c;width:100%;" value="Enviar por Whatsapp">'+
                                            '</div>'+
                                            '<div class="cent-text" style="width:100%;margin: 2rem 0;">'+
                                                '<input type="button" class="btn btn-primary" data-id-venta="'+idVenta+'" data-pass-hash="'+ passHash +'" id="imprimir-venta" style="width:100%;" value="Imprimir venta">'+
                                            '</div>',
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            showCancelButton: true,
                                            cancelButtonText: 'Cerrar'
                                        }).then((resp) => {
                                            if(resp.dismiss){
                                                resetFormVenta();
                                            }
                                        })
                                    } else {
                                        Swal.fire(
                                            '¡Oh, no!',
                                            'Error al ingresar los datos. Intente nuevamente.',
                                            'error'
                                        );
                                        submit_btn = false;
                                    }
                                }
                            })     
                        }
                    }
                }
            })
        } else {
            swal.fire(
                '¡Atención!',
                'Debe seleccionar un cliente para poder generar la venta.',
                'error'
            );
            submit_btn = false;
        }
    })

    // Función tomar productos
    $('#buscar-producto').on('change', function(){
        var producto = parseInt($('#buscar-producto').select2('val'));
        var c = '1.00';
        if(producto > 0) {
            $.ajax({
                type: 'post',
                data: {
                    'producto_id' : producto,
                    'cantidad' : c,
                    'tipo-accionar' : 'buscar-productos'
                },
                url: '../funciones/modelos.php',
                dataType: 'json',
                success: function(data) {
                    var prod_traido = data.producto;
                    var c_traida = data.cant;
                    var dc = data.cod;
                    var ganacia_mas = data.ganancia;
                    var item = parseInt(data.item);
                    var sitem = parseInt(data.sitem);
                    var a_item = parseInt($('#cant-items').val());
                    var a_sitem = parseInt($('#cant-sub-items').val());
                    // Variables modificadas
                    ganacia_mas = c*ganacia_mas;
                    ganacia_mas = parseFloat(ganacia_mas);
                    ganacia_mas = ganacia_mas.toFixed(2);
                    var gan_inp =  $('#ganancia-prev').val();
                    var stotal = $('#subtotal-preventa').html();
                    stotal = stotal.split("$");
                    stotal = stotal[1];
                    var ganacia = parseFloat(gan_inp)+parseFloat(ganacia_mas);
                    ganacia = ganacia.toFixed(2);
                    var total = data.total;
                    total = parseFloat(total);
                    total = total.toFixed(2);
                    var descuento = $('#descuento-preventa').html();
                    if(descuento == "") {
                        descuento = 0;
                     } else {
                        descuento = descuento.split('$');
                        descuento = descuento[1];
                    }
                    var cuenta = total-descuento;
                    cuenta = parseFloat(cuenta);
                    cuenta = cuenta.toFixed(2);
                    var cantidad = '<td class="cent-text"><a href="#" data-ganancia="'+ganacia_mas+'" data-total="'+total+'" data-sitem="'+sitem+'" class="btn btn-td bg-maroon btn-flat borrar-td" style="margin-right:8px;width:100%;"><i class="fa fa-trash"></i></a></td><td class="cent-text"><input type="text" class="form-control cant-tab solo-numero" data-id="'+producto+'" style="width:100px;text-align: right;" value="'+c+'"></td>';
                    var string = cantidad+data.string;
                    
                    // !- Declaración de variables
                    if(data.res == 'no'){
                        if(cant = 0){
                            swal.fire(
                                '¡Atención!',
                                'No queda stock de '+dc+'.',
                                'error'
                            )
                        } else {
                            swal.fire({
                                title: '¡Atención!',
                                html: 'Solamente quedan <b>'+c_traida+' <i>'+dc+'</i></b>. Por favor, ingrese una cantidad menor.',
                                icon: 'warning'
                            })
                        }
                    } else {
                        // var long = $("tbody").find("tr").length;
                        var nitem = item+a_item;
                        var nsitem = sitem+a_sitem;
                        var long = nitem+nsitem;
                        if(long <= 13){
                            if(long == 0){
                                $('tbody').html("<tr>"+string+"</tr>");
                                $('#ganancia-prev').val(ganacia);
                                $('#subtotal-preventa').html("$"+total);
                                $('#total-valor').val("$"+cuenta);
                                $('#cant-items').val(item);
                                $('#cant-sub-items').val(sitem);
                            } else {
                                var comp = '';
                                var nt_item = a_item+item;
                                var nt_sitem = a_sitem+sitem;
                                for(var i = 0; i < long; i++){
                                    var busq = $('table').children('tbody').children('tr').eq(i).find('td:eq(2)').html();
                                    if(prod_traido == busq){
                                        comp += 'si';
                                    } else {
                                        comp += '';
                                    }
                                }
                                if(comp == ''){
                                    $('tbody').append("<tr>"+string+"</tr>");
                                    var cu = 0;
                                    var lg = $("tbody").find("tr").length;
                                    for(var i = 0; i < lg; i++){
                                        var nval = $('tbody').children('tr').eq(i).find('td:eq(6)').html();
                                        nval = nval.split('$');
                                        nval = nval[1];
                                        cu = parseFloat(nval) + parseFloat(cu);
                                        cu = parseFloat(cu);
                                        cu = cu.toFixed(2);
                                    }
                                    $('#subtotal-preventa').html('$'+cu);
                                    $('#ganancia-prev').val(ganacia);
                                    var nstot = $('#subtotal-preventa').html();
                                    nstot = nstot.split("$");
                                    nstot = nstot[1];
                                    nstot = parseFloat(nstot);
                                    var ncuenta = nstot-descuento;
                                    ncuenta = parseFloat(ncuenta);
                                    ncuenta = ncuenta.toFixed(2);
                                    $('#total-valor').val("$"+ncuenta);
                                    $('#cant-items').val(nt_item);
                                    $('#cant-sub-items').val(nt_sitem);
                                } else {
                                    swal.fire({
                                        title: '¡Atención!',
                                        html: 'El producto <b>'+dc+'</b> ya está ingresado en la preventa.',
                                        icon: 'warning'
                                    })
                                }
                            }
                        } else {
                            swal.fire(
                                '¡Atención',
                                'Debe generar una nueva preventa, ya que llegó al máximo de productos.',
                                'error'
                            );
                        }
                    }
                }
            })
        }
        // $('#cant-productos').val('1.00');
    });

    // Función para borrar el TD al apretar eliminar en el TABLE DOM
    $(document).on('click', '.borrar-td', function(e){
        e.preventDefault();
        var ganancia_prod = $(this).closest('tr').find('td').eq(0).children('a').attr('data-ganancia');
        var desc_td = $(this).closest('tr').find('td').eq(0).children('a').attr('data-total');
        var sitem = parseInt($(this).closest('tr').find('td').eq(0).children('a').attr('data-sitem'));
        var desc_input = $('#total-valor').val();
        var imp_gan = $('#ganancia-prev').val();
        var cant_items = parseInt($('#cant-items').val());
        var a_sitem = parseInt($('#cant-sub-items').val());
        desc_input = desc_input.split("$");
        desc_input = desc_input[1];
        desc_input == "" ? desc_input = 0 : desc_input = parseFloat(desc_input);
        var total_fin = desc_input-desc_td;
        ganancia_prod = parseFloat(ganancia_prod);
        var tot_gan_n = parseFloat(imp_gan)-parseFloat(ganancia_prod);
        tot_gan_n = parseFloat(tot_gan_n);
        cant_items = cant_items-1;
        var res_sitem = a_sitem-sitem;
        $('#ganancia-prev').val(tot_gan_n.toFixed(2));
        if(total_fin !== 0) {
            $('#total-valor').val("$"+total_fin.toFixed(2));
            $('#subtotal-preventa').html("$"+total_fin.toFixed(2));
            $('#cant-items').val(cant_items);
            $('#cant-sub-items').val(res_sitem);
        } else {
            $('#total-valor').val("");
            $('#subtotal-preventa').html("");
            $('#cant-items').val(0);
            $('#cant-sub-items').val(0);
        }
        $(this).closest('tr').remove();
    });

    // Función para cambio de cantidad en ventas y presupuesto
    $(document).on('change keyup', '.cant-tab', function(){
        var pr = parseInt($(this).attr('data-id'));
        var cant = $(this).val();
        var esto = $(this);
        var a_item = parseInt($('#cant-items').val());
        var a_sitem = parseInt($('#cant-sub-items').val());
        var t = $(this).closest('tr').find('.total-prev');
        var camb = $(this).closest('tr').find('td').eq(0).children('a');
        if(cant > 0){
            $.ajax({
                type: 'post',
                data: {
                    'producto' : pr,
                    'cant' : cant,
                    'action' : 'cant-producto'
                },
                url: '../funciones/modelos.php',
                dataType: 'json',
                success: function(data){
                    if(data.res == 'ok'){
                        var c = parseFloat(data.cant);
                        var pventa = data.pVenta;
                        var pcosto = data.pCosto;
                        var ganacia = parseFloat(pventa) - parseFloat(pcosto);
                        var ganancia = ganacia * c;
                        var total = data.total;
                        t.html("$"+total);
                        camb.attr('data-ganancia', ganancia);
                        camb.attr('data-total', total);

                        // Copia del código anterior
                        var long = a_item+a_sitem;
                        var descuento = $('#descuento-preventa').html();
                        if(descuento == "") {
                            descuento = 0;
                        } else {
                            descuento = descuento.split('$');
                            descuento = descuento[1];
                        }
                        if(long == 0){
                            $('tbody').html("<tr>"+string+"</tr>");
                            $('#ganancia-prev').val(ganacia);
                            $('#subtotal-preventa').html("$"+total);
                            $('#total-valor').val("$"+total);
                        } else {
                            var cu = 0;
                            var lg = $("tbody").find("tr").length;
                            var adGan = 0;
                            for(var i = 0; i < lg; i++){
                                var nval = $('tbody').children('tr').eq(i).find('td:eq(6)').html();
                                var ngan = $('tbody').children('tr').eq(i).find('td:eq(0)').children('a').attr('data-ganancia');
                                adGan += parseFloat(ngan);
                                nval = nval.split('$');
                                nval = nval[1];
                                cu = parseFloat(nval) + parseFloat(cu);
                                cu = parseFloat(cu);
                                cu = cu.toFixed(2);
                            }
                            $('#subtotal-preventa').html('$'+cu);
                            $('#ganancia-prev').val(adGan);
                            var nstot = $('#subtotal-preventa').html();
                            nstot = nstot.split("$");
                            nstot = nstot[1];
                            nstot = parseFloat(nstot);
                            var ncuenta = nstot-descuento;
                            ncuenta = parseFloat(ncuenta);
                            ncuenta = ncuenta.toFixed(2);
                            $('#total-valor').val("$"+ncuenta);
                        }
                    } else {
                        var cant = data.cant;
                        var dc = data.cod;
                        var c_traida = data.cantBd;
                        esto.val(c_traida);
                        if(cant = 0){
                            swal.fire(
                                '¡Atención!',
                                'No queda stock de '+dc+'.',
                                'error'
                            )
                        } else {
                            swal.fire({
                                title: '¡Atención!',
                                html: 'Solamente quedan <b>'+c_traida+' <i>'+dc+'</i></b>. Por favor, ingrese una cantidad menor.',
                                icon: 'warning'
                            })
                        }
                    }
                }
            })
        } else {
            $(this).val('1.00');
            $(this).focus();
            $(this).select();
        }
    });

    // Boton enviar por Whatsapp
    $(document).on('click', 'input#enviar-venta', function(e) {
        var emp = 'null';
        var idv = $(this).attr('data-id-venta');
        var ventaHashed = $(this).attr('data-pass-hash');
        var cliente = $(this).attr('data-id-cliente');
        var emp = $(this).attr('data-business');
        Swal.close();
        Swal.fire({
            title: 'Ingresa el número al que deseas enviar el comprobante',
            html: '<input type="number" id="tel-popup" class="swal2-input" maxlength="10">',
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                return [
                    document.getElementById('tel-popup').value
                ]
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                var tel = result.value[0];
                var url = 'https://cliente.siscon-system.com/factura.php?sid='+idv+'&b='+emp+'&c='+cliente+'&vh='+ventaHashed;
                var text = "Te envío tu comprobante. Abrilo desde este enlace: "+url;
                var message = encodeURIComponent(text);
                var whatsapp_url = "whatsapp://send?text="+message+"&phone=+54"+tel+"&abid=+54"+tel;
                window.open(whatsapp_url);
            }
        });
        resetFormVenta();
    });

    // Boton enviar por imprimir factura
    $(document).on('click', 'input#imprimir-venta', function(e) {
        Swal.close();
        var idv = $(this).attr('data-id-venta');
        var usuario = 'null';
        window.open('https://siscon-system.com/pages/printing.php?type-pr=billing-pos&sale-id='+idv+'&user='+usuario);
        resetFormVenta();
    });

    /* FUNCIONES */

    function resetFormVenta(){
        $('tbody, #subtotal-preventa, #descuento-preventa').html("");
        $('#descuento-preventa').removeClass("bg-td");
        $('#total-valor, textarea#coment_preventa').val("");
        $('#buscar-producto').select2('val', '0');
        $('.ocultar').addClass('hide-all');
        $('#ganancia-prev, #cant-items, #cant-sub-items').val('0');
        $('span#descuento-preventa').parent('b').removeClass('bg-td');
        submit_btn = false;
    }
    
})