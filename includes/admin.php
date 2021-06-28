<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
add_action('admin_menu', 'addAdminPageContent');

function addAdminPageContent(){
    add_menu_page(
        'CoDesign',
        'Productos',
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
        $descripcion = $_POST["descripcion"];
        $tasa = $_POST["tasa"];
        $cuotas = $_POST["cuotas"];
        $dac = $_POST["dac"];
        
        $newFinanciera = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
            'dac' => $dac,
        );

        $wpdb->insert($tablaFinanciera, $newFinanciera);
        $redirect = true;
    }

    if(isset($_POST['updateValue'])){

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $tasa = $_POST["tasa"];
        $cuotas = $_POST["cuotas"];
        $dac = json_encode($_POST["dac"]);
        $dac = str_replace("\\","", $dac);
        
        $updateFinanciera = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tasa' => $tasa,
            'cuotas' => $cuotas,
            'dac' => $dac,
        );
        $wpdb->update($tablaFinanciera,$updateFinanciera, array('id' => $id));
        $redirect = true;
    }

    if(isset($_GET["del"])){
        $id = $_GET["del"];
        $wpdb->delete($tablaFinanciera, array("id" => $id));
        $redirect = true;
    }

    if($redirect)
        echo $redirectUrl;
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
                    <th width="25%">DAC</th>
                    <th width="20%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php    
                    $result = $wpdb->get_results("SELECT * FROM $tablaFinanciera ");
                    foreach($result as $item)
                    {
                        echo "
                        <tr>
                            <th>$item->id</th>
                            <th>$item->nombre</th>
                            <th>$item->tasa</th>
                            <th>$item->cuotas</th>
                            <th>$item->dac</th>
                            <th>
                            <a href='admin.php?page=productos&update=$item->id'>
                                <button type='button'>
                                Actualizar
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
                            <td><input type='text' name='dac' style='width: 100%;' value='$item->dac'/></td>
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
                        <td><input type="text" name="dac" style="width: 100%;"/></td>
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
    $redirectUrl = "<script>location.replace('admin.php?page=reglas');</script>";

    if(isset($_POST['newValue'])){
        $montoDesde = $_POST["montoDesde"];
        $montoHasta = $_POST["montoHasta"];
        $relacionCuota = $_POST["relacionCuota"];
        $rebajoAutomatico = $_POST["rebajoAutomatico"];
        $valor = $_POST["valor"];
        
        $newRegla = array(
            '$montoDesde'       => $montoDesde,
            '$montoHasta'       => $montoHasta,
            '$relacionCuota'    => $relacionCuota,
            '$rebajoAutomatico' => $rebajoAutomatico,
            '$valor'            => $valor
        );

        $wpdb->insert($tabla, $newRegla);
        $redirect = true;
    }

    if(isset($_POST['updateValue'])){

        $id = $_POST["id"];
        $montoDesde = $_POST["montoDesde"];
        $montoHasta = $_POST["montoHasta"];
        $relacionCuota = $_POST["relacionCuota"];
        $rebajoAutomatico = $_POST["rebajoAutomatico"];
        $valor = $_POST["valor"];
        
        $newRegla = array(
            '$montoDesde'       => $montoDesde,
            '$montoHasta'       => $montoHasta,
            '$relacionCuota'    => $relacionCuota,
            '$rebajoAutomatico' => $rebajoAutomatico,
            '$valor'            => $valor
        );
        $wpdb->update($tabla,$newRegla, array('id' => $id));
        $redirect = true;
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
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tasa %</th>
                    <th>Plazo</th>
                    <th width="25%">DAC</th>
                    <th width="20%">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php    
                    $result = $wpdb->get_results("SELECT * FROM $tablaFinanciera ");
                    foreach($result as $item)
                    {
                        echo "
                        <tr>
                            <th>$item->id</th>
                            <th>$item->nombre</th>
                            <th>$item->tasa</th>
                            <th>$item->cuotas</th>
                            <th>$item->dac</th>
                            <th>
                            <a href='admin.php?page=productos&update=$item->id'>
                                <button type='button'>
                                Actualizar
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
                            <td><input type='text' name='dac' style='width: 100%;' value='$item->dac'/></td>
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
                        <td><input type="text" name="dac" style="width: 100%;"/></td>
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