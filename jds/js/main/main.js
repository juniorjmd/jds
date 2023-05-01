/*************************************************************************************************
 
 main.js 
 
 @date: Agosto de 2015
 
 @author: Jose Luis Paternina Casadiego
 
 @Description: Este javascript contiene todas las funciones principales para la correcta ejecución
 de SAT del lado del cliente con invocaciones al servidor.
 
 *************************************************************************************************/

/**
 * Alias console.log
 * @param {type} x Dato a imprimir por la consola
 * @returns {bool}
 */
function log(x) {
    console.log(x);
    return false;
}

/*Ejemplo Google maps*/

//Ejemplo de coordenadas del mapa de google usado en la página maps.
function coord1() {
    return [
        new google.maps.LatLng(10.999452, -74.813250),
        new google.maps.LatLng(10.999462, -74.814260),
        new google.maps.LatLng(10.999462, -74.816270),
        new google.maps.LatLng(10.999442, -74.815253)
    ];
}

function coord2() {
    return [
        new google.maps.LatLng(11.0175358, -74.8066475),
        new google.maps.LatLng(11.0176456, -74.80662000000001),
        new google.maps.LatLng(11.0155776, -74.83066170000001),
        new google.maps.LatLng(11.0133853, -74.83141030000002)
    ];
}

//mapRoutes();
//calcRoute();

/*Dibuja zonas en el mapa*/
//dibujar_zonas();

/*Fin ejemplo Google maps*/

var _login_date = new Date();
var _expire_time;
window.action = '';
window.user = '';
window.actionData = '';
var _dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
var _meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
//<editor-fold defaultstate="collapsed" desc="DOCUMENT LOAD">

/**
 * Solicita el branding de la empresa (logo, tema, etc.)
 * @returns {null} Devuelve nulo cuando el branding falla sino devuelve el resultado de la "tabla" sat_empresas
 */
function getBranding() {
    var jXHR = $.post('actions', {action: 'GET_BRANDING'});
    jXHR.done(function (xhr) {
        var jsonData = JSON.parse(xhr);
        jsonData = JSON.parse(jsonData);
        var html_string = $('<div/>').html(jsonData.Records[0].pie_pagina.texto).text();
        log("Branding success");
        $('#logo_welcome').attr('src', jsonData.Records[0].logo_mono_med.raw); //Logo en welcome
        $('#logo_main').attr('src', jsonData.Records[0].logo_mono_min.raw); // Logo en main
        $('#main_footer #copy').html(html_string); // CopyRight en main
        $('#main_footer #madeBy').html(jsonData.Records[0].made_by.texto)
                .css('color', 'gray'); // Logo en main        
        $('#main_footer #copyImg')
                .addClass('padding-min')
                .attr('src', jsonData.Records[0].logo_sat_min.raw)
                .attr('width', '27px')
                .attr('alt', 'SAT')
                .attr('opacity', '0.7'); // Logo sat en main

        $('#logo_mono_med_preview').attr('src', jsonData.Records[0].logo_mono_med.raw); // Preview de Logo en welcome                
        $('#logo_mono_min_preview').attr('src', jsonData.Records[0].logo_mono_min.raw); // Preview de Logo en main
        $('#Administrar_form_Empresa_HTML_footer').html(html_string); // Preview CopyRight en main

        return xhr;
    });
    jXHR.fail(function (xhr) {
        log("Branding fail");
        return null;
    });
}

var tableToExcel = (function (elem) {
    var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
    , format = function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
        })
    }
    return function (table, name) {
        if (!table.nodeType)
            table = document.getElementById(elem);
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        window.location.href = uri + base64(format(template, ctx));
    }
})()

$(window).load(function () {

    $("[data-sec='1']").show();
    $("[data-sec='2']").show();
    $("[data-sec='3']").show();
    $("[data-sec='4']").show();
    $("[data-sec='8']").show();
    security();
    //Logos y demás
    getBranding();
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'), sParameterName, i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    window.user = getUrlParameter('user');
    window.action = getUrlParameter('action');
    window.actionData = getUrlParameter('data');
    var mainUrl = window.location.pathname.indexOf('/main') >= 0 ? true : false; //Si estamos navegando o no en main

    if (window.action != undefined && window.action != '' && !mainUrl) {
        $('#respuesta').html(waitProgress('Cargando...') + '<br/>');
        $('#inputuser').val(window.user);
        $('#respuesta').html('');

        setTimeout(function () {
            $('#inputpassword').focus();
        }, 1000);
    }

});
//</editor-fold>

function security() {
    var jXHR = $.post('actions', {action: 'GET_SECURITY'});
    var data_sec = $(document).find("[data-sec]");
    $('#cargando_permisos_wait').html(waitProgress("<h5 class=''><i class='fa fa-spinner fa-pulse '></i>&nbsp;Cargando sus permisos en SAT... &nbsp;<i class='fa fa-spinner fa-pulse'></h5>"));
    $.each(data_sec, function (idx, data) {
        try {
            $(this).hide();
        } catch (e) {

        }
    });
    jXHR.done(function (xhr) {
        log('Security success');
        var permisos = JSON.parse(xhr);
        var listado_accessos = '<table class="table border border-solid border-lgray"><thead><tr class="success"><th colspan=2 class="text-default text-center">Accesos</th></tr></thead><tbody>';
        var conteo = 0;
        $.each(permisos, function (idx, permiso) {
            conteo++;
            $(document).find('[data-sec=' + idx + ']').show();
            listado_accessos += '<tr class="show-cursor-hand-active"><td >' + conteo + '</td><td>' + permiso.replace(/\s\(([^\)]+)\)/g, '.') + '</td></tr>';
        });
        listado_accessos += '</tbody></table>';
        $('#Vista_modulo_perfil_accesos_div').html(listado_accessos);
        $('#cargando_permisos_wait').html('');
    });
    jXHR.fail(function () {
        $('#cargando_permisos_wait').html('');
        log('Security fail');
    });
}

// <editor-fold defaultstate="collapsed" desc="DOCUMENT READY">
$(document).ready(function () {

    //Carga funcion de autenticacion
    Authenticate();
    //Reloj digital 
    setInterval(function () {
        relojDigital('reloj_digital')
    }, 1000);
    /**
     * Solo para main.php
     */
    //En el móvil contrae el menú después del clic en caso de fallar
    $(document).on('click', '.navbar-collapse.in', function (e) {
        if ($(e.target).is('a') && ($(e.target).attr('class') !== 'dropdown-toggle')) {
            $(this).collapse('hide');
        }
    });
    //Cada clic en la barra de navegación que contenga el atributo 'data-mod'
    $('[data-mod]').on('click', function (e) {
        $('#navbar-ex-collapse').find('li').removeClass('active'); //Remueve la clase que resalta al botón
        tabs("#module-container", 1, $(this).data('mod')); //Muestra el módulo según el botón seleccionado
        $(this).parent().addClass('active'); //Añade la clase al botón para resaltar según el módulo seleccionado               
    });
    //Cada clic en la barra de navegación que contenga el atributo 'data-mod'
    $('[data-mod-item]').on('click', function (e) {
        tabs("#module-container", 2, $(this).data('mod-item')); //Muestra el módulo según el botón seleccionado
        $(this).parent().addClass('active'); //Añade la clase al botón para resaltar según el módulo seleccionado   
        //Activa el suavizado del scroll
        scrollSmooth($('.fix-scroll.show'));
        e.preventDefault();
    });
    //carga submódulos de segundo nivel, es decir Main->submod->submod
    $('[data-smod-item]').on('click', function (e) {
        tabs("#submodulo-ubicaciones", 3, $(this).data('smod-item')); //Muestra el módulo según el botón seleccionado
        $(this).parent().addClass('active'); //Añade la clase al botón para resaltar según el módulo seleccionado         
    });
    //Activa los botones del sistema
    triggerButtons();
    //Activa acciones en el sistema
    triggerActions();
    //Obtiene el tiempo de expiración
    get_expire_timeout();
    dont_expire();
    setTimeout(function () {
        expire_scheduled();
    }, 300);
    //Activa acordeones
    accordion();
    //Activa el suavizado del scroll
    scrollSmooth($('.fix-scroll'));


// <editor-fold defaultstate="collapsed" desc="LLAMADAS AL INICIAR EL SISTEMA">   

    creadorXdefault();

    get_roles('Administrar_form_perfiles_lista_roles', true);
//Activa el módulo Consultar
    modConsultar();
//Activa el módulo Despacho
    modDespacho();
//Activa el modulo Aprobar
    modAprobar();
    get_solicitudes_estados();
    get_solicitudes_tipos();

    //Activa los tooltips
    activateQtip();

    setTimeout(function () {
        dont_expire();
    }, 30000);



// </editor-fold>



});
// </editor-fold>

function print_format() {
    var doc = $("#_PRINT_FORMAT").html();
    var logo_mono_min = $('#logo_mono_min_preview').attr('src');
    var fecha = new Date();
    var w = window.open('', '', 'titlebar=no,menubar=no,toolbar=no,status=yes,centerscreen=yes,height=768,width=1024');
    w.document.write('<html><head><title></title>');
    w.document.write('</head><body ><div style="font-size:8px;float:right;"> Impreso desde SAT el: '
            + _dias[fecha.getDay()] + ', ' + fecha.getDay() + ' de '
            + _meses[fecha.getMonth()] + ' de '
            + fecha.getFullYear() + ' a las '
            + fecha.toLocaleTimeString('en-US', {hour12: true}) + '.</div><img width="77px" src="' + logo_mono_min + '"><br/><br/>');
    w.document.write(doc);
    w.document.write('</body></html>');
    w.document.close();
    w.print();
    w.close();
    //Falta update de la impresión
}

/**
 * Consulta una sola solicitud 
 * @param {String} idSolicitud Numero de la solicitud a consultar
 * @returns {null} no retorna nada
 */
function consultarSolicitud(idSolicitud) {

    var jXHR = $.post('actions', {action: 'GET_SOLICITUDES', id_solicitud: idSolicitud});
    jXHR.done(function (xhr) {

        log('Consultar solicitud ' + idSolicitud + ' success');
        var jsonData = JSON.parse(xhr);

        if (jsonData.Records[0].estadoSolicitudDetalle != "B" && jsonData.Records[0].estadoSolicitudDetalle != "P") {
            $('#Crear_form_reparto_estado_solicitud_div').attr('disabled', true);
            var estadoSol;
            switch (jsonData.Records[0].estadoSolicitudDetalle) {
                case 'A':
                    estadoSol = 'Aprobada	';
                    break;
                case 'B':
                    estadoSol = 'Borrador	';
                    break;
                case 'D':
                    estadoSol = 'Despachada	';
                    break;
                case 'E':
                    estadoSol = 'Eliminada	';
                    break;
                case 'N':
                    estadoSol = 'Nula         ';
                    break;
                case 'P':
                    estadoSol = 'Pendiente	';
                    break;
                case 'R':
                    estadoSol = 'Rechazada	';
                    break;
                case 'V':
                    estadoSol = 'Vencida	';
                    break;
            }
            $('#Crear_form_reparto_estado_solicitud_div').html('<label class="control-label" for="">Estado</label><br/><label class="form-control border border-solid border-red" for="">' + estadoSol + '</label>');
            $('#Crear_form_reparto_estado_solicitud').hide();
            $('#Crear_form_reparto_btnsave').attr('disabled', true).attr('id', 'btnsave_disabled');
            $('#Crear_form_reparto_sel_tipo select').attr('disabled', true);
            $('#Crear_form_reparto_beneficiarios_div').attr('disabled', true);
            $('#Crear_form_reparto_chk_mismo').attr('disabled', true);
            $('#Crear_form_reparto_btn_beneficiarios').hide();
            $('#Crear_form_reparto_aprobador_listar').hide();
        }

        $('#Crear_form_reparto_id_solicitud').val(jsonData.Records[0].idSolicitudNoHtml);
        $('#Crear_form_reparto_estado_solicitud').val(jsonData.Records[0].estadoSolicitudDetalle);
        $('#crear_form_reparto_fecha_inicia_solicitud').val(jsonData.Records[0].fechaAplicaSolicitud);
        $('#crear_form_reparto_fecha_finaliza_solicitud').val(jsonData.Records[0].fechaFinalizaSolicitud);
        $('#Crear_form_reparto_empleados_listar_id').val(jsonData.Records[0].idCreadorSolicitud);
        $('#Crear_form_reparto_empleados_listar_nombre').val(jsonData.Records[0].Creador);
        $('#Crear_form_reparto_centro_costo_listar_id').val(jsonData.Records[0].idCentroCostoCreador);
        $('#Crear_form_reparto_centro_costo_listar_nombre').val(jsonData.Records[0].nombreCentroCostoCreador);
        $('#Crear_form_reparto_estado_solicitud select').val(jsonData.Records[0].estadoSolicitudDetalle);
        $('#Crear_form_reparto_sel_tipo select').val(jsonData.Records[0].idTipoSolicitud);
        $('#Crear_form_reparto_motivo').val(jsonData.Records[0].motivo);
        $('#Crear_form_reparto_aprobador_benef').val(jsonData.Records[0].idAprobador);
        $('#Crear_form_reparto_aprobador_listar_id').val(jsonData.Records[0].idAprobador);
        $('#Crear_form_reparto_aprobador_listar_nombre').val(jsonData.Records[0].nombreAprobador);
        $('#Crear_form_reparto_centro_costo_listar_aprobador_id').val(jsonData.Records[0].idCentroCostoAaplicar).change(); //Como es un read only se dispara el evento
        $('#Crear_form_reparto_centro_costo_listar_aprobador_nombre').val(jsonData.Records[0].nombreCentroCostoAaplicar);
        $('#Crear_form_reparto_aprobador_listar_correo').val(jsonData.Records[0].correoAprobador);

        $.each(jsonData.Records, function (idx, data) {

            var beneficiario = "<tr id='" + data.idBeneficiarioNoHtml + "' class='show-cursor-hand-active'>" +
                    "<input class='js-createobject' data-field='_id' name='%_" + data.idBeneficiarioNoHtml + "_id' type='hidden' value='" + data.idBeneficiarioNoHtml + "'>" +
                    "<input class='js-createobject' data-field='_tipoBene' name='%_" + data.idBeneficiarioNoHtml + "_tipoBene' type='hidden' value='" + data.tipoBene + "'>" +
                    "<input class='js-createobject' data-field='_nombre' name='%_" + data.idBeneficiarioNoHtml + "_nombre' type='hidden' value='" + data.nombreBeneficiario + "'>" +
                    "<input class='js-createobject' data-field='_ccosto_id' name='%_" + data.idBeneficiarioNoHtml + "_ccosto' type='hidden' value='" + data.idCentroCostoAaplicar + "'>" +
                    "<input class='js-createobject' data-field='_ccosto_nombre' name='%_" + data.idBeneficiarioNoHtml + "_ccosto_nombre' type='hidden' value='" + data.nombreCentroCostoAaplicar + "'>" +
                    "<input class='js-createobject' data-field='_id_zona' name='%_" + data.idBeneficiarioNoHtml + "_zona' type='hidden' value='" + data.zonaSolicitud + "'>" +
                    "<input class='js-createobject' data-field='_valor' name='%_" + data.idBeneficiarioNoHtml + "_valor' type='hidden' value='" + data.valor + "'>" +
                    //"<input class='js-createobject' data-field='_adic' name='%_" + data.idBeneficiarioNoHtml + "_adic' type='hidden' value='" + data.valorAdic + "'>" +
                    "<input class='js-createobject' data-field='_puebloDir' name='%_" + data.idBeneficiarioNoHtml + "_puebloDir' type='hidden' value='" + data.destino + "'>" +
                    "<input class='js-createobject' data-field='_ciudad_id' name='%_" + data.idBeneficiarioNoHtml + "_ciudad_id' type='hidden' value='" + data.idCiudad + "'>" +
                    "<input class='js-createobject' data-field='_ciudad_nombre' name='%_" + data.idBeneficiarioNoHtml + "_ciudad_nombre' type='hidden' value='" + ' ' + "'>" +
                    "<input class='js-createobject' data-field='_dir' name='%_" + data.idBeneficiarioNoHtml + "_dir' type='hidden' value='" + data.destino + "'>" +
                    "<td data-th='Tipo'>" + data.tipoBene + "</td>" +
                    "<td data-th='C&#233;d.'>" + data.idBeneficiarioNoHtml + "</td>" +
                    "<td data-th='Nombre'>" + data.nombreBeneficiario + "</td>" +
                    "<td data-th='C.Costo'>" + data.idCentroCostoAaplicar + "-" + data.nombreCentroCostoAaplicar + "</td>" +
                    "<td data-th='Zona'>" + data.zonaSolicitud + (data.zonaNombre !== '' ? '-' + data.zonaNombre : '') + "</td>" +
                    "<td data-th='Valor $'>" + parseFloat(data.valor || 0).toLocaleString() + "</td>" +
                    //"<td data-th='Adic. $'>" + parseFloat(data.valorAdic || 0).toLocaleString() + "</td>" +
                    "<td data-th='Dir'>" + data.destino + "</td>";

            if (jsonData.Records[0].estadoSolicitudDetalle != "B" && jsonData.Records[0].estadoSolicitudDetalle != "P") {
                beneficiario += "<td data-th='Opciones'><div class='btn-group inline pull-right'>&nbsp;</div></td></tr>";
            } else {
                beneficiario += "<td data-th='Opciones'><div class='btn-group inline pull-right'><a class='btn btn-xs btn-info js-editar-beneficiario js-show-qtip' title='Editar'><i class='fa fw fa-edit'></i></a><a class='btn btn-xs btn-danger js-remover-beneficiario js-show-qtip' title='Eliminar'><i class='fa fw fa-times'></i></a></div></td>" +
                        "</tr>";
            }

            $('#Crear_form_reparto_beneficiarios_lista').append(beneficiario);
            //Trigger para editar beneficiario
            $('#' + data.idBeneficiarioNoHtml + ' .js-editar-beneficiario').on('click', function () {

                var inputArray = $(this).closest('tr').find('input:hidden');
                var idTr = $(this).closest('tr').attr('id');
                var dataArray = [];
                $.each(inputArray, function (index, data) {
                    var inputId = $(data).attr('name');
                    inputId = inputId.replace('_' + idTr, ''); //Quita el id del benenficiario para dejar el nombre del id genérico
                    dataArray[inputId] = $(data).val();
                });
                modalShow('Crear_form_reparto_btn_beneficiarios', 'EDITANDO', 'Beneficiario', 'info', true, dataArray);
            });
            //Para remover el beneficiario
            $('a.js-remover-beneficiario').on('click', function (e) {
                var beneficiarios = $(this).parent().parent().parent().find('.js-bene');
                var item = this.parent().parent.find('li');
                $(item).css({opacity: '0.3', 'background-color': 'red', right: '20px', height: '5px', width: '1px', border: '1px solid black'}).remove();
                //$('#Despachar_form_despacho_listado').find('table').find('tbody').append('<tr class="jtable-data-row">' + $(this).parent().find('.js-fila').val() + '</tr>');
                sobrecupo(beneficiarios);
                updateComboPaneles();
                e.preventDefault();
            });
        });
        $('#Crear_form_reparto_beneficiarios_lista_total_solicitud').val('$' + parseFloat(jsonData.Records[0].totalSolicitud || 0).toLocaleString());
    });
}

