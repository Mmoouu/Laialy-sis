
function stockLaialy(id_insumo) { 
    var parametros = {"id_insumo":id_insumo};
    $.ajax({
        data: parametros,            
        url: 'componentes/stock_laialy.php',
        type: 'POST',
        success: function(data) {
            document.getElementById("col1").innerHTML = data;
            $('.id_insumo_'+parametros.id_insumo).addClass("active");         
        }
    });                   
} 

function stockDetalle(id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo) { 
    var parametros = {"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo};
    if($('.id_insumo_'+parametros.id_insumo).hasClass("active") ){
        document.getElementById("col2").innerHTML = "<div id='columna_2_stock'><div style='width:100%; heigh:20%; display:block; margin:40% 0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>Seleccione un Insumo</p></div></div>";
        document.getElementById("col3").innerHTML = '';
        $('.id_insumo_'+parametros.id_insumo).removeClass("active");
    } else {
        $.ajax({
            data: parametros,            
            url: 'componentes/stock_detalle.php',
            type: 'POST',
            beforeSend: function (response) { 
                loadingOnColumna();
                selectLi(parametros.id_insumo);                                 
            }, 
            success: function(data) {    
                document.getElementById("col3").innerHTML = '';                    
                document.getElementById("col2").innerHTML = data;
            },
            complete: function(response) {
                setTimeout(function() { loadingOffColumna(); },1000);
            }
        }); 
    }                 
} 

function stockGuardar(accion,id_stock,id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo,valor_stock,stock_stock,valor,stock,aclaracion) { 
    var parametros = {"accion":accion,"id_stock":id_stock,"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo,"valor_stock":valor_stock,"stock_stock":stock_stock,"valor":valor,"stock":stock,"aclaracion":aclaracion}; 
    // if con parametros de stock en 0 y devolucion de mensaje
    if(parametros.accion == "resta" && parametros.stock > parametros.stock_stock){
        stockMensajeForm('No puede ingresar un valor menor a su cantidad de stock','0');
    } else if(parametros.stock == 0){
        stockMensajeForm('Ingrese un Stock valido','0');
    } else if(parametros.valor == 0){
        stockMensajeForm('Ingrese un valor valido','0');
    } else if(parametros.aclaracion == "Ninguno"){
        stockMensajeForm('Complete el campo de aclaracion, con el motivo del cambio','0');
    } else {
        $.ajax({
            data: parametros,            
            url: 'api/stock_guardar.php',
            type: 'POST',
            beforeSend: function (data) { 
                loadingOnColumna();                                
            },
            success: function(data) {
                document.getElementById("col3").innerHTML = '';                         
            },
            complete: function(data) {
                $('.id_insumo_'+parametros.id_insumo).removeClass("active");
    
                if(parametros.accion == "suma"){
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = (Number(parametros.stock_insumo)) + (Number(parametros.stock));
                } else if(parametros.accion == "resta"){
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = (Number(parametros.stock_insumo)) - (Number(parametros.stock));
                } else if (parametros.accion == "valor"){
                    //revisar
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = parametros.stock_insumo;    
                }
    
                new Promise(function(resolve) {
                    resolve(stockDetalle(parametros.id_insumo,parametros.cod,parametros.insumo,parametros.proveedor,parametros.medida,nuevo_valor_insumo,nuevo_stock_insumo));
                }).then(function(data) {
                   stockLaialy(parametros.id_insumo);     
                });
    
                setTimeout(function() { loadingOffColumna(); },1000);                                 
            }
        }); 
    }                                
} 

function stockMovimientos(accion,id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo,valor,stock,adjunto) { 
    var parametros = {"accion":accion,"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo,"valor":valor,"stock":stock,"adjunto":adjunto}; 
    // if con parametros de stock en 0 y devolucion de mensaje
    if (parametros.valor == 0){
        stockMensajeForm('Ingrese un Valor valido','0');
    } else if(parametros.stock == 0){
        stockMensajeForm('Ingrese un Stock valido','0');
    } else {
        $.ajax({
            data: parametros,            
            url: 'api/stock_movimientos.php',
            type: 'POST',
            beforeSend: function (data) { 
                loadingOnColumna();                                
            },
            success: function(data) {
                document.getElementById("col3").innerHTML = '';                         
            },
            complete: function(data) {
                $('.id_insumo_'+parametros.id_insumo).removeClass("active");
    
                if(parametros.accion == "suma"){
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = (Number(parametros.stock_insumo)) + (Number(parametros.stock));
                } else if(parametros.accion == "resta"){
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = (Number(parametros.stock_insumo)) - (Number(parametros.stock));
                } else if (parametros.accion == "valor"){
                    //revisar
                    var nuevo_valor_insumo = parametros.valor;
                    var nuevo_stock_insumo = parametros.stock_insumo;    
                }
    
                new Promise(function(resolve) {
                    resolve(stockDetalle(parametros.id_insumo,parametros.cod,parametros.insumo,parametros.proveedor,parametros.medida,nuevo_valor_insumo,nuevo_stock_insumo));
                }).then(function(data) {
                   stockLaialy(parametros.id_insumo);     
                });
    
                setTimeout(function() { loadingOffColumna(); },1000);                                 
            }
        }); 
    }                                
} 

function stockEdit(accion,id_stock,id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo,valor_stock,stock_stock) { 
    var parametros = {"accion":accion,"id_stock":id_stock,"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo,"valor_stock":valor_stock,"stock_stock":stock_stock};   
    $.ajax({
        data: parametros,            
        url: 'componentes/stock_'+parametros.accion+'.php',
        type: 'POST', 
        beforeSend: function (response) { 
            loadingOnColumna();                        
        },                 
        success: function(data) {                        
            document.getElementById("col3").innerHTML = data;
        },
        complete: function(response) {
            setTimeout(function() { loadingOffColumna(); },1000);
        }                
    });             
}

function stockIngreso(id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo) { 
    var parametros = {"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo};
    $.ajax({
        data: parametros,            
        url: 'componentes/stock_ingreso.php',
        type: 'POST', 
        beforeSend: function (response) { 
            loadingOnColumna();                        
        },                 
        success: function(data) {                        
            document.getElementById("col3").innerHTML = data;
        },
        complete: function(response) {
            setTimeout(function() { loadingOffColumna(); },1000);
        }                
    });             
}

function stockEgreso(id_insumo,cod,insumo,proveedor,medida,valor_insumo,stock_insumo) { 
    var parametros = {"id_insumo":id_insumo,"cod":cod,"insumo":insumo,"proveedor":proveedor,"medida":medida,"valor_insumo":valor_insumo,"stock_insumo":stock_insumo};
    $.ajax({
        data: parametros,            
        url: 'componentes/stock_egreso.php',
        type: 'POST', 
        beforeSend: function (response) { 
            loadingOnColumna();                        
        },                 
        success: function(data) {                        
            document.getElementById("col3").innerHTML = data;
        },
        complete: function(response) {
            setTimeout(function() { loadingOffColumna(); },1000);
        }                
    });             
}

function stockMensajeForm(mensaje,estado) {  
    if(estado == 1){
        $('#stock_mensaje_form').attr("style","border: 1px solid rgb(109, 151, 104);");
    }  else {
        $('#stock_mensaje_form').attr("style","border: 1px solid rgb(199, 94, 99);");
    }      
    document.getElementById("stock_mensaje_form").innerHTML = mensaje;    
    $('#stock_mensaje_form').fadeIn(1000);                    
    setTimeout(function() { 
        $('#stock_mensaje_form').fadeOut(1000);
    },5000);    
}

function cerrarCol2() { 
    loadingOnColumna();
    $('.li_stock_ver').removeClass("active");
    document.getElementById("col2").innerHTML = "<div id='columna_2_stock'><div style='width:100%; heigh:20%; display:block; margin:40% 0px;'><p style='font-family:thin; color:#aaaaaa; text-align:center; font-size:3em;'>Seleccione un Insumo</p></div></div>";                      
    setTimeout(function() { loadingOffColumna(); },1000);
}

function cerrarCol3() { 
    loadingOnColumna();
    document.getElementById("col3").innerHTML = '';           
    setTimeout(function() { loadingOffColumna(); },1000);
}

function selectLi(id) { 
    $('.li_stock_ver').removeClass("active");            
    $('.id_insumo_'+id).addClass("active");            
}

function loadingOnColumna() { 
    $(".loading_pop_up_columna").fadeIn(0);
}

function loadingOffColumna() { 
    $(".loading_pop_up_columna").fadeOut(700);
}