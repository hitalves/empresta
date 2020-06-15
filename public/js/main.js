jQuery(document).ready(function($) {

    //input effects
    $('input, select').focus(function(){
        $(this).parent('.field').addClass('fc')
    });
    $('input, select').focusout(function(){
        if($(this).val() != '') {
            $(this).parent('.field').addClass('fc') 
        } else {
            $(this).parent('.field').removeClass('fc') 
        }
    })

    //money mask
    $('.money').mask('000.000.000.000.000,00', {reverse: true});

    //load data
    var instituicoesURL = apiURL + '/instituicao';
    var conveniosURL = apiURL + '/convenio';
    var simularURL = apiURL + '/simular';

    function jsonLoader(key, url) {
        $.getJSON(url, function(data){

            $.each(data, function(i, o){
                var input = '<label><input type="checkbox" name="' + key + '[]" val="' + o.chave + '" />' + o.valor + '</label>';
                $('.field.' + key + ' .dest').append(input);
            })
               
        });
        return true;
    }

    //change animation
    $.when(jsonLoader('instituicoes', instituicoesURL), jsonLoader('convenios', conveniosURL)).then(function(){
        $(window).bind('load', function(){
            setTimeout(function(){
                $('#all-loader').addClass('ok');
            }, 500);
            setTimeout(function(){
                $('.s1').removeClass('lo');
            }, 1500);
            setTimeout(function(){
                $('.s2').removeClass('hi');
            }, 1700);
            setTimeout(function(){
                $('.s2').removeClass('lo');
            }, 2500);
            setTimeout(function(){
                $('.s3').removeClass('hi');
            }, 2500);
        })
    });


    //steps collecting data
        //money loan value
    function s3() {
        var valor_emprestimo = $('input[name="valor_emprestimo"]').val();
        if (valor_emprestimo != '') {
            $(this).hide();
            $('.value_emprestimo p').text('R$' + valor_emprestimo);
            $('.value_emprestimo').removeClass('hi');
            $('.s3').addClass('hi');
            setTimeout(function(){
                $('.s4, .we2').removeClass('hi');
            }, 300);
            setTimeout(function(){
                $('.s4').removeClass('lo');
            }, 1000);
            setTimeout(function(){
                $('.s5').removeClass('hi');
            }, 1200);
        }
        
    }
        //click
    $('.s3 a').click(function(e){
        e.preventDefault();
        s3();
    });
        //enter
    $('input[name="valor_emprestimo"]').keypress(function(e){   
        if(e.which == 13) {
            e.preventDefault();
            s3();
            return false;
        }
    });


    //credit institutions
    function s5(){
        var instituicoes = [];
        $.each($('input[name="instituicoes[]"]:checked'), function(){
            instituicoes.push($(this).attr('val'));
        });
        instituicoesText = instituicoes.join(', ');
        $('.value_instituicao p').text(instituicoesText).val();
        $('.value_instituicao').removeClass('hi');
        $('.s5').addClass('hi');
        setTimeout(function(){
            $('.s6, .we3').removeClass('hi');
        }, 300);
        setTimeout(function(){
            $('.s6').removeClass('lo');
        }, 1000);
        setTimeout(function(){
            $('.s7').removeClass('hi');
        }, 1200);
    }
    $('.s5 a').click(function(e){
        e.preventDefault();
        s5();
    });


    //agreements 
    function s7(){
        var convenios = [];
        $.each($('input[name="convenios[]"]:checked'), function(){
            convenios.push($(this).attr('val'));
        });
        conveniosText = convenios.join(', ');
        $('.value_convenio p').text(conveniosText);
        $('.value_convenio').removeClass('hi');
        $('.s7').addClass('hi');
        setTimeout(function(){
            $('.s8, .we4').removeClass('hi');
        }, 300);
        setTimeout(function(){
            $('.s8').removeClass('lo');
        }, 1000);
        setTimeout(function(){
            $('.s9').removeClass('hi');
        }, 1000);
    }
    $('.s7 a').click(function(e){
        e.preventDefault();
        s7();
    });


    //loan installments 
    function s9() {
        var parcelas = $('select[name="parcela"] option:selected').val();
        $('.value_parcela p').text(parcelas);
        $('.value_parcela').removeClass('hi');
        $('.s9').hide();
        $('.s10').removeClass('hi');
    }
    $('.s9 a').click(function(e){
        e.preventDefault();
        s9();
    });


    //ajax submit to receive results
        //enter submit block
    $('#simular').keypress(function(e){
        if(e.which == 13) {
            e.preventDefault();
            return false
        }
    });

        //ajax and prevent reload
    $('#simular').submit(function(e){
        e.preventDefault();
            //values and convertions
        var urlSimular = simularURL;
        var vEmprestimo = $('input[name="valor_emprestimo"]').val();
        var vEmprestimo = vEmprestimo.trim(vEmprestimo);
        var vEmprestimo = vEmprestimo.replace('.', '');
        var vEmprestimo = vEmprestimo.replace(',', '.');

        var vEmprestimo = parseFloat(vEmprestimo);
        var vInstituicoes = [];
            $.each($('input[name="instituicoes[]"]:checked'), function(){
                vInstituicoes.push($(this).attr('val'));
            });
        var vConvenios = [];
            $.each($('input[name="convenios[]"]:checked'), function(){
                vConvenios.push($(this).attr('val'));
            });
        var vParcela = $('select[name="parcela"] option:selected').val();
        var vParcela = parseInt(vParcela);

        $('#simular').addClass('loading');

        $.ajax({
            url : urlSimular,
            type : 'post',
            data : {
                valor_emprestimo : vEmprestimo,
                instituicoes : vInstituicoes,
                convenios : vConvenios,
                parcela : vParcela,
            },
            success: function (r) {
                console.log(r);
                $('#simular').addClass('hide');
                $('#resultado').removeClass('hide');
                var b = 0;
                $.each(r, function(i, o){
                    b++;
                    if (b > 0) {
                        if ( ! $.isEmptyObject(o) ) {
                            var div = '<h3>Instituição: <span>' + i + '</span></h3>';
                            $('#resultados > div').append(div);
                            var a = 0;
                            $.each(o, function(i, o){
                                a++;
                                var op = '<div class="op"><h4>Opção ' + a + '</h4><ul><li>Valor da Parcela: R$<span>' + o.valor_parcela + '</span></li> <li>Convênio: <span>' + o.convenio + '</span></li> <li>Taxa: <span>' + o.taxa + '</span>% a.m.</li> <li>Total de parcelas: <span>' + o.parcelas + '</span></li></ul></div>';
                                $('#resultados > div').append(op);
                            });
                            $('.noload').remove();
                        } 
                    } 
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })
    });
    
    //fill results
    function results(r) {

    }

});