/**
 * Simualción de teclas y mouse (clic)
 * @returns {null} No retorna nada
 */
function simulacionKey2Click() {
    $(document).bind('keypress', function (evt) {
        var focused = $(':focus');
        if (evt.keycode == 13 || evt.keycode == 32) {
            if (focused.prop('type') == '') {
                focused.trigger('click');
            }
        }
    });
}

/**
 * //Activa los tooltips en los elementos
 * @returns {Boolean}
 */
function activateQtip() {
    /**
     * Para todos los elementos que contengan la clase js-show-qtip y el atributo 'title' lleno
     * Tooltips qTip2
     */
    $('.js-show-qtip').each(function () { //Busqueda de todos los elementos con la clase js-show-qtip
        $(this).qtip({
            content: {
                text: $(this).attr('[title!=""]') // Asume que title es el text del content del qtip
            },
            position: {
                effect: true,
                my: 'bottom left',
                at: 'top center',
                target: $(this)

            },
            style: {
                classes: 'qtip-shadow qtip-rounded qtip-custom',
                tip: {
                    corner: true
                }
            }
        });
    });
    return false;
}

/**
 *  Detona acciones del sistema
 * @returns {Boolean}
 */
function triggerActions() {
    currencyControls('', false);
    return false;
}

function previewFile(elem) {
    var preview = $('#' + elem + '_preview'); //selects the query named img
    var file = $('#' + elem + '_file')[0].files[0]; //sames as here
    var reader = new FileReader();
    reader.onloadend = function () {
        $(preview).attr('src', reader.result);
    };
    if (file) {

        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        $(preview).attr('src', '');
    }
}

/**
 * Desencripta texto AES 256
 * @param {type} texto en Base 64
 * @param {type} phrase llave de cifrado
 * @returns {String} texto desenciptado
 */
function desencriptar(texto, phrase) {
    texto = atob(texto);
    var crypt = CryptoJS.DES.decrypt(texto, phrase);
    return crypt;
}

function updateComboPaneles() {
    var paneles = $('#Despachar_form_despacho_viajes_paneles').find('.panel-heading');
    addPanelsOption(paneles);
}

/**
 * Establece si hay taxi lleno o sobrecupo de pasajeros (hipoteticamente creyendo que un taxi puede con 4 pasajeros)
 * @param {type} beneficiarios Lista de beneficiarios
 * @returns {null} No retorna nada
 */
function sobrecupo(beneficiarios) {

    var tamVehiculo = $(beneficiarios).parent().parent().find('.js-tipo-vehiculo').val();
    var vehiculo = $(beneficiarios).parent().parent().find('.js-tipo-vehiculo option:selected').text();
    var icono;
    tamVehiculo == 4 ? icono = "taxi" : icono = "bus";
    vehiculo = vehiculo.replace(/\s\(([^\)]+)\)/g, '');
    if ($(beneficiarios).find('li').length === tamVehiculo) {
        $(beneficiarios).parent().find('.js-sobrecupo').html('<i class="fa fa-' + icono + '"></i>&nbsp;' + vehiculo + ' - LLENO <i class="fa fa-user"></i> = ' + $(beneficiarios).find('li').length).addClass('text-warning').removeClass('text-danger').removeClass('text-info');
    } else if ($(beneficiarios).find('li').length > tamVehiculo) {
        $(beneficiarios).parent().find('.js-sobrecupo').html('<i class="fa fa-' + icono + ' fa-spin"></i>&nbsp;' + vehiculo + ' -SOBRECUPO <i class="fa fa-users"></i> = ' + $(beneficiarios).find('li').length).addClass('text-danger').removeClass('text-warning').removeClass('text-info');
    } else {
        $(beneficiarios).parent().find('.js-sobrecupo').html('<i class="fa fa-' + icono + '"></i>&nbsp;' + vehiculo + ' - Asientos disponibles <i class="fa fa-user-plus"></i> = &nbsp;' + (tamVehiculo - $(beneficiarios).find('li').length)).addClass('text-muted').removeClass('text-danger').removeClass('text-warning');
    }
    return null;
}

/**
 * Añadir items a los Combo Box 
 * @param {String} paneles Los paneles actuales
 * @returns {Boolean} No retorna nada
 */
function addPanelsOption(paneles) {

    var num = 0;
    //Limpia el combo "viajes"
    $('.js-panel-viaje').empty();
    //Lee los paneles "viajes" e inserta en el combobox los viajes en creados
    $('.js-panel-viaje').append('<option value="0">---</option>');
    $.each(paneles, function (idx, data) {
        num = $(data).find('.panel-title').text().replace(/[^0-9]/g, ''); //Obtiene el número del panel
        $('.js-panel-viaje').append('<option value="' + (num) + '">Viaje-' + (num) + '</option>');
    });
    $('.js-movil').unbind('keyup');
    $('select').unbind('change');
    $('.js-movil').on('keyup', function () {
        if (this.value == '') {
            $(this).css('border', '1px solid red');
        } else {
            $(this).css('border', '1px solid rgb(204, 204, 204)');
        }
        var moviles = $('#Despachar_form_despacho_moviles select').empty();
        moviles.append("<option value=''>---</option>");
        $.each($('.js-movil'), function (idx, data) {
            if (data.value !== '') {
                moviles.append("<option value='" + data.id + "'>" + data.value.toUpperCase() + "</option>");
            }
        });
        $(moviles).change(function () {

            var anchor = document.createElement('a');
            anchor.href = '#' + this.value;
            anchor.click();
            //$('#Despachar_form_despacho_moviles').scrollTo(this.value);
            //window.location.hash="someAnchor";            
        });
    });
    $('select').change(function () {

        if ($(this).hasClass('js-panel-viaje')) {
            //Viaje seleccionado
            var viaje_sel = $(this).val();
            //Agregar el beneficiario escogido

            var fila = $(this).parent().parent();
            var numero = $(this).val();
            var panel = $('#Despachar_form_despacho_viajes_paneles').find('.panel-title');
            $.each(panel, function (idx, data) {
                var x = $(data).text().replace(/[^0-9]/g, ''); //Obtiene el número del panel
                if (parseInt(x) === parseInt(numero)) {

                    var id_sol = $(fila).children().eq(1).text();
                    var tipo_sol = ($(fila).children().eq(2).text() == 'Hora' ? '3' : '');
                    var id_bene = $(fila).children().eq(3).text()
                    var nombre_bene = $(fila).children().eq(4).text();
                    var destino = $(fila).children().eq(5).text();
                    var valor = $(fila).children().eq(6).text();
                    var peaje = $(fila).children().eq(7).text();
                    var recargos = $(fila).children().eq(8).text();
                    var id_zona = $(fila).children().eq(10).text();
                    var nombre_zona = $(fila).children().eq(11).text();
                    var centro_costo = $(fila).children().eq(12).text();
                    var fecha_aplica = $(fila).children().eq(9).text();
                    var mismoDestino = $(fila).children().eq(14).text();
                    nombre_zona != '' ? nombre_zona = id_zona + '-' + nombre_zona : nombre_zona = id_zona;
                    var bene = "Id: " + id_bene + " " + nombre_bene + "<br/><b>Destino:</b> " + destino + " (" + nombre_zona + ")";
                    var existe_bene = buscaBeneficiarioEnViajes(id_bene);
                    if (!existe_bene) {
                        //VALIDACION DE INCOMPATIBILIDAD DE ZONAS
                        var forms = $('#Despachar_form_despacho_viajes_paneles').find('#form_Viaje_' + viaje_sel).find("input.js-id-zona");
                        if (forms.length > 0) {
                            $.each(forms, function (i, v) {
                                var jXHR = $.post('actions', {action: 'GET_ZONAS_INCOMPATIBLES_COMPARA', zona1: id_zona, zona2: v.value, viaje: viaje_sel});
                                jXHR.done(function (xhr) {

                                    var result = JSON.parse(xhr);
                                    if (result.result == '0') {

                                        var viaje = result.viaje;
                                        var beneficiarios = $('#Despachar_form_despacho_viajes_paneles').find('#form_Viaje_' + viaje).find('.js-bene');
                                        if (!buscaBeneficiarioEnViajes(id_bene)) {

                                            if (mismoDestino == 'SI') {
                                                modalShow('mismoDestino', 'Esta orden posee usuarios con igual destino.', '¿Desea agregarlos a todos?', 'info', false, {soli: id_sol, viaje: viaje_sel, id_bene: id_bene, tipo_sol: tipo_sol}, 'SI, todos', 'NO, solo uno');
                                            } else {
                                                beneficiarios.append("<li class='list-group-item unstyled list-unstyled radius-border-min border border-solid border-lgray'>\n\
                                                    <input type='hidden' class='js-info' value='" + id_sol + "§" + id_bene + "§" + nombre_bene + "§" + destino + "§" + valor + "§" + id_zona + "§" + nombre_zona + "§" + centro_costo + "§" + fecha_aplica + "§" + tipo_sol + "'>\n\
                                                    <input type='hidden' class='js-id-bene' value='" + id_bene + "'>\n\
                                                    <input type='hidden' class='js-id-zona' value='" + id_zona + "'>\n\
                                                    <a class='btn btn-xs btn-danger padding-off js-remover-beneficiario js-show-qtip pull-right' title='Eliminar Beneficiario'><i class='fa fw fa-times'></i></a>&nbsp;<span>" + bene + "</span></li>");
                                                //Revisa sobrecupo o taxi lleno
                                                sobrecupo(beneficiarios);
                                                //Remueve la fila de la lista
                                                $(fila).remove();
                                                //Para remover el beneficiario
                                                $('a.js-remover-beneficiario').unbind('click');
                                                $('a.js-remover-beneficiario').on('click', function (e) {
                                                    var beneficiarios = $(this).parent().parent().parent().find('.js-bene');
                                                    var item = this.closest('li');
                                                    $(item).css({opacity: '0.3', 'background-color': 'red', right: '20px', height: '5px', width: '1px', border: '1px solid black'}).remove();
                                                    //$('#Despachar_form_despacho_listado').find('table').find('tbody').append('<tr class="jtable-data-row">' + $(this).parent().find('.js-fila').val() + '</tr>');
                                                    sobrecupo(beneficiarios);
                                                    e.preventDefault();
                                                });
                                            }
                                        }
                                    } else if (result.result == '1') {
                                        modalShow(null, 'Zonas incompatibles en un mismo viaje:', '<br/> Zona ' + result.zona1 + ' y ' + result.zona2 + ' son incompatibles.<br/><br/><span style="color:gray;">- Use otro viaje para este beneficiario.<br/>- O elimine el que tenga la zona incompatible y asignelo a otro viaje</span>', 'warning');
                                    }
                                });
                            });
                        } else {
                            var beneficiarios = $(this).parent().parent().parent().find('.js-bene');
                            if (mismoDestino == 'SI') {

                                modalShow('mismoDestino', 'Esta orden posee usuarios con igual destino.', '¿Desea agregarlos a todos?', 'info', false, {soli: id_sol, viaje: viaje_sel, id_bene: id_bene}, 'SI, todos', 'NO, solo uno');
                            } else {
                                beneficiarios.append("<li class='list-group-item unstyled list-unstyled radius-border-min border border-solid border-lgray'>\n\
                                            <input type='hidden' class='js-info' value='" + id_sol + "§" + id_bene + "§" + nombre_bene + "§" + destino + "§" + valor + "§0§" + id_zona + "§" + nombre_zona + "§" + centro_costo + "§" + fecha_aplica + "§" + tipo_sol + "'>\n\
                                            <input type='hidden' class='js-id-bene' value='" + id_bene + "'>\n\
                                            <input type='hidden' class='js-id-zona' value='" + id_zona + "'>\n\
                                            <a class='btn btn-xs btn-danger padding-off js-remover-beneficiario js-show-qtip pull-right' title='Eliminar Beneficiario'><i class='fa fw fa-times'></i></a>&nbsp;<span>" + bene + "</span></li>");
                                //Revisa sobrecupo o taxi lleno
                                sobrecupo(beneficiarios);
                                //Remueve la fila de la lista
                                $(fila).remove();
                                //Para remover el beneficiario

                                $('a.js-remover-beneficiario').unbind('click');
                                $('a.js-remover-beneficiario').on('click', function (e) {
                                    var beneficiarios = $(this).parent().parent().parent().find('.js-bene');
                                    var item = this.closest('li');
                                    $(item).css({opacity: '0.3', 'background-color': 'red', right: '20px', height: '5px', width: '1px', border: '1px solid black'}).remove();
                                    //$('#Despachar_form_despacho_listado').find('table').find('tbody').append('<tr class="jtable-data-row">' + $(this).parent().find('.js-fila').val() + '</tr>');
                                    sobrecupo(beneficiarios);
                                    e.preventDefault();
                                });
                            }
                        }
                    } else {
                        modalShow(null, 'Este usuario ya está agregado en un viaje:', id_bene + ' ' + nombre_bene, 'warning');
                    }
                }
            });
        }
    });
    return false;
}

function mismo_destino(solicitud, viaje, _id_bene) {

    var tabla = $('#Despachar_form_despacho_listado').find('tbody');
    var filas = tabla.find('tr');
    var beneficiarios = $('#Despachar_form_despacho_viajes_paneles').find('#form_Viaje_' + viaje).find('.js-bene');
    $.each(filas, function (i, fila) {

        var id_sol = $(fila).children().eq(1).text();
        var id_bene = $(fila).children().eq(3).text()
        var nombre_bene = $(fila).children().eq(4).text();
        var destino = $(fila).children().eq(5).text();
        var valor = $(fila).children().eq(6).text();
        //var adic = $(fila).children().eq(7).text();
        var id_zona = $(fila).children().eq(9).text();
        var nombre_zona = $(fila).children().eq(9).text();
        var centro_costo = $(fila).children().eq(11).text();
        var fecha_aplica = $(fila).children().eq(8).text();
        nombre_zona != '' ? nombre_zona = id_zona + '-' + nombre_zona : nombre_zona = id_zona;
        var bene = "Id: " + id_bene + " " + nombre_bene + "<br/><b>Destino:</b> " + destino + " (" + nombre_zona + ")";
        var existe_bene = buscaBeneficiarioEnViajes(id_bene);
        if (_id_bene == id_bene || _id_bene == '') {

            if (!existe_bene && solicitud == id_sol) {
                beneficiarios.append("<li class='list-group-item unstyled list-unstyled radius-border-min border border-solid border-lgray'>\n\
<input type='hidden' class='js-info' value='" + id_sol + "§" + id_bene + "§" + nombre_bene + "§" + destino + "§" + valor + "§" + id_zona + "§" + nombre_zona + "§" + centro_costo + "§" + fecha_aplica + "'>\n\
<input type='hidden' class='js-id-bene' value='" + id_bene + "'>\n\
<input type='hidden' class='js-id-zona' value='" + id_zona + "'>\n\
<a class='btn btn-xs btn-danger padding-off js-remover-beneficiario js-show-qtip pull-right' title='Eliminar Beneficiario'><i class='fa fw fa-times'></i></a>&nbsp;<span>" + bene + "</span></li>");
                //Revisa sobrecupo o taxi lleno
                sobrecupo(beneficiarios);
                //Remueve la fila de la lista
                $(fila).remove();
                //Para remover el beneficiario
                $('a.js-remover-beneficiario').unbind('click');
                $('a.js-remover-beneficiario').on('click', function (e) {
                    var beneficiarios = $(this).parent().parent().parent().find('.js-bene');
                    var item = this.closest('li');
                    $(item).css({opacity: '0.3', 'background-color': 'red', right: '20px', height: '5px', width: '1px', border: '1px solid black'}).remove();
                    //$('#Despachar_form_despacho_listado').find('table').find('tbody').append('<tr class="jtable-data-row">' + $(this).parent().find('.js-fila').val() + '</tr>');
                    sobrecupo(beneficiarios);
                    e.preventDefault();
                });
            }
        }
    });
}

function buscaBeneficiarioEnViajes(texto) {

    var encontrado = false;
    var forms = $('#Despachar_form_despacho_viajes_paneles').find('form').find("input.js-id-bene");
    $.each(forms, function (i, v) {
        if (v.value == texto) {
            encontrado = true;
        }
    });
    return encontrado;
}

/**
 * Acciones de todos los botones del sistema SAT
 * @returns {Boolean} Retorna false, irrelevante
 */
