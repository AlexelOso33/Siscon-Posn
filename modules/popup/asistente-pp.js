$(document).ready(function(){

    /*------------------ POPUP MODULE ------------------*/

    // Mostrar tutorial Primeros pasos
    $('#tutorial-pp').on('click', function(e){
        e.preventDefault();
        $('.cont-popup').removeClass('hide-popup');
        $('body').css('overflow', 'hidden');
    })

    $(document).on('click', '#omitir-fs', function(e){
        e.preventDefault();
        $('.cont-popup').addClass('hide-popup');
        $.ajax('../modules/popup/popup-ajax.php', {
                'action' : 'omitir-paso'
            }
        )
        setTimeout(() => {
            backPopup();
        }, 400);
    })

    $(document).on('click', '#btn-ok-popup', function(e){
        e.preventDefault();
        $('.cont-popup').addClass('hide-popup');
        $('body').css('overflow', 'unset');
        $.post('../modules/popup/popup-ajax.php', {
            'step' : 1,
            'action' : 'siguiente-paso'
            }
        )
        setTimeout(() => {
            backPopup();
        }, 400);
    })

    $(document).on('click', '#btn-sig-popup', function(){
        $('#step1').addClass('carousel-hide');
        $('#step2').removeClass('carousel-pre');
        $('.conf-sist').addClass('sel-fs');
        $('.p-footer').removeClass('hide');
        $('.cont-msg-popup').addClass('hpp');
        $('.actions-popup').removeClass('hide');
    })

    $(document).on('click', '#siguiente', function(){
        if(!($('#txt14').hasClass('carousel-hide')) || !($('#txt14').hasClass('carousel-pre'))){
            $('#atras').removeClass('hide');
            var txtlen = $('#step2').children('.body-popup').find('.text-body');
            for(var i = 0; i < txtlen.length; i++){
                var comp = txtlen.eq(i);
                
                if(!($('#txt4').hasClass('carousel-hide')) && !($('#txt4').hasClass('carousel-pre'))){
                    $('#tt1').addClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt3, #tt4').addClass('carousel-pre').removeClass('carousel-hide');
                    $('#tt2').removeClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 2 de 4');
                }

                if(!($('#txt8').hasClass('carousel-hide')) && !($('#txt8').hasClass('carousel-pre'))){
                    $('#tt2, #tt1').addClass('carousel-hide').removeClass('carousel-pre');
                    $(' #tt4').addClass('carousel-pre').removeClass('carousel-hide');
                    $('#tt3').removeClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 3 de 4');
                }

                if(!($('#txt12').hasClass('carousel-hide')) && !($('#txt12').hasClass('carousel-pre'))){
                    $('#tt2, #tt1, #tt3').addClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt4').removeClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 4 de 4');
                }

                if(!($('#txt13').hasClass('carousel-hide')) && !($('#txt13').hasClass('carousel-pre'))){
                    $('.cont-msg-popup').removeClass('hpp');
                    $('#tt2, #tt1, #tt3, #tt4').addClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt5').removeClass('carousel-pre').removeClass('carousel-hide');
                    $('.footer-popup').addClass('hide');
                }

                if(!(comp.hasClass('carousel-pre')) && !(comp.hasClass('carousel-hide'))){
                    comp.addClass('carousel-hide').removeClass('carousel-pre');
                } else if(comp.hasClass('carousel-pre')){
                    comp.removeClass('carousel-pre').removeClass('carousel-hide');
                    break;
                }
            }
        }
    })

    $(document).on('click', '#atras', function(){
        if($('#txt1').hasClass('carousel-hide') || $('#txt1').hasClass('carousel-pre')){
            $('#siguiente').show();
            var txtlen = $('#step2').children('.body-popup').find('.text-body');
            for(var i = txtlen.length-1; i >= 0; i--){
                var comp = txtlen.eq(i);
                if(!($('#txt5').hasClass('carousel-hide')) && !($('#txt5').hasClass('carousel-pre'))){
                    $('#tt1').removeClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt2').addClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 1 de 4');
                }
                if(!($('#txt9').hasClass('carousel-hide')) && !($('#txt9').hasClass('carousel-pre'))){
                    $('#tt2').removeClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt3').addClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 2 de 4');
                }
                if(!($('#txt13').hasClass('carousel-hide')) && !($('#txt13').hasClass('carousel-pre'))){
                    $('#tt3').removeClass('carousel-hide').removeClass('carousel-pre');
                    $('#tt4').addClass('carousel-pre').removeClass('carousel-hide');
                    $('.p-footer p').html('Paso 3 de 4');
                }
                if(!(comp.hasClass('carousel-hide')) && !(comp.hasClass('carousel-pre'))){
                    comp.addClass('carousel-pre').removeClass('carousel-hide');
                    txtlen.eq(i-1).removeClass('carousel-hide');
                    break;
                }
                if(!($('#txt2').hasClass('carousel-hide')) && !($('#txt2').hasClass('carousel-pre'))) {
                    $(this).addClass('hide');
                }
            }
        }
    })

    /*  FUNCIONES  */

    function backPopup(){
        $('.cont-msg-popup').removeClass('hpp');
        $('.carousel-popup, .head-popup, .text-body').removeClass('carousel-hide').addClass('carousel-pre');
        $('.footer-popup').removeClass('hide');
        $('#tt1, #txt1').removeClass('carousel-hide').removeClass('carousel-pre');
        $('.actions-popup').addClass('hide');
        $('.p-footer:nth-child(2)').addClass('hide');
        $('.p-footer p').html('Paso 1 de 4');
        $('#step1, #step1 .head-popup, #step1 .text-body').removeClass('carousel-pre');
    }
})