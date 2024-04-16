
//-----------------------------------ACTIVA CAMPOS PARA REGISTRAR EMPLEADO------------------------------------

  $('.btn_new_empleado').click(function(e) {
      e.preventDefault();
      // Habilitar los campos
      $('#cedula_empleado').removeAttr('disabled');
      $('#nom_empleado').removeAttr('disabled');
      $('#ape_empleado').removeAttr('disabled');
      $('#pro_empleado').removeAttr('disabled');
      $('#cor_empleado').removeAttr('disabled');
      // Ocultar el botón "Nuevo Empleado"

      // Mostrar el botón "Guardar"
      $('#div_registro_empleado').slideDown();
  });

//------------------------------------- CREAR EMPLEADO = ASIG-------------------------------------------------
$('#form_new_empleado_asig').submit(function(e) {
  e.preventDefault();
  $.ajax({
    url: 'modal.php',
    type: "POST",
    async: true,
    data: $('#form_new_empleado_asig').serialize(),
    success: function(response) {
      if (response  != 0) {
        // Agregar id a input hidden
        $('#id_empleado').val(response);
        //bloque campos
        $('#cedula_empleado').attr('disabled','disabled');
        $('#nom_empleado').attr('disabled','disabled');
        $('#ape_empleado').attr('disabled','disabled');
        $('#pro_empleado').attr('disabled','disabled');
        $('#cor_empleado').attr('disabled','disabled');
        // ocultar boton Agregar
        $('.btn_new_empleado').slideUp();
        //ocultar boton Guardar
        $('#div_registro_empleado').slideDown();
      }
    },
    error: function(error) {
    }
  });
});

// ------------------------------------------BUSCAR EMPLEADO POR CEDULA---------------------------------------
$('#cedula_empleado').keyup(function(e) {
  e.preventDefault();
  var em = $(this).val();
  var action = 'searchEmpleado';
  $.ajax({
    url: 'modal.php',
    type: "POST",
    async: true,
    data: {action:action,empleados:em},
    success: function(response) {
      //SI LA RESPUESTA DEVUELVE 0 LOS CAMPOS QUEDAN EN BLANCO Y PERMITIRA MOSTRAR EL BOTON PARA AGREGAR UN NUEVO EMPLEADO
      if (response == 0) {
        $('#id_empleado').val('');
        $('#nom_empleado').val('');
        $('#ape_empleado').val('');
        $('#pro_empleado').val('');
        $('#cor_empleado').val('');
        // mostar boton agregar
        $('.btn_new_empleado').slideDown();
      }else {
        //
        var data = $.parseJSON(response);
        $('#id_empleado').val(data.id_empleado);
        $('#nom_empleado').val(data.nombres);
        $('#ape_empleado').val(data.apellidos);
        $('#pro_empleado').val(data.proceso);
        $('#cor_empleado').val(data.correo);
        // ocultar boton Agregar
        $('.btn_new_empleado').slideUp();

        // BLOQUEA LOS SIGUIENTES CAMPOS 
        $('#nom_cliente').attr('disabled','disabled');
        $('#ape_empleado').attr('disabled','disabled');
        $('#pro_empleado').attr('disabled','disabled');
        $('#cor_empleado').attr('disabled','disabled');
        // ocultar boto Guardar
        $('#div_registro_empleado').slideUp();
      }
    },
    error: function(error) {

    }
  });

});
// -----------------------------ALERTAS DE ELIMINAR DE TODOS LOS MODULOS OK?------------------------------------
$(".confirmar").submit(function(e) {
  e.preventDefault();
  Swal.fire({
    title: 'Esta seguro de eliminar?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'SI, Eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {
      this.submit();
    }
  })
});
// ------------------------------------------BUSCAR PRODUCTO = ASIGNACION-------------------------------------

