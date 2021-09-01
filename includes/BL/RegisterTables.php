<?php
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    function register_tables(){
        global $wpdb;
        $configProducto = BaseHelper::$configProducto;
        $cotizaciones   = BaseHelper::$cotizaciones;
        dbDelta("CREATE TABLE $configProducto
            (
            `id`                  int NOT NULL AUTO_INCREMENT,
            `productoId`          int NOT NULL,
            `montoDesde`          decimal(16,4) NULL,
            `montoHasta`          decimal(16,4) NOT NULL,
            `relacionCuota`       decimal(16,4) NOT NULL,
            `rebajoAutomatico`    decimal(16,4) NOT NULL,
            `valor`               decimal(16,4) NOT NULL,
            PRIMARY KEY (`id`)
            );"
        );

        dbDelta("CREATE TABLE $cotizaciones (
            `id` INT NOT NULL AUTO_INCREMENT,
            `cedula` VARCHAR(25) NOT NULL,
            `contacto` TEXT,
            `ingresoBruto` Text,
            `deudaSugef` Text,
            `cupoCredito` Text,
            `tipoCambio` Text,
            `ingresoNeto` Text,
            `esAsalariado` Text,
            `rebajoAutomatico` Text,
            `nivelSugef` Text,
            `promedioCuotas` Text,
            `porcentajeDeuda` Text,
            `creditoColones` Text,
            `creditoDolares` Text,
            `tasa` Text,
            `plazo` Text,
            `sugerenciaColones` Text,
            `sugerenciaDolares` Text,
            `montoSolicitado` Text,
            `montoCuotaFinal` Text,
            `emailClient` Text,
            `productoId` Text,
            `moneda` Text,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB;
        ");

    }

    function delete_tables(){
        $configProducto = BaseHelper::$configProducto;
        $cotizaciones   = BaseHelper::$cotizaciones;

        global $wpdb;
        dbDelta('DROP TABLE '.$configProducto);
        dbDelta('DROP TABLE '.$cotizaciones);
        
    }

?>