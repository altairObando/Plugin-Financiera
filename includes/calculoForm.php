<?php
    function renderForm(){
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '    <meta charset="UTF-8">';
        echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '    <title>Calculadora de costos</title>';
        echo '</head>';
        echo '<body>';
        echo '    ';
        echo '</body>';
        echo '</html>';
    }

    function wpb_hook_javascript() {
        ?>
            <script>
              // your javscript code goes
            </script>
        <?php
    }

    function deliver_mail(){

    }

    function cf_shortcode() {
        ob_start();
        deliver_mail();
        renderForm();    
        return ob_get_clean();
    }

    add_action('wp_head', 'wpb_hook_javascript');    
    add_shortcode( 'codesign_calculadora_form', 'cf_shortcode' );
    
?>