<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
add_action('admin_menu', 'addAdminPageContent');

function addAdminPageContent(){
    add_menu_page(
        'CoDesign',
        'CoDesign',
        'manage_options',
        'productos',
        'crudOperationsProducto',
        'dashicons-calculator'
    );
    add_submenu_page('productos', 'CoDesign', 'Reglas', 'manage_options' , 'Reglas',  'crudOperationsReglas' );
}


function crudOperationsProducto(){    
    global $wpdb;
    $tablaFinanciera = $wpdb->prefix."financiera";
    $redirect = false;
    $redirectUrl = "<script>location.replace('admin.php?page=productos');</script>";

    if(isset($_POST['newValue'])){
        $nombre = $_POST["nombre"];
        $tasa = $_POST["tasa"];
        $cuotas = $_POST["cuotas"];
        // $dac = $_POST["dac"];
        
        $newFinanciera = array(
            'nombre' => $nombre,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
        );

        $wpdb->insert($tablaFinanciera, $newFinanciera);
        $redirect = true;
    }

    if(isset($_POST['updateValue'])){

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $tasa = $_POST["tasa"];
        $cuotas = $_POST["cuotas"];
        
        $updateFinanciera = array(
            'nombre' => $nombre,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
        );
        $wpdb->update($tablaFinanciera,$updateFinanciera, array('id' => $id));
        $redirect = true;
    }

    if(isset($_GET["del"])){
        $id = $_GET["del"];
        $wpdb->delete($tablaFinanciera, array("id" => $id));
        $redirect = true;
    }

    // if($redirect)
    //     echo $redirectUrl;
    ?>
    
    <div class="wrap">
        <h2 style="text-align: center;"> Administar productos </h2>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tasa %</th>
                    <th>Plazo</th>
                    <!-- <th width="25%">DAC</th> -->
                    <th width="20%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php    
                    $result = $wpdb->get_results("SELECT * FROM $tablaFinanciera ");
                    foreach($result as $item)
                    {
                        //<th>$item->dac</th>
                        echo "
                        <tr>
                            <th>$item->id</th>
                            <th>$item->nombre</th>
                            <th>$item->tasa</th>
                            <th>$item->cuotas</th>
                            
                            <th>
                            <a href='admin.php?page=productos&update=$item->id'>
                                <button type='button'>
                                Actualizar
                                </button>
                            </a> | 
                            <a href='admin.php?page=Reglas&productoId=$item->id'>
                                <button type='button'>
                                Configurar
                                </button>
                            </a> |
                            <a href='admin.php?page=productos&del=$item->id'>
                                <button type='button'>
                                Eliminar
                                </button>
                            </a>
                            </th>
                        </tr>
                        ";
                    }

                if(isset($_GET['update'])){
                    $id = $_GET['update'];
                    $result = $wpdb->get_results("SELECT * FROM $tablaFinanciera WHERE id='$id'");
                    foreach($result as $item){
                        $nombre = $item->nombre;
                        $tasa = $item->tasa;
                        $cuotas = $item->cuotas;
                        $dac = $item->dac;
                    }
                    echo "
                    <form action='' method='POST'>
                        <tr>
                            <td><input type='text' name='id' value='$id' readonly /></td>
                            <td><input type='text' name='nombre' value='$item->nombre'/></td>
                            <td><input type='text' name='tasa' value='$item->tasa'/></td>
                            <td><input type='text' name='cuotas' value='$item->cuotas'/></td>
                            <td>
                                <button id='updateValue' name='updateValue' type='submit'>Aplicar cambios</button> | 
                                <button type='button'>
                                    <a href='admin.php?page=productos'>Cancelar</a>
                                </button>
                            </td>
                        </tr>
                    </form>
                    ";
                }

                ?>
                <form action="" method="POST">
                    <tr>
                        <td><input type="text" value="ID" disabled/></td>
                        <td><input type="text" name="nombre" /></td>
                        <td><input type="text" name="tasa" /></td>
                        <td><input type="text" name="cuotas" /></td>
                        <td>
                            <button id="newValue" name="newValue">Añadir</button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
    <?php
}
function crudOperationsReglas(){    
    global $wpdb;
    $tabla = $wpdb->prefix."nivelesDeEndeudamiento";
    $redirect = false;
    $redirectUrl = "<script>location.replace('admin.php?page=Reglas');</script>";

    $productoId = isset($_GET["productoId"]) ? $_GET["productoId"] : 0;
    $tablaFinanciera = $wpdb->prefix."financiera";
    $productos = $wpdb->get_results("SELECT id, nombre from $tablaFinanciera ");
    $selectProducto = "<select name='productoId' required> <option value=''> Seleccione una opcion</option>";
    foreach ($productos as $value) {
        $selectProducto = $selectProducto."<option value='$value->id'>$value->nombre</option>";
    }
    $selectProducto = $selectProducto."</select>";
    if(isset($_POST['newValue'])){
        $productoId = $_POST["productoId"];
        $montoDesde = $_POST["montoDesde"];
        $montoHasta = $_POST["montoHasta"];
        $relacionCuota = $_POST["relacionCuota"];
        $rebajoAutomatico = $_POST["rebajoAutomatico"];
        $valor = $_POST["valor"];
        
        $newRegla = array(
            'productoId'       => $productoId,
            'montoDesde'       => $montoDesde,
            'montoHasta'       => $montoHasta,
            'relacionCuota'    => $relacionCuota,
            'rebajoAutomatico' => $rebajoAutomatico,
            'valor'            => $valor
        );
        $wpdb->insert($tabla, $newRegla);
        $redirectUrl = "<script>location.replace('admin.php?page=Reglas&productoId=$productoId');</script>";
        $redirect = true;
    }

    if(isset($_POST['updateValue'])){

        $id = $_POST["id"];
        $productoId = $_POST["productoId"];
        $montoDesde = $_POST["montoDesde"];
        $montoHasta = $_POST["montoHasta"];
        $relacionCuota = $_POST["relacionCuota"];
        $rebajoAutomatico = $_POST["rebajoAutomatico"];
        $valor = $_POST["valor"];
        
        $newRegla = array(
            'productoId'       => $productoId,
            'montoDesde'       => $montoDesde,
            'montoHasta'       => $montoHasta,
            'relacionCuota'    => $relacionCuota,
            'rebajoAutomatico' => $rebajoAutomatico,
            'valor'            => $valor
        );
        $wpdb->update($tabla,$newRegla, array('id' => $id));
        $redirect = true;
        $redirectUrl = "<script>location.replace('admin.php?page=Reglas&productoId=$productoId');</script>";
    }

    if(isset($_GET["del"])){
        $id = $_GET["del"];
        $wpdb->delete($tabla, array("id" => $id));
        $redirect = true;
    }

    if($redirect)
        echo $redirectUrl;
    ?>
    <div class="wrap">

        <h2 style="text-align: center;"> Regla de nivel de endeudamiento </h2>
        <form action="" style="float:right">
            <?php echo $selectProducto ?>
            <button type="submit" name="page" value="Reglas">
                Filtrar Producto
            </button>
            <button type='button'>
                <a href='admin.php?page=Reglas'>Sin Filtro</a>
            </button>
        </form>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th style="width:">Id</th>
                    <th>Producto</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Relación %</th>
                    <th>Rebajo %</th>
                    <th>Endeudamiento %</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = null;
                    if($productoId != 0){
                        $result = $wpdb->get_results("SELECT P.nombre, R.* FROM $tabla as R INNER JOIN $tablaFinanciera P WHERE R.productoId = P.id AND R.productoId='$productoId' order by r.id ");
                    }else
                        $result = $wpdb->get_results("SELECT P.nombre, R.* FROM $tabla as R INNER JOIN $tablaFinanciera P WHERE R.productoId = P.id order by p.id");
                    foreach($result as $item)
                    {
                        echo "
                        <tr>
                            <th style='width: 20px;'>$item->id</th>
                            <th>$item->nombre</th>
                            <th>$item->montoDesde</th>
                            <th>$item->montoHasta</th>
                            <th>$item->relacionCuota</th>
                            <th>$item->rebajoAutomatico</th>
                            <th>$item->valor</th>
                            <th>
                            <a href='admin.php?page=Reglas&update=$item->id&productoId=$productoId'>
                                <button type='button'>
                                Actualizar
                                </button>
                            </a> | 
                            <a href='admin.php?page=Reglas&del=$item->id'>
                                <button type='button'>
                                Eliminar
                                </button>
                            </a>
                            </th>
                        </tr>
                        ";
                    }

                if(isset($_GET['update'])){
                    $id = $_GET['update'];
                    $query = "";
                    if($productoId != 0){
                        $query = "SELECT * FROM $tabla WHERE id='$id' && productoId=$productoId";
                    }else {
                        $query = "SELECT * FROM $tabla WHERE id='$id'";
                    }
                    $result = $wpdb->get_results($query);
                    foreach($result as $item){
                        $productoId = $item->productoId;
                        $montoDesde = $item->montoDesde;
                        $montoHasta = $item->montoHasta;
                        $relacionCuota = $item->relacionCuota;
                        $rebajoAutomatico = $item->rebajoAutomatico;
                        $valor = $item->valor;
                    }
                    echo "
                    <form action='' method='POST'>
                        <tr>
                            <td style='width: 20px;'><input type='text' name='id' value='$id' readonly /></td>
                            <td> $selectProducto
                            </td>
                            <td><input type='text' name='montoDesde'        value='$item->montoDesde'/></td>
                            <td><input type='text' name='montoHasta'        value='$item->montoHasta'/></td>
                            <td><input type='text' name='relacionCuota'     value='$item->relacionCuota'/></td>
                            <td><input type='text' name='rebajoAutomatico'  value='$item->rebajoAutomatico'/></td>
                            <td><input type='text' name='valor'             value='$item->valor'/></td>
                            <td>
                                <button id='updateValue' name='updateValue' type='submit'>Aplicar cambios</button> | 
                                <button type='button'>
                                    <a href='admin.php?page=Reglas'>Cancelar</a>
                                </button>
                            </td>
                        </tr>
                    </form>
                    ";
                }
                ?>

                <form action="" method="POST">
                    <tr>
                        <td><input type='text' name='id'style="width: 20px;" readonly /></td>
                        <td>
                            <?php echo $selectProducto ?>
                        </td>
                        <td><input type='text' name='montoDesde'/></td>
                        <td><input type='text' name='montoHasta'/></td>
                        <td><input type='text' name='relacionCuota'/></td>
                        <td><input type='text' name='rebajoAutomatico'/></td>
                        <td><input type='text' name='valor'/></td>
                        <td>
                            <button id="newValue" name="newValue">Añadir</button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
    <?php
}
?>