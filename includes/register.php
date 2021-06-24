<?php

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    function register_tables(){
        global $wpdb;

        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaNiveles = $wpdb->prefix."nivelesDeEndeudamiento";

        $createdFinanciera = dbDelta("CREATE TABLE $tablaFinanciera
            (
            `id`          int NOT NULL AUTO_INCREMENT ,
            `nombre`      varchar(45) NOT NULL ,
            `descripcion` varchar(250) NULL ,
            `tasa`        decimal(16,4) NOT NULL ,
            `cuotas`      int NOT NULL ,
            `dac`         varchar(50000) NOT NULL ,
            PRIMARY KEY (`id`));");
            
        $crearNiveles = dbDelta("CREATE TABLE $tablaNiveles
            (
            `id`                  int NOT NULL AUTO_INCREMENT ,
            `montoDesde`          decimal(16,4) NULL,
            `montoHasta`          decimal(16,4) NOT NULL,
            `relacionCuota`       decimal(16,4) NOT NULL,
            `rebajoAutomatico`    decimal(16,4) NOT NULL,
            `valor`               decimal(16,4) NOT NULL
            PRIMARY KEY (`id`)
            );"
        );

    }

    function delete_tables(){
        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaClientes = $wpdb->prefix."clientes";

        global $wpdb;
        dbDelta('DROP TABLE '.$tablaFinanciera);
        dbDelta('DROP TABLE '.$tablaClientes);
        
    }

?>