function triggerButtons() {

// <editor-fold defaultstate="collapsed" desc="MÓDULO MAIN">
    $('#main_logout').on('click', function (evt) {
//Activación del modal
        modalShow(evt);
    });
    //Trigger de activación de paneles según el data target 
    var elemPanel = $($('.js-toggle-panel').data('toggle-target')); //Convertir a jQuery

    $('.js-toggle-panel').on('click', function () {
        elemPanel.toggle('fast', 'swing'); //Animación
    });
    //Trigger de activación de paneles según el data target 
    var itemAccordion = $($('.js-toggle-item-acc').data('toggle-target')); //Convertir a jQuery 

    $('.js-toggle-panel').on('click', function () {
        itemAccordion.toggle('fast', 'swing'); //Animación
    });
    /*
     //Click en el botón notificaciones en el main
     $('#notifications-btn').on('click', function () {
     var action = {action: 'NOTIFICATIONS'};
     $.post('actions', action, function (data, textStatus, jqXHR) {
     var elem = $('#' + main_lista_notificaciones);
     //Recorre el JSON
     $.each(data, function (i, item) {
     elem.append(item.estado);
     });
     }, 'json');
     });
     */
// </editor-fold>
//
// <editor-fold defaultstate="collapsed" desc="MÓDULO LOGIN">
    //Clic al boton de ingreso
    $("#btn-login").click(function (evt) {

        var usr = $("#inputuser").val();
        var psw = $("#inputpassword").val();
        //Llamada ajax para autenticar
        var paramData = {userBD: usr, password: psw, action: 'login'};
        var jXHR = $.post('login', paramData);
        $('#login_wait').html(waitProgress('Enviando autenticación'));
        jXHR.done(function (data) {
            if (data == 1) { //Correcto
                $('.panel-footer').removeClass('text-danger');
                $('.panel-footer').addClass('text-success');
                $('#respuesta').addClass('text-default').addClass('bg-success');
                $('#respuesta p').prepend('<i class="fa fa-spinner fa-pulse"></i>&nbsp;');
                $('#login_wait').html('');
                setTimeout(function () {
                    if (window.action != undefined && window.action != '') {
                        window.location = 'main?user=' + window.user + '&action=' + window.action + '&data=' + window.actionData;
                    } else {
                        window.location = 'main';
                    }
                }, 500); // Redirecciona a la página principal
            } else {
                $('.panel-footer').removeClass('text-success');
                $('.panel-footer').addClass('text-danger')
                $('#respuesta').addClass('text-default').addClass('bg-danger');
                $('#login_wait').html('');
                modalShow(evt, data);
            }
        });
        jXHR.fail(function (xhr, status, error) {
            modalShow(evt, xhr);
            $('#login_wait').html('');
            log("Fatal error login: \n" + xhr);
        });
        return false; //Para compatibilidad con varios navegadores
    });
// </editor-fold>
//
// <editor-fold defaultstate="collapsed" desc="MÓDULO ADMINISTRAR">
    $('[data-target=#modalGrid]').on('click', function (evt) {
//Activación del modal grid
        modalGrid(evt, true);
    });
    $('#Crear_form_reparto [data-target=#modalDialog]').on('click', function (evt) {
//Activación del modal dialog
        modalShow(evt);
    });
// </editor-fold> 
//
//<editor-fold defaultstate="collapsed" desc="MÓDULO CONSULTAR">
    $('#Consultar_form_audit_btnauditexport').on('click', function (e) {
        tableToExcel('Consultar_form_audit_listado'); //'testTable', 'W3C Example Table');
        //fnExcelReport('Consultar_form_audit_listado');
        e.preventDefault(); //Evita la acción por defecto
    });
//</editor-fold>
//
//<editor-fold defaultstate="collapsed" desc="MÓDULO DESPACHAR">

    $('#Despachar_form_despacho_btndespacho').on('click', function (e) {

        e.preventDefault();
        var data = {action: 'GET_PANEL_VIAJE'};
        var paneles = $('#Despachar_form_despacho_viajes_paneles').find('.panel-heading');
        var viajeMax = Math.max.apply(null, $.map(paneles.find('h3').text().replace(/[^0-9]/g, ',').split(','), function (num) {
            return parseInt(num, 10) || 0
        }));
        $.extend(data, {viaje: viajeMax + 1});
        var jXHR = $.post('actions', data);
        jXHR.done(function (xhr) {
            log('panel viajes success');
            $('#Despachar_form_despacho_viajes_paneles').append(xhr);
            llenar_Empresas(viajeMax + 1);
            paneles = $('#Despachar_form_despacho_viajes_paneles').find('.panel-heading');
            addPanelsOption(paneles);
            $('.js-close-panel').on('click', function (e) {
                e.preventDefault();
                var pane = $(this).parent().parent().parent().find('.panel');
                var marcoPane = pane.parent().parent().parent();
                marcoPane.animate({opacity: 0.1});
                pane.removeClass('panel-success').addClass('panel-danger');
                marcoPane.fadeTo("fast", 0, function () {
                    marcoPane.remove();
                });
                updateComboPaneles();
            });
        });
    });
//</editor-fold>

    return false;
}

//Llena el combo empresas
function llenar_Empresas(viaje) {

    var jXHRe = $.post('actions', {action: 'GET_TAXIS_EMPRESAS'});
    jXHRe.done(function (xhr) {

        var json = JSON.parse(xhr);
        var combo = '';
        $.each(json.Records, function (i, data) {
            combo += '<option value=' + json.Records[i].id + '>' + json.Records[i].razonSocial + '</option>';
        });
        //Llena el combo empresas
        $('#Despachar_form_reparto_empresa_viaje_' + viaje).html(combo);
    });
}

function resaltar(elem) {

    var bg = elem.css('background-color');
    var c = elem.css('color');
    elem.css('background-color', 'rgba(255,0,0,0.5)').css('color', 'red');
    setTimeout(function () {
        elem.css('background-color', bg).css('color', c);
    }, 2000);
}

/** 
 * Retorna una barra de progreso de cargue infinito, más un texto
 * @param {String} text Texto que quiere mostrarse en la barra
 * @returns {String}
 */
function waitProgress(text) {

    if (typeof text === 'undefined' || text === '' || text === null) { //Evita que la barra desaparezca, debe tener texto
        text = '&nbsp';
    }
    return "<div class='progress-bar progress-bar-striped active border-radius-max' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:100%'>" + text + "</div>";
}

/** 
 * Retorna una barra de progreso de cargue infinito, más un texto
 * @param {String} text Texto que quiere mostrarse en la barra
 * @returns {String}
 */
function waitProgress_min(text) {

    if (typeof text === 'undefined' || text === '' || text === null) { //Evita que la barra desaparezca, debe tener texto
        text = '&nbsp';
    }
    return "<div class='progress-bar progress-bar-striped active border-radius-max' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:20px'>" + text + "</div>";
}


/**
 * Reloj Digital
 */
function relojDigital(clase) {

    var fecha = new Date().toLocaleDateString(); //Fecha corta
    var tiempo = new Date().toLocaleTimeString('en-US'); //Hora

    if (clase != '') {
        $('.' + clase).html(tiempo);
    } else {
        return fecha + ' ' + tiempo;
    }
}

/**
 * Sistema de pestañas (tabs)
 * @param {type} container contenedor de pestañas
 * @param {type} level nivel de pestaña
 * @param {type} tab pestaña
 * @returns {null} 
 */
function tabs(container, level, tab) {

// Oculta todas las tabs    
    $(container).find('.tab-lvl-' + level).removeClass('show'); //Remueve la clase show a todos los containers de módulos con la clase tab
    $(container).find('.tab-lvl-' + level).addClass('hidden'); //Añade la clase hidden a todos los containers de módulos con la clase tab

    tab = document.getElementById(tab);
    $(tab).removeClass('hidden');
    $(tab).addClass('show');
}

/**
 * Programación de la tarea expiración
 */
function dont_expire() {
//Carga función de control de expiración de sesión
    $('html body').on('keypress mouseover', function () {
        _login_date = new Date();
    });
}

/**
 * Mantiene la expiración de la sesión actualizada con valores en segundos para que no expire
 */
function expire_scheduled() {
    var diff = new Date(new Date() - _login_date);
    if ((diff / 1000) >= _expire_time) {
        window.location = '.';
        alert('SAT - Cerrado por inactividad.');
    }
}

/*
 * Rellena con caracteres a la izquierda
 */
function lPad(str, caracter, maxLong) {
    var result = str;
    var i;
    for (i = 0; i < maxLong - str.toString().length; i++) {
        result = caracter + result;
    }

    return result;
}

/*
 * Rellena con caracteres a la derecha
 */
function rPad(str, caracter, maxLong) {
    var result = str;
    var i;
    for (i = 0; i < maxLong - str.toString().length; i++) {
        result = result + caracter;
    }

    return result;
}

/**
 * Obtiene de la configuración el timeout
 */
function get_expire_timeout() {

    var data = {action: 'GET_EXPIRE_TIME'};
    var jqXHR = $.post('login', data);
    jqXHR.done(function (xhr) {
        log('get expire timeout, sucess');
        _expire_time = xhr || 0;
    });
    jqXHR.fail(function () {
        log('get expire timeout, fail');
    });
    return false; //Para compatibilidad con varios navegadores
}

/**
 * Autenticación de usuario
 */
function Authenticate() {

//En caso de focus
    $("#inputuser, #inputpassword").focus(function () {
        $('#respuesta').removeClass('bg-danger');
        $('.panel-footer').html('&nbsp;');
    });
    //Validación tecla ENTER
    $('#inputuser').on('keyup', function (event, selection) {
        if (event.keyCode === 13 && this.val == "") {
            $('#inputuser').focus();
        } else if (event.keyCode === 13 && this.val !== "") {
            $('#inputpassword').focus();
        }
    });
    $('#inputpassword').on('keyup', function (event, selection) {
        if (event.keyCode === 13 && this.val !== "") {
//$("#btn-login").trigger('click');
        }

    });
}

/**
 * Cierre de sesión del usuario
 * @returns {Boolean}
 */
function Logout() {

    var data = {action: 'logout'};
    var jqXHR = $.post('login', data);
    jqXHR.done(function () {
        log('Logout sucess');
        window.location = '.';
    });
    jqXHR.fail(function () {
        log('Logout fail');
    });
    jqXHR.always(function () {
        log('Logout complete');
    });
    return false;
}

/**
 * Ocultar el modal
 * @returns {Boolean}
 */
function modalHide() {

    var modalDlg = $('#modalDialog');
    modalDlg.find('.modal.fade.in').trigger('click');
    modalDlg.hide();
    return false;
}

/**
 * Ocultar el modal grid
 * @returns {Boolean}
 */
function modalGridHide() {

    var modalDlg = $('#modal_grid');
    modalDlg.find('.modal.fade.in').trigger('click');
    modalDlg.hide();
    $(document).find('.modal-backdrop').remove();
    return false;
}

/**
 * modalShow Inserta plantilla, muestra, ejecuta acciones de acuerdo a lo programado en el dialogo modal
 * @param {event} evt evento asociado, con el que se trata de obtener el currentarget (la fuente)
 * @param {String} msg mensaje que se muestra normal
 * @param {String} msg_err mensaje que se muestra a modo de error
 * @param {String} modalType tipo de modal
 * @param {boolean} editando Cuando se llama el formulario para editar
 * @param {array} datosEdicion Datos de llenado para la edición
 * @param {String} btnAccept Texto del botón aceptar
 * @param {String} btnClose Texto del botón cerrar
 * @returns no retorna, la función llama a un formulario modal
 */
