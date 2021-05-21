<?php

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    function register_tables(){
        global $wpdb;

        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaClientes = $wpdb->prefix."clientes";

        $createdFinanciera = dbDelta("CREATE TABLE $tablaFinanciera
            (
            `id`          int NOT NULL AUTO_INCREMENT ,
            `nombre`      varchar(45) NOT NULL ,
            `descripcion` varchar(250) NULL ,
            `tasa`        decimal(16,4) NOT NULL ,
            `cuotas`      int NOT NULL ,
            `dac`         varchar(50000) NOT NULL ,
            PRIMARY KEY (`id`));");
            
        $crearClientes = dbDelta("CREATE TABLE $tablaClientes
            (
            `id`                  int NOT NULL AUTO_INCREMENT ,
            `doc_identidad`       varchar(15) NOT NULL ,
            `nombre`              varchar(45) NOT NULL ,
            `segundo_nombre`      varchar(45) NULL ,
            `apellido`            varchar(50) NULL ,
            `segundo_apellido`    varchar(50) NOT NULL ,
            `direccion`           varchar(250) NOT NULL ,
            `direccion_adicional` varchar(250) NULL ,
            `ingreso_bruto`       decimal(16, 4) NOT NULL ,
            `cuotas_asignadas`    decimal NULL ,
            `cuotas_pagadas`      decimal NULL ,
            `cuotas_pendientes`   decimal NULL ,
            `es_asalariado`       bit NOT NULL ,
            `telefono`            varchar(15) NULL ,
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