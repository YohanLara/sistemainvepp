<?php include_once "includes/header.php"; 
// echo md5($_SESSION['idUser']);
?>
          <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h4 class="text-center">Datos del Empleado</h4>
                                <a href="#" class="btn btn-primary btn_new_empleado"><i class="fas fa-user-plus"></i> Nuevo Empleado</a>
                                <button class="btn btn-success" type="button" onclick="openIndexPag()">Ventana Empleados</button>
                            </div>
                            <div class="card">  
                                <div class="card-body">
                                    <form action="enviar.php" method="post" name="form_new_empleado_asig" id="form_new_empleado_asig">

                                        <input type="hidden" name="action" value="addEmpleado">
                                        <input type="hidden" id="id_empleado" value="1" name="id_empleado" required>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Cedula</label>
                                                    <input type="number" name="cedula_empleado" id="cedula_empleado" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nombres</label>
                                                    <input type="text" name="nom_empleado" id="nom_empleado" class="form-control" disabled required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Apellidos</label>
                                                    <input type="text" name="ape_empleado" id="ape_empleado" class="form-control" disabled required>
                                                </div>
                                            </div>
                                          
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Proceso</label>
                                                    <input type="text" name="pro_empleado" id="pro_empleado" class="form-control" disabled required>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Correo</label>
                                                    <input type="email" name="cor_empleado" id="cor_empleado" class="form-control" disabled required>
                                                    
                                                </div>
                                            </div>


                                           
                                            </div>
                                            <div id="div_registro_empleado" style="display: none;">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div> 
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">   
                                    </div>
                                </div>
                                <div class="col-lg 6">
                                    <label>Acciones</label>
                                    <div id="acciones_asig" class="form-group">
                                        <a href="#" class="btn btn-danger" id="btn_anular_asig">Anular</a>
                                        <a href="#" class="btn btn-primary" id="btn_asig" style="display: none;"> <i class="fas fa-save"></i> Generar Asignacion</a>
                                        <button class="btn btn-success" type="button" onclick="openIndexPage()">Ventana Productos</button>


                                    </div>
                                </div>
                            </div>
                              <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="100px">Cód. Producto</th>
                                            <th>Descripción</th>
                                            <th>Talla</th>
                                            <th>Stock</th>
                                            <th width="100px">Cantidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                        <tr>
                                            <td><input type="number" name="txt_cod_producto" id="txt_cod_producto"></td>
                                            <td id="txt_descripcion">-</td>
                                            <td id="txt_talla">-</td>
                                            <td id="txt_cantidad">-</td>
                                            <td><input type="text" name="txt_cant_producto" id="txt_cant_producto"value="0" min="1" disabled></td>
                                            <td><a href="#" id="add_product_asig" class="btn btn-success" style="display: none;">Agregar</a></td>
                                        </tr>
                                        <tr>
                                            <th>Cód. Producto</th>
                                            <th colspan="1">Descripción</th>
                                            <th>Talla</th>
                                            <th>Cantidad</th>
                                            <th colspan="2" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalle_asig">
                                        <!-- Contenido ajax -->
                                    </tbody>
                                    <!-- <tfoot id="detalle_totales"> -->
                                        <!-- Contenido ajax -->
                                    </tfoot>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <?php include_once "includes/footer.php"; ?>

 