$('#txt_cod_producto').keyup(function(e) {
  e.preventDefault();
  var productos = $(this).val();
  if (productos == "") {
    $('#txt_descripcion').html('-');
    $('#txt_cantidad').html('-');
    $('#txt_cant_producto').val('0');

    //Bloquear Cantidad
    $('#txt_cant_producto').attr('disabled', 'disabled');
    // Ocultar Boto Agregar
    $('#add_product_asig').slideUp();
  }
  var action = 'infoProducto';
  if (productos != '') {
  $.ajax({
    url: 'modal.php',
    type: "POST",
    async: true,
    data: {action:action,productos:productos},
    success: function(response){
      if(response == 0) {
        $('#txt_descripcion').html('-');
        $('#txt_talla').html('-');
        $('#txt_cantidad').html('-');
        $('#txt_cant_producto').val('0');
   

        //Bloquear Cantidad
        $('#txt_cant_producto').attr('disabled','disabled');
        // Ocultar Boto Agregar
        $('#add_product_asig').slideUp();


      }else{

        var info = JSON.parse(response);
        $('#txt_descripcion').html(info.descripcion);
        $('#txt_talla').html(info.talla);
        $('#txt_cantidad').html(info.cantidad);
        $('#txt_cant_producto').val('');

        // Activar Cantidad
        $('#txt_cant_producto').removeAttr('disabled');
        // Mostar boton Agregar
        $('#add_product_asig').slideDown();

      }
    },
    error: function(error) {
    }
  });
  $('#txt_descripcion').html('-');
  $('#txt_talla').html('-');  
  $('#txt_cantidad').html('-');
  $('#txt_cant_producto').val('0');


  //Bloquear Cantidad
  $('#txt_cant_producto').attr('disabled','disabled');
  // Ocultar Boto Agregar
  $('#add_product_asig').slideUp();

  }
});
// -----------------------------------------AGREGAR PRODUCTO AL DETALLE ---------------------------------------

//Agregar producto al detalle_asig
$('#add_product_asig').click(function(e) {
  e.preventDefault();
  if ($('#txt_cant_producto').val() > 0) {
    var codproducto = $('#txt_cod_producto').val();
    var cantidad = $('#txt_cant_producto').val();
    var action = 'addProductoDetalle';
    $.ajax({
      url: 'modal.php',
      type: 'POST',
      async: true,
      data: {action:action,producto:codproducto,cantidad:cantidad},

      success: function(response)
      {
        if (response !== 'error') 
        {
           var info = JSON.parse(response);
           $('#detalle_asig').html(info.detalle);
           


           $('#txt_cod_producto').val('');
           $('#txt_descripcion').html('-');
           $('#txt_talla').html('-');
           $('#txt_cantidad').html('-');
           $('#txt_cant_producto').val('0');

           //bloquear cantidad
           $('#txt_cant_producto').attr('disabled','disabled');


           //ocultar boton agregar 
           $('#add_product_asig').slideUp();

        }else
        console.log ('no encontro ningun dato');
          
        viewProcesar();
      },
      error: function(error){

      }
    });
  }
});
// ---------------------NOS PERMITE AGREGAR MAS CANTIDAD DE LA QUE HAY ACTUALMENTE-----------------------------
$('#txt_cant_producto').keyup(function(e) {
  e.preventDefault();

  var cantidad = parseInt($('#txt_cantidad').html());

  // Ocultat el boton Agregar si la cantidad es menor que 1
  if (($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > cantidad)){
    $('#add_product_asig').slideUp();
  }else {
    $('#add_product_asig').slideDown();
  }
});

// ------------------------------------------ANULAR ASIG----------------------------------------------------
$('#btn_anular_asig').click(function(e) {
  e.preventDefault();
  var rows = $('#detalle_asig tr').length;
  if (rows > 0) {
    var action = 'anularAsig';
    $.ajax({
      url: 'modal.php',
      type: 'POST',
      async: true,
      data: {action:action},
      success: function(response) {
        if (response != 0) {
          location.reload();
        }
      },
      error: function(error) {

      }
    });
  }
});
// -------------------------------ABRE VENTANA MODAL DE LISTA DE PRODUCTOS------------------------------------
function openIndexPage() {
  // Abre la página index en una ventana pequeña, se puede ajustar el tamaño segun sus necesidades
  window.open('lista_productos.php', 'IndexPage', 'width=600,height=500,scrollbars=yes');
  }
  // ---------------------------ABRE VENTANA MODAL DE LISTA DE EMPLEADOS--------------------------------------
  function openIndexPag() {
    // Abre la página index en una ventana pequeña, se puede ajustar el tamaño segun sus necesidades
    window.open('lista_empleado.php', 'IndexPage', 'width=600,height=500,scrollbars=yes');
    }

  // ---------------------------ABRE VENTANA MODAL DE LISTA DE Productos DE LA TABLA DETALLE DE ENTRADA--------------------------------------
  function openIndexPag3() {
    // Abre la página index en una ventana pequeña, se puede ajustar el tamaño segun sus necesidades
    window.open('lista_productos.php', 'IndexPage', 'width=600,height=500,scrollbars=yes');
    }
    
  
// *-----------------------------------------ELIMINAR DETALLES DE ASIGNACION------------------------------------------------
    
function del_product_detalle(correlativo) {
  var action = 'delProductoDetalle';
  var id_detalle = correlativo;
  $.ajax({  
    url: 'modal.php',
    type: "POST",
    async: true,
    data: {action:action,id_detalle:id_detalle},
    success: function(response) {
        if (response != 0) {
          
        var info = JSON.parse(response);

        $('#detalle_asig').html(info.detalle);
           

        $('#txt_cod_producto').val('');
        $('#txt_descripcion').html('-');
        $('#txt_talla').html('-');
        $('#txt_cantidad').html('-');
        $('#txt_cant_producto').val('0');

        // Bloquear cantidad
        $('#txt_cant_producto').attr('disabled','disabled');

        // Ocultar boton agregar
        $('#add_product_asig').slideUp();
        
      }else {
        $('#detalle_asig').html('');
     
      }

      viewProcesar();
 
    },
    error: function(error) {
      
    }
  });
}

// mostrar/ ocultar boton Procesar
function viewProcesar() {
  if ($('#detalle_asig tr').length > 0){
    $('#btn_asig').show();
    $('#btn_anular_asig').show();
  }else {
    $('#btn_asig').hide();
    $('#btn_anular_asig').hide();
  }
}
// --------------------------------------------REALIZAR ASIGNACION------------------------------------------------
$('#btn_asig').click(function(e) {
  e.preventDefault();

  var rows = $('#detalle_asig tr').length;
  if (rows > 0) 
  {

    var action = 'procesarAsig';
    var codemp = $('#id_empleado').val();

    $.ajax({
      url: 'modal.php',
      type: 'POST',
      async: true,
      data: {action:action,codemp:codemp},
      success: function(response)
      {
        if (response != 'error')
        {
          var info = JSON.parse(response);
          console.log(info);

          generarPDF(info.codemple,info.noasig);
          location.reload();

        }else{
          console.log('No hay datos');
        } 
      //  console.log(response);
      },
      error: function(error) {

      }
    });
  }
});

//---------------------------------------------- GENERA EL PDF-----------------------------------------
function generarPDF(cliente,asignacion) {
  url = 'fpdf/pruebav.php?codemp='+cliente+'&a='+asignacion;
  window.open(url, '_blank');
}
$('.view_asig').click(function(e) {
  e.preventDefault();

  var codEmple = $(this).attr('codemp');
  var noasig = $(this).attr('a');

  generarPDF(codEmple,noasig);
});

// ------------------------------------------CAMBIAR CONTRASEÑA----------------------------------------------
// Cambiar contraseña
$('.newPass').keyup(function() {
  validaPass();
});

// cambiar contraseña
$('#frmChangePass').submit(function(e){
  e.preventDefault();
  var passActual = $('#actual').val();
  var passNuevo = $('#nueva').val();
  var passconfir = $('#confirmar').val();
  var action = "changePasword";
  if (passNuevo != passconfir) {
    $('.alertChangePass').html('<p style="color:red;">Las contraseñas no Coinciden</p>');
    $('.alertChangePass').slideDown();
    return false;
    }
  if (passNuevo.length < 5) {
  $('.alertChangePass').html('<p style="color:orangered;">Las contraseñas deben contener como mínimo 5 caracteres');
  $('.alertChangePass').slideDown();
  return false;
  }
  $.ajax({
    url: 'modal.php',
    type: 'POST',
    async: true,
    data: {action:action,passActual:passActual,passNuevo:passNuevo},
    success: function(response) {
      if (response != 'error') {
        var info = JSON.parse(response);
        if (info.cod == '00') {
          $('.alertChangePass').html('<p style="color:green;">'+info.msg+'</p>');
          $('#frmChangePass')[0].reset();
        }else {
          $('.alertChangePass').html('<p style="color:green;">'+info.msg+'</p>');
        }
        $('.alertChangePass').slideDown();
      }
    },
    error: function(error) {
    }
  });
});


// ALERTAS DE INICIO DE SESION

