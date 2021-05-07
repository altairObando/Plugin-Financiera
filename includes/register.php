<?php

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    function register_tables(){
        global $wpdb;

        $tablaFinanciera = $wpdb->prefix."financiera";
        $tablaRangoDeudor = $wpdb->prefix."rango_deudor";
        $tablaTasa = $wpdb->prefix."tasa";

        $createdFinanciera = dbDelta(
            "CREATE TABLE $tablaFinanciera (
                id int(11) NOT NULL,
                nombre varchar(100) NOT NULL,
                rangoDeudorId int(11) DEFAULT NULL
            )"
        );

        $createdTasa = dbDelta("CREATE TABLE $tablaTasa (
            id int(11) NOT NULL,
            tasa decimal(16,4) NOT NULL,
            fecha date NOT NULL,
            activo bit(1) NOT NULL,
            financieraId int(11) DEFAULT NULL
          )");
        
        $createdFinanciera = dbDelta(
            "CREATE TABLE $tablaRangoDeudor (
                id int(11) NOT NULL,
                valorDesde decimal(16,4) NOT NULL,
                valorHasta decimal(16,4) NOT NULL,
                porcentajeCuota decimal(16,4) NOT NULL,
                rebajoAutomatico decimal(16,4) NOT NULL,
                porcentajeDeudal decimal(16,4) NOT NULL,
                activo bit(1) NOT NULL
              )"
        );

    }

    function delete_tables(){
        global $wpdb;
        dbDelta('DROP TABLE '.$wpdb->prefix."financiera");
        dbDelta('DROP TABLE '.$wpdb->prefix."rango_deudor");
        dbDelta('DROP TABLE '.$wpdb->prefix."tasa");
    }

?>