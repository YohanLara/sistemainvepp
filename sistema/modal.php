
<?php
include("../conexion.php");
session_start();
//print_r($_POST);
//-------------------------------------------BUSCAR INFO DEL PRODUCTO----------------------------------------------
if (!empty($_POST)) {
  // Extraer datos del producto
  if ($_POST['action'] == 'infoProducto') {
      $data = "";
    $producto_id = $_POST['productos'];
  
    $query = mysqli_query($conexion, "SELECT codproducto, descripcion, cantidad, talla FROM producto WHERE codproducto = $producto_id");

    $result = mysqli_num_rows($query);
    if ($result > 0) {
      $data = mysqli_fetch_assoc($query);
      echo json_encode($data,JSON_UNESCAPED_UNICODE);
      exit;
    }else {
      $data = 0;
    }
  }
  
// Eliminar Producto
  if ($_POST['action'] == 'infoproducto') {
    if (empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])) {
      echo "error";
    }
    //  else {

  //   $idproducto = $_REQUEST['producto_id'];
  //   $query_delete = mysqli_query($conexion, "UPDATE producto SET estado = 0 WHERE codproducto = $idproducto");
  //   mysqli_close($conexion);

  // }
 echo "error";
 exit;
}
}

//-------------------------------------------CAMBIAR CONTRASEÑA----------------------------------------------
    if ($_POST['action'] == 'changePasword') {
      if (!empty($_POST['passActual']) && !empty($_POST['passNuevo'])) {
        $password = md5($_POST['passActual']);
        $newPass = md5($_POST['passNuevo']);
        $idUser = $_SESSION['idUser'];
        $code = '';
        $msg = '';
        $arrayData = array();
        $query_user = mysqli_query($conexion, "SELECT * FROM usuario WHERE clave = '$password' AND idusuario = $idUser");
        $result = mysqli_num_rows($query_user);
        if ($result > 0) {
          $query_update = mysqli_query($conexion, "UPDATE usuario SET clave = '$newPass' where idusuario = $idUser");
          mysqli_close($conexion);
          if ($query_update) {
            $code = '00';
            $msg = "Su contraseña se ha actualizado con exito";
            header("Refresh:1; URL=salir.php");
          }else {
            $code = '2';
            $msg = "No es posible actualizar su contraseña";
          }
        }else {
          $code = '1';
          $msg = "La contraseña actual es incorrecta";
        }
        $arrayData = array('cod' => $code, 'msg' => $msg);
        echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
      }else {
        echo "error";
      }
      exit;
      }

//---------------------------------------- REGISTRAR EMPLEADO = ASIGNACIONES-----------------------------------------
if ($_POST['action'] == 'addEmpleado') {
  $cedula = $_POST['cedula_empleado'];
  $nombres = $_POST['nom_empleado'];
  $apellidos = $_POST['ape_empleado'];
  $proceso = $_POST['pro_empleado'];
  $correo = $_POST['cor_empleado'];
  $usuario_id = $_SESSION['idUser'];

  $query_insert = mysqli_query($conexion, "INSERT INTO empleados (cedula, nombres, apellidos, proceso, correo, usuario_id) VALUES ('$cedula','$nombres','$apellidos','$proceso', '$correo','$usuario_id')");
  if ($query_insert) {
    $codEmp = mysqli_insert_id($conexion);
    $msg = $codEmp;
  }else {
    $msg = 'error';
  }
  mysqli_close($conexion);
  echo $msg;
  exit;
} 

//---------------------------------------------BUSCAR EMPLEADO-----------------------------------------------
if ($_POST['action'] == 'searchEmpleado') {
  if (!empty($_POST['empleados'])) {
    $cedula = $_POST['empleados'];

    $query = mysqli_query($conexion, "SELECT * FROM empleados WHERE cedula LIKE '$cedula'");
    mysqli_close($conexion);
    $result = mysqli_num_rows($query);
    $data = '';
    if ($result > 0) {
      $data = mysqli_fetch_assoc($query);
    }else {
      $data = 0;
    }
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
  }
  exit;
}

//----------------------------------AGREGAR PRODUCTO A DETALLE TEMPORAL----------------------------------------
//agregar producto a detalle temporal
if ($_POST['action'] == 'addProductoDetalle') {
  if (empty($_POST['producto']) || empty($_POST['cantidad'])){
      echo 'error';
  } else {
      $codproducto = $_POST['producto'];
      $cantidad = $_POST['cantidad'];
      $token = md5($_SESSION['idUser']);

      }
      // Llamar al procedimiento almacenado con los parámetros correspondientes
      $query_detalle_temp = mysqli_query($conexion, "CALL add_detalle_temp($codproducto, $cantidad, '$token')");
      // Verificar si se ejecutó correctamente la consulta
      if (!$query_detalle_temp) {
          echo 'error';
      } else {
          $detalleTabla = '';

          while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
              $detalleTabla .= '<tr>
                  <td >' . $data['codproducto'] . '</td>
                  <td colspan="1">' . $data['descripcion'] . '</td>
                  <td class="textcenter">' . $data['talla'] . '</td>
                  <td class="textcenter">' . $data['cantidad'] . '</td>
             
                 
          
                  <td>
                      <a href="#" class="btn btn-danger" onclick="event.preventDefault(); del_product_detalle(' . $data['correlativo'] . ');"><i class="fas fa-trash-alt"></i> Eliminar</a>
                  </td>
              </tr>';
          }
          // Crear un array con los datos del detalle para enviar como respuesta JSON
          $arrayData['detalle'] = $detalleTabla;
          // Enviar respuesta JSON con los datos del detalle
          echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
      }

// -------------------------------------------ELIMINAR DETALLE------------------------------------------------
if ($_POST['action'] == 'delProductoDetalle') {
  if (empty($_POST['id_detalle'])){ //si viene vacio devuelve error
    print_r($_POST);exit;
    echo 'error';
  
  }else {
    $id_detalle = $_POST['id_detalle'];
    $token = md5($_SESSION['idUser']);

    $query_detalle_tmp = mysqli_query($conexion, "CALL del_detalle_temp($id_detalle,'$token')");
    $result = mysqli_num_rows($query_detalle_tmp);

    $detalleTabla = '';
    
      
    while ($data = mysqli_fetch_assoc($query_detalle_tmp)) {
        $detalleTabla .= '<tr>
            <td>'.$data['codproducto'].'</td>
            <td colspan="1">'.$data['descripcion'].'</td>
            // <td class="textcenter">' . $data['talla'] . '</td>
            <td class="textcenter">'.$data['cantidad'].'</td>
            <td>
                <a href="#" class="btn btn-danger" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');">Eliminar</a>
            </td>
        </tr>';
      }
      // Crear un array con los datos del detalle para enviar como respuesta JSON
      $arrayData['detalle'] = $detalleTabla;
      // Enviar respuesta JSON con los datos del detalle
      echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    }
  
  }

  //------------------------------------------GENERARA ASIGNACION---------------------------------------------
  if ($_POST['action'] == 'procesarAsig') {
    if (empty($_POST['codemp'])) {
      $codemp = 1;
    }else{
      $codemp = $_POST['codemp'];

      $token = md5($_SESSION['idUser']);
      $usuario = $_SESSION['idUser'];
      $query = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE token_user = '$token' ");
      $result = mysqli_num_rows($query);
    }
  
    if ($result > 0) {
      $query_procesar = mysqli_query($conexion, "CALL procesar_asignacion($usuario,$codemp,'$token')");
      $result_detalle = mysqli_num_rows($query_procesar);
      if ($result_detalle > 0)
       {
        $data = mysqli_fetch_assoc($query_procesar);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
      }else {
        echo "error";
      }
    }else {
      echo "error";
    }
    mysqli_close($conexion);
    exit;
  }






















///////////////////////////////////////////LO PIDIO KAREN//////////////////////////////////////////////////

// // Verificar si se recibió una solicitud AJAX para obtener los productos
// if (isset($_POST['action']) && $_POST['action'] === 'getProductos') {
//     // Realizar la consulta para obtener los productos
//     $query = mysqli_query($conexion, "SELECT codproducto, descripcion FROM producto");

//     // Verificar si se encontraron productos
//     if (mysqli_num_rows($query) > 0) {
//         $productos = array();
//         // Iterar sobre los resultados y agregarlos al array de productos
//         while ($row = mysqli_fetch_assoc($query)) {
//             $productos[] = $row;
//         }
//         // Devolver los productos como datos JSON
//         echo json_encode($productos);
//     } else {
//         // Si no se encontraron productos, devolver un array vacío
//         echo json_encode(array());
//     }
//     // Cerrar la conexión a la base de datos
//     mysqli_close($conexion);
// }

// // Verificar si se recibió una solicitud AJAX para obtener la información de un producto específico
// if (isset($_POST['action']) && $_POST['action'] === 'infoProducto' && isset($_POST['producto'])) {
//     // Obtener el ID del producto enviado desde el cliente
//     $producto_id = $_POST['producto'];

//     // Realizar la consulta para obtener la información del producto
//     $query = mysqli_query($conexion, "SELECT codproducto, descripcion, cantidad, talla FROM producto WHERE codproducto = $producto_id");

//     // Verificar si se encontró el producto
//     if (mysqli_num_rows($query) > 0) {
//         // Obtener los datos del producto
//         $producto = mysqli_fetch_assoc($query);
//         // Devolver los datos del producto como datos JSON
//         echo json_encode($producto);
//     } else {
//         // Si el producto no se encuentra, devolver un objeto vacío como datos JSON
//         echo json_encode(array());
//     }
//     // Cerrar la conexión a la base de datos
//     mysqli_close($conexion);
// }

//---------------------------------------------ANULAR ASIG--------------------------------------------------

if ($_POST['action'] == 'anularAsig') {
    $data = "";
  $token = md5($_SESSION['idUser']);
  $query_del = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE token_user = '$token'");
  mysqli_close($conexion);
  if ($query_del) {
    echo 'ok';
  }else {
    $data = 0;
  }
  exit;
}
?>














