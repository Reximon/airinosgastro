<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION
 add_action( 'init', 'dcms_add_shortcode_date' );

function dcms_add_shortcode_date(){
	add_shortcode('current_date', 'dcms_create_current_date');
}

function dcms_create_current_date( $atts, $content ){
	$atts = shortcode_atts(
				['format' => get_option('date_format')],
				$atts, 'current_date');
	$str = date_i18n($atts['format']);
	return $str;
}

// Registrar la ruta de la API REST personalizada
add_action('rest_api_init', function() {
    register_rest_route('pago/v1', '/generar-firma', [
        'methods' => 'POST',
        'callback' => 'generar_firma', // Función que manejará la lógica
        'permission_callback' => '__return_true', // Si no necesitas autenticación, permite todo
    ]);
});


function agregar_gtm_head() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5KBBJF5Z');
	gtag('config', 'AW-17058218049');
</script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action('wp_head', 'agregar_gtm_head');

function agregar_gtm_body() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5KBBJF5Z"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('wp_body_open', 'agregar_gtm_body');

// Añadir el atributo defer al script de CookieYes
add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
    if ( strpos( $src, 'cdn-cookieyes.com' ) !== false ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}, 10, 3 );

//Codigo para las fuentes 
add_filter( 'style_loader_tag', function( $html, $handle ) {
    if ( strpos( $html, 'jkiticon' ) !== false && strpos( $html, 'font-display' ) === false ) {
        return str_replace( "rel='stylesheet'", "rel='stylesheet' font-display='swap'", $html );
    }
    return $html;
}, 10, 2 );