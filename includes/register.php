<?php

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    function register_tables(){
        global $wpdb;

        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaNiveles = $wpdb->prefix."nivelesDeEndeudamiento";
        $cotizaciones = $wpdb->prefix."cotizacion";
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

        $createCotizacion = dbDelta("CREATE TABLE $cotizaciones (
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
        
        dbDelta("ALTER TABLE `wp_nivelesdeendeudamiento` 
        ADD CONSTRAINT `Niveles_FK_ProductoId_Financiera_PK_Id` 
        FOREIGN KEY (`productoId`) REFERENCES `wp_financiera`(`id`) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE;");

    }

    function delete_tables(){
        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaClientes = $wpdb->prefix."clientes";

        global $wpdb;
        dbDelta('DROP TABLE '.$tablaFinanciera);
        dbDelta('DROP TABLE '.$tablaClientes);
        
    }

?>