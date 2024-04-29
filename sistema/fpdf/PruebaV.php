<?php
session_start();
if(empty($_SESSION['active']))
{
   header('location: ../');
}
require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      // $consulta_info = $conexion->query(" SELECT * FROM empleados ");//traemos datos de la empresa desde BD
      // $dato_info = $consulta_info->fetch_object();
 
      include "../../conexion.php";
      if(empty($_REQUEST['codemp']) || empty($_REQUEST['a']))
	{
		echo "No es posible generar la factura."; 

   }else{
   $codEmple = $_REQUEST['codemp'];
   $noasig = $_REQUEST['a'];


   

	$asignacion = mysqli_query($conexion, "SELECT * FROM asignacion WHERE noasig = $noasig");
	$result_venta = $asignacion->fetch_object();

   $consulta = mysqli_query($conexion, "SELECT * FROM empleados WHERE id_empleado =  $codEmple");
   $dato_info = $consulta->fetch_object();



   
}

      //creamos una celda o fila
      $this->SetXY(160, 10);
        $this->SetFont('arial', '', 8);
        $this->Cell(0, 5, utf8_decode('Codigo:  F-MTO- 056'), 0, 1, 'R');
        $this->Cell(0, 1, utf8_decode('Vigencia: 02/06/2020'), 0, 1, 'R');
        $this->Cell(0, 5, utf8_decode('Version: 1'), 0, 1, 'R');

        $this->Cell(66);
    
        $this->Image('logo.png', 10, 10, 20);
        $this->addFont('anton.php', '', "anton.php");
        $this->SetFont('anton.php', '', 16);
        $this->SetTextColor(42, 47, 134);
        $this->Cell(10, 10, utf8_decode('FORMATO ACTA DE ASIGNACION'), 0, 1, 0, '', 0);
        

        $this->Cell(55);
        $this->SetTextColor(42, 47, 134);
        $this->addFont('anton.php', '', "anton.php");
        $this->SetFont('anton.php', '', 16);
        $this->SetTextColor(42, 47, 134);
        $this->Cell(0, 0, utf8_decode("DE ELEMENTOS DE PROTECCION PERSONAL"), 0, 0, 0, '', 0);
        $this->Ln(25);

      $this->Cell(1);
      $this->SetTextColor(0, 0, 0);
      $this->SetFont('Arial', '', 11);
      $this->Cell(96, 10, utf8_decode("Acta N°:$result_venta->noasig  "), 0, 0, '', 0);
      $this->Ln(5);

      /* NOMBRE */
      $this->Cell(1);
      $this->SetTextColor(0, 0, 0);
      $this->SetFont('Arial', '', 11);
      $this->Cell(96, 11, utf8_decode("Nombre: $dato_info->nombres "), 0, 0, '', 0);
      $this->Ln(5);

      /* Proceso */
      $this->Cell(1);
      $this->SetTextColor(0, 0, 0);
      $this->SetFont('Arial', '', 11);
      $this->Cell(96, 11, utf8_decode("Proceso: $dato_info->proceso "), 0, 0, '', 0);
    

      $this->SetXY(120, 57); // Establecer la posición para "Fecha:"
      $this->SetFont('Arial', '', 11);
      $this->Cell(15, 6, "Fecha: $result_venta->fecha  ");
      $this->SetXY(128, 48);  


      $this->SetXY(120, 63); // Establecer la posición para "Fecha:"
      $this->SetFont('Arial', '', 11);
      $this->Cell(15, 6, "Apellidos: $dato_info->apellidos");
      $this->SetXY(128, 48); 
      $this->Ln(5);


      $this->SetXY(120, 68); // Establecer la posición para "Fecha:"
      $this->SetFont('Arial', '', 11);
      $this->Cell(15, 6, "Correo: $dato_info->correo");
      $this->SetXY(128, 48); 
      $this->Ln(35);

      $this->SetFont('Arial', '', 11);
      $this->SetTextColor(0, 0, 0);
      $this->SetFont('Arial', '', 11);
      $this->MultiCell(0, 5, utf8_decode('En el presente documento se certifica que se han entregado los elementos de proteccion personal en las cantidades descritas, para mi cuidado y custodia con el propósito de cumplir con las tareas y asignaciones propias de mi cargo en la compañía. 
'), 0);
      $this->Ln(15);
      
      
   

      // /* TITULO DE LA TABLA */
      // //color
      // $this->SetTextColor(228, 100, 0);
      // $this->Cell(50); // mover a la derecha
      // $this->SetFont('Arial', 'B', 15);
      // $this->Cell(100, 11, utf8_decode("REPORTE DE HABITACIONES "), 0, 1, 'C', 0);
      // $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(42, 47, 134); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(25, 10, utf8_decode('ID'), 1, 0, 'C', 1);
      // $this->Cell(20, 10, utf8_decode('CANTIDAD'), 1, 0, 'C', 1);
      // $this->Cell(30, 10, utf8_decode('TIPO'), 1, 0, 'C', 1);
      // $this->Cell(25, 10, utf8_decode('PRECIO'), 1, 0, 'C', 1);
      $this->Cell(95, 10, utf8_decode('DESCRIPCION'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('CANTIDAD'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('TALLA'), 1, 1, 'C', 1);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      // $hoy = date('d/m/Y');
      // $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 11);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;

/* TABLA */

include "../../conexion.php";
$codEmple = $_REQUEST['codemp'];
$noasig = $_REQUEST['a'];
$productos = mysqli_query($conexion, "SELECT d.noasig, d.codproducto, d.cantidad, p.codproducto, p.descripcion, p.talla FROM detalleasig d INNER JOIN producto p ON d.noasig = $noasig WHERE d.codproducto = p.codproducto");


while ($row = mysqli_fetch_assoc($productos)){
   $pdf->Cell(25, 8, utf8_decode($row['codproducto']), 1, 0, 'C', 0);
   $pdf->Cell(95, 8, utf8_decode($row['descripcion']), 1, 0, 'C', 0);
   $pdf->Cell(35,8, utf8_decode($row['cantidad']), 1, 0, 'C', 0);
   $pdf->Cell(35, 8, utf8_decode($row['talla']), 1, 1, 'C', 0);
   }



$codigo_producto = 25  ;
$desproducto = 95;
$cantproducto = 35;
$tallaproducto = 35;


$x = 10;
$y = 123;



// Iterar para mostrar 12 campos fijos
for ($i = 0; $i < 12; $i++) {
    // Dibujar rectángulos para cada columna
    $pdf->Rect($x, $y, $codigo_producto, 8);
    $pdf->Rect($x + $codigo_producto, $y, $desproducto, 8);
    $pdf->Rect($x + $codigo_producto + $desproducto, $y, $cantproducto, 8);
    $pdf->Rect($x + $codigo_producto + $desproducto + $cantproducto, $y, $tallaproducto, 8);

    // Colocar texto dentro de los rectángulos (vacíos por ahora)
    $pdf->SetXY($x, $y);
    $pdf->MultiCell($codigo_producto, 8, '', 0, 'C');
    $pdf->SetXY($x + $codigo_producto, $y);
    $pdf->MultiCell($desproducto, 8, '', 0, 'C');
    $pdf->SetXY($x + $codigo_producto + $desproducto, $y);
    $pdf->MultiCell($cantproducto, 8, '', 0, 'C');
    $pdf->SetXY($x + $codigo_producto + $desproducto + $cantproducto, $y);
    $pdf->MultiCell($tallaproducto, 8, '', 0, 'L');

    $y += 8;
}
$y = 109;


$consulta = mysqli_query($conexion, "SELECT * FROM empleados WHERE id_empleado =  $codEmple");
$dato_info = $consulta->fetch_object();


$pdf->SetFont('Arial', '', 10);

$pdf->SetXY(15, 240); // Ajusta los valores de X e Y para la primera firma
$pdf->Cell(15, 9, 'Firma quien recibe', 0, 1);
$pdf->Line(15, 240, 70, 240); // Dibuja una línea más larga con 8 cm de espacio debajo de la primera firma

$pdf->SetXY(15, 249); // Ajusta los valores de X e Y para el nombre después de la primera firma
$pdf->Cell(85, 0, utf8_decode("Nombre: $dato_info->nombres"), 0, 0, '', 0); // Agrega el nombre después de la primera firma
$pdf->SetXY(41, 249); // Ajusta los valores de X e Y para el nombre después de la primera firma
$pdf->Cell(85, 0, utf8_decode("$dato_info->apellidos"), 0, 0, '', 0); // Agrega el nombre después de la primera firma
$pdf->SetXY(15, 253); // Ajusta los valores de X e Y para la cédula después de la primera firma
$pdf->Cell(85, 0, utf8_decode("Cedula:$dato_info->cedula"), 0, 0, '', 0); // Agrega la cédula después de la primera firma

$pdf->SetXY(115, 240); // Ajusta los valores de X e Y para la segunda firma
$pdf->Cell(15, 9, 'Firma quien entrega', 0, 1);
$pdf->Line(115, 240, 170, 240); // Dibuja una línea más larga con 8 cm de espacio debajo de la segunda firma

$pdf->SetXY(115, 249); // Ajusta los valores de X e Y para el nombre después de la segunda firma
$pdf->Cell(85, 0, utf8_decode("Nombre: " . $_SESSION['nombre']), 0, 0, '', 0);


// $pdf->Cell(85, 0, utf8_decode("Nombre: "), 0, 0, '', 0); // Agrega el nombre completo después de la segunda firma
$pdf->SetXY(115, 253); // Ajusta los valores de X e Y para la cédula después de la segunda firma
$pdf->Cell(85, 0, utf8_decode("Usuario: " . $_SESSION['user']), 0, 0, '', 0);
$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