function modalShow(evt, msg, msg_err, modalType, editando, datosEdicion, btnAccept, btnClose, viajero) {

    var optionDateTime = {locale: "es", format: "Y-MM-DD hh:mm:ss A", showTodayButton: true, toolbarPlacement: "top", useCurrent: true, showClose: true, stepping: 10,
        tooltips: {
            today: 'Seleccionar hoy',
            clear: 'Limpiar selección',
            close: 'Cerrar Calend.',
            selectMonth: 'Selec. mes',
            prevMonth: 'Mes ant.',
            nextMonth: 'Mes sig.',
            selectYear: 'Selec. año',
            prevYear: 'Año ant.',
            nextYear: 'Año sig.',
            selectDecade: 'Selec. Decada',
            prevDecade: 'Década ant.',
            nextDecade: 'Década Sig.',
            prevCentury: 'Siglo ant.',
            nextCentury: 'Siglo sig.',
            selectTime: 'Cambiar Hora/Fecha',
            incrementMinute: 'Subir minutos',
            decrementMinute: 'Bajar minutos',
            pickMinute: 'Toque para ver mas',
            incrementHour: 'Subir horas',
            decrementHour: 'Bajar horas',
            pickHour: 'Toque para ver mas',
            togglePeriod: 'Cambiar AM/PM'
        }};
    if (typeof evt !== 'string' && evt !== null) { //Valida que sea un evento
//Busca en el evento el elemento que produjo este evento
        var elem = $(evt.currentTarget);
        //Invoker = Quien es el control invocador, se define en data-invoker
        var invoker = elem.data('invoker');
    } else if (typeof evt === 'string') {
        var invoker = evt; //Simplemente es un texto.
    }

//Se invoca el modal en una petición
    var data = {prefix: invoker, type: modalType, title: '', msg: msg, msg_error: msg_err, btn_accept: btnAccept, btn_close: btnClose};
    var modalBackdrop = $('.modal-backdrop');
    modalBackdrop.each().on('click', function () {
        modalBackdrop.fadeOut('fast').each().remove();
        $('#modalContainer').html('');
    });
    //Oculta el modal
    modalHide();
    var jqXHR = $.post('modal', data);
    jqXHR.done(function (xhr, status, error) {

        //Se carga la plantilla del modal
        $('#modalContainer').html(xhr);
        //Cache
        var modalDlg = $('#modalDialog');
        if (invoker != undefined || invoker != null) {
            switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
                case 'get_print_format':
                    //Inserta barra de espera
                    modalDlg.find('.modal-body').html(waitProgress('Cargando...'));
                    //Modifica tamaño del modal
                    modalDlg.find('.modal-dialog').removeClass('modal-sm').addClass('modal-lg');
                    //Llena el modal con información

                    $.post('actions', {action: 'GET_PRINT_FORMAT',
                        rows: datosEdicion.rows,
                        noVale: datosEdicion.noVale,
                        recargos: datosEdicion.recargos,
                        peaje: datosEdicion.peaje,
                        subtotal: datosEdicion.subtotal,
                        copia: datosEdicion.copia,
                        transportador: datosEdicion.transportador,
                        fechaAplica: datosEdicion.fechaAplica}
                    )
                            .done(function (xhr) {
                                modalDlg.find('.modal-body').html(xhr);
                            });
                    break;
                case 'aprobacion_solicitudes':
                    modalDlg.find('.modal-dialog').removeClass('modal-sm').addClass('modal-md');
                    break;
                case 'crear_form_reparto_btn_beneficiarios':
                    //Inserta barra de espera
                    modalDlg.find('.modal-body').html(waitProgress('Cargando...'));
                    //Modifica tamaño del modal
                    modalDlg.find('.modal-dialog').removeClass('modal-sm').addClass('modal-md');
                    //Llena el modal con información
                    $.post('actions', {action: 'GET_BENEFICIARIO_FORM'})
                            .done(function (xhr) {
                                modalDlg.find('.modal-body').html(xhr);
                                $('#Crear_form_beneficiarios_centro_costo_listar').hide();
                                $('#Crear_form_beneficiarios_nombre_listar').hide();
                                //Eventos generados después de crear el form
                                $('#Crear_form_beneficiarios [data-target=#modalGrid]').on('click', function (evt) {
                                    //Activación del modal grid
                                    modalGrid(evt, false);
                                });
                                //Selección de barrio o dirección
                                if ($("#Crear_form_beneficiarios input[name=puebloDir]").is(":checked")) {

                                }

                            });
                    break;
            }
        }

        //Muestra diálogo modal
        modalDlg.modal('show');
        if (editando) {
            modalDlg.on('shown.bs.modal', function () {

                switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {

                    case 'crear_form_reparto_btn_beneficiarios':

                        if (editando) {
                            //Deshabilitando controles para evitar cambiar datos inamovibles
                            $('#Crear_form_beneficiarios_btn_empl').attr('disabled', true); //Tipo empleado
                            //$('#Crear_form_beneficiarios_btn_cont').attr('disabled', true); //Tipo contratista
                            $('#Crear_form_beneficiarios_btn_visi').attr('disabled', true); //Tipo visitante
                            $('#Crear_form_beneficiarios_nombre_listar_id').attr('readonly', true); //Cédula
                            $('#Crear_form_beneficiarios_nombre_listar_nombre').attr('readonly', true); //Nombre del beneficiario
                            $('#Crear_form_beneficiarios_centro_costo_listar').attr('readonly', true); //Botón de listar Centro de costo
                        }

                        if (datosEdicion['%_tipoBene'] === 'EMPL') {
                            $('#Crear_form_beneficiarios_btn_empl').attr('disabled', false); //Tipo empleado
                            $('#Crear_form_beneficiarios_btn_empl').attr('checked', 'checked').trigger('click');
                        } else if (datosEdicion['%_tipoBene'] === 'CONT') {
                            //$('#Crear_form_beneficiarios_btn_cont').attr('disabled', false); //Tipo contratista
                            //$('#Crear_form_beneficiarios_btn_cont').attr('checked', 'checked').trigger('click');
                        } else if (datosEdicion['%_tipoBene'] === 'VISI') {
                            $('#Crear_form_beneficiarios_btn_visi').attr('disabled', false); //Tipo visitante
                            $('#Crear_form_beneficiarios_btn_visi').attr('checked', 'checked').trigger('click');
                        }

                        //if (datosEdicion['%_puebloDir'] == 'PUE') {
                        var _zona = datosEdicion['%_zona'];
                        if (_zona.substr(0, 1) == 'P') {
                            $('#Crear_form_beneficiarios_btn_pueblos').attr('checked', 'checked').trigger('click');
                        } else if (_zona.substr(0, 1) == 'Z') {
                            $('#Crear_form_beneficiarios_btn_dirs').attr('checked', 'checked').trigger('click');
                        }
                        debugger
                        $('#Crear_form_beneficiarios_nombre_listar_id').val(datosEdicion['%_id']);
                        $('#Crear_form_beneficiarios_nombre_listar_nombre').val(datosEdicion['%_nombre']);
                        $('#Crear_form_beneficiarios_centro_costo_listar_id').val(datosEdicion['%_ccosto']);
                        $('#Crear_form_beneficiarios_centro_costo_listar_nombre').val(datosEdicion['%_ccosto_nombre']);
                        $('#Crear_form_beneficiarios_ciudades_listar_nombre').val(datosEdicion['%_ciudad_nombre']);
                        $('#Crear_form_beneficiarios_direccion').val(datosEdicion['%_dir']);
                        if (datosEdicion['%_zona'].substr(0, 1) == 'Z') {
                            var dirs = depuraDir(datosEdicion['%_dir']);
                            var dirZona = dirs.dirZona;
                            listarZonasDir(dirZona, 'Crear_form_beneficiarios_zonas_dir', datosEdicion['%_zona'], datosEdicion['%_ciudad_id']); //Busca la zona y la selecciona
                        } else {
                            $('#Crear_form_beneficiarios_direccion').val(datosEdicion['%_zona']);
                            $('#Crear_form_beneficiarios_ciudades_listar_id').val(datosEdicion['%_zona']);
                            //Tabla de zonas
                            $('#Crear_form_beneficiarios_zonas_dir').html("<tbody class='rwd-table small table-responsive table-bordered'>" +
                                    "<tr ><th >&nbsp;</th><th >ID</th><th >Nombre</th><th >Valor</th><th >Rango</th></tr>" +
                                    "<tr id='" + datosEdicion['%_zona'] + "' class='show-cursor-hand-active'>" +
                                    "<td data-th='Seleccionar'><label><input type='radio' checked='checked' value=" + datosEdicion['%_zona'] + " name='_id_zona' id='id_zona'></label></td>" +
                                    "<td data-th='ID'>" + datosEdicion['%_zona'] + "</td>" +
                                    "<td id='_nombre_zona' data-th='Nombre'>" + datosEdicion['%_ciudad_nombre'] + "</td>" +
                                    "<td id='_valor_zona' data-th='Valor'>" + parseFloat(datosEdicion['%_valor'] || 0).toLocaleString() + "</td>" +
                                    //"<td id='_valor_adic' data-th='Valor'>" + parseFloat(datosEdicion['%_adic'] || 0).toLocaleString() + "</td>" +
                                    "<td data-th='Rango'>" + datosEdicion['%_dir'] + "</td>" +
                                    "</tr></tbody>");
                        }
                        break;
                }
            });
        } else {
            switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
                case 'js-finalizar-servicio':
                    $("#Finaliza_solicitud").datetimepicker(optionDateTime);
                    break;
            }
        }

        modalDlg.on('click', '[name=_puebloDir]', function () {
            $('#Crear_form_beneficiarios_ubicacion').removeClass('hidden');
            $('#Crear_form_beneficiarios_zonas_dir').html(''); //Limpia la caja de texto de la dirección
            $('#Crear_form_beneficiarios_direccion_dir').val(''); //Limpia la caja de texto de la dirección
            $('#Crear_form_beneficiarios_direccion').val(''); //Limpia la caja de texto de la dirección depurada
            $('#Crear_form_beneficiarios_ciudades_listar_id').val(''); //Limpia el id de la ciudad/pueblo
            $('#Crear_form_beneficiarios_ciudades_listar_nombre').val('');
            if ($(this).val() == 'PUE') { //Si es pueblo
                $('#Crear_form_beneficiarios_direccion_dir').hide(); //Oculta la caja de texto de dirección     
                $('#Crear_form_beneficiarios_ciudades_listar_nombre').prop('placeholder', 'Seleccione el destino  -->>'); //Sugiere seleccionar el destino
            } else { //Si es dirección
                $('#Crear_form_beneficiarios_direccion_dir').show(); //Muestra la caja de texto para digitar la dirección
                $('#Crear_form_beneficiarios_ciudades_listar_nombre').val('Cargando ciudad...');
                $.post('actions', {action: 'GET_COD_CIUDAD', ciudad: 'BARRANQUILLA'}) //Consulta el nombre de la ciudad por defecto                
                        .done(function (result) { //Asigna resultado de la consulta a la base de datos
                            var jsonData = JSON.parse(result);
                            if (jsonData.TotalRecordCount > 0) {
                                $('#Crear_form_beneficiarios_ciudades_listar_nombre').val(jsonData.Records[0].nombreCiudad);
                                $('#Crear_form_beneficiarios_ciudades_listar_id').val(jsonData.Records[0].id);
                            } else {
                                $('#Crear_form_beneficiarios_ciudades_listar_nombre').prop('placeholder', 'Seleccione el destino  -->>');
                            }
                        })
                        .fail(function () { //En caso de fallar limpia el codigo de ciudad y coloca un texto sugerente
                            $('#Crear_form_beneficiarios_ciudades_listar_nombre').prop('placeholder', 'Seleccione el destino  -->>');
                        });
            }
        });
        modalDlg.on('click', '#Crear_form_beneficiarios_btn_empl', function () {
            $('#Crear_form_beneficiarios_centro_costo_listar').hide();
            $('#Crear_form_beneficiarios_nombre_listar_id').val('');
            $('#Crear_form_beneficiarios_nombre_listar_nombre').val('');
            $('#Crear_form_beneficiarios_centro_costo_listar_id').val('');
            $('#Crear_form_beneficiarios_centro_costo_listar_nombre').val('');
            $('#Crear_form_beneficiarios_nombre_listar_nombre').parent().removeClass('col-md-12');
            $('#Crear_form_beneficiarios_nombre_listar_id').prop('readonly', true);
            $('#Crear_form_beneficiarios_nombre_listar_nombre').prop('readonly', true);
            $('#Crear_form_beneficiarios_nombre_listar_nombre').prop('placeholder', 'Seleccione el beneficiario  ->>');
            $('#Crear_form_beneficiarios_nombre_listar_id').prop('placeholder', '');
            $('#Crear_form_beneficiarios_nombre_listar').show();
        });
        /*modalDlg.on('click', '#Crear_form_beneficiarios_btn_cont, #Crear_form_beneficiarios_btn_visi', function () {
         $('#Crear_form_beneficiarios_centro_costo_listar').show();
         $('#Crear_form_beneficiarios_nombre_listar_id').val('');
         $('#Crear_form_beneficiarios_nombre_listar_nombre').val('');
         $('#Crear_form_beneficiarios_centro_costo_listar_id').val('');
         $('#Crear_form_beneficiarios_centro_costo_listar_nombre').val('');
         $('#Crear_form_beneficiarios_nombre_listar_nombre').parent().addClass('col-md-12');
         $('#Crear_form_beneficiarios_nombre_listar_id').prop('readonly', false);
         $('#Crear_form_beneficiarios_nombre_listar_nombre').prop('readonly', false);
         $('#Crear_form_beneficiarios_nombre_listar_nombre').prop('placeholder', 'Digite el beneficiario');
         $('#Crear_form_beneficiarios_nombre_listar_id').prop('placeholder', 'Digite la cédula del beneficiario');
         $('#Crear_form_beneficiarios_nombre_listar').hide();
         });*/
        //Se delega botón cerrar
        modalDlg.on('click', '#modal_button_close', function () {
            switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
                case 'mismodestino':
                    mismo_destino(datosEdicion['soli'], datosEdicion['viaje'], datosEdicion['id_bene']);
                    modalDlg.modal('hide');
                    break;
                case 'consultar_form_audit_listado':
                    var elem = $('#' + invoker).find('table');
                    $(elem).tableExport({type: 'doc', escape: 'false'});
                    modalDlg.modal('hide');
                    break;
            }
        });
        //Se delega el clic al botón de aceptación
        modalDlg.on('click', '#modal_button_accept', function () {

            var todoBien = false;
            //Validación de acciones según el invoker (si hay invoker y no está aquí registrado como acción solo se usará para el lenguaje)
            switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
                case 'js-finalizar-servicio':

                    $('#error_finaliza_solicitud').text('');
                    var fecha_aplica = $('#Aplica_Solicitud').val();
                    var fecha_finaliza = $('#Finaliza_solicitud').val();
                    //Conversion a tiempo unix
                    var fecha_finaliza_unix = moment(fecha_finaliza, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm").valueOf();
                    var fecha_aplica_unix = moment(fecha_aplica, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm").valueOf();
                    //fecha_finaliza = Date.parse(fecha_finaliza); //Falla en firefox
                    //fecha_aplica = Date.parse(fecha_aplica);//Falla en firefox
                    var diff = moment(fecha_finaliza_unix).unix() - moment(fecha_aplica_unix).unix();
                    var segundos = diff; // 1000;
                    var solicitud = $('#Finaliza_solicitud_id_sol').val();
                    var id_bene = $('#Finaliza_solicitud_bene').val();
                    if (parseFloat(segundos || 0) > 0) {
                        var jHXR = $.post('actions', {action: 'SAVE_FECHA_FINALIZA_HORA', solicitud: solicitud, id_bene: id_bene, fecha: fecha_finaliza, fecha_aplica: fecha_aplica});
                        jHXR.done(function (xhr) {
                            log('fecha_finaliza_hora success');
                            var json_data = JSON.parse(xhr);
                            //var fecha_hora_fin = [fecha_finaliza.substring(' ', fecha_finaliza.indexOf(' ')), fecha_finaliza.substring(fecha_finaliza.indexOf(' ') + 1)];

                            if (json_data._result[0].msg == 'ok') {

                                modalDlg.modal('hide');
                                modalDlg.on('hidden.bs.modal', function () {

                                    var solicitud = json_data._result[1].id;
                                    var valorHora = json_data._result[2].valorxhora;
                                    fecha_finaliza = moment(fecha_finaliza, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm");
                                    fecha_aplica = moment(fecha_aplica, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm");
                                    //Conversion a tiempo unix
                                    fecha_finaliza_unix = moment(fecha_finaliza, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm").valueOf();
                                    fecha_aplica_unix = moment(fecha_aplica, ["YYYY-MM-DD hh:mm A"]).format("YYYY-MM-DD HH:mm").valueOf();
                                    //fecha_finaliza = Date.parse(fecha_finaliza); //Falla en firefox
                                    //fecha_aplica = Date.parse(fecha_aplica);//Falla en firefox
                                    diff = moment(fecha_finaliza_unix).unix() - moment(fecha_aplica_unix).unix();
                                    segundos = diff; // 1000;
                                    var horas = Math.floor(segundos / 3600);
                                    var minutos = Math.floor((segundos % 3600) / 60);
                                    var valorMinuto = valorHora / 60;
                                    var liquidacion = 0;
                                    //Se cobra una hora como mínimo
                                    horas > 1 ? liquidacion = parseFloat(horas * valorHora || 0) + parseFloat(valorMinuto * minutos || 0) : liquidacion = valorHora;
                                    var jHXR_sol = $.post('actions', {action: 'GET_SOLICITUDES', todas: 'NO', id_solicitud: solicitud, _estado_solicitud: 'D'});
                                    jHXR_sol.done(function (xhr_sol) {

                                        var json_sol = JSON.parse(xhr_sol);
                                        var subtotal_solicitud = 0;
                                        var recargos_solicitud = 0;
                                        var peaje_solicitud = 0;
                                        var fecha;
                                        var transportador;
                                        var vale = {};
                                        var noVale = 0;
                                        var rows = '';
                                        var No = 0;
                                        var fila_beneficiario;
                                        var tiempo;
                                        $.each(json_sol.Records, function (i, registro) {
                                            fila_beneficiario = '<tr> <td class="left-border td-border tg-vertical-top">%_NO_%</td>' +
                                                    '<td class="td-border tg-vertical-top">%_BENEFICIARIO_%</td>' +
                                                    '<td class="td-border tg-vertical-top">%_CON_CARGO_A_%</td>' +
                                                    '<td class="td-border tg-vertical-top">%_DESTINO_%</td>' +
                                                    '<td class="td-border tg-vertical-top">%_ZONA_%</td>' +
                                                    '<td class="precio td-border tg-vertical-top">%_RECARGO_%</td>' +
                                                    '<td class="td-border tg-vertical-top">%_TIEMPO_%</td>' +
                                                    '<td class="precio right-border td-border tg-vertical-top">%_VALOR_%</td>' +
                                                    '</tr>';
                                            No++;
                                            vale.id_sol = registro.idSolicitudNoHtml;
                                            vale.id_bene = registro.idBeneficiarioNoHtml;
                                            vale.nombre_bene = registro.nombreBeneficiario;
                                            vale.destino = registro.destino;
                                            vale.valor = registro.valor;
                                            vale.recargo = registro.recargo;
                                            vale.peaje = registro.peaje;
                                            vale.id_zona = registro.zonaSolicitud;
                                            vale.nombre_zona = registro.zonaNombre;
                                            vale.centro_costo = registro.nombreCentroCostoAaplicar;
                                            fecha = registro.fechaAplicaSolicitud;
                                            noVale = registro.valeDespacho;
                                            transportador = registro.idTransportador;
                                            horas > 0 ? tiempo = horas + 'h ' + minutos + 'm' : tiempo = '0h ' + minutos + 'm';
                                            fila_beneficiario = fila_beneficiario.replace(/%_NO_%/g, No);
                                            fila_beneficiario = fila_beneficiario.replace(/%_BENEFICIARIO_%/g, vale.nombre_bene);
                                            fila_beneficiario = fila_beneficiario.replace(/%_CON_CARGO_A_%/g, vale.centro_costo);
                                            fila_beneficiario = fila_beneficiario.replace(/%_DESTINO_%/g, vale.destino);
                                            fila_beneficiario = fila_beneficiario.replace(/%_ZONA_%/g, vale.id_zona);
                                            fila_beneficiario = fila_beneficiario.replace(/%_TIEMPO_%/g, tiempo);
                                            fila_beneficiario = fila_beneficiario.replace(/%_VALOR_%/g, '$' + parseFloat(vale.valor.trim() || 0).toLocaleString() + '/h');
                                            fila_beneficiario = fila_beneficiario.replace(/%_RECARGO_%/g, '$' + parseFloat(vale.recargo.trim() || 0).toLocaleString());
                                            rows += fila_beneficiario;
                                            recargos_solicitud += parseFloat(vale.recargo.trim() || 0);
                                            peaje_solicitud += parseFloat(vale.peaje.trim() || 0);
                                        });
                                        subtotal_solicitud = liquidacion;

                                        var fechaAplica = moment(fecha).format("YYYY-MM-DD hh:mm A");
                                        var data = {rows: rows, subtotal: subtotal_solicitud, recargos: recargos_solicitud, peaje: peaje_solicitud, noVale: noVale, transportador: transportador, fechaAplica: fechaAplica};
                                        modalShow('get_print_format', '', '', 'success', false, data, 'Imprimir', 'Cerrar');
                                    });
                                });
                            }
                        });
                        //modalDlg.modal('hide');
                    } else {
                        var msg = '';
                        fecha_finaliza < fecha_aplica && fecha_finaliza != '' ? msg += 'Fecha y hora final menor que inicial de la solicitud.<br/>' : '';
                        fecha_finaliza == '' ? msg += 'Elija una fecha y hora.<br/>' : '';
                        fecha_finaliza == undefined ? msg += 'Fecha inválida, debe ser fecha y hora.<br/>' : '';
                        $('#error_finaliza_solicitud').html(msg);
                    }

                    break;
                case 'mismodestino':
                    mismo_destino(datosEdicion['soli'], datosEdicion['viaje'], '');
                    modalDlg.modal('hide');
                    break;
                case 'get_print_format':
                    print_format();
                    modalDlg.modal('hide');
                    break;
                case 'consultar_form_audit_listado':
                    var elem = $('#' + invoker).find('table');
                    $(elem).tableExport({type: 'excel', escape: 'false'});
                    modalDlg.modal('hide');
                    break;
                case 'main_logout':
                    todoBien = true;
                    Logout();
                    break;
                case 'crear_form_reparto_btn_beneficiarios':
                    debugger
                    todoBien = validaModal(invoker);
                    if (!todoBien) {
                        alert('Faltan datos');
                    } else {
                        var elem = $('#Crear_form_beneficiarios');
                        var formArrSerial = elem.serializeArray();
                        var formArr = [];
                        formArr = arrSerial2arrKey(formArrSerial);
                        var zonaSel = $('#' + elem.find('table').find('input:checked').val()); //Obtiene el ID de la zona seleccionada
                        formArr['_valor'] = zonaSel.find('#_valor_zona').text(); //Valor de la zona seleccionada
                        //formArr['_adic'] = zonaSel.find('#_valor_adic').text(); //Valor de la zona seleccionada
                        formArr['_nombre_zona'] = zonaSel.find('#_nombre_zona').text(); //Nombre de la zona seleccionada

                        var beneficiario = "<tr id='" + formArr['_id'] + "' class='show-cursor-hand-active'>" +
                                "<input class='js-createobject' data-field='_id' name='%_" + formArr['_id'] + "_id' type='hidden' value='" + formArr['_id'] + "'>" +
                                "<input class='js-createobject' data-field='_tipoBene' name='%_" + formArr['_id'] + "_tipoBene' type='hidden' value='" + formArr['_tipoBene'] + "'>" +
                                "<input class='js-createobject' data-field='_nombre' name='%_" + formArr['_id'] + "_nombre' type='hidden' value='" + formArr['_nombre'] + "'>" +
                                "<input class='js-createobject' data-field='_ccosto_id' name='%_" + formArr['_id'] + "_ccosto' type='hidden' value='" + formArr['_ccosto_id'] + "'>" +
                                "<input class='js-createobject' data-field='_ccosto_nombre' name='%_" + formArr['_id'] + "_ccosto_nombre' type='hidden' value='" + formArr['_ccosto_nombre'] + "'>" +
                                "<input class='js-createobject' data-field='_id_zona' name='%_" + formArr['_id'] + "_zona' type='hidden' value='" + formArr['_id_zona'] + "'>" +
                                "<input class='js-createobject' data-field='_valor' name='%_" + formArr['_id'] + "_valor' type='hidden' value='" + formArr['_valor'].match(/([0-9])/g).join('') + "'>" +
                                //"<input class='js-createobject' data-field='_adic' name='%_" + formArr['_id'] + "_adic' type='hidden' value='" + formArr['_adic'].match(/([0-9])/g).join('') + "'>" +
                                "<input class='js-createobject' data-field='_puebloDir' name='%_" + formArr['_id'] + "_puebloDir' type='hidden' value='" + formArr['_puebloDir'] + "'>" +
                                "<input class='js-createobject' data-field='_ciudad_id' name='%_" + formArr['_id'] + "_ciudad_id' type='hidden' value='" + formArr['_ciudad_id'] + "'>" +
                                "<input class='js-createobject' data-field='_ciudad_nombre' name='%_" + formArr['_id'] + "_ciudad_nombre' type='hidden' value='" + formArr['_ciudad_nombre'] + "'>" +
                                "<input class='js-createobject' data-field='_dir' name='%_" + formArr['_id'] + "_dir' type='hidden' value='" + formArr['_dir'] + "'>" +
                                "<td data-th='Tipo'>" + formArr['_tipoBene'] + "</td>" +
                                "<td data-th='C&#233;d.'>" + formArr['_id'] + "</td>" +
                                "<td data-th='Nombre'>" + formArr['_nombre'] + "</td>" +
                                "<td data-th='C.Costo'>" + formArr['_ccosto_id'] + "-" + formArr['_ccosto_nombre'] + "</td>" +
                                "<td data-th='Zona'>" + formArr['_id_zona'] + (formArr['_nombre_zona'] !== '' ? '-' + formArr['_nombre_zona'] : '') + "</td>" +
                                "<td data-th='Valor $'>" + formArr['_valor'] + "</td>" +
                                //"<td data-th='Adic. $'>" + formArr['_adic'] + "</td>" +
                                "<td data-th='Dir'>" + formArr['_dir'] + "</td>" +
                                "<td data-th='Opciones'><div class='btn-group inline pull-right'><a class='btn btn-xs btn-info js-editar-beneficiario js-show-qtip' title='Editar'><i class='fa fw fa-edit'></i></a><a class='btn btn-xs btn-danger js-remover-beneficiario js-show-qtip' title='Eliminar'><i class='fa fw fa-times'></i></a></div></td>" +
                                "</tr>";
                        var existeBeneficiario = $('#Crear_form_reparto_beneficiarios_lista').children('tr[id]').filter(function () {
                            return $(this).attr('id') === formArr['_id'];
                        });
                        if ($('#Crear_form_reparto_aprobador_listar_id') == formArr['_id']) {
                            modalShow('', 'Este usuario no se puede aprobar a si mismo.', 'Elija otro aprobador', 'danger', false, '', '', 'Cerrar');
                        } else if (existeBeneficiario.length === 0 && (viajero ? true : !editando)) { //Si ya existe y no se está editando

                            guardarViajeroFrecuente(formArr['_id'], formArr['_tipoBene'], formArr['_id_zona'], formArr['_dir'], formArr['_ciudad_id']);

                            $('#Crear_form_reparto_beneficiarios_lista').append(beneficiario);
                            //Llenar cedula beneficiario para filtrar aprobador
                            $('#Crear_form_reparto_aprobador_benef').val(formArr['_id']);
                            //Llamar aprobador de este beneficiario
                            var jXHR = $.post('actions', {action: 'GET_APROBADORES', id_bene: formArr['_id']});
                            //Todo bien
                            jXHR.done(function (xhr) {

                                if ($('#Crear_form_reparto_aprobador_listar_id').val() == '') {
                                    var jsonData = JSON.parse(xhr);
                                    //Llenar Centro de Costo                                    
                                    //var elemCcostoId = $('#Crear_form_reparto_centro_costo_listar_aprobador_id');
                                    //var elemCcostoNombre = $('#Crear_form_reparto_centro_costo_listar_aprobador_nombre');
                                    var elemCorreo = $('#Crear_form_reparto_aprobador_listar_correo');
                                    var elemId = $('#Crear_form_reparto_aprobador_listar_id'); //Contendrá el id
                                    var elemNombre = $('#Crear_form_reparto_aprobador_listar_nombre'); //Contendrá el nombre

                                    //elemCcostoId.val(jsonData.Records[0].codigoCentro);
                                    //elemCcostoNombre.val(jsonData.Records[0].nombreCentro);
                                    //Llenar aprobador
                                    elemNombre.val(jsonData.Records[0].primerNombre + ' ' + jsonData.Records[0].segundoNombre + ' ' + jsonData.Records[0].primerApellido + ' ' + jsonData.Records[0].segundoApellido);
                                    elemId.val(jsonData.Records[0].id).change();
                                    //$('#Crear_form_reparto_centro_costo_listar_aprobador_id').change();
                                    //Este correo es de prueba [CORREO DE PRUEBA]
                                    elemCorreo.val(jsonData.Records[0].correo); //Correo que se enviará al aprobador

                                }
                            });
                            //Todo falla
                            jXHR.fail(function () {

                            });
                            actualizaTotalSolicitud('Crear_form_reparto_beneficiarios_lista');
                            //Trigger para remover beneficiario
                            $('#' + formArr['_id'] + ' .js-remover-beneficiario').on('click', function () {
                                this.closest('tr').remove(); //Remueve el item de la tabla
                                //Borrar los campos de aprobador y su centro de costo
                                if ($('#Crear_form_reparto_beneficiarios_lista').find('tr').length < 2) {
                                    $('#Crear_form_reparto_aprobador_listar_nombre').val('');
                                    //$('#Crear_form_reparto_centro_costo_listar_aprobador_id').val('').change(); //Como es un read only se dispara el evento
                                    //$('#Crear_form_reparto_centro_costo_listar_aprobador_nombre').val('');
                                }
                                actualizaTotalSolicitud('Crear_form_reparto_beneficiarios_lista');
                            });
                            //Trigger para editar beneficiario
                            $('#' + formArr['_id'] + ' .js-editar-beneficiario').on('click', function () {

                                var inputArray = $(this).closest('tr').find('input:hidden');
                                var idTr = $(this).closest('tr').attr('id');
                                var dataArray = [];
                                $.each(inputArray, function (index, data) {
                                    var inputId = $(data).attr('name');
                                    inputId = inputId.replace('_' + idTr, ''); //Quita el id del benenficiario para dejar el nombre del id genérico
                                    dataArray[inputId] = $(data).val();
                                });
                                modalShow('Crear_form_reparto_btn_beneficiarios', 'EDITANDO', 'Beneficiario', 'info', true, dataArray);
                            });
                        } else if (editando) {
                            $('#Crear_form_reparto_beneficiarios_lista').children('tr[id]').filter(function () {
                                if ($(this).attr('id') == formArr['_id']) {
                                    $(this).find('[data-field="_id_zona"]').val(formArr["_id_zona"]);
                                    $(this).find('[data-field="_valor"]').val(formArr["_valor"]);
                                    //$(this).find('[data-field="_adic"]').val(formArr["_adic"]);
                                    $(this).find('[data-field="_puebloDir"]').val(formArr["_puebloDir"]);
                                    $(this).find('[data-field="_ciudad_id"]').val(formArr["_ciudad_id"]);
                                    $(this).find('[data-field="_ciudad_nombre"]').val(formArr["_ciudad_nombre"]);
                                    $(this).find('[data-field="_dir"]').val(formArr["_dir"]);
                                    $(this).find('[data-th="Zona"]').text(formArr["_id_zona"] + '-' + formArr["_ciudad_nombre"]);
                                    $(this).find('[data-th="Valor $"]').text(formArr["_valor"]);
                                    //$(this).find('[data-th="Adic. $"]').text(formArr["_adic"]);
                                    formArr["_puebloDir"] === 'PUE' ? $(this).find('[data-th="Dir"]').text(formArr["_ciudad_nombre"]) : $(this).find('[data-th="Dir"]').text(formArr["_dir"]);
                                    actualizaTotalSolicitud('Crear_form_reparto_beneficiarios_lista');
                                }
                            });
                        } else {
                            $('#Crear_form_beneficiarios_nombre_listar_nombre').addClass('border-dotted');
                            $('#Crear_form_beneficiarios_nombre_listar_nombre').addClass('border-red');
                            $('#Crear_form_beneficiarios_nombre_listar_nombre').css('color', 'red');
                            $('#Crear_form_beneficiarios_nombre_listar_nombre').css('font-weight', '900');
                            alert('Beneficiario ya está en la lista de beneficiarios.');
                            todoBien = false;
                        }
                    }
                    break;
                case 'crear_form_beneficiarios_btn_pueblos':
                    todoBien = true;
                    break;
                case 'crear_form_beneficiarios_btn_dirs':
                    todoBien = true;
                    break;
            }

            //Oculta el modal en medio segundo
            if (todoBien) {
                setTimeout(function () {
                    modalDlg.modal('hide');
                }, 300);
            }

            $('#modal_button_close').focus();
        });
        //Validar dirección (Estandarización)
        modalDlg.on('click', '#Crear_form_beneficiarios_btn_validar_dir', function () {
            var elem = $('#Crear_form_beneficiarios_direccion');
            var elemDirZona = $('#Crear_form_beneficiarios_direccion_zona');
            var dir = elem.val();
            var dirs = depuraDir(dir); //Depuración de la dirección
            var ciudad = $('#Crear_form_beneficiarios_ciudades_listar_id').val();
            var dirZona = dirs.dirZona;
            var dirEstandar = dirs.dirEstandar;
            dirZona = extractDirZona(dirZona);
            dirEstandar.toLowerCase().indexOf('circunvalar') >= 0 ? dirZona = 'circunvalar:' + dirZona : '';
            dirEstandar.toLowerCase().indexOf('las flores') >= 0 ? dirZona = 'lasflores:' + dirZona : '';
            elemDirZona.val(dirZona);
            elem.val(dirEstandar);
            listarZonasDir(dirZona, 'Crear_form_beneficiarios_zonas_dir', '', ciudad);
        });
        jqXHR.fail(function (xhr, status, error) {
            log('modal_show fail:\n' + error);
        });
        jqXHR.always(function (xhr, status, error) {
            log('modal_show complete\n' + error);
        });
    });
}


/**
 * Guarda/Actualizar a beneficiario como viajero frecuente 
 * @param {type} id_bene Identificación del beneficiario
 * @param {type} tipo_bene Tipo de beneficiario 
 * @param {type} zona Id de la zona
 * @param {type} destino Destino 
 * @param {type} id_ciudad Id de la ciudad
 * @returns {null} no retorna nada solamente realiza la insercción
 */
function guardarViajeroFrecuente(id_bene, tipo_bene, zona, destino, id_ciudad) {

    if ($('#Crear_form_beneficiarios_chk_viajero').is(':checked')) {

        var data = {action: 'SAVE_VIAJERO_FRECUENTE', id_bene: id_bene, tipo_bene: tipo_bene, zona: zona, destino: destino, id_ciudad: id_ciudad};

        var jXHR = $.post('actions', data);

        jXHR.done(function () {
            log('save_viajero success');
            modalShow('', 'Viajero Guardado', '', 'success', '', '', '', 'Cerrar');
        });

        jXHR.fail(function () {
            log('save_viajero FAIL');
            modalShow('', 'Error', 'Error guardando viajero', 'danger', '', '', '', 'Cerrar');
        });


    }
}

function actualizaTotalSolicitud(elem) {
    //var subtotal = $('#' + elem + '_subtotal_solicitud');
    //var adic = $('#' + elem + '_adic_solicitud');
    var total = $('#' + elem + '_total_solicitud');
    var elem = $('#' + elem);
    total.val('');
    var sumatotal = 0;
    //var sumasubtotal = 0;
    //var sumaadic = 0;
    $.each(elem.find('input:hidden'), function (index, data) {
        if (data.name.substring(data.name.length, data.name.length - 6) === '_valor') {
            sumatotal += parseInt(data.value.match(/([0-9])/ig).join(''));
            //sumasubtotal += parseInt(data.value.match(/([0-9])/ig).join(''));
        }
        else if (data.name.substring(data.name.length, data.name.length - 5) === '_adic') {
            sumatotal += parseInt(data.value.match(/([0-9])/ig).join(''));
            //sumaadic += parseInt(data.value.match(/([0-9])/ig).join(''));
        }
    });
    total.val('$' + sumatotal.toLocaleString()); // Formateo a moneda
    //subtotal.val('$' + sumasubtotal.toLocaleString()); // Formateo a moneda
    //adic.val('$' + sumaadic.toLocaleString()); // Formateo a moneda
}

/**
 * Depuración de la dirección
 * @param {type} dir direccion
 * @returns {Array|depuraDir.dirs} direcciones depuradas
 */
function depuraDir(dir) {
    var dirEstandar = '';
    var dirZona = '';
    var dirs = [];
    var clle = false;
    var cra = false;
    var letra = '';
    var numero = '';
    var rgxNumLetra = /([^a-z]*[\s][a-z]{1}) | ([^a-z]*[\s][a-z]{1}[0-9])/ig;
    var corrigeLetras = dir.match(rgxNumLetra);
    dir = dir.replace(/[^\w\s#-]/g, ' ');
    dir = dir.replace(/[.]/g, ' ');
    dir = dir.replace(/[,]/g, ' ');
    dir = dir.replace(/[;]/g, ' ');
    dir = dir.replace(/[º]/g, ' ');
    dir = dir.replace(/[:]/g, ' ');
    dir = dir.replace(/[_]/g, ' ');
    dir = dir.replace(/[\/]/g, ' ');
    dir = dir.replace(/[\\]/g, ' ');
    if (corrigeLetras != null) {
        $.each(corrigeLetras, function (index, data) {
            dir = dir.replace(data, ' ' + data.replace(/\s/ig, '') + ' ');
        });
    }

    dir = dir.replace(/[#]/g, ' # ');
    dir = dir.replace(/([\s]*[#][\s]*)/g, ' # ');
    dir = dir.replace(/  +/g, ' ');
    dir = dir.split(' ');
    $.each(dir, function (index, data) {
        var dir = encontrarDir(data);
        if (dir.indexOf('-') >= 0) { // Buscar el guión 
            dir = dir.replace(/\s/g, ''); //Remueve todos los espacios  
            var dir = dir.split('-'); //Separa el primer número guió
        }

        var rgx;
        var dirIsArray = $.isArray(dir);
        dirIsArray ? rgx = dir[0].split(/([0-9].*)+([a-z].*)/ig) : rgx = dir.split(/([0-9].*)+([a-z].*)/ig); //Busca si tiene número + letra

        if (rgx.length > 1) {
            numero = dirIsArray ? dir[0].replace(/(\D[a-z]*[0-9]*)/ig, '') : dir.replace(/(\D[a-z]*[0-9]*)/ig, '');
            letra = dirIsArray ? dir[0].replace(/(^[0-9]*[0-9])/ig, '') : dir.replace(/(^[0-9]*[0-9])/ig, '');
            dirZona += numero + ':' + letra + ':'; //Letra y número
        } else {
            if (clle) { //Si es calle 
                clle = false;
            } else if (cra) { //Si es carrera
                cra = false;
            }
        }

        dirEstandar += $.isArray(dir) ? dir.join('-') + ' ' : dir + ' '; //En caso de se un array lo une y lo adjunta

        //Valida calle o carrera
        if (!$.isArray(dir)) {
            if (dir.toLowerCase() === 'cra') {
                cra = true;
                dirZona += 'cra:';
            } else if (dir.toLowerCase() === 'clle') {
                clle = true;
                dirZona += 'clle:';
            } else if (dir.toLowerCase() === 'via') {
                clle = true;
                dirZona += 'via:';
            } else if ($.isNumeric(dir)) {
                dirZona += dir + ':';
            }
        }
        else if (dir[0].trim().toString().length > 0 && dir[0].indexOf(dir[0].replace(/([0-9])/ig, '')) === 0) {
            dirZona += dir[0] + ':';
        }
    });
    dirs['dir'] = dir;
    dirs['dirZona'] = dirZona;
    dirs['dirEstandar'] = dirEstandar;
    return dirs;
}

function arrSerial2arrKey(arrSerial) {

    var formArr = [];
    $.each(arrSerial, function (index, data) {
        formArr[data.name] = data.value;
    });
    return formArr;
}

function validaModal(invoker) {

    var seguir = true;
    var zona = false;
    var tipoBene = false;
    var puebloDir = false;
    switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
        case 'crear_form_reparto_btn_beneficiarios':
            var elem = $('#Crear_form_beneficiarios');
            var formArray = elem.serializeArray();
            //var idZona = elem.find('table').find('input:checked').val();
            $.each(formArray, function (index, data) {
                if (seguir) {
                    if (data.value === undefined || data.value === '' && data.name != '_ciudad_nombre') {
                        seguir = false;
                    }
                    if (data.name === '_id_zona') { //Busca la zona
                        zona = true;
                    }
                    if (data.name === '_tipoBene') { //Busca la opcion tipo de beneficiario
                        tipoBene = true;
                    }
                    if (data.name === '_puebloDir') { //Busca la opción pueblo o dir
                        puebloDir = true;
                    }
                }
            });
            break;
    }
    if (!zona || !tipoBene || !puebloDir) { //Si no hay zona o tipo beneficiario o pueblo o dir
        seguir = false;
    }
    return seguir;
}

/**
 * Lista las zonas de 
 * @param {type} dir dirección
 * @param {type} target destino de la lista de zonas
 * @param {type} zona cuando se esté editando se envía para seleccionarla
 * @returns {undefined}  no retorna nada
 */
function listarZonasDir(dir, target, zona, ciudad) {
    window.data = {action: 'GET_ZONA_DIR', ciudad: ciudad};
    var dir = dir.split(':');
    var clle = 0;
    var cra = 0;
    var lclle = '';
    var lcra = '';
    if (dir[0] === 'clle') {
        clle = dir[1];
        //Si es letra
        if (!$.isNumeric(dir[2])) {
            lclle = dir[2]; //Letra calle            
            cra = dir[3]; //Carrera
            if (!$.isNumeric(dir[4])) {
                lcra = dir[4]; //Letra carrera
            }
        } else if ($.isNumeric(dir[2])) {
            cra = dir[2]; //Carrera
            if (!$.isNumeric(dir[3])) {
                lcra = dir[3]; //Letra carrera
            }
        }
    }

    if (dir[0] === 'cra') {
        cra = dir[1];
        //Si es letra
        if (!$.isNumeric(dir[2])) {
            lcra = dir[2]; //Letra carrera
            clle = dir[3]; //Calle
            if (!$.isNumeric(dir[4])) {
                lclle = dir[4]; //Letra calle
            }
        } else if ($.isNumeric(dir[2])) {
            clle = dir[2]; //Carrera
            if (!$.isNumeric(dir[3])) {
                lclle = dir[3]; //Letra calle
            }
        }
    }

    $.extend(window.data, {clle: clle});
    $.extend(window.data, {lclle: lclle});
    $.extend(window.data, {cra: cra});
    $.extend(window.data, {lcra: lcra});
    $.extend(window.data, {fecha: $('#crear_form_reparto_fecha_inicia_solicitud').val()});
    $.extend(window.data, {param1: 'html'});
    var jqXHR = $.post('actions', window.data);
    jqXHR.done(function (xhr, status, error) {

        switch (target.toLowerCase()) {
            case 'crear_form_beneficiarios_zonas_dir':
                $('#Crear_form_beneficiarios_zonas_dir').html(xhr);
                if (zona !== '') {
                    $('#' + zona + ' input:radio').attr('checked', 'checked');
                }
                break;
        }
    });
    jqXHR.fail(function (xhr, status, error) {
        log('modal_show fail:\n' + error);
    });
    jqXHR.always(function (xhr, status, error) {
        log('modal_show complete\n' + error);
    });
}

/**
 * modalShow Inserta plantilla, muestra, ejecuta acciones de acuerdo a lo programado en el dialogo modal
 * @param {event} evt evento asociado, con el que se trata de obtener el currentarget (la fuente)
 * @returns no retorna, la función llama a un formulario modal
 */
function modalGrid(evt, shadow) {

    if (typeof evt !== 'string' && evt !== null) { //Valida que sea un evento
//Busca en el evento el elemento que produjo este evento
        var elem = $(evt.currentTarget);
        //Invoker = Quien es el control invocador, se define en data-invoker
        var invoker = elem.data('invoker');
        var action = elem.data('action');
    } else if (typeof evt === 'string') {
        var invoker = evt; //Sino es un objeto 'event' simplemente es un texto.
    }

//Se invoca el modal en una petición
    var data = {prefix: invoker};
    var modalBackdrop = $('.modal-backdrop');
    modalBackdrop.on('click', function () {
        modalBackdrop.fadeOut('fast').each().remove();
        $('#modalContainerGrid').html('');
    });
    //Oculta el modal
    modalGridHide();
    var jqXHR = $.post('modal_grid', data);
    jqXHR.done(function (xhr, status, error) {

        //Se carga la plantilla del modal
        $('#modalContainerGrid').html(xhr);
        var modalDlg = $('#modal_grid');
        switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
            case 'crear_form_beneficiarios_nombre_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_beneficiarios_ciudades_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_reparto_empleados_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_recogida_empleados_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_especiales_empleados_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_ciudades_empleados_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_reparto_aprobador_listar':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_reparto_btn_beneficiarios':
                modalDlg.find('.modal-dialog').removeClass('modal-md').addClass('modal-lg'); // Tamaño del grid
                break;
            case 'crear_form_reparto_btn_viajeros':
                modalDlg.find('.modal-dialog').removeClass('modal-md ').addClass('modal-lg'); //Coloca el modal mas grande
                action = 'GET_VIAJEROS';
                /*
                 $.post('actions', {action: 'GET_VIAJEROS'}) //Obtiene el listado de viajeros
                 .done(function (xhr) {
                 modalDlg.find('.modal-body').html('<b>Viajeros frecuentes:</b><br/>' + xhr); //Escribe los viajeros en el modal
                 
                 
                 });
                 */
                $('#tabla_viajeros_frecuentes').on('click', 'tr', function () {

                    modalGridHide();

                    evt.preventDefault();
                    //$('#Crear_form_reparto_btn_beneficiarios').trigger('click');
                });
                break;
        }

        modalDlg.modal('show');
        modalDlg.on('shown.bs.modal', function () {

            //Donde se va a cargar la lista (el Body del panel)
            var elemList = $('#modal_grid').find('.modal-body');
            var fields = getFields(invoker);
            var dataArray = {action: action, fields: fields};
            grid(elemList, dataArray, invoker);
        });
        //Se delega el clic al botón de aceptación
        modalDlg.on('click', '#modal_button_accept', function () {

            //Oculta el modal en 2 segundos
            setTimeout(function () {
                modalDlg.modal('hide');
            }, 300);
            //Validación de acciones según el invoker (si hay invoker y no está aquí registrado como acción solo se usará para el lenguaje)
            switch (invoker) {
                case 'Administrar_form_empresas_taxis_ciudad_placa_taxi_listar':
                    break;
            }

            $('#modal_button_close').focus();
        });
        jqXHR.fail(function (xhr, status, error) {
            log('modalGrid_show fail:\n' + error);
        });
        jqXHR.always(function (xhr, status, error) {
            log('modalGrid_show complete\n' + error);
        });
    });
}

/**
 * Obtiene los campos de la lista según el tipo de invocador 'invoker'
 * @param {String} invoker Nombre del invocador
 * @returns {Json} Datos convertidos en formato Json
 */
function getFields(invoker) {
//Variables genéricas, en el switch del invoker se pueden personalizar otras

    var fields;
    var paises = {id: {list: false},
        nombrePais: {title: 'País'},
        estado: {list: false}};
    var dptos = {id: {list: false},
        nombrePais: {title: 'País'},
        nombreDpto: {title: 'Departamento'},
        estado: {list: false}};
    var ciudades = {id: {list: false},
        idCiudad: {list: false},
        nombreCiudad: {title: 'Ciudad'},
        idPais: {list: false},
        nombrePais: {title: 'País'},
        idDpto: {list: false},
        nombreDpto: {title: 'Departamento'},
        estado: {list: false}};
    var localidades = {id: {list: false},
        nombreLocalidad: {title: 'Localidad'},
        idCiudad: {list: false},
        nombreCiudad: {title: 'Ciudad'},
        idPais: {list: false},
        nombrePais: {nombrePais: 'Nombre país'},
        idDpto: {list: false},
        nombreDpto: {title: 'nombreDpto'},
        estado: {list: false}
    };
    var barrios = {idBarrio: {list: false},
        nombreBarrio: {title: 'Barrio'},
        idCiudad: {list: false},
        nombreCiudad: {title: 'Ciudad'},
        idLocalidad: {list: false},
        nombreLocalidad: {title: 'Localidad'},
        idPais: {list: false},
        nombrePais: {title: 'Nombre país'},
        idDpto: {list: false},
        nombreDpto: {title: 'nombreDpto'},
        estado: {list: false}
    };
    /*Módulo crear*/
    var centro_costo = {codCentro: {title: 'Código '},
        nombreCentroCosto: {title: 'Centro de costo'}
    };
    var empleados = {id: {title: 'Id'},
        primerNombre: {title: '1erNombre'},
        segundoNombre: {title: '2doNombre'},
        primerApellido: {title: '1erApe'},
        segundoApellido: {title: '2doApe'},
        codigoCentro: {title: 'Cod.Centro'},
        nombreCentro: {title: 'C.Costo', width: '300px'},
        prestamoVehiculo: {title: 'P.Vehíc.', list: false}
    };
    var beneficiarios = {id: {title: 'Id'},
        primerNombre: {title: '1erNombre'},
        segundoNombre: {title: '2doNombre'},
        primerApellido: {title: '1erApe'},
        segundoApellido: {title: '2doApe'},
        codigoCentro: {title: 'Cod.Centro'},
        nombreCentro: {title: 'C.Costo', width: '300px'}
        //prestamoVehiculo: {title: 'P.Vehíc.', list: true}
    };

    var viajeros = {idBeneficiario: {title: 'cedula', list: true},
        nombreBeneficiario: {title: 'Beneficiario', list: true},
        centroCosto: {title: 'cod.Centro', list: true},
        nombreCentroCosto: {title: 'Centro_costo', list: true},
        tipoBeneficiario: {title: 'Tipo', list: true},
        zona: {title: 'Zona', list: true},
        destino: {title: 'Destino', list: true},
        idCiudad: {title: 'Cod.Ciudad', list: true},
        nombreCiudad: {title: 'Ciudad', list: true}
    };

    var aprobadores = {id: {title: 'Id'},
        primerNombre: {title: '1erNombre'},
        segundoNombre: {title: '2doNombre'},
        primerApellido: {title: '1erApe'},
        segundoApellido: {title: '2doApe'},
        codigoCentro: {title: 'Cod.Centro'},
        nombreCentro: {title: 'C.Costo', width: '300px'}
    };
    var empresas = {id: {list: false},
        NIT: {title: 'NIT', list: true},
        razonSocial: {title: 'Nombre', list: true},
        nombreContacto: {title: 'Contacto', list: true},
        correo: {title: 'Correo', list: true},
        telefonos: {title: 'Telefono', list: true},
        direccion: {title: 'Dirección', list: true},
        observaciones: {title: 'Observaciones', list: true},
        estado: {title: 'estado', list: true},
        idCiudad: {list: false},
        nombreCiudad: {title: 'Ciudad', list: true}
    };
    var zonas_incompatibles = {Zona1: {title: 'Zona1', list: true},
        nombreZona1: {title: 'Nombre_Zona1', list: true},
        Zona2: {title: 'Zona2', list: true},
        nombreZona2: {title: 'Nombre_Zona2', list: true},
        estadoIncompatibilidad: {title: 'Estado', list: true}
    };
    var zonas = {id: {title: 'Id'},
        nombreZona: {title: 'Nombre zona', list: true},
        idCiudad: {list: false},
        nombreCiudad: {title: 'Ciudad', list: true},
        idDpto: {list: false},
        nombreDpto: {title: 'Dpto', list: true},
        idPais: {list: false},
        nombrePais: {title: 'Pais', list: true},
        valorZona: {title: 'Valor', list: true},
        observacion: {title: 'Observación', list: true},
        CalleDesde: {title: 'Cll_Desde', list: true},
        LetraCalledesde: {title: 'Letra', list: true},
        CalleHasta: {title: 'Clle_Hasta', list: true},
        LetraCalleHasta: {title: 'Letra', list: true},
        CarreraDesde: {title: 'Cra_Desde', list: true},
        LetraCraDesde: {title: 'Letra', list: true},
        CarreraHasta: {title: 'Cra_Hasta', list: true},
        LetraCraHasta: {title: 'Letra', list: true}
    };
    var solicitudes = {
        idSolicitud: {title: 'Solicitud', list: true},
        idSolicitudNoHtml: {title: 'idSolicitudNoHtml', list: false},
        totalSolicitud: {title: 'Total', list: true},
        idTipoSolicitud: {title: 'Id_Tipo', list: false},
        tipoNombre: {title: 'Tipo', list: true},
        idCreadorSolicitud: {title: 'Id_Creador', list: false},
        Creador: {title: 'Nombre_Creador', list: true},
        idCentroCostoCreador: {title: 'Centro_Costo', list: false},
        fechaCreacion: {title: 'Fecha_Creación', list: true},
        idSolicitudDetalle: {title: 'Id', list: false},
        fechaAplicaSolicitud: {title: 'Fecha_Inicia', list: true},
        horaSolicitud: {title: 'Hora', list: true},
        fechaFinalizaSolicitud: {title: 'Fecha_Finaliza', list: false},
        estadoSolicitudDetalle: {title: 'Estado', list: false},
        nombreEstado: {title: 'Estado', list: true},
        motivo: {title: 'Motivo', list: true},
        idAprobador: {title: 'Id_Aprobador', list: true},
        nombreAprobador: {title: 'Nombre_Aprobador', list: true},
        zonaSolicitud: {title: 'Zona', list: true},
        zonaNombre: {title: 'Nombre_Zona', list: true},
        idBeneficiario: {title: 'Id', list: true},
        idBeneficiarioNoHtml: {title: 'idBeneficiarioNoHtml', list: false},
        nombreBeneficiario: {title: 'Beneficiario', list: true},
        idCentroCostoAaplicar: {title: 'Centro_Costo', list: false},
        usuarioDespachador: {title: 'Despachador', list: true},
        fechaDespacho: {title: 'Fecha_Despacho', list: true}
    };
    var solicitudes_despacho_consul = {
        idSolicitud: {title: 'No.Sol', list: false},
        idSolicitudAccion: {title: 'No.Sol', list: true},
        idSolicitudNoHtml: {title: 'No.Sol', list: false},
        totalSolicitud: {title: 'Total', list: false},
        idTipoSolicitud: {title: 'Id_Tipo', list: false},
        tipoNombre: {title: 'Tipo', list: true},
        idBeneficiario: {title: 'Id', list: false},
        idBeneficiarioNoHtml: {title: 'Cédula', list: true},
        nombreBeneficiario: {title: 'Beneficiario', list: true},
        destino: {title: 'Destino', list: true},
        idTransportador: {title: 'Movil', list: true},
        idEmpresaTaxi: {title: 'IdEmpresa', list: false},
        empresaTaxi: {title: 'Empresa', list: true},
        idSolicitudDetalle: {title: 'Id', list: false},
        estadoSolicitudDetalle: {title: 'Estado', list: false},
        nombreEstado: {title: 'Estado', list: true},
        motivo: {title: 'Motivo', list: false},
        idAprobador: {title: 'Id_Aprobador', list: false},
        nombreAprobador: {title: 'Nombre_Aprobador', list: false},
        valor: {title: 'Valor', list: true},
        valorPeaje: {title: 'Peaje', list: true},
        valorRecargo: {title: 'Recargo', list: true},
        fechaAplicaSolicitud: {title: 'Fecha_Inicia', list: true},
        fechaFinalizaSolicitud: {title: 'Fecha_Finaliza', list: false},
        zonaSolicitud: {title: 'Zona', list: true},
        zonaNombre: {title: 'Nombre_Zona', list: true},
        idCentroCostoAaplicar: {title: 'CCosto', list: true},
        nombreCentroCostoAaplicar: {title: 'Centro_Costo', list: true},
        usuarioDespachador: {title: 'Despachador', list: false},
        fechaDespacho: {title: 'Fecha_Despacho', list: false},
        fechaCreacion: {title: 'Fecha_Creación', list: false},
        idCreadorSolicitud: {title: 'Id_Creador', list: false},
        Creador: {title: 'Nombre_Creador', list: true},
        idCentroCostoCreador: {title: 'Centro_Costo', list: false}
    };
    var solicitudes_despacho = {
        comboViaje: {title: 'Asignar_viaje', display: function (data) {
                return "<select class='form-control js-panel-viaje'><option value=0>No hay viajes</option></select>";
            }},
        idSolicitud: {title: 'Solicitud', list: false},
        idSolicitudNoHtml: {title: 'No.Sol', list: true},
        totalSolicitud: {title: 'Total', list: false},
        idTipoSolicitud: {title: 'Id_Tipo', list: false},
        tipoNombre: {title: 'Tipo', list: true},
        idBeneficiario: {title: 'Id', list: false},
        idBeneficiarioNoHtml: {title: 'Cédula', list: true},
        nombreBeneficiario: {title: 'Beneficiario', list: true},
        destino: {title: 'Destino', list: true},
        idSolicitudDetalle: {title: 'Id', list: false},
        estadoSolicitudDetalle: {title: 'Estado', list: false},
        nombreEstado: {title: 'Estado', list: false},
        motivo: {title: 'Motivo', list: false},
        idAprobador: {title: 'Id_Aprobador', list: false},
        nombreAprobador: {title: 'Nombre_Aprobador', list: false},
        valor: {title: 'Valor', list: true},
        valorPeaje: {title: 'Peaje', list: true},
        valorRecargo: {title: 'Recargo', list: true},
        fechaAplicaSolicitud: {title: 'Fecha_Inicia', list: true},
        fechaFinalizaSolicitud: {title: 'Fecha_Finaliza', list: false},
        zonaSolicitud: {title: 'Zona', list: true},
        zonaNombre: {title: 'Nombre_Zona', list: true},
        idCentroCostoAaplicar: {title: 'CCosto', list: true},
        nombreCentroCostoAaplicar: {title: 'Centro_Costo', list: true},
        usuarioDespachador: {title: 'Despachador', list: false},
        mismoDestino: {title: '=Destino', list: true},
        fechaDespacho: {title: 'Fecha_Despacho', list: false},
        fechaCreacion: {title: 'Fecha_Creación', list: false},
        idCreadorSolicitud: {title: 'Id_Creador', list: false},
        Creador: {title: 'Nombre_Creador', list: true},
        idCentroCostoCreador: {title: 'Centro_Costo', list: false}
    };
    var zonas_pueblo = {
        id: {title: 'Id zona', list: true},
        nombreZona: {title: 'Nombre zona', list: true},
        nombreDpto: {title: 'Departamento', list: true},
        valorZona: {title: 'Valor', list: true}
    };
    var roles = {id: {title: 'id', list: false},
        rol: {title: 'Nombre corto', list: true},
        nombreRol: {title: 'Nombre completo', list: true},
        estado: {title: 'Estado', list: true}
    };
    var users = {id: {title: 'id', list: false},
        usuario: {title: 'Usuario', list: true},
        primerApellido: {title: '1er Apellido', list: true},
        segundoApellido: {title: '2do Apellido', list: true},
        primerNombre: {title: '1er Nombre', list: true},
        segundoNombre: {title: '2do Nombre', list: true},
        codigoCentro: {title: 'Cod.Centro', list: true},
        nombreCentro: {title: 'Centro Costo', list: true}
    };
    var perfiles = {id: {title: 'id', list: false},
        perfil: {title: 'Nombre corto', list: true},
        nombrePerfil: {title: 'Nombre completo', list: true},
        estado: {title: 'Estado', list: true}
    };
    var audit = {fecha: {title: 'Fecha', list: true},
        usuario: {title: 'Usuario', list: true},
        accion: {title: 'Acción', list: true},
        tabla: {title: 'Tabla', list: true},
        campo: {title: 'Campo', list: true},
        antes: {title: 'Antes', list: true, width: '20%'},
        msg: {title: ' ', list: true},
        despues: {title: 'Después', list: true, width: '20%'}
    };
    switch (typeof invoker == 'string' ? invoker.toLowerCase() : invoker) {
        /*MODULO ADMINISTRAR*/
        case 'administrar_form_zonas_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            fields = paises;
            break;
        case 'administrar_form_zonas_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_dptos"
            fields = dptos;
            break;
        case 'administrar_form_zonas_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            fields = ciudades;
            break;
        case 'administrar_form_empresas_taxis_ciudad_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            fields = ciudades;
            break;
        case 'administrar_form_dptos_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            fields = paises;
            break;
        case 'administrar_form_ciudades_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            fields = paises;
            break;
        case 'administrar_form_ciudades_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_departamentos"
            fields = dptos;
            break;
        case 'administrar_form_localidades_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            fields = paises;
            break;
        case 'administrar_form_localidades_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_departamentos"
            fields = dptos;
            break;
        case 'administrar_form_localidades_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            fields = ciudades;
            break;
        case 'administrar_form_barrios_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            fields = paises;
            break;
        case 'administrar_form_barrios_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_departamentos"
            fields = dptos;
            break;
        case 'administrar_form_barrios_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            fields = ciudades;
            break;
        case 'administrar_form_barrios_localidades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_localidades"
            fields = localidades;
            break;
        case 'administrar_form_perfiles_btnrecargar_perfiles':
            fields = perfiles;
            break;
        case 'administrar_form_perfiles_btnrecargar_usuarios':
            fields = users;
            break;
            /*MODULO CREAR*/
        case 'crear_form_reparto_btn_viajeros':
            fields = viajeros;
            break;
        case 'crear_form_reparto_centro_costo_listar': // Tiene el orden de la vista en la base de datos "sat_vw_centro_costo"
            fields = centro_costo;
            break;
        case 'crear_form_reparto_centro_costo_listar_aprobador': // Tiene el orden de la vista en la base de datos "sat_vw_centro_costo"
            fields = centro_costo;
            break;
        case 'crear_form_reparto_centro_costo_cargar': // Tiene el orden de la vista en la base de datos "sat_vw_centro_costo"
            fields = centro_costo;
            break;
        case 'crear_form_reparto_empleados_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = empleados;
            break;
        case 'crear_form_recogida_empleados_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = empleados;
            break;
        case 'crear_form_especiales_empleados_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = empleados;
            break;
        case 'crear_form_ciudades_empleados_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = empleados;
            break;
        case 'crear_form_beneficiarios_nombre_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = beneficiarios;
            break;
        case 'crear_form_beneficiarios_centro_costo_listar':
            fields = centro_costo;
            break;
        case 'crear_form_beneficiarios_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            if (!$('#Crear_form_beneficiarios_btn_pueblos').is(':checked')) {
                fields = ciudades;
            }
            else {
                fields = zonas_pueblo;
            }
            break;
        case 'crear_form_reparto_aprobador_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_aprobadores"
            fields = aprobadores;
            break;
        case 'crear_form_recogida_aprobador_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_aprobadores"

            fields = aprobadores;
            break;
        case 'crear_form_especiales_aprobador_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_aprobadores"
            fields = aprobadores;
            break;
        case 'crear_form_ciudades_aprobador_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_aprobadores"

            fields = aprobadores;
            break;
        case 'crear_form_reparto_btn_beneficiarios': // Tiene el orden de la vista en la base de datos "sat_vw_conex_siwi_empleados"
            fields = empleados;
            break;
        case 'administrar_form_zonas_btnzonaslistado' :
            fields = zonas;
            break;
        case 'administrar_form_incompatibilidad_btnzonaslistado' :
            fields = zonas_incompatibles;
            break;
        case 'administrar_form_roles_btnroleslistado':
            fields = roles;
            break;
        case 'administrar_form_empresas_btnlistado' :
            fields = empresas;
            break;
            /*MÓDULO CONSULTAR*/
        case 'consultar_form_zonas_btnzonaslistado':
            fields = zonas;
            break;
        case 'consultar_form_solicitudes_btnsolicitudeslistado':
            fields = solicitudes;
            break;
        case 'crear_form_borradores_btnborradoreslistado':
            fields = solicitudes;
            break;
        case 'consultar_form_paises_btnpaiseslistado':
            fields = paises;
            break;
        case 'consultar_form_dptos_paises_listar':
            fields = paises;
            break;
        case 'consultar_form_dptos_btndptoslistado':
            fields = dptos;
            break;
        case 'consultar_form_ciudades_paises_listar':
            fields = paises;
            break;
        case 'consultar_form_ciudades_dptos_listar':
            fields = dptos;
            break;
        case 'consultar_form_ciudades_btnciudadeslistado':
            fields = ciudades;
            break;
        case 'consultar_form_barrios_btnbarrioslistado':
            fields = barrios;
            break;
        case 'consultar_form_barrios_paises_listar':
            fields = paises;
            break;
        case 'consultar_form_barrios_dptos_listar':
            fields = dptos;
            break;
        case 'consultar_form_barrios_ciudades_listar':
            fields = ciudades;
            break;
        case 'consultar_form_users_btnuserslistado':
            fields = users;
            break;
        case 'consultar_form_roles_btnroleslistado':
            fields = roles;
            break;
        case 'consultar_form_perfiles_btnperfileslistado':
            fields = perfiles;
            break;
        case 'consultar_form_audit_btnauditlistado':
            fields = audit;
            break;
            /*MÓDULO DESPACHAR*/
        case 'despachar_form_solicitudes_btnsolicitudeslistado':
            fields = solicitudes_despacho_consul;
            break;
        case 'despachar_form_despacho_btndespacholistado':
            fields = solicitudes_despacho;
            break;
            /*MÓDULO APROBAR*/
        case 'aprobar_form_solicitudes_btnsolicitudeslistado':
            fields = solicitudes;
            break;
    }
    return fields;
}
//<editor-fold defaultstate="collapsed" desc="FUNCIONES GENERALES">

/**
 * Exporta a excel
 * @param {String} elem
 * @returns {Window|sa}
 */
function fnExcelReport(elem) {

//getting values of current time for generating the file name
    var dt = new Date();
    var day = dt.getDate();
    var month = dt.getMonth() + 1;
    var year = dt.getFullYear();
    var hour = dt.getHours();
    var mins = dt.getMinutes();
    var postfix = year + "_" + month + "_" + day + "_" + hour + "_" + mins;
    var nombreArchivo = "Reporte" + "_" + postfix;
    modalShow(elem, '<h3>Exportar Reporte</h3>', 'Elija el formato:', 'warning', false, '', 'Excel (*.xls)', 'Word (*.doc)');
    /*
     var a = document.createElement('a');
     
     var table_data = elem.html()
     //Acentos
     .replace(/([Á])/g, "%C1")
     .replace(/([É])/g, "%C9")
     .replace(/([Í])/g, "%CD")
     .replace(/([Ó])/g, "%D3")
     .replace(/([Ú])/g, "%DA")
     .replace(/([á])/g, "%E1")
     .replace(/([é])/g, "%E9")
     .replace(/([í])/g, "%ED")
     .replace(/([ó])/g, "%F3")
     .replace(/([ú])/g, "%FA")
     .replace(/([Ñ])/g, "%D1")
     .replace(/([ñ])/g, "%F1")
     //Html
     .replace(/([\s])/gi, "%20") //Espacios
     .replace(/(<\/tr>)/gi, " %0D%0A") //Filas
     .replace(/(<\/td>)/gi, ";") //Celdas
     .replace(/(<\/th>)/gi, ";") //Encabezados
     .replace(/(<[^>]*>)/gi, ""); //HTML tags restantes (basura)
     
     table_data = btoa(unescape(encodeURIComponent(elem.html())));//PDF
     
     $(a).bind('click', function () {
     //$(this).prop({'href': "data:application/octect-stream;charset=UTF-8," + $('<div/>').html(table_data).text(), 'download': '"nombreArchivo"' + ".csv"});        
     $(this).prop({'href': "data:application/pdf;base64," + table_data, 'download': nombreArchivo + ".pdf"});
     //window.open('','_new').location.href = this.href;
     window.location.href = this.href;
     });
     
     $(a).trigger('click');
     */
}

/**
 * Serializa objetos no permitidos por la serialización de la W3 artículo de referencia: http://www.w3.org/TR/html401/interact/forms.html#h-17.13.2
 * @param {object} elem formulario o contenedor con elementos que tengan la clase js-serialize
 * @returns {String}
 */
function createObjects(elem) {
    var data = {};
    $(elem).find('.js-createobject').each(function () {
        var dataNew = {};
        dataNew[$(this).data('field')] = $(this).val();
        $.extend(data, dataNew);
    });
    return data;
}

/**
 * Serializa objetos no permitidos por la serialización de la W3 artículo de referencia: http://www.w3.org/TR/html401/interact/forms.html#h-17.13.2
 * @param {object} elem formulario o contenedor con elementos que tengan la clase js-serialize
 * @returns {String}
 */
function serializeOthers(elem) {

    var data = '';
    var joiner = '';
    elem.find('.js-serialize').each(function () {
        data += joiner + $(this).val();
        joiner = '&';
    });
    return data;
}

/**
 * Valida lo campos requeridos a grabar
 * @param {type} elem Nombre del formulario a validar
 * @returns {boolean} Retorna false si no se ha llenado un campo
 */
function validate_required(elem) {

    var _elems = elem.find(':input[required=""], :input[required]'); //Vector de elementos requeridos soportado en el atributo required

    //Validación campo por campo si es requerido y muestra el placeholder como advertencia
    var msg = '';
    var result = false;
    _elems.each(function () {

        //inicializa variables y componente
        msg = '';
        //Se programa remover clase de "error" en caso de perder el foco, con el fin de no confundir al usuario
        $(this).on('keyup', function () {
            try {
                //Coloca la clase de error al contenedor del control del formulario
                $(this).parent().removeClass('has-error');
            } catch (ex) {
                log('Error: ' + ex.message);
            }
        });
        //Se usa el placeholder para el mensaje en el diálogo de error
        msg = $(this).attr('placeholder');
        //Validación vacío
        if ($(this).val().trim() === '') {

            try {
                //Coloca la clase de error al contenedor del control del formulario
                $(this).parent().addClass('has-error');
            } catch (ex) {
                log('Error: ' + ex.message);
            }

            //Emerge diálogo modal de error
            modalShow(null, 'Error', msg, 'danger');
            result = false;
            return result;
        } else {
            //Si todo estuvo bien
            result = true;
        }
    });
    return result;
}

/**
 * Obtiene todos los posibles estados de las solicitudes
 * @returns {string} Resultado ajax
 */
function get_solicitudes_estados() {

//Obtiene estados de las solicitudes
    var data = {action: 'GET_SOLICITUD_ESTADOS', param1: 'html'};
    var jXHR = $.post('actions', data);
    jXHR.done(function (xhr) {
        log("get_solicitud_estados done");
        $('#Crear_form_borrador_sel_soli').html(xhr);
        $('#Crear_form_borrador_sel_tipo').html(xhr);
        $('#Despachar_form_despacho_sel_soli').html(xhr);
        $('#Despachar_form_solicitudes_sel_soli').html(xhr);
        $('#Aprobar_form_aprobar_sel_soli').html(xhr);
        $('#Aprobar_form_solicitudes_sel_soli').html(xhr);
    });
    jXHR.fail(function (xhr) {
        log("get_solicitud_estados FAIL " + xhr);
    });
}

/**
 * Obtiene todos los posibles tipos de las solicitudes
 * @returns {string} Resultado ajax
 */
function get_solicitudes_tipos() {
//Obtiene tipos de solicitudes
    var data = {action: 'GET_SOLICITUD_TIPOS', param1: 'html'};
    var jXHR = $.post('actions', data);
    jXHR.done(function (xhr) {
        log("get_solicitud_tipos start");
        $('#Crear_form_borradores_sel_tipo').html(xhr);
        $('#Crear_form_reparto_sel_tipo').html(xhr);
        $('#Despachar_form_despacho_sel_estado').html(xhr);
        $('#Despachar_form_solicitudes_sel_estado').html(xhr);
        $('#Aprobar_form_aprobar_sel_estado').html(xhr);
        $('#Aprobar_form_solicitudes_sel_estado').html(xhr);
        log("get_solicitud_tipos success");
    });
    jXHR.fail(function (xhr) {
        log("get_solicitud_tipos FAIL " + xhr);
    });
}


/**
 * Remueve el formato de moneda al texto
 * @param {String} texto Texto a formatear
 * @returns {String} retorna el texto sin formato
 */
function removeCurrency(texto) {
    return $(texto).replace('$', '').replace('.', '').replace(',', '');
}

/**
 * Control de formato de moneda
 * @param {type} elem El objeto afectado
 * @param {type} grabando Si está grabando o no
 * @returns {null} No retorna nada
 */
function currencyControls(elem, grabando) {

    if (grabando) {
        var elem = $(elem);
        elem.find('.js-currency').each(function () {
            $(this).val($(this).val().replace('$', ''))
            $(this).val($(this).val().replace('.', ''))
            $(this).val($(this).val().replace(',', ''))
        });
    } else {
//Retira el formato de moneda
        $('.js-currency').on('focusin change mousein', function () {
            $(this).val($(this).val().replace('$', ''));
            $(this).val($(this).val().replace('.', ''));
            $(this).val($(this).val().replace(',', ''));
        });
        //Retira el formato de moneda
        $('.js-currency').on('focusout', function () {
            $(this).val('$' + parseFloat($(this).val() || 0).toLocaleString());
        });
    }
}

/**
 * Valida si es fecha
 * @param {type} val
 * @returns {Boolean}
 */
function isDate(val) {
    var d = new Date(val);
    return !isNaN(d.valueOf());
}

/**
 * Rellenar con patrón a la izquierda
 * @param {type} pattern patrón ejemplo '00'
 * @param {type} cant
 * @param {type} val texto afectado
 * @returns {String}
 */
function lPad(pattern, cant, val) {
    return (pattern + '' + val).slice(cant * -1);
}

/**
 *  Rellenar con patrón a la derecha
 * @param {type} pattern patrón ejemplo '00'
 * @param {type} cant
 * @param {type} val texto afectado
 * @returns {String}
 */
function rPad(pattern, cant, val) {
    return (pattern + '' + val).slice(cant);
}

/**
 * Retorna una fecha tipo 201510011420 es decir 2015-10-01 2:20 pm
 * @param {type} _date fecha ejemplo:  2015-10-01 2:20 pm
 * @returns {String|dInLine}
 */
function dateInLine(_date) {

    var d = new Date(_date);
    dInLine = d.getFullYear() + lPad('00', 2, d.getMonth() + 1) + lPad('00', 2, d.getDate()) + lPad('00', 2, d.getHours()) + lPad('00', 2, d.getMinutes());
    return  dInLine;
}

function capitalize(palabra) {
    palabra = palabra.toLowerCase();
    return palabra.charAt(0).toUpperCase() + palabra.slice(1);
}

function accordion() {

    $('.accordion > li').children('ol').slideUp();
    $('.accordion > li').on('click', function (e) {
        $('.accordion > li').children('ol').slideUp();
        $(this).children('ol').slideToggle();
        e.preventDefault();
    });
}


/**
 * Retorna html codificado Ej.: As&iacute;
 * @param {type} html Datos en html
 * @returns {string} Retorna html codificado Ej.: Así
 */
function decodeHTML(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

// </editor-fold>
// 
// <editor-fold defaultstate="collapsed" desc="JTABLE Grid">
/**
 * Carga los datos de un ajax
 * @param {Object} elem Elemento donde se cargarán los datos
 * @param {Array} data Información para el post y el JTtable
 * @param {type} target Quien recibe el la información despues del Callback
 * @returns {Boolean}
 */
function grid(elem, data, target) {
//window.data = [{name: 'action', value: data.action}]; //Array de la acción
    window.data = data;
    var fieldsData = data.fields; //Array de los campos de la lista   

    try {
        var valDepend;
        var t;
        if (target.toLowerCase() != 'crear_form_beneficiarios_ciudades_listar') {
            t = $('#' + target)
            valDepend = filtrarDepend(t);
        } else {
            if (!$('#Crear_form_beneficiarios_btn_pueblos').is(':checked')) {
                t = $('#' + target)
                valDepend = filtrarDepend(t);
            } else {
                valDepend = {tipo_zona: 'PUE'};
            }
        }
    } catch (e) {
        valDepend = null;
    }

    if (valDepend != null) {
        $.extend(window.data, valDepend); //Agregar data extra
    }

    var jsonData = {
        animationsEnabled: true,
        dialogShowEffect: 'fade',
        dialogHideEffect: 'fade',
        loadingAnimationDelay: 500,
        selecting: true, //Enable selecting
        multiselect: false, //Allow multiple selecting
        actions: {
            listAction: function () {
                return $.Deferred(function ($dfd) {
                    $.post('actions', window.data, function () {
                    }, 'json')
                            .done(function (xhr) {
                                log('grid success');
                                elem.addClass('modal_grid-body'); // Tamaño del cuadro de lista de registro
                                elem.find('.jtable').addClass('show-cursor-hand'); //Coloca el cursor pointer (mano)                                
                                buscarModalGrid(); // Activa la búsqueda
                                $dfd.resolve(xhr);
                                if (elem.attr('id') === 'Despachar_form_despacho_listado') { //Para los paneles de despacho
                                    updateComboPaneles();
                                    colorearCompatibilidad();
                                }
                            })
                            .fail(function (xhr, status, error) {
                                log('grid fail:\n' + error);
                                $dfd.reject();
                            })
                            .always(function (xhr, status, error) {
                                log('grid complete\n' + error);
                            });
                });
            }
        },
        fields: fieldsData,
        selectionChanged: function () {
            //Get all selected rows

            var $selectedRows = elem.jtable('selectedRows');
            var records = {"records": []};
            if ($selectedRows.length > 0) {
                var record = '';
                //Buscar los registros seleccionados
                $selectedRows.each(function () {
                    record = $(this).data('record');
                    records.records.push(record); //Lo añade al JSON  ej.: records.records[0].estado
                });
                if (data.action.toUpperCase() == "GET_VIAJEROS") {

                    var id_bene = records.records[0].idBeneficiario;
                    var nombre_bene = records.records[0].nombreBeneficiario;
                    var ccosto = records.records[0].centroCosto;
                    var ncosto = records.records[0].nombreCentroCosto;
                    var tipo_bene = records.records[0].tipoBeneficiario;
                    var id_zona = records.records[0].zona;
                    var destino = records.records[0].destino;
                    var id_ciudad = records.records[0].idCiudad;
                    var nombre_ciudad = records.records[0].nombreCiudad;

                    var dataArray = {'%_id': id_bene, '%_nombre': nombre_bene, '%_tipoBene': tipo_bene, '%_ccosto': ccosto, '%_ccosto_nombre': ncosto, '%_zona': id_zona, '%_ciudad_id': id_ciudad, '%_dir': destino, '%_ciudad_nombre': nombre_ciudad};
                    modalGridHide();
                    modalShow('Crear_form_reparto_btn_beneficiarios', 'Viajero frecuente', '', 'success', true, dataArray, '', '', true);
                } else {
                    fillTarget(target, records); //Llena el elemento que lo ha invocado
                }
            }
            modalGridHide();
        }
    };
    elem.addClass('border').addClass('border-solid').addClass('border-lgray').addClass('border-radius-min');
    elem.jtable(jsonData);
    elem.jtable('reload');
    /*
     var vehiculo = false;
     try {
     vehiculo = fieldsData.hasOwnProperty('prestamoVehiculo');
     } catch (e) {
     
     }
     
     if (vehiculo) {
     elem.jtable('load', {prestamoVehiculo: "NO"});
     } else {
     */
}

function colorearCompatibilidad() {
    var jXHR = $.post('actions', {action: 'GET_ZONAS_INCOMPATIBLES'});

    jXHR.done(function (xhr) {
        var result = JSON.parse(xhr);
        var id_zona;
        var lastZona = '';
        var tabla = $('#Despachar_form_despacho_listado table');
        var fila = $(tabla).find('tr');

        $.each(fila, function (i, v) {
            if (i > 0) {
                id_zona = $(v).children().eq(9).text();
                if (id_zona != lastZona) {
                    if (buscarIncompatibilidad(id_zona, lastZona, result.Records)) {
                        tabla.find('tr').eq(i).children().eq(9).css('background', 'rgba(0,255,0,0.1)');
                    } else {
                        tabla.find('tr').eq(i).children().eq(9).css('background', 'rgba(255,0,0,0.1)');
                    }
                }

                if (lastZona == '') {
                    lastZona = id_zona;
                    tabla.find('tr').eq(i).children().eq(9).css('background', 'rgba(0,255,0,0.1)');
                } else {
                    if (lastZona == id_zona) {
                        tabla.find('tr').eq(i).children().eq(9).css('background', 'rgba(0,255,0,0.1)');
                    }
                }
            }
        });
    });
}

function buscarIncompatibilidad(zona1, zona2, records) {
    $.each(records, function (i, v) {
        if ((v.Zona1 == zona1 && v.Zona2 == zona2)) {
            return true;
        }
    });
    return false;
}

function filtrarDepend(elem) {
    if (elem != null) {
        try {
            var depend = elem.data('depend');
        } catch (e) {

        }
        try {
            var action = elem.data('action');
        } catch (e) {

        }
        var val;
        switch (action) {
            case 'GET_APROBADORES':
                val = $('#' + depend).val();
                if ((val == '') || (val == null)) {
                    val = -1; //Cuando es (-1) menos uno, devuelve todos los registros
                }
                return {'id_bene': val};
                break;
            case 'GET_DPTOS' :
                val = $('#' + depend).val();
                if ((val == '') || (val == null)) {
                    val = -1; //Cuando es (-1) menos uno, devuelve todos los registros
                }
                return {'id_pais': val};
                break;
            case 'GET_CIUDADES' :
                val = $('#' + depend).val();
                if ((val == '') || (val == null)) {
                    val = -1; //Cuando es (-1) menos uno, devuelve todos los registros
                }
                return {'id_dpto': val};
                break;
            case 'GET_LOCALIDADES' || 'GET_BARRIOS' :
                val = $('#' + depend).val();
                if ((val == '') || (val == null)) {
                    val = -1; //Cuando es (-1) menos uno, devuelve todos los registros
                }
                return {'id_ciudad': val};
                break;
            case 'GET_CENTRO_COSTO':
                val = $('#' + depend).val();
                if ((val == '') || (val == null)) {
                    val = -1; //Cuando es (-1) menos uno, devuelve todos los registros
                }
                return {'id': val};
                break;
        }
    }
    return null;
}


/**
 * Obtiene presupuesto (comprometido, etc.)
 * @param {type} centro_costo
 * @returns {null}
 */
function presupuesto() {

    $('#Aprobar_form_aprobar_presupuesto_div label span').html(waitProgress_min("<i class='fa fa-money fa-spin'></i>"));
    var jXHR = $.post('actions', {action: 'GET_PRESUPUESTO', year: new Date().getFullYear(), mes: new Date().getMonth() + 1});
    jXHR.done(function (xhr) {

        log('presupuesto success');
        $('#Aprobar_form_aprobar_presupuesto_div label span').html('');
        var jsonData = JSON.parse(xhr);
        var pres = parseFloat(jsonData.presupuesto || 0).toLocaleString();
        var real = parseFloat(jsonData.acumulado || 0).toLocaleString() || 0;
        var comprometido = parseFloat(jsonData.comprometido || 0).toLocaleString() || 0;
        var dispo = parseFloat(jsonData.disponible || 0).toLocaleString() || 0;
        $('#Aprobar_form_aprobar_presupuesto').val('$ ' + pres);
        $('#Aprobar_form_aprobar_real').val('$ ' + real);
        $('#Aprobar_form_aprobar_comprometido').val('$ ' + comprometido);
        $('#Aprobar_form_aprobar_disponible').val('$ ' + dispo);
        $('#Aprobar_form_aprobar_disponible_valor').val(parseFloat(jsonData.disponible || 0));
    });
    jXHR.fail(function (xhr) {
        log('presupuesto fail');
        $('#Aprobar_form_aprobar_presupuesto_div label span').html('');
    });

    $('#Aprobar_form_aprobar_listado').on('click', 'input:checkbox', function (e) {

        var valorAaprobar = 0;
        var valor = 0;

        $('#Aprobar_form_aprobar_listado input:checked').each(function () {

            valor = $(this).parent().parent().parent().parent().children().eq(10).find('input:hidden').val();

            valorAaprobar += parseFloat(valor || 0);
        });
        $('#Aprobar_form_aprobar_valor_a_aprobar').val('$' + valorAaprobar.toLocaleString());
        $('#Aprobar_form_aprobar_valor_a_aprobar_hidden').val(parseFloat(valorAaprobar || 0));

        //Valida disponible
        var disponible = parseFloat($('#Aprobar_form_aprobar_valor_a_aprobar_hidden').val() || 0);
        valorAaprobar = parseFloat($('#Aprobar_form_aprobar_disponible_valor').val() || 0);

        var disponibleActual = valorAaprobar - disponible;

        if (disponibleActual < 6000) {//podría decirce que la mínima
            $('#Aprobar_form_aprobar_disponible_eval').text('Dispo. tentativo excedido en $ ' + disponibleActual.toLocaleString()).css('color', 'red');
        } else if (disponibleActual == 6000) {
            $('#Aprobar_form_aprobar_disponible_eval').text('Dispo. tentativo = $ ' + disponibleActual.toLocaleString()).css('color', 'orange');
        } else if (disponibleActual > 6000) {
            $('#Aprobar_form_aprobar_disponible_eval').text('Dispo. tentativo = $ ' + disponibleActual.toLocaleString()).css('color', 'green');
        }
    });
}

/**
 * Llena al target con información del json
 * @param {object} target elemento
 * @param {json} json
 * @returns {Boolean}
 */
function fillTarget(target, json) {
    var jsonData = json;
    var elem = $('#' + target + '_nombre'); //Contendrá el nombre
    var elemId = $('#' + target + '_id'); //Contendrá el id

    switch (target.toLowerCase()) {
// <editor-fold defaultstate="collapsed" desc="Módulo Administrar">
        case 'administrar_form_zonas_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_zonas_dptos_listar':
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_zonas_ciudades_listar':
            elem.val(jsonData.records[0].nombreCiudad);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_empresas_taxis_ciudad_listar':
            //$('#' + target + '_2').html(jsonData.records[0].nombreCiudad); //Personalizado la ciudad que se dibuja en la placa del carro en el formulario Taxis
            $('#Administrar_form_empresas_taxis_ciudad_listar_nombre').val(jsonData.records[0].nombreCiudad);
            $('#Administrar_form_empresas_taxis_ciudad_listar_id').val(jsonData.records[0].id);
            break;
        case 'administrar_form_dptos_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_ciudades_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_ciudades_dptos_listar':
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_localidades_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_localidades_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_departamentos"
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_localidades_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            elem.val(jsonData.records[0].nombreCiudad);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_barrios_paises_listar': // Tiene el orden de la vista en la base de datos "sat_vw_paises"
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_barrios_dptos_listar': // Tiene el orden de la vista en la base de datos "sat_vw_departamentos"
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_barrios_ciudades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_ciudades"
            elem.val(jsonData.records[0].nombreCiudad);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_barrios_localidades_listar': // Tiene el orden de la vista en la base de datos "sat_vw_localidades"
            elem.val(jsonData.records[0].nombreLocalidad);
            elemId.val(jsonData.records[0].id);
            break;
        case 'administrar_form_zonas':
            resetForm(target);
            $('#Administrar_form_zonas_paises_listar_nombre').val(decodeHTML(jsonData.records[0].nombrePais));
            $('#Administrar_form_zonas_paises_listar_id').val(decodeHTML(jsonData.records[0].idPais));
            $('#Administrar_form_zonas_dptos_listar_nombre').val(decodeHTML(jsonData.records[0].nombreDpto));
            $('#Administrar_form_zonas_dptos_listar_id').val(decodeHTML(jsonData.records[0].idDpto));
            $('#Administrar_form_zonas_ciudades_listar_nombre').val(jsonData.records[0].nombreCiudad === null ? 'NO CIUDAD' : decodeHTML(jsonData.records[0].nombreCiudad));
            $('#Administrar_form_zonas_ciudades_listar_id').val(decodeHTML(jsonData.records[0].idCiudad));
            $('#Administrar_form_zonas_estado').val(decodeHTML(jsonData.records[0].estado));
            $('#Administrar_form_zonas_codigo_zona').val(decodeHTML(jsonData.records[0].id));
            $('#Administrar_form_zonas_nombre_zona').val(decodeHTML(jsonData.records[0].nombreZona));
            $('#Administrar_form_zonas_obs_zona').val(decodeHTML(jsonData.records[0].observacion));
            $('#Administrar_form_zonas_calle_desde').val(decodeHTML(jsonData.records[0].CalleDesde));
            $('#Administrar_form_zonas_calle_hasta').val(decodeHTML(jsonData.records[0].CalleHasta));
            $('#Administrar_form_zonas_calle_hasta_letra').val(decodeHTML(jsonData.records[0].LetraCalleHasta));
            $('#Administrar_form_zonas_calle_desde_letra').val(decodeHTML(jsonData.records[0].LetraCalleDesde));
            $('#Administrar_form_zonas_cra_desde').val(decodeHTML(jsonData.records[0].CarreraDesde));
            $('#Administrar_form_zonas_cra_hasta').val(decodeHTML(jsonData.records[0].CarreraHasta));
            $('#Administrar_form_zonas_cra_hasta_letra').val(decodeHTML(jsonData.records[0].LetraCraHasta));
            $('#Administrar_form_zonas_cra_desde_letra').val(decodeHTML(jsonData.records[0].LetraCraDesde));
            $('#Administrar_form_zonas_tarifa_zona').val('$' + parseFloat(decodeHTML(jsonData.records[0].valorZona || 0)).toLocaleString());
            break;
        case 'administrar_form_empresas_listado':
            resetForm('Administrar_form_empresas_taxis');
            $('#Administrar_form_empresas_taxis_id').val(decodeHTML(jsonData.records[0].NIT));
            $('#Administrar_form_empresas_taxis_nombre').val(decodeHTML(jsonData.records[0].razonSocial));
            $('#Administrar_form_empresas_taxis_tel').val(decodeHTML(jsonData.records[0].telefonos));
            $('#Administrar_form_empresas_taxis_estado').val(decodeHTML(jsonData.records[0].estado.substring(0, 1)));
            $('#Administrar_form_empresas_taxis_dir').val(decodeHTML(jsonData.records[0].direccion));
            $('#Administrar_form_empresas_taxis_email').val(decodeHTML(jsonData.records[0].correo));
            $('#Administrar_form_empresas_taxis_obs').val(decodeHTML(jsonData.records[0].observaciones));
            $('#Administrar_form_empresas_taxis_contacto').val(decodeHTML(jsonData.records[0].nombreContacto));
            $('#Administrar_form_empresas_taxis_ciudad_listar_nombre').val(decodeHTML(jsonData.records[0].nombreCiudad));
            $('#Administrar_form_empresas_taxis_ciudad_listar_id').val(decodeHTML(jsonData.records[0].idCiudad));
            break;
// </editor-fold> 
//           
// <editor-fold defaultstate="collapsed" desc="Módulo Crear">
        case 'crear_form_reparto_centro_costo_listar': // Tiene el orden de la vista en la base de datos "sat_vw_conex__kiwi_centros_costo"
            elem.val(jsonData.records[0].nombreCentroCosto);
            elemId.val(jsonData.records[0].codCentro);
            break;
        case 'crear_form_reparto_centro_costo_listar_aprobador': // Tiene el orden de la vista en la base de datos "sat_vw_conex__kiwi_centros_costo"
            elem.val(jsonData.records[0].nombreCentroCosto);
            elemId.val(jsonData.records[0].codCentro);
            break;
        case 'crear_form_reparto_centro_costo_cargar': // Tiene el orden de la vista en la base de datos "sat_vw_conex__kiwi_centros_costo"
            elem.val(jsonData.records[0].nombreCentroCosto);
            elemId.val(jsonData.records[0].codCentro);
            break;
        case 'crear_form_reparto_empleados_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_reparto_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_reparto_centro_costo_listar_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_recogida_empleados_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_recogida_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_recogida_centro_costo_listar_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_especiales_empleados_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_especiales_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_especiales_centro_costo_listar_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_ciudades_empleados_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_ciudades_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_ciudades_centro_costo_listar_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_reparto_aprobador_listar' :
            //Llenar Centro de Costo
            //var elemCcostoId = $('#Crear_form_reparto_centro_costo_listar_aprobador_id');
            //var elemCcostoNombre = $('#Crear_form_reparto_centro_costo_listar_aprobador_nombre');
            var elemCorreo = $('#Crear_form_reparto_aprobador_listar_correo');
            //elemCcostoId.val(jsonData.records[0].codigoCentro);
            //elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar aprobador
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id).change();
            //$('#Crear_form_reparto_centro_costo_listar_aprobador_id').change();
            elemCorreo.val(jsonData.records[0].correo); //Correo que se enviará al aprobador
            break;
        case 'crear_form_recogida_aprobador_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_recogida_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_recogida_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar aprobador
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_especiales_aprobador_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_especiales_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_especiales_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar aprobador
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_ciudades_aprobador_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_ciudades_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_ciudades_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar aprobador
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_beneficiarios_nombre_listar':
            //Llenar Centro de Costo
            var aPesarDePrestamoVehi = true;
            var elemCcostoId = $('#Crear_form_beneficiarios_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_beneficiarios_centro_costo_listar_nombre');
            if (jsonData.records[0].prestamoVehiculo == 'SI') {
                aPesarDePrestamoVehi = confirm("Este beneficiario " + jsonData.records[0].primerNombre + ' ' + jsonData.records[0].primerApellido + " posee prestamo para vehículo.\n¿Desea escogerlo?");
            }

            if (aPesarDePrestamoVehi) {
                elemCcostoId.val(jsonData.records[0].codigoCentro);
                elemCcostoNombre.val(jsonData.records[0].nombreCentro);
                //Llenar empleado
                elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
                elemId.val(jsonData.records[0].id);
                elem.removeClass('border-dotted').removeClass('border-red').css('color', 'black').css('font-weight', 'normal');
            }
            break;
        case 'crear_form_beneficiarios_centro_costo_listar':
            var elemCcostoId = $('#Crear_form_beneficiarios_centro_costo_listar_id');
            var elemCcostoNombre = $('#Crear_form_beneficiarios_centro_costo_listar_nombre');
            elemCcostoId.val(jsonData.records[0].codCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentroCosto);
            break;
        case 'crear_form_beneficiarios_ciudades_listar':

            if (!$('#Crear_form_beneficiarios_btn_pueblos').is(':checked')) {
                elem.val(jsonData.records[0].nombreCiudad);
                elemId.val(jsonData.records[0].id);
            } else {
                elem.val(jsonData.records[0].nombreZona);
                elemId.val(jsonData.records[0].id);
                $('#Crear_form_beneficiarios_direccion').val(jsonData.records[0].nombreZona);
                //Tabla de zonas
                //var adic = jsonData.records[0].valorAdic;
                //adic == undefined ? adic = 0 : adic = adic;
                $('#Crear_form_beneficiarios_zonas_dir').html("<tbody class='rwd-table small table-responsive table-bordered'>" +
                        "<tr ><th >&nbsp;</th><th >ID</th><th >Nombre</th><th >Valor</th><th >Rango</th></tr>" +
                        "<tr id='" + jsonData.records[0].id + "' class='show-cursor-hand-active'>" +
                        "<td data-th='Seleccionar'><label><input type='radio' checked='checked' value=" + jsonData.records[0].id + " name='_id_zona' id='id_zona'></label></td>" +
                        "<td data-th='ID'>" + jsonData.records[0].id + "</td>" +
                        "<td id='_nombre_zona' data-th='Nombre'>" + jsonData.records[0].nombreZona + "</td>" +
                        "<td id='_valor_zona' data-th='Valor'>" + jsonData.records[0].valorZona + "</td>" +
                        //"<td id='_valor_adic' data-th='Adic.'>" + adic + "</td>" +
                        "<td data-th='Rango'>" + jsonData.records[0].nombreZona + "</td>" +
                        "</tr></tbody>");
            }
            break;
        case 'crear_form_reparto_aprobador_listar' :
            //Llenar Centro de Costo
            //var elemCcostoId = $('#Crear_form_reparto_centro_costo_listar_aprobador_id');
            //var elemCcostoNombre = $('#Crear_form_reparto_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            //$('#Crear_form_reparto_centro_costo_listar_aprobador_id').change();
            break;
        case 'crear_form_recogida_aprobador_listar' :

            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_recogida_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_recogida_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_especiales_aprobador_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_especiales_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_especiales_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_ciudades_aprobador_listar' :
            //Llenar Centro de Costo
            var elemCcostoId = $('#Crear_form_ciudades_centro_costo_listar_aprobador_id');
            var elemCcostoNombre = $('#Crear_form_ciudades_centro_costo_listar_aprobador_nombre');
            elemCcostoId.val(jsonData.records[0].codigoCentro);
            elemCcostoNombre.val(jsonData.records[0].nombreCentro);
            //Llenar empleado
            elem.val(jsonData.records[0].primerNombre + ' ' + jsonData.records[0].segundoNombre + ' ' + jsonData.records[0].primerApellido + ' ' + jsonData.records[0].segundoApellido);
            elemId.val(jsonData.records[0].id);
            break;
        case 'crear_form_reparto_btn_beneficiarios':
            var data = [{name: 'action', value: 'GET_BENEFICIARIO'}];
            var vars = [{name: '_cedula', value: jsonData.records[0].id},
                {name: '_nombre', value: (jsonData.records[0].primerNombre + ' ' +
                            jsonData.records[0].segundoNombre + ' ' +
                            jsonData.records[0].primerApellido + ' ' +
                            jsonData.records[0].segundoApellido)},
                {name: '_cod_costo', value: jsonData.records[0].codigoCentro},
                {name: '_nom_ccosto', value: jsonData.records[0].nombreCentro}];
            $.each(vars, function (i, val) {
                data.push(vars[i]);
            });
            $('#Crear_form_reparto_btn_beneficiarios_wait').html(waitProgress());
            var jXHR = $.post('actions', data);
            jXHR.done(function (xhr) {
                log('Beneficiarios x success');
                $('#Crear_form_reparto_btn_beneficiarios_wait').html('');
                $('#Crear_form_reparto_beneficiarios_lista').append(xhr);
            });
            jXHR.fail(function (xhr) {
                log('Beneficiarios fail ' + xhr);
            });
            jXHR.always(function (xhr) {

            });
            break;
// </editor-fold> 
//            
// <editor-fold defaultstate="collapsed" desc="Módulo Consultar">
        case 'consultar_form_dptos_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'consultar_form_ciudades_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'consultar_form_ciudades_dptos_listar':
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'consultar_form_barrios_paises_listar':
            elem.val(jsonData.records[0].nombrePais);
            elemId.val(jsonData.records[0].id);
            break;
        case 'consultar_form_barrios_dptos_listar':
            elem.val(jsonData.records[0].nombreDpto);
            elemId.val(jsonData.records[0].id);
            break;
        case 'consultar_form_barrios_ciudades_listar':
            elem.val(jsonData.records[0].nombreCiudad);
            elemId.val(jsonData.records[0].id);
            break;
// </editor-fold> 

    }
    return false;
}

/**
 * Reiniciar el formulario y borrar la remover has-error
 * @param {type} form El formulario a reiniciar
 * @returns {Boolean}
 */
function resetForm(form) {
    document.getElementById(form).reset();
    removeHasError(form);
    return false;
}

/**
 * Borra la clase has-error
 * @param {type} form Formulario que contiene los elementos a eliminarle la clase has-error
 * @returns {bool} */
function removeHasError(form) {
    $('#' + form).find('.has-error').each(function () {
        $(this).removeClass('has-error');
    });
    return false;
}

/** 
 * Busqueda en la grilla modal emergente
 */
function buscarModalGrid() {

    $("#searchGridInput").focus();
    //Evitar sensibilidad a mayúsculas.
    $.extend($.expr[":"], {
        "containsIN": function (elem, i, match, array) {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });
    $("#searchGridInput").keyup(function () {
//split the current value of searchInput
        var data;
        data = this.value; //Busqueda exacta        
        //data = this.value.split(" ");  //Busqueda relativa
        //create a jquery object of the rows
        var jo = $(this).parents().find("tbody").find("tr.jtable-data-row");
        if (this.value == "") {
            jo.show();
            return;
        }
        //hide all the rows
        jo.hide();
        //Recusively filter the jquery object to get results.
        jo.filter(function (i, v) {
            var $t = $(this);
            //for (var d = 0; d < data.length; ++d) {
            if ($t.is(":containsIN('" + data + "')")) {
                return true;
            }
            // }
            return false;
        })
                //show the rows that match.
                .show();
    }).focus(function () {
        this.value = "";
        $(this).css({
            "color": "black"
        });
        $(this).unbind('focus');
    }).css({
        "color": "red"
    });
}
// </editor-fold